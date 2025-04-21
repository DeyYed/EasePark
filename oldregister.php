<?php
  require('connection.php');
  session_start();
  if(!isset($_SESSION["logined"])){
  header("Location: verification.php");   
  }
  if (empty($_SESSION['form_token'])) {
    $_SESSION['form_token'] = bin2hex(random_bytes(32));
  } 
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
    <label>First Name:</label>
    <input type="text" name="fname"><br>
    <label>Last Name</label>
    <input type="text" name="lname"><br>
    <label>Email:</label>
    <input type="email" name="email"><br>
    <label>Password</label>
    <input type="password" name="password"><br>
    <label>Confirm Password</label>
    <input type="password" name="confirmpw"><br>
    <label>UID:</label>
    <input type="text" name="uid"><br>
    <input type="hidden" name="form_token" value="<?= $_SESSION['form_token']; ?>">
    <input type="submit" name="submit" value="Register">
  </form>
</body>
</html>
<?php
  // Function to generate a random salt
  function generateSalt($length = 16) {
    return bin2hex(random_bytes($length));
  }

  // Function to hash the password with salt
  function hashPassword($password, $salt) {
    // Concatenate the salt with the password
    $saltedPassword = $salt . $password;
    // Hash the salted password using bcrypt algorithm
    return password_hash($saltedPassword, PASSWORD_BCRYPT);
  }

  // Function to verify the password
  function verifyPassword($password, $hashedPassword, $salt) {
    // Concatenate the salt with the input password
    $saltedPassword = $salt . $password;
    // Verify the password hash
    return password_verify($saltedPassword, $hashedPassword);
  }

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_SESSION['form_token']) && isset($_POST['form_token']) && 
    hash_equals($_SESSION['form_token'], $_POST['form_token'])) {
      if(isset($_POST['submit'])){
        $password = $_POST['password'];
        $confirmPassword= $_POST['confirmpw'];
        if($password === $confirmPassword){
          $fname = $_POST['fname'];
          $lname = $_POST['lname'];
          $email = $_POST['email'];
          $salt = generateSalt();
          $hashedPassword = hashPassword($password, $salt);
          $uid = $_POST['uid'];
        
          $sql = "INSERT INTO rfid_user(first_name, last_name, user_email, user_password, salt,rfid_uid)VALUES(?,?,?,?,?,?)";
          $stmt = $pdo->prepare($sql);
          $stmt->execute([$fname, $lname, $email, $hashedPassword, $salt, $uid]);
  
        if ($stmt) {
          echo "New record created successfully";
          header("Location: verification.php");
          session_destroy();
          unset($_SESSION['form_token']);
        } else {
          echo "Error: " . $sql . "<br>" . $pdo->errorCode() . ": " . implode(", ", $pdo->errorInfo());
        }
      }else{
        echo "Your Password doesnt match";
      }
      }
  }
}
?>