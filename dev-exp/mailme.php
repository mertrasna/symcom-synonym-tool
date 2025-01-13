<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$sender = 'someone@somedomain.tld';
$recipient = 'jay3000bc@gmail.com';

$subject = "php mail test";
$message = "php test message";
$headers = 'From:' . $sender;

if (mail($recipient, $subject, $message, $headers))
{
    echo "Message accepted";
}
else
{
    echo "Error: Message not accepted";
}
?>