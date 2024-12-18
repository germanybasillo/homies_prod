<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Room;
use App\Models\Selected;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{


    public function create(): View
    {
        return view('room.add', [
            'selecteds' => Selected::all() // Pass the tenant profiles to the view
        ]);
     }
                public function store(Request $request)
                {
                    $request->validate([
                        
        'selected_id' => 'nullable|exists:selecteds,id|unique:rooms,selected_id,NULL,id,user_id,' . Auth::id(), // Ensure selected_id is unique per user
                        'start_date' => 'required|date',
                        'due_date' =>  'required|date|after_or_equal:start_date',
                    ], [
                        'due_date.after_or_equal' => 'The due date must be a date after or equal to the start date.',
                        'selected_id.unique' => 'This room is already selected. Please choose another one.',
                    ]);
            
                    $room = new Room($request->all());
            
                    // Assign the room to the currently authenticated user
                    $room->user_id = Auth::id();
                    $room->save();
            
                    return redirect('/tenantprofiles')->with('success', "Room has been inserted");
                }
}
