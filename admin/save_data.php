<?php
require('../connection.php'); // Make sure this file connects to your database

// Check if the request method is POST and required fields are set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'], $_POST['fname'], $_POST['lname'], $_POST['uid'], $_POST['plate'])) {
    $user_id = htmlspecialchars(strip_tags($_POST['user_id']));
    $new_fname = htmlspecialchars(strip_tags($_POST['fname']));
    $new_lname = htmlspecialchars(strip_tags($_POST['lname']));
    $new_uid = htmlspecialchars(strip_tags($_POST['uid']));
    $new_plate = htmlspecialchars(strip_tags($_POST['plate']));

    try {
        // Fetch current user data from the database
        $currentStmt = $pdo->prepare("SELECT first_name, last_name, rfid_uid, plate_number FROM rfid_user WHERE user_id = :user_id");
        $currentStmt->execute(['user_id' => $user_id]);
        $currentData = $currentStmt->fetch(PDO::FETCH_ASSOC);

        // If no data found, return an error
        if (!$currentData) {
            echo json_encode(['success' => false, 'message' => 'User not found.']);
            exit;
        }

        // Check if any values are changed
        if ($new_fname == $currentData['first_name'] && $new_lname == $currentData['last_name'] && $new_uid == $currentData['rfid_uid'] && $new_plate == $currentData['plate_number']) {
            echo json_encode(['success' => false, 'message' => 'No changes were made.']);
            exit;
        }

        // Check for duplicate UID in the database
        $checkUidStmt = $pdo->prepare("SELECT COUNT(*) FROM rfid_user WHERE rfid_uid = :uid AND user_id != :user_id");
        $checkUidStmt->execute(['uid' => $new_uid, 'user_id' => $user_id]);
        $uidExists = $checkUidStmt->fetchColumn();

        // Check for duplicate plate number in the database
        $checkPlateStmt = $pdo->prepare("SELECT COUNT(*) FROM rfid_user WHERE plate_number = :plate AND user_id != :user_id");
        $checkPlateStmt->execute(['plate' => $new_plate, 'user_id' => $user_id]);
        $plateExists = $checkPlateStmt->fetchColumn();

        if ($uidExists > 0) {
            echo json_encode(['success' => false, 'message' => 'UID already exists.']);
            exit;
        }

        if ($plateExists > 0) {
            echo json_encode(['success' => false, 'message' => 'Plate number already exists.']);
            exit;
        }

        // Update the database table if changes exist
        $stmt = $pdo->prepare("UPDATE rfid_user SET first_name = :fname, last_name = :lname, rfid_uid = :uid, plate_number = :plate WHERE user_id = :user_id");
        $stmt->execute([
            'fname' => $new_fname,
            'lname' => $new_lname,
            'uid' => $new_uid,
            'plate' => $new_plate,
            'user_id' => $user_id,
        ]);

        echo json_encode(['success' => true, 'message' => 'Data updated successfully.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error: Invalid request']);
}
?>
