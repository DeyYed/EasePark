<?php
if (isset($_GET['uid'])) {
    $uid = htmlspecialchars($_GET['uid']);
    file_put_contents('data_uid.txt', $uid);
    echo "UID saved successfully!";
} else {
    echo "No UID provided!";
}
?>
