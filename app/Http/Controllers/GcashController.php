<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Session;

class GcashController extends Controller
{
   public function pay()
{
    $data = [
        'data' => [
            'attributes' => [
                'line_items' => [
                    [
                        'currency'    => 'PHP',
                        'amount'      => 10000,
                        'description' => 'text',
                        'name'        => 'Test Product',
                        'quantity'    => 1,
                    ],
                ],
                'payment_method_types' => ['gcash'],
                'success_url' => 'http://localhost:8000/success',
                'cancel_url'  => 'http://localhost:8000/cancel',
                'description' => 'text',
            ],
        ],
    ];

    $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions')
        ->withHeader('Content-Type: application/json')
        ->withHeader('Accept: application/json')
        ->withHeader('Authorization: Basic ' . env('AUTH_PAY'))
        ->withData($data)
        ->asJson()
        ->post();


    if (isset($response->data)) {
        Session::put('session_id', $response->data->id);
        return redirect()->to($response->data->attributes->checkout_url);
        }
    }
    
}