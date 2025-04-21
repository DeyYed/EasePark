<?php
  require('connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
    <label>Email:</label>
    <input type="email" name="email"><br>
    <label>UID:</label>
    <input type="text" name="uid"><br>
    <input type="submit" name="submit" value="Register">
  </form>
</body>
</html>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

function generateNumber(){
  return random_int(100000, 999999);
}

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['submit'])){


      $verificationCode = generateNumber();
      $sql ="SELECT * from verification_number where verify_number = ?";;
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$verificationCode]);
      
      $existingCode = $stmt->fetchAll();
      if($existingCode){
        $verificationCode = generateNumber();
      }else{
        $is_used = false; 
        $sql ="INSERT INTO verification_number(verify_number, is_used)VALUES(?,?)";;
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$verificationCode,$is_used]);

        
        $email = $_POST['email'];
        $uid = $_POST['uid'];

        $mail = new PHPMailer(true);


        
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'facethereality01@gmail.com';
        $mail->Password = 'xzlm ixrh qjiw abbk';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('facethereality01@gmail.com');

        $mail->addAddress($email);

        $mail->isHTML(true);

        $subject = "Registration Link";
        
        $message = "This is your verification code for the link below<br>Verification Code: ".$verificationCode."<br>Link: http://localhost/parking/register.php"."<br>UID: ".$uid;

        $mail->Subject = $subject;
        $mail->Body = $message;

        If($mail->send()){
          echo "Sent Successfully!".$verificationCode;
        }else{
          echo "Sent failed";
        }
      }
    }
  }
?>