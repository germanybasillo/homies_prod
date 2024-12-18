<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\BedController;
use App\Http\Controllers\BedSelected;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\BookingMessageController;
use App\Http\Controllers\MonthlyPayment;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BillingMessageController;
use App\Http\Controllers\PaymentMessageController;
use App\Http\Controllers\HubrentalController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomSelected;
use App\Http\Controllers\TenantprofileController;
use App\Http\Middleware\CheckUserType;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;


Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});



Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])

                ->name('logout');

    Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');


     Route::middleware([CheckUserType::class.':tenant', 'verified'])->group(function () {
                    // Resource route for tenant profiles
    Route::resource('/tenantprofiles', TenantProfileController::class);
        // Additional tenant profile routes
    Route::post('/tenantprofile/store', [TenantProfileController::class, 'store'])->name('tenantprofile.store');
    Route::put('/tenantprofiles/{id}', [TenantProfileController::class, 'update'])->name('tenantprofiles.update');

    //Route::resource('/rooms', RoomController::class)->middleware('checkRoomData');
    //Route::post('/room/store', [RoomController::class, 'store'])->name('room.store')->middleware('checkRoomData');

    //Route::resource('/beds', BedController::class)->middleware('checkBedData');
    //Route::post('/bed/store', [BedController::class, 'store'])->name('bed.store')->middleware('checkBedData');

    //Route::post('/payment/store', [PaymentController::class, 'store'])->name('payment.store');

    Route::get('/billing-messages/show', [BillingMessageController::class, 'show'])->name('billing_messages.show');

    Route::get('/payment-messages', [PaymentMessageController::class, 'index'])->name('payment_messages.index');
    // Route to display the form to send a new message
    Route::get('/payment-messages/create', [PaymentMessageController::class, 'create'])->name('payment_messages.create');
    // Route to store the new message
    Route::post('/payment-messages', [PaymentMessageController::class, 'store'])->name('payment_messages.store');
      
    Route::get('/billing-messages', [BillingMessageController::class, 'index'])->name('billing_messages.index');

  Route::get('/booking-messages', [BookingMessageController::class, 'index'])->name('booking_messages.index'); 
    Route::get('/booking-messages/create', [BookingMessageController::class, 'create'])->name('booking_messages.create');
    Route::post('/booking-messages', [BookingMessageController::class, 'store'])->name('booking_messages.store');
   

    //Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    //Route::get('/booking/create', [BookingController::class, 'create'])->name('bookings.create');
    //Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
   
     });

    Route::middleware([CheckUserType::class.':rental_owner','verified'])->group(function () {
        Route::resource('/selecteds', RoomSelected::class);
        Route::post('/selected/store', [RoomSelected::class, 'store'])->name('selected.store');
        Route::put('/selecteds/{id}', [RoomSelected::class, 'update'])->name('selecteds.update');
    
        //Route::resource('/selectbeds', BedSelected::class);
        //Route::post('/selectbed/store', [BedSelected::class, 'store'])->name('selectbed.store');
        //Route::put('/selectbeds/{id}', [BedSelected::class, 'update'])->name('selectbeds.update');



Route::put('/payment-messages/{id}', [PaymentMessageController::class, 'update'])->name('payment_messages.update');
     Route::delete('payment_messages/{id}', [PaymentMessageController::class, 'destroy'])->name('payment_messages.destroy');


        
        //Route::resource('/payments', PaymentController::class);
        //Route::put('payments/{id}', [PaymentController::class, 'update'])->name('payments.update');
	
        Route::get('/hubrental/create', [HubrentalController::class, 'create'])->name('hubrentals.create');
	Route::post('/hubrental/store', [HubrentalController::class, 'store'])->name('hubrental.store');
        Route::get('/hubrentals/{id}/edit', [HubrentalController::class, 'show'])->name('hubrentals.show');
        Route::put('/hubrentals/{id}', [HubrentalController::class, 'update'])->name('hubrentals.update');

        Route::get('/bedassign', [PageController::class, 'bedassign'])->name('bedassign');
        Route::get('/income', [PageController::class, 'income'])->name('income');
        Route::get('/collectibles', [PageController::class, 'collectibles'])->name('collectibles');
	Route::get('/map', [PageController::class, 'map'])->name('map');

        //Route::get('/booking', [PageController::class, 'booking'])->name('booking');
	//Route::put('/bookings/{id}', [BookingController::class, 'update'])->name('bookings.update');
	//Route::delete('/bookings/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');

 Route::get('/billing-messages', [BillingMessageController::class, 'index'])->name('billing_messages.index');
    // Route to display the form to send a new message
    Route::get('/billing-messages/create', [BillingMessageController::class, 'create'])->name('billing_messages.create');
    // Route to store the new message
    Route::post('/billing-messages', [BillingMessageController::class, 'store'])->name('billing_messages.store');
     Route::delete('billing_messages/{id}', [BillingMessageController::class, 'destroy'])->name('billing_messages.destroy');
Route::put('/billing-messages/{id}', [BillingMessageController::class, 'update'])->name('billing_messages.update');
Route::get('/payment-messages/show', [PaymentMessageController::class, 'show'])->name('payment_messages.show');

Route::put('/booking-messages/{id}', [BookingMessageController::class, 'update'])->name('booking_messages.update');
Route::get('/booking-messages/show', [BookingMessageController::class, 'show'])->name('booking_messages.show'); 
Route::delete('booking_messages/{id}', [BookingMessageController::class, 'destroy'])->name('booking_messages.destroy');


    });


    Route::middleware([CheckUserType::class.':admin'])->group(function () {
	    Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.form');

        Route::delete('/hubrentals/{id}', [HubrentalController::class, 'destroy'])->name('hubrentals.destroy');
        Route::get('/hubrentals', [HubrentalController::class, 'index'])->name('hubrentals.index');
	Route::post('/hubrentals/{id}/status', [HubrentalController::class, 'changeStatus'])->name('hubrentals.changeStatus');
Route::get('/pendingacc', [PageController::class, 'pendingacc'])->name('pendingacc');
Route::patch('/users/{user}/status', [RegisteredUserController::class, 'updateStatus'])->name('users.updateStatus');
Route::delete('/users/{user}', [RegisteredUserController::class, 'destroy'])->name('users.destroy');


        });
});
