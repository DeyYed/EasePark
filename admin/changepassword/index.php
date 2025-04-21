<?php
require('../connection.php');
session_start();
if (empty($_SESSION['form_token'])) {
  $_SESSION['form_token'] = bin2hex(random_bytes(32));
}
if (empty($_SESSION['email'])) {
  header("Location: ../");
}
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Password</title>
    <link rel="icon" href="../changepassword/image/favicon.ico" type="image/x-icon"> 
  <link rel="stylesheet" href="../css/changepassword.css">
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
      <p class="title">Verify</p>
      <div class="flex">
        <label>
          <input class="input" type="text" name="vcode" placeholder="" required="">
          <span>Verification Code</span>
        </label>
      </div>
      <input type="submit" name="submit" class="submit">
    </form>
  </div>
  <div class="bottom"></div>
</body>

</html>
<?php
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Check if the submit button was clicked
  if (isset($_POST['submit'])) {
    // Retrieve and sanitize input
    $code = trim($_POST['vcode']); // Remove leading and trailing whitespace

    // Check if the code is empty or less than 6 digits
    if (empty($code) || !ctype_digit($code) || strlen($code) < 6) {
      // Output JavaScript for failure message
      echo '<script>
                Swal.fire({
                    title: "Verification Fail!",
                    text: "Code must be a number and at least 6 digits long.",
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
      exit();
    }

    // No need for additional sanitization, as ctype_digit ensures only digits are allowed

    try {
      // Prepare and execute the SQL statement
      $sql = "SELECT * FROM cpverification WHERE verify_number = ? AND is_used = 0";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$code]);
      $existing = $stmt->fetchAll();

      if ($existing) {
        // Mark code as used
        $is_used = 1;
        $sql = "UPDATE cpverification SET is_used = ? WHERE verify_number = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$is_used, $code]);

        $_SESSION["cpverification"] = true;
        $email = $_SESSION['email'];
        $_SESSION['email'] = $email; // This line seems redundant

        // Redirect to newpassword.php
        header("Location: ../newpassword/");
        exit();
      } else {
        // Output JavaScript for failure message
        echo '<script>
                    Swal.fire({
                        title: "Verification Fail!",
                        text: "Code already used or does not exist.",
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
        exit();
      }
    } catch (PDOException $e) {
      // Handle SQL errors
      echo '<script>
                Swal.fire({
                    title: "Database Error!",
                    text: "An error occurred while processing your request.",
                    icon: "error",
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                </script>';
      exit();
    }
  }
}

// End output buffering and flush output
ob_end_flush();
?>