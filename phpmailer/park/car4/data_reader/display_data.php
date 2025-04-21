<?php
// Read the content of data_log.txt
$logContent = file_get_contents("data_log.txt");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Log</title>
</head>
<body>
    <h1>Data Log</h1>
    <pre><?php echo htmlspecialchars($logContent); ?></pre>
</body>
</html>
