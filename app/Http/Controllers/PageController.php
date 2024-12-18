<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\BookingMessage;
use App\Models\PaymentMessage;
use Illuminate\Http\Request;

use Stevebauman\Location\Facades\Location;

class PageController extends Controller
{
 
    public function income()
    {
      
        return view('page.income');
    }

    public function collectibles()
    {
	$users = User::where('id', '!=', auth()->id())->get();
    
    // Get all messages where the user is either the sender or receiver
    $paymentmessages = PaymentMessage::where('receiver_id', auth()->id())
                                      ->orWhere('sender_id', auth()->id())
                                      ->get();  
	 $bookingmessages = BookingMessage::where('receiver_id', auth()->id())
                                      ->orWhere('sender_id', auth()->id())
                                      ->get();  
        return view('page.collectibles', compact('users', 'paymentmessages','bookingmessages'));
    }

    public function profile()
    {
  
        return view('page.profile');
    }

    public function bedassign()
{
    $users = User::where('id', '!=', auth()->id())->get();
    
    // Get all messages where the user is either the sender or receiver
    $bookingmessages = BookingMessage::where('receiver_id', auth()->id())
                                      ->orWhere('sender_id', auth()->id())
                                      ->get();  

    return view('page.bedassign', compact('users', 'bookingmessages'));
}

 public function pendingacc()
    {
  
    return view('page.pendingacc');
    }





}
