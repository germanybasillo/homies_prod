<?php

namespace App\Services;

use Twilio\Rest\Client;

class SmsService
{
    protected $twilio;

    public function __construct()
    {
        // Initialize Twilio client with your SID and Auth Token
        $this->twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.auth_token')
        );
    }

    // Method to send SMS
    public function sendSms($to, $message)
    {
        return $this->twilio->messages->create(
            $to, // Recipient's phone number
            [
                'from' => config('services.twilio.phone_number'), // Your Twilio phone number
                'body' => $message // The message to send
            ]
        );
    }
}
