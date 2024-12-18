<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Selected;
use App\Models\Hubrental;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class RoomSelected extends Controller
{

public function index(): View
{
    // Filter Hubrental data to only show those associated with the current authenticated user
    $hubrentals = Hubrental::where('user_id', Auth::id()) // Filter by the current authenticated user's ID
                            ->with(['selecteds' => function($query) {
                                $query->where('user_id', Auth::id()); // Ensure the selected data is for the current user
                            }])
                            ->get();

    return view('roomselected.view', compact('hubrentals'));
}

    public function create(): View
    {
           $hubrentals = Hubrental::where('user_id', Auth::id())->get();
	    return view('roomselected.add', compact('hubrentals'));
    }

    public function show(string $id): View
{
    $selected = Selected::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
    $hubrentals = Hubrental::where('user_id', Auth::id())->get();
    
    // Using compact to pass the variables
    return view('roomselected.edit', compact('selected', 'hubrentals'));
}
    public function store(Request $request)
    {
        $request->validate([
               'room_no' => [
        'required',
        'string',
        'regex:/^[a-zA-Z]+-\d+$/', // Must be in the format of letters-number, e.g., rom-123
        'unique:selecteds,room_no,NULL,id,user_id,' . Auth::id() . ',hubrental_id,' . $request->hubrental_id, // Ensure room_no and hubrental_id are unique for the current user
    ],   
     	    'description' => 'required|string',
            'profile1' => 'required|mimes:png,jpeg,jpg|max:2048',
            'profile2' => 'nullable|mimes:png,jpeg,jpg|max:2048',
            'profile3' => 'nullable|mimes:png,jpeg,jpg|max:2048',
            'profile4' => 'nullable|mimes:png,jpeg,jpg|max:2048',
            'profile5' => 'nullable|mimes:png,jpeg,jpg|max:2048',
            'profile6' => 'nullable|mimes:png,jpeg,jpg|max:2048',
            'caption1' => 'required|string',
            'caption2' => 'nullable|string',
            'caption3' => 'nullable|string',
            'caption4' => 'nullable|string',
            'caption5' => 'nullable|string',
	    'caption6' => 'nullable|string',
	    'bed_no' => 'required|string',
	    'bed_status' => 'required|in:available,occupied',
            'hubrental_id' => 'required|exists:hubrentals,id',
        ]);

        $selected = new Selected();
	$selected->room_no = $request->input('room_no');
	$selected->bed_no = $request->input('bed_no');
        $selected->description = $request->input('description');
	$selected->bed_status = $request->input('bed_status');
        $selected->hubrental_id = $request->hubrental_id;
        // Handle each profile image individually
        for ($i = 1; $i <= 6; $i++) {
            $profileField = 'profile' . $i;
            $captionField = 'caption' . $i;

            if ($request->hasFile($profileField)) {
                $file = $request->file($profileField);
                $filename = time() . "_$profileField." . $file->getClientOriginalExtension();
                $path = $file->storeAs('profiles', $filename, 'public');
                $selected->$profileField = 'storage/' . $path;
            }

            $selected->$captionField = $request->input($captionField);
        }

        $selected->user_id = Auth::id();
        $selected->save();

        return redirect('/selecteds')->with('success', "RoomSelected Has Been inserted");
    }

    public function update(Request $request, $id)
{
    $selected = Selected::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

    $request->validate([
        'room_no' => [
            'required',
            'string',
            'regex:/^[a-zA-Z]+-\d+$/', // Must be in the format of letters-number, e.g., rom-123
            // Ensure room_no and hubrental_id are unique for the current user, excluding the current record
            'unique:selecteds,room_no,' . $id . ',id,user_id,' . Auth::id() . ',hubrental_id,' . $request->hubrental_id,
        ],
        'description' => 'required|string',
        'profile1' => 'nullable|mimes:png,jpeg,jpg|max:2048',
        'profile2' => 'nullable|mimes:png,jpeg,jpg|max:2048',
        'profile3' => 'nullable|mimes:png,jpeg,jpg|max:2048',
        'profile4' => 'nullable|mimes:png,jpeg,jpg|max:2048',
        'profile5' => 'nullable|mimes:png,jpeg,jpg|max:2048',
        'profile6' => 'nullable|mimes:png,jpeg,jpg|max:2048',
        'caption1' => 'nullable|string',
        'caption2' => 'nullable|string',
        'caption3' => 'nullable|string',
        'caption4' => 'nullable|string',
        'caption5' => 'nullable|string',
        'caption6' => 'nullable|string',
        'bed_no' => 'required|string',
        'bed_status' => 'required|in:available,occupied',
            ]);

  $selected->room_no = $request->input('room_no');
    $selected->bed_no = $request->input('bed_no');
    $selected->description = $request->input('description');
    $selected->bed_status = $request->input('bed_status');
            for ($i = 1; $i <= 6; $i++) {
            $profileField = 'profile' . $i;
            $captionField = 'caption' . $i;

            if ($request->hasFile($profileField)) {
                $file = $request->file($profileField);
                $filename = time() . "_$profileField." . $file->getClientOriginalExtension();
                $path = $file->storeAs('profiles', $filename, 'public');
                $selected->$profileField = 'storage/' . $path;
            }

            if ($request->has($captionField)) {
                $selected->$captionField = $request->input($captionField);
            }
        }

        $selected->user_id = Auth::id();
        $selected->save();

        return redirect('/selecteds')->with('success', "RoomSelected Has Been updated");
    }

    public function destroy($id)
    {
        $selected = Selected::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();

        $selected->delete();

        return redirect('/selecteds')->with('success', 'Selected has been deleted successfully');
    }
}

