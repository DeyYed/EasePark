<?php
require('../connection.php');

// Check if userId is provided via POST
if (isset($_POST['userId'])) {
    // Sanitize the input (assuming it's an integer)
    $userId = intval($_POST['userId']);

    try {
        // Prepare SQL statement to set 'is_deleted' to 'fusshp' (mark as deleted)
        $sql = "UPDATE rfid_user SET is_deleted = 'fusshp' WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);

        // Execute the statement
        if ($stmt->execute()) {
            // If update is successful, return success status
            echo json_encode(['status' => 'success', 'message' => 'User marked as deleted']);
        } else {
            // If execution fails, return error status with message
            echo json_encode(['status' => 'error', 'message' => 'Failed to mark user as deleted']);
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
