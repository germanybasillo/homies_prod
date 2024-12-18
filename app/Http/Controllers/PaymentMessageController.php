<?php

namespace App\Http\Controllers;
use App\Models\PaymentMessage;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentMessageController extends Controller
{
  
   public function create()
   {
        // Get all users except the authenticated user
     $users = User::where('id', '!=', auth()->id())->get();

      return view('payment_messages.create', compact('users'));
    }

    // Store a newly created billing message in the database
    public function store(Request $request)
    {
        // Validate the incoming request data
	    $request->validate([

          'receiver_id' => 'required|exists:users,id',
            'ownername' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'billingname' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'paymentmethod' => 'required|string|max:255',
            'total' => 'required|numeric|min:0',
            'fee' => 'required|numeric|min:0',
             'status' => 'required|in:pending,paid',
        ]);

        // Create the payment message
        PaymentMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'ownername' => $request->ownername,
	    'number' => $request->number,
            'billingname' => $request->billingname,
	    'price' => $request->price,
	    'paymentmethod' => $request->paymentmethod,
	    'total' => $request->total,
	    'fee' => $request->fee,
	    'status' => $request->status,

        ]);

        // Redirect back with success message
        return redirect()->route('payment_messages.index')->with('success', 'Payment message sent successfully!');
    }

    // Display all payment messages for the authenticated user
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        // Get all messages where the user is either the sender or receiver
        $paymentmessages = PaymentMessage::where('receiver_id', auth()->id())
                                  ->orWhere('sender_id', auth()->id())
                                  ->get();

        return view('payment_messages.index', compact('users', 'paymentmessages'));
    }



public function show()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        // Get all messages where the user is either the sender or receiver
        $paymentmessages = PaymentMessage::where('receiver_id', auth()->id())
                                  ->orWhere('sender_id', auth()->id())
                                  ->get();

        return view('payment_messages.show', compact('users', 'paymentmessages'));
    }


    // Show the form to edit an existing payment message
    public function edit($id)
    {
        // Find the billing message by its ID
        $paymentMessage = PaymentMessage::findOrFail($id);

        // Get all users except the authenticated user
        $users = User::where('id', '!=', auth()->id())->get();

        return view('payment_messages.edit', compact('paymentMessage', 'users'));
    }



    // Update the specified payment message in the database
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
	    $request->validate([
             'status' => 'required|in:pending,paid',
                    ]);

        // Find the payment message by its ID
        $paymentMessage = PaymentMessage::findOrFail($id);

        // Update the payment message
        $paymentMessage->update([
            'status' => $request->status,
        ]);

          return response()->json([
        'success' => true,
        'message' => 'Payment message updated successfully!',
        'status' => $paymentMessage->status, // Return updated status
	 ]);  
    }

    

    // Delete the specified payment message from the database
    public function destroy($id)
    {
        // Find the payment message by its ID
        $paymentMessage = PaymentMessage::findOrFail($id);

        // Delete the payment message
        $paymentMessage->delete();

        // Redirect back with success message
        return redirect()->route('payment_messages.show')->with('success', 'Billing message deleted successfully!');
    }
}




















