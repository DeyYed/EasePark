<?php
require('../connection.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['submit'])) {
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirmpw'];

            if ($password === $confirmPassword) {
                $email = $_POST['email'];

                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                $sql = "INSERT INTO admin_table (admin_email, admin_password) VALUES (?, ?)";
                $stmt = $pdo->prepare($sql);

                if ($stmt->execute([$email,$hashedPassword])) {
                    $message = "Register Success";
                    $type = "success";
                    $redirect = "../";
                    echo "<script>
                    window.onload = function() {
                        Swal.fire({
                            title: 'NOTE',
                            text: '{$message}',
                            icon: '{$type}',
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                            },
                            willClose: () => {
                                if ('{$redirect}') {
                                    window.location.href = '{$redirect}';
                                }
                            }
                        });
                    }
                    </script>";
                    session_destroy();
                } else {
                  $message = "Register Failed. Please try again.";
                  $type = "error";
                  echo "<script>
                  window.onload = function() {
                      Swal.fire({
                          title: 'NOTE',
                          text: '{$message}',
                          icon: '{$type}',
                          timer: 2000,
                          timerProgressBar: true,
                          didOpen: () => {
                              Swal.showLoading();
                          },
                          willClose: () => {
                            window.history.back();
                          }
                      });
                  }
                  </script>";
                }
            }else{
              $message = "Passwords do not match.";
              $type = "error";
              echo "<script>
              window.onload = function() {
                  Swal.fire({
                      title: 'NOTE',
                      text: '{$message}',
                      icon: '{$type}',
                      timer: 2000,
                      timerProgressBar: true,
                      didOpen: () => {
                          Swal.showLoading();
                      },
                      willClose: () => {
                         window.history.back();
                      }
                  });
              }
              </script>";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="icon" href="../register/image/favicon.ico" type="image/x-icon"> 
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/register.css">
</head>
<body>
<div class="container">
    <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="logo-container">
            <img class="cyberpark-logo" src="image/logo1.png" alt="Logo">
        </div>
        <p class="title">Register</p>
        <label>
            <input class="input" type="text" name="email" placeholder="" required>
            <span>Email</span>
        </label>
        <label>
            <input class="input" type="password" name="password" placeholder="" required>
            <span>Password</span>
        </label>
        <label>
            <input class="input" type="password" name="confirmpw" placeholder="" required>
            <span>Confirm password</span>
        </label>   
        <button type="submit" name="submit" class="submit">Register</button>
    </form>
</div>
<div class="bottom"></div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
<script>
