<?php

require __DIR__ . '/vendor/autoload.php';

// Use your Vonage API credentials here
$apiKey = '63c2ad5d';              // Replace with your Nexmo API Key
$apiSecret = 'DBLSzDbD2b3ys7br';  // Replace with your Nexmo API Secret
$brandName = 'HomePet';      // Replace with your sender ID or phone number

// Recipient phone number in E.164 format (e.g., Cambodia +855 number)
$to = '855962689324'; // No plus sign according to Vonage docs (but check your setup)

// Initialize Vonage client
$basic  = new \Vonage\Client\Credentials\Basic($apiKey, $apiSecret);
$client = new \Vonage\Client($basic);

// Send SMS
$response = $client->sms()->send(
    new \Vonage\SMS\Message\SMS($to, $brandName, 'A text message sent using the Nexmo SMS API')
);

$message = $response->current();

if ($message->getStatus() == 0) {
    echo "The message was sent successfully\n";
} else {
    echo "The message failed with status: " . $message->getStatus() . "\n";
}
