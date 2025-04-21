<?php
require('../connection.php');
session_start();
if (empty($_SESSION['form_token'])) {
  $_SESSION['form_token'] = bin2hex(random_bytes(32));
}
if(empty($_SESSION['email'] && $_SESSION["changeEverification"])){
    header("Location: ../verification/");
}
$email = isset($_SESSION["email"]) ? $_SESSION["email"] : ''; // Safe check in case session email is not set
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Email</title>
    <link rel="icon" href="../changeemail/image/favicon.ico" type="image/x-icon"> 
  <link rel="stylesheet" href="../css/newpassword.css">
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
    <p class="title">Change Email</p>
    <label>
      <input class="input" type="email" name="email" placeholder="" required="">
      <span>Email</span>
    </label>
    <input type="submit" name="submit" class="submit">
  </form>
</div>
<div class="bottom"></div>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['email'])) {
        $newemail = $_POST['email'];
        $newemail = filter_var($newemail, FILTER_SANITIZE_EMAIL);

        // Assuming you're getting the current email from the session
        $currentEmail = $_SESSION['email']; // Replace this with your actual session variable or value

        // Step 1: Check if the new email already exists in the database
        $sql = "SELECT COUNT(*) FROM admin_table WHERE admin_email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$newemail]);
        $emailExists = $stmt->fetchColumn();

        if ($emailExists > 0) {
            // If the new email already exists, show an error
            echo '<script>
                    Swal.fire({
                        title: "Error",
                        text: "The email is already in use. Please use a different email address.",
                        icon: "error",
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                        didClose: () => {
                            window.history.back(); // Go back to the previous page
                        }
                    });
                  </script>';
        } else {
            // Step 2: Update the email in the database since it doesn't exist
            $sql = "UPDATE admin_table SET admin_email = ? WHERE admin_email = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$newemail, $currentEmail]);

            if ($stmt->rowCount() > 0) {
                // Email updated successfully
                $_SESSION['email'] = $newemail;  // Update the session with the new email
                session_destroy();  // Optionally destroy the session if needed (e.g., force logout)
                echo '<script>
                        Swal.fire({
                            title: "Success",
                            text: "Email updated successfully.",
                            icon: "success",
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                            },
                            didClose: () => {
                                window.location.href = "../"; // Optionally redirect
                            }
                        });
                      </script>';
            } else {
                // If no rows are affected, display an error message with SweetAlert
                echo '<script>
                        Swal.fire({
                            title: "Error",
                            text: "Email update failed. Please try again.",
                            icon: "error",
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                            },
                            didClose: () => {
                                window.history.back(); // Go back to the previous page
                            }
                        });
                      </script>';
            }
        }
    } else {
        // If email format is invalid, show an error message
        echo '<script>
                Swal.fire({
                    title: "Error",
                    text: "Invalid email format.",
                    icon: "error",
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    didClose: () => {
                        window.history.back(); // Go back to the previous page
                    }
                });
              </script>';
    }
}
?>