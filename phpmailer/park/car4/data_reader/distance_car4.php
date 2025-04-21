<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["distance"])) {
    $distance = htmlspecialchars($_GET["distance"]);
    // Append the received distance data to a log file
    file_put_contents("distance_car_log.txt", $distance . PHP_EOL, FILE_APPEND);
    // Display a success message
    echo "Received distance data: " . $distance . " cm";
} else {
    http_response_code(400);
    echo "Invalid request";
}
?>
