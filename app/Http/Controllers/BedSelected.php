<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Selectbed;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class BedSelected extends Controller
{
    public function index(): View
    {
        return view('bedselected.view', [
            'selectbeds' => Selectbed::where('user_id', Auth::id())->get(),
        ]);
    }

    public function create(): View
    {
        return view('bedselected.add');
    }

    public function show(string $id): View
    {
        $selectbed = Selectbed::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('bedselected.edit', ['selectbed' => $selectbed]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'bed_no' => [
                'required',
                'string',
                'regex:/^[a-zA-Z]+-\d+$/',  // Must be in the format of letters-number, e.g., bed-121
                'unique:selectbeds,bed_no,NULL,id,user_id,' . Auth::id(), // Ensure unique for the user
            ],
            'description' => 'required|string',
            'bed_status' => 'required|in:available,occupied',
        ]);

        // Create a new Selectbed record
        $selectbed = new Selectbed($request->all());
        $selectbed->user_id = Auth::id();  // Set user ID for the currently authenticated user
        $selectbed->save();

        return redirect('/selectbeds')->with('success', "BedSelected Data Has Been inserted");
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bed_no' => [
                'required',
                'string',
                'regex:/^[a-zA-Z]+-\d+$/',  // Must be in the format of letters-number, e.g., bed-121
                Rule::unique('selectbeds', 'bed_no')->ignore($id), // Ignore the current record for uniqueness check
            ],
            'description' => 'required|string',
            'bed_status' => 'required|in:available,occupied',
        ]);

        // Find and update the Selectbed record
        $selectbed = Selectbed::findOrFail($id);
        $selectbed->update($request->all());

        return redirect('/selectbeds')->with('success', "BedSelected Data Has Been updated");
    }

    public function destroy($id)
    {
        // Find and delete the Selectbed record for the current user
        $selectbed = Selectbed::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();

        $selectbed->delete();

        return redirect('/selectbeds')->with('success', 'BedSelected has been deleted successfully');
    }
}
