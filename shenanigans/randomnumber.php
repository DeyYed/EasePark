<?php
  require('connection.php');
?>
<?php
function generateNumber(){
  random_int(100000, 999999);
}
$verificationCode = generateNumber();

$sql ="SELECT * from verification_number where verify_number = ?";;
$stmt = $pdo->prepare($sql);
$stmt->execute([$verificationCode]);

if($stmt){
  $verificationCode = generateNumber();
}else{
  $is_used = false; 
  $sql ="INSERT INTO verification_number(verify_number, is_used)VALUES(?,?)";;
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$verificationCode,$is_used]);
}
?>