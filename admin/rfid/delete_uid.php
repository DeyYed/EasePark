<?php
if (file_exists('uid.txt')) {
    file_put_contents('uid.txt', '');
    echo "UID file contents cleared";
} else {
    echo "UID file does not exist";
}
?>
