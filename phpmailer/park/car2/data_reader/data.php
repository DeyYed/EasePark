<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["data"])) {
    $data = htmlspecialchars($_GET["data"]);
    // Append the received data to a log file
    file_put_contents("data_log.txt", $data . PHP_EOL, FILE_APPEND);
    // Display a success message
    echo "Received data successfully!";
} else {
    http_response_code(400);
    echo "Invalid request";
}
?>
