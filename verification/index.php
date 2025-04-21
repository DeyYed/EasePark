<?php
require('../connection.php');
session_start();

// Start output buffering
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verification</title>
  <link rel="icon" href="../verification/image/favicon.ico" type="image/x-icon"> 
  <link rel="stylesheet" href="../css/verification.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <div class="container">
    <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="logo-container">
        <img class="cyberpark-logo" src="../admin/image/logo1.png" alt="Logo">
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
// Ensure output buffering is enabled
ob_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

  // Retrieve and sanitize input
  $code = trim($_POST['vcode']); // Remove leading and trailing whitespace

  // Check if the code is empty, not numeric, or not exactly 6 digits
  if (empty($code) || !ctype_digit($code) || strlen($code) !== 6) {
    // Output JavaScript for failure message
    echo '<script>
            Swal.fire({
                title: "Validation Fail!",
                text: "Code must be a number and exactly 6 digits long.",
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

  // Database connection (ensure you have a proper PDO setup)
  try {
    // Assuming $pdo is your PDO connection object
    $sql = "SELECT * FROM verification_number WHERE verify_number = ? AND is_used = 0";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$code]);
    $existing = $stmt->fetchAll();

    if ($existing) {
      // Update verification number to used
      $sql = "UPDATE verification_number SET is_used = 1 WHERE verify_number = ?";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$code]);

      // Set session variable
      $_SESSION["user_verification"] = true;

      // Redirect to register.php
      header("Location: ../register/");
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
    }
  } catch (PDOException $e) {
    // Handle database connection errors
    echo '<script>
            Swal.fire({
                title: "Database Error!",
                text: "An error occurred while accessing the database.",
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

// End output buffering and flush output
ob_end_flush();
?>