<?php
  require('../connection.php');
session_start();
if (empty($_SESSION['form_token'])) {
  $_SESSION['form_token'] = bin2hex(random_bytes(32));
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Password</title>
    <link rel="icon" href="..//favicon.ico" type="image/x-icon"> 
  <link rel="stylesheet" href="../css/verifychangepassword.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link href="sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container">
  <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="logo-container">
      <img class="cyberpark-logo" src="image/logo1.png" alt="Logo">
    </div>
    <p class="title">Change Password</p>
    <label>
      <input class="input" type="email" name="email" placeholder="" required="">
      <span>Email</span>
    </label>
    <input type="hidden" name="form_token" value="<?= $_SESSION['form_token']; ?>">
    <input type="submit" name="submit" class="submit" value="Send Code">
  </form>
</div>
<div class="bottom"></div>
</body>
</html>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

function generateNumber(){
  return random_int(100000, 999999);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if the token is set and valid
    if (isset($_SESSION['form_token']) && isset($_POST['form_token']) && 
        hash_equals($_SESSION['form_token'], $_POST['form_token'])) {
        if(isset($_POST['submit'])){
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

        $sql = "SELECT admin_email FROM admin_table WHERE admin_email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $verificationCode = generateNumber();
            $sql ="SELECT * from cpverification where verify_number = ?";;
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$verificationCode]);
            
            $existingCode = $stmt->fetchAll();
            if($existingCode){
              $verificationCode = generateNumber();
            }else{
              $is_used = 0; 
              $sql ="INSERT INTO cpverification(verify_number, is_used)VALUES(?,?)";;
              $stmt = $pdo->prepare($sql);
              $stmt->execute([$verificationCode,$is_used]);
      
              
              $email = $_POST['email'];
      
              $mail = new PHPMailer(true);

              $mail->isSMTP();
              $mail->Host = 'smtp.gmail.com';
              $mail->SMTPAuth = true;
              $mail->Username = 'easeparksolutions@gmail.com';
              $mail->Password = 'fkgw ghsy nask myrr';
              $mail->SMTPSecure = 'ssl';
              $mail->Port = 465;
      
              $mail->setFrom('easeparksolutions@gmail.com');
      
              $mail->addAddress($email);
      
              $mail->isHTML(true);
      
              $subject = "Change Password";
              
$message = "
    <div style='font-family: Arial, sans-serif; color: #333; max-width: 600px; margin: 0 auto; background-color: #fff;'>
        <div style='background-color: rgb(0, 13, 24); color: #fff; padding: 20px; text-align: center;'>
            <img src='https://easepark.online/admin/data/image/test.png' alt='EasePark' style='width: 50px; height: 50px; vertical-align: middle;'>
            <div style='margin-top: 10px;'>
                <span style='font-size: 24px; font-weight: bold;'>EasePark</span>
            </div>
        </div>
        
        <div style='padding: 20px; background-color: #f9f9f9;'>
            <p style='color: #000;'>This is your verification code:</p>
            <p><strong>Verification Code: {$verificationCode}</strong></p>
        </div>
        
        <div style='background-color: rgb(0, 13, 24); color: #fff; padding: 10px; text-align: center;'>
            <p>&copy; " . date('Y') . " EasePark. All rights reserved.</p>
        </div>
    </div>
";
      
              $mail->Subject = $subject;
              $mail->Body = $message;
      
              If($mail->send()){
                $_SESSION["email"] = $email;
                unset($_SESSION['form_token']);
                echo '<script>
                Swal.fire({
                    title: "Mail Sent Successfully!",
                    text: "Your message has been sent.",
                    icon: "success",
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    didClose: () => {
                        window.location.href = "http://easepark.online/admin/changepassword/"; // Make sure to use double quotes for the URL
                    }
                });
                </script>';
              }else{
                echo '<script>
                Swal.fire({
                  title: "Mail Sent Failed!",
                  text: "Your message has not sent.",
                  icon: "error",
                  timer: 2000,
                  timerProgressBar: true,
                  didOpen: () => {
                    Swal.showLoading();
                  },
                  willClose: () => {
                    window.history.back();
                  }
                });
                </script>';
              }
            }
            exit;
        }else{
          echo '<script>
          Swal.fire({
              title: "Error",
              text: "Email does not exist",
              icon: "error",
              timer: 2000,
              timerProgressBar: true,
              didOpen: () => {
                  Swal.showLoading();
              },
              willClose: () => {
                window.history.back();
              }
          });
          </script>';
        }

      }
    } else {
      echo '<script>
      Swal.fire({
          title: "Mail Sent Fail!",
          text: "Inavalid form of Submission or possible CSRF attack.",
          icon: "error",
          timer: 2000,
          timerProgressBar: true,
          didOpen: () => {
              Swal.showLoading();
          },
          willClose: () => {
            window.history.back();
          }
      });
      </script>';
    }
} else {
    echo "Invalid request method.";
}
?>
