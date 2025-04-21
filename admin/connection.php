<?php
  $host="localhost";
  $user ="u552515938_test";
  $password ="Om@r12345";
  $dbname ="u552515938_testdb";

try{
  $dsn = "mysql:host=$host;dbname=$dbname";
  $pdo = new PDO($dsn, $user, $password);
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
}catch(PDOException $e){
  echo "Connection failed" . $e->getMessage();
}
// try {
//     // Create a connection
//     $mysqli = new mysqli($host, $user, $password, $dbname);

//     // Check for connection errors
//     if ($mysqli->connect_error) {
//         throw new Exception("Connection failed: " . $mysqli->connect_error);
//     }

//     // Set default fetch mode (similar to PDO's fetch mode)
//     $mysqli->set_charset("utf8"); // Optional, set character set if needed

// } catch (Exception $e) {
//     echo $e->getMessage();
// }