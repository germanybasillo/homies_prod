<?php

namespace App\Http\Controllers;

use App\Models\Contact; // Ensure you have a Contact model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function showForm()
    {
        // Fetch all contacts from the database
        $contacts = Contact::all();
        return view('contact', compact('contacts')); // Pass contacts to the view
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string',
            'comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Save the contact submission to the database
        Contact::create($request->only('name', 'email', 'comment'));

        return response()->json(['success' => 'Message sent successfully!']);
    }
}
