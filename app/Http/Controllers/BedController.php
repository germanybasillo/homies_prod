<?php

namespace App\Http\Controllers;
use Illuminate\View\View;
use App\Models\Bed;
use App\Models\Selectbed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BedController extends Controller
{

    public function create(): View
    {
        return view('bed.add',[
            'selectbeds' => Selectbed::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'selectbed_id' => 'required|exists:selectbeds,id|unique:beds,selectbed_id',
        ], [
            'selectbed_id.unique' => 'This bed is already selected. Please choose another one.',
        ]);

        $bed = new Bed($request->all());

        // Assign the bed to the currently authenticated user
        $bed->user_id = Auth::id();
        $bed->save();

        return redirect('/tenantprofiles')->with('success', "Bed-Management Data Has Been inserted");
    }

}
