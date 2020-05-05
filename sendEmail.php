<?php

$success = mail('alvinliu92@outlook.com', 'Hi Alvin', 'Here is a Message for you!');
if (!$success) {
    $errorMessage = error_get_last()['message'];
}
?>
