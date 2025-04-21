<?php
require('../../connection.php');

$search = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = htmlspecialchars($_GET['search']);

    $sql = "SELECT parking_logs.*, parking_logs.name AS user_name 
            FROM parking_logs 
            WHERE parking_logs.name LIKE :search
            OR parking_logs.rfid_uid LIKE :search 
            OR parking_logs.plate_number LIKE :search
            OR parking_logs.time_in LIKE :search 
            OR parking_logs.time_out LIKE :search
            ORDER BY parking_logs.time_in DESC";
} else {
    $sql = "SELECT parking_logs.*, parking_logs.name AS user_name 
            FROM parking_logs 
            ORDER BY parking_logs.time_in DESC";
}

$stmt = $pdo->prepare($sql);
if (!empty($search)) {
    $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
}
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_OBJ);
$totalLogs = count($rows);
$output = "";
$index = 1;

if ($rows) {
    foreach ($rows as $row) {
        $class = ($index % 2 !== 0) ? 'table-row' : '';
        $output .= "<tr class='$class'>
                        <td class='reg-date'>" . htmlspecialchars($row->user_name) . "</td>
                        <td class='reg-date'>" . htmlspecialchars($row->rfid_uid) . "</td>
                        <td class='reg-date'>" . htmlspecialchars($row->plate_number) . "</td>
                        <td class='reg-date' style='color: green;'>" . htmlspecialchars($row->time_in) . "</td>
                        <td class='reg-date' style='color: red;'>" . htmlspecialchars($row->time_out) . "</td>
                    </tr>";
        $index++;
    }
}
$response = [
    'total' => $totalLogs,
    'data' => $output
];

echo json_encode($response);
?>
