<?php
require('../connection.php');

// Check if userId is provided via POST
if (isset($_POST['userId'])) {
    // Sanitize the input (assuming it's an integer)
    $userId = intval($_POST['userId']);

    try {
        // First, check the current status of the user
        $sql = "SELECT is_active FROM rfid_user WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        $stmt->execute();
        $currentStatus = $stmt->fetchColumn();

        // Toggle the status
        $newStatus = $currentStatus == 1 ? 0 : 1;
        $sql = "UPDATE rfid_user SET is_active = ? WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $newStatus, PDO::PARAM_INT);
        $stmt->bindParam(2, $userId, PDO::PARAM_INT);

        // Execute the update
        if ($stmt->execute()) {
            // Return success status
            echo json_encode(['status' => 'success', 'newStatus' => $newStatus]);
        } else {
            // Return error status with message
            echo json_encode(['status' => 'error', 'message' => 'Failed to toggle user status']);
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
