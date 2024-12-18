<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // Show the form to send a message
    public function create()
    {
        // Get all users except the authenticated user
        $users = User::where('id', '!=', auth()->id())->get();

        return view('messages.create', compact('users'));
    }

    // Store the message in the database
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
        ]);

        // Create the new message
        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);

        return redirect()->route('messages.index')->with('success', 'Message sent!');
    }

    // Display all messages for the authenticated user
    public function index()
    {
        // Get all messages for the authenticated user
        $messages = Message::where('receiver_id', auth()->id())
                           ->orWhere('sender_id', auth()->id())
                           ->get();
        return view('messages.index', compact('messages'));
    }
}
