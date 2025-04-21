<?php
if (file_exists('data_uid.txt')) {
    file_put_contents('data_uid.txt', '');
    echo "UID file contents cleared";
} else {
    echo "UID file does not exist";
}
?>
