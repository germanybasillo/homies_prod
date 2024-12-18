<?php

use App\Http\Controllers\GcashController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('welcome');
})->middleware(['auth', 'verified']);


Route::get('/dashboard', function () {

    // Get all users except the authenticated one
    $users = App\Models\User::where('id', '!=', auth()->id())->get();
    
    // Get all messages where the user is either the sender or receiver
    $bookingmessages = App\Models\BookingMessage::where('receiver_id', auth()->id())
                                  ->orWhere('sender_id', auth()->id())
                                  ->where('status', 'approaved')  // Ensure only 'pending' messages are retrieved
                                  ->get();

   $paymentmessages = App\Models\PaymentMessage::where('receiver_id', auth()->id())
                                                ->orWhere('sender_id', auth()->id())
                                                ->get();  

    // Return the dashboard view with the users and booking messages
    return view('dashboard', [
        'users' => $users,            // Corrected variable name
        'bookingmessages' => $bookingmessages, // Corrected variable name
    	'paymentmessages' => $paymentmessages, 
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

//Route::get('pay',[GcashController::class,'pay']);
//Route::get('success',[GcashController::class,'success']);
