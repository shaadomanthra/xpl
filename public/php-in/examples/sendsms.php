<?php

require('../textlocal.class.php');

$textlocal = new Textlocal('packetcode@gmail.com', 'c1120d3477ff90880eb3327e1526a4f76114d87812ad7d9da247eac6fdb74f13');

$numbers = array();
$sender = 'PKTPRP';
$message = 'Thank you for registering with PacketPrep. Your Verification Code is 45678';

try {
    $result = $textlocal->sendSms($numbers, $message, $sender);
    print_r($result);
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>