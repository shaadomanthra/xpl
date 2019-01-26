<?php
require('../textlocal.class.php');

$textlocal = new Textlocal('packetcode@gmail.com', 'apidemo123');

$numbers = array(918688079590);
$sender = 'PCKPRP';
$message = 'This is a sample message';

try {
    $result = $textlocal->sendSms($numbers, $message, $sender);
    print_r($result);
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>