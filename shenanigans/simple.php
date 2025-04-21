<?php
require('connection.php');
session_start();

// Start output buffering
ob_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        $code = $_POST['vcode'];

        // Prepare and execute the SQL statement
        $sql = "SELECT * FROM verification_number WHERE verify_number = ? AND is_used = 0";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$code]);
        $existing = $stmt->fetchAll();

        if ($existing) {
            $is_used = true;
            $sql = "UPDATE verification_number SET is_used = ? WHERE verify_number = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$is_used, $code]);
            $_SESSION["logined"] = true;

            // Redirect to register.php
            header("Location: register.php");
            exit();
        } else {
            // Output JavaScript for failure message
            echo '<script>
                Swal.fire({
                    title: "Verification Fail!",
                    text: "Code already used or not exist.",
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

// End output buffering and flush output
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link href="sweetalert2.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
body{
  font-family: "Montserrat", sans-serif;
  background-color: rgb(244,249,255);
  height: 100%;
  margin: 0;
}
.container{
  display: flex;
  justify-content: center; /* Center horizontally */
  align-items: center; /* Center vertically */
  height: 100vh; /* Full viewport height */
}
.logo-container{
  position: absolute;
  overflow: hidden;
  top: -70px; /* Adjust as needed for vertical positioning */
  left: 50%; /* Center horizontally */
  transform: translateX(-50%); /* Adjust for center alignment */
}
.cyberpark-logo{
  width: 153px; 
  height: 120px;
  object-fit: cover;
}

.form {
  display: flex;
  flex-direction: column;
  gap: 10px;
  max-width: 350px;
  padding: 20px;
  border-radius: 20px;
  position: relative;
  background-color: white;
  color: #fff;
  background-color: white;
  border:1px solid rgba(255, 255, 255, 0.18);
  box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
}

.title {
  font-size: 28px;
  font-weight: 600;
  letter-spacing: -1px;
  position: relative;
  display: flex;
  align-items: center;
  padding-left: 30px;
  color: black;
}

.title::before {
  width: 18px;
  height: 18px;
}

.title::after {
  width: 18px;
  height: 18px;
  animation: pulse 1s linear infinite;
}

.title::before,
.title::after {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  border-radius: 50%;
  left: 0px;
  background-color: rgb(39, 55, 77);
}

.message, 
.signin {
  font-size: 14.5px;
  color: rgba(255, 255, 255, 0.7);
}

.signin {
  text-align: center;
}

.signin a:hover {
  text-decoration: underline royalblue;
}

.signin a {
  color: #00bfff;
}

.flex {
  display: flex;
  width: 95%;
  gap: 30px;
}

.form label {
  position: relative;
  padding-bottom: 10px;
}

.form label .input {
  font-family: "Montserrat", sans-serif;
  background-color: rgb(217,217,217);
  color: black;
  width: 95%;
  padding: 20px 05px 05px 10px;
  outline: 0;
  border: none;
  border-radius: 10px;
}

.form label .input + span {
  font-family: "Montserrat", sans-serif;
  color: rgba(255, 255, 255, 0.5);
  position: absolute;
  left: 10px;
  top: 0px;
  font-size: 0.9em;
  cursor: text;
  transition: 0.3s ease;
}

.form label .input:placeholder-shown + span {
  font-family: "Montserrat", sans-serif;
  top: 12.5px;
  font-size: 0.9em;
}

.form label .input:focus + span,
.form label .input:valid + span {
  font-family: "Montserrat", sans-serif;
  color: black;
  top: 0px;
  font-size: 0.7em;
  font-weight: 800;
}

.input {
  font-size: medium;
}

.submit {
  font-family: "Montserrat", sans-serif;
  border: none;
  outline: none;
  padding: 10px;
  border-radius: 10px;
  color: white;
  font-size: 16px;
  transform: .3s ease;
  background-color: rgb(0, 13, 24);
  transition: 0.15s;
}

.submit:hover {
  box-shadow: 4px 4px 12px white, inset -1px -1px 12px white;
  color: white;
}

@keyframes pulse {
  from {
    transform: scale(0.9);
    opacity: 1;
  }

  to {
    transform: scale(1.8);
    opacity: 0;
  }
}
.bottom{
position: fixed;
height: 80px;
bottom: 0;
left: 0;
right: 0;
background-color: rgb(0,13,24);
}
</style>
</head>
<body>
<div class="container">
  <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="logo-container">
      <img class="cyberpark-logo" src="admin/image/logo1.png" alt="Logo">
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
