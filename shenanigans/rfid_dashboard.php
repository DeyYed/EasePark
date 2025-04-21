<?php
require('connection.php');
session_start();
if(!isset($_SESSION["logined"])){
header("Location: signin.php");   
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
<h1>Hello</h1>
  This is the Dashboard<br>
  <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">
  <input type="submit" name="logout" value="logout">
  </form>
</body>
</html>
<?php 
  if($_SERVER["REQUEST_METHOD"] == 'POST'){
    if(isset($_POST['logout'])){
      session_destroy();
      header('Location: signin.php');
    }
  }
?>
