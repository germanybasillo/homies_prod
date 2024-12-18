<?php

namespace App\Http\Controllers;
use App\Models\BookingMessage;
use App\Models\User;
use Illuminate\Http\Request;

class BookingMessageController extends Controller
{  
   public function create()
   {
        // Get all users except the authenticated user
     $users = User::where('id', '!=', auth()->id())->get();

      return view('booking_messages.create', compact('users'));
    }

    // Store a newly created billing message in the database
    public function store(Request $request)
    {
        // Validate the incoming request data
	 $request->validate([
        'receiver_id' => 'required|exists:users,id',
        'selected_id' => 'nullable|exists:selecteds,id|unique:booking_messages,selected_id', // Ensure selected_id is unique
        'start_date' => 'required|date',
        'address' => 'required|string',
        'due_date' => 'required|date|after_or_equal:start_date',
        'status' => 'required|string|max:50',
    ], [
        'selected_id.unique' => 'The selected option has already been booked. Please choose a different one.', // Custom error message
    ]);
        // Create the payment message
        BookingMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'selected_id' => $request->selected_id,
	    'start_date' => $request->start_date,
            'address' => $request->address,
	    'due_date' => $request->due_date,
	    'status' => $request->status,

        ]);

        // Redirect back with success message
        return redirect()->route('booking_messages.index')->with('success', 'Booking sent successfully!');
    }

    // Display all payment messages for the authenticated user
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        // Get all messages where the user is either the sender or receiver
        $bookingmessages = BookingMessage::where('receiver_id', auth()->id())
                                  ->orWhere('sender_id', auth()->id())
                                  ->where('status', 'approaved')  // Ensure only 'pending' messages are retrieved
                                  ->get();
        return view('booking_messages.index', compact('users', 'bookingmessages'));
    }



public function show()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        // Get all messages where the user is either the sender or receiver
        $bookingmessages = BookingMessage::where('receiver_id', auth()->id())
                                  ->orWhere('sender_id', auth()->id())
                                  ->get();

        return view('booking_messages.show', compact('users', 'bookingmessages'));
    }


    // Show the form to edit an existing payment message
    public function edit($id)
    {
        // Find the billing message by its ID
        $bookingMessage = BookingMessage::findOrFail($id);

        // Get all users except the authenticated user
        $users = User::where('id', '!=', auth()->id())->get();

        return view('booking_messages.edit', compact('bookingMessage', 'users'));
    }

    // Update the specified payment message in the database
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
	    $request->validate([
             'status' => 'required|in:pending,approaved',
                    ]);

        // Find the payment message by its ID
        $bookingMessage = BookingMessage::findOrFail($id);

        // Update the payment message
        $bookingMessage->update([
            'status' => $request->status,
        ]);

         return response()->json([
        'success' => true,
        'message' => 'Booking message updated successfully!',
        'status' => $bookingMessage->status, // Return updated status
	 ]);  
    }

    // Delete the specified payment message from the database
    public function destroy($id)
    {
        // Find the payment message by its ID
        $bookingMessage = BookingMessage::findOrFail($id);

        // Delete the payment message
        $bookingMessage->delete();

        // Redirect back with success message
        return redirect()->route('booking_messages.show')->with('success', 'Booking message deleted successfully!');
    }
}

