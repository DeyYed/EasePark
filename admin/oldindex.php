<?php
require_once "../connection.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/signin.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link href="sweetalert2.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container">
  <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="logo-container">
      <img class="cyberpark-logo" src="image/logo1.png" alt="Logo">
    </div>
    <p class="title">Sign-in</p>
    <label>
      <input class="input" type="email" name="email" placeholder="" required="">
      <span>Email</span>
    </label>
    <label>
        <input class="input" type="password" name="password" placeholder="" required="">
        <span>Password</span>
    </label>
    <input type="submit" name="submit" class="submit">
  </form>
</div>
<div class="bottom"></div>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!empty($_POST['email']) && !empty($_POST['password'])) {
      $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
      $password = $_POST['password'];

      $sql = "SELECT admin_password FROM admin_table WHERE admin_email = ?";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$email]);

      if ($stmt->rowCount() > 0) {
          $user = $stmt->fetch(PDO::FETCH_OBJ);
          $hashedPassword = $user->admin_password;

          if(password_verify($password, $hashedPassword)) {
            $_SESSION["email"] = $email;
            $_SESSION["logined"] = true;
            header("Location: admin_dashboard.php");
            exit;
          }else{
            echo '<script>
            Swal.fire({
                title: "Verification Fail!",
                text: "Password is Wrong",
                icon: "error",
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            </script>';
          }
      }else{
        echo '<script>
        Swal.fire({
            title: "Sign in Fail",
            text: "Email does not exist",
            icon: "error",
            timer: 2000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        </script>';
      }
  }
}
?>