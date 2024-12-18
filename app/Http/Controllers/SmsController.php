<?php

namespace App\Http\Controllers;

use App\Services\SmsService;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class SmsController extends Controller
{
    protected $smsService;

    // Inject SmsService into the controller
    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    // Show the SMS form
    public function showForm()
    {
        return view('send_sms');
    }

   public function sendSms(Request $request)
    {
        // Validate the phone number and message
        $validated = $request->validate([
            'phone' => ['required', 'regex:/^(\+63|0)9\d{9}$/'],
            'message' => 'required|string|max:160',
        ]);

        // Normalize phone number if it's in local format (starts with 09)
        $phone = $request->input('phone');
        if (strpos($phone, '09') === 0 && strlen($phone) == 11) {
            $phone = '+63' . substr($phone, 1);  // Convert to international format
        }

        // Twilio credentials
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilio_number = env('TWILIO_PHONE_NUMBER');  // Your Twilio phone number, with country code

        // Create a new Twilio client
        $client = new Client($sid, $token);

        try {
            // Send SMS
            $client->messages->create(
                $phone,  // The recipient's phone number
                [
                    'from' => $twilio_number, // Your Twilio phone number
                    'body' => $request->input('message'), // The message body
                ]
            );

            return redirect()->back()->with('success', 'SMS sent successfully!');
        } catch (\Twilio\Exceptions\RestException $e) {
            return back()->withErrors(['phone' => 'Failed to send SMS: ' . $e->getMessage()]);
        }
    }
}
