<?php
session_start();
if (isset($_GET['uid'])) {
    $_SESSION['uid'] = htmlspecialchars($_GET['uid']);
    echo "UID received: " . $_SESSION['uid'];
}
?>
