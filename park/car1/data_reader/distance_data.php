<?php
$logFile = "distance_car_log.txt";
// $timeout = 7;
// $newData = 251;
// $maintenanceTimeout = 30;

if (file_exists($logFile) && is_readable($logFile)) {
    $fileModTime = filemtime($logFile);
    $currentTime = time();
    $lines = file($logFile);
    $lastLine = trim(end($lines));

    // if (($currentTime - $fileModTime) > $maintenanceTimeout) {
    //     echo json_encode([
    //         'status' => 'Maintenance'
    //     ]);
    //     exit;
    // }

    if (!empty($lastLine)) {
        $distance = (float)$lastLine;
        $status = ($distance >= 10 && $distance <= 100) ? 'Occupied' : 'Available';
        if (($currentTime - $fileModTime) > $timeout) {
            if ($distance != $newData) {
                file_put_contents($logFile, $newData . PHP_EOL, FILE_APPEND);
                $distance = $newData;
                $status = 'Occupied';
            }
        }
    } else {
        $distance = $newData;
        $status = 'Occupied';
        file_put_contents($logFile, $newData . PHP_EOL);
    }
    echo json_encode([
        'distance' => $distance,
        'status' => $status
    ]);
} else {
    echo json_encode(['error' => 'Log file not found or not readable']);
}
