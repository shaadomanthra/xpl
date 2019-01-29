<?php

require('../textlocal.class.php');

$textlocal = new Textlocal('packetcode@gmail.com', 'c1120d3477ff90880eb3327e1526a4f76114d87812ad7d9da247eac6fdb74f13');

$numbers = array(919515125110);
$sender = 'PKTPRP';
$message = 'Welcome to PacketPrep. Your Username is krishna,and Password is xYd34, website: packetprep.com';

try {
    $result = $textlocal->sendSms($numbers, $message, $sender);
    print_r($result);
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>