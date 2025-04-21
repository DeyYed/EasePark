<?php
session_start();
header('Content-Type: application/json'); // Set content type to JSON
require('../connection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['uid'])) {
        $uid = $_POST['uid'];
        
        // Prepare and execute the SQL query
        $sql = "SELECT * FROM rfid_user WHERE rfid_uid = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$uid]);

        // Check if UID exists
        $exists = $stmt->fetch();

        if ($exists) {
            echo json_encode(['exists' => true]);
        } else {
            echo json_encode(['exists' => false]);
        }
    } else {
        echo json_encode(['error' => 'UID not provided']);
    }
}
?>
