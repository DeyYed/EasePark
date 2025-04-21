<?php
require('../connection.php');
session_start();
if (empty($_SESSION['form_token'])) {
  $_SESSION['form_token'] = bin2hex(random_bytes(32));
}
if(empty($_SESSION['email'] && $_SESSION["cpverification"])){
    header("Location: signin.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/newpassword.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
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
      <input class="input" type="password" name="password" placeholder="" required="">
      <span>Password</span>
    </label>
    <label>
      <input class="input" type="password" name="confirmpw" placeholder="" required="">
      <span>Confirm Password</span>
    </label>
    <input type="submit" name="submit" class="submit">
  </form>
</div>
<div class="bottom"></div>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['password']) && !empty($_POST['confirmpw'])) {
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmpw'];

        if ($password === $confirmPassword) {
            $email = $_SESSION['email'];

            // Fetch the current hashed password from the database
            $sql = "SELECT admin_password FROM admin_table WHERE admin_email = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email]);
            $currentHashedPassword = $stmt->fetchColumn();

            // Check if the new password is the same as the current one
            if (password_verify($password, $currentHashedPassword)) {
                echo '<script>
                Swal.fire({
                    title: "No Changes!",
                    text: "The new password is the same as the current password.",
                    icon: "info",
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                </script>';
            } else {
                // Hash and update the new password
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $sql = "UPDATE admin_table SET admin_password = ? WHERE admin_email = ?";
                $stmt = $pdo->prepare($sql);
                $success = $stmt->execute([$hashedPassword, $email]);
                
                if ($success) {
                    $rowsAffected = $stmt->rowCount();
                    if ($rowsAffected > 0) {
                        unset($_SESSION['email']);
                        unset($_SESSION['cpverification']);
                        echo '<script>
                        Swal.fire({
                            title: "Success!",
                            text: "Your password has been changed successfully",
                            icon: "success",
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                            },
                            willClose: () => {
                                // Redirect after alert closes
                                window.location.href = "http://easepark.online/admin/signin.php";
                            }
                        });
                        </script>';
                    } else {
                        echo 'No rows were updated. Check if the email exists.';
                    }
                } else {
                    echo 'Error updating password. Please try again.';
                }
            }
        } else {
            echo '<script>
            Swal.fire({
                title: "Fail!",
                text: "Your password doesn\'t match",
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
