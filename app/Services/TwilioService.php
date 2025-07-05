<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService {
    protected $client;
    protected $from;

    public function __construct() {
        $sid = env('TWILIO_ACCOUNT_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $this->from = env('TWILIO_PHONE_NUMBER');

        if (!$sid || !$token || !$this->from) {
            throw new \Exception('Twilio credentials missing!');
        }

        $this->client = new Client($sid, $token);
    }

    public function sendSMS($to, $message) {
        return $this->client->messages->create($to, [
            'from' => $this->from,
            'body' => $message
        ]);
    }
}
