<?php
require('../connection.php');

// Check if userId is provided via GET
if (isset($_GET['userId'])) {
    // Sanitize the input (assuming it's an integer)
    $userId = intval($_GET['userId']);

    try {
        // Prepare SQL statement to select is_active status
        $sql = "SELECT is_active FROM rfid_user WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        // Fetch the current status
        $isActive = $stmt->fetchColumn();

        if ($isActive !== false) {
            // Return success status with the current is_active value
            echo json_encode(['status' => 'success', 'is_active' => $isActive]);
        } else {
            // User not found
            echo json_encode(['status' => 'error', 'message' => 'User not found']);
        }
    } catch (PDOException $e) {
        // Handle PDO exceptions (database errors)
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }

    // Close connection
    $pdo = null;
} else {
    // If userId is not provided, return an error response
    echo json_encode(['status' => 'error', 'message' => 'User ID not provided']);
}
?>
