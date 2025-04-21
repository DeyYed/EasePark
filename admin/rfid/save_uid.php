<?php
require('../../connection.php');

header('Content-Type: application/json');

date_default_timezone_set('Asia/Manila');

$response = [];

if (isset($_GET['uid'])) {
    $uid = htmlspecialchars($_GET['uid']);
    file_put_contents('uid.txt', $uid);

    $stmt = $pdo->prepare("SELECT * FROM rfid_user WHERE rfid_uid = :uid AND is_active = 1");
    $stmt->execute(['uid' => $uid]);

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $plate_number = $user['plate_number'];
        $full_name = $user['first_name'] . ' ' . $user['last_name'];

        $current_date = date('Y-m-d');
        $time_now = date('Y-m-d H:i:s');
        $stmt = $pdo->prepare("SELECT * FROM parking_logs WHERE rfid_uid = :uid AND DATE(time_in) = :current_date AND time_out IS NULL");
        $stmt->execute(['uid' => $uid, 'current_date' => $current_date]);

        if ($stmt->rowCount() > 0) {
            $last_record = $stmt->fetch(PDO::FETCH_ASSOC);
            $last_time_in = $last_record['time_in'];

            $last_time = new DateTime($last_time_in);
            $current_time = new DateTime($time_now);
            $interval = $last_time->diff($current_time);
            $minutes_difference = ($interval->h * 60) + $interval->i;

            if ($minutes_difference < 2) {
                $response['status'] = 'error';
                $response['message'] = 'You have tapped too soon. Please wait before tapping again.';
            } else {
                $stmt = $pdo->prepare("UPDATE parking_logs SET time_out = :time_now WHERE rfid_uid = :uid AND DATE(time_in) = :current_date AND time_out IS NULL");
                $stmt->execute(['time_now' => $time_now, 'uid' => $uid, 'current_date' => $current_date]);

                $response['status'] = 'success';
                $response['message'] = 'Time out logged successfully';
            }
        } else {
            $stmt = $pdo->prepare("SELECT * FROM parking_logs WHERE rfid_uid = :uid AND DATE(time_out) = :current_date ORDER BY time_out DESC LIMIT 1");
            $stmt->execute(['uid' => $uid, 'current_date' => $current_date]);

            if ($stmt->rowCount() > 0) {
                $last_record = $stmt->fetch(PDO::FETCH_ASSOC);
                $last_time_out = $last_record['time_out'];

                $last_time = new DateTime($last_time_out);
                $current_time = new DateTime($time_now);
                $interval = $last_time->diff($current_time);
                $minutes_difference = ($interval->h * 60) + $interval->i;

                if ($minutes_difference < 2) {
                    $response['status'] = 'error';
                    $response['message'] = 'You have tapped too soon. Please wait before tapping again.';
                } else {
                    $stmt = $pdo->prepare("INSERT INTO parking_logs (rfid_uid, time_in, plate_number, name) VALUES (:uid, :time_now, :plate_number, :name)");
                    $stmt->execute(['uid' => $uid, 'time_now' => $time_now, 'plate_number' => $plate_number, 'name' => $full_name]);

                    $response['status'] = 'success';
                    $response['message'] = 'Time in logged successfully with plate number and name.';
                }
            } else {
                $stmt = $pdo->prepare("INSERT INTO parking_logs (rfid_uid, time_in, plate_number, name) VALUES (:uid, :time_now, :plate_number, :name)");
                $stmt->execute(['uid' => $uid, 'time_now' => $time_now, 'plate_number' => $plate_number, 'name' => $full_name]);

                $response['status'] = 'success';
                $response['message'] = 'Time in logged successfully with plate number and name.';
            }
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'RFID not registered or inactive';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'No UID provided';
}

echo json_encode($response);
?>
