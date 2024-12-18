<?php

namespace App\Http\Controllers;

use App\Models\Hubrental;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class HubrentalController extends Controller

{
    public function index(): View
    {
        // Show only the tenant profiles associated with the authenticated user
        return view('hubrental.view', [
		'hubrentals' =>Hubrental::where('user_id', Auth::id())->get(),
		                        ]);
    }

    public function create(): View
    {
        return view('hubrental.add');
    }

    public function show(string $id): View
    {
        $hubrental = Hubrental::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('hubrental.edit', ['hubrental' => $hubrental]);
    }

    public function store(Request $request)
    {
    $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
	    'type' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
	    'price' => 'required|string|max:255',    
	    'status' => 'required|string|max:50',
]);
        
         if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
	 }   

        $hubrental = new Hubrental($request->all());
        $hubrental->user_id = Auth::id(); // Associate the profile with the authenticated user

	$hubrental->save();
		
         return redirect()->back()->with('success','Hubrental has been inserted and wait for the admin to message you to make a approval.');

        
    }
    
    public function update(Request $request, $id)
    {
        $hubrental = Hubrental::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $validator = Validator::make($request->all(), [ 
	    'name' => 'required|string|max:255',
	    'type' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
	    'price' => 'required|string|max:255',    
	    'status' => 'required|string|max:50', 
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
	}        

        $hubrental->update($request->all()); 
        $hubrental->save();

            return redirect()->back()->with('success','Hubrental has been update and contact the admin to inform that yo change the location to approved!');

    }


public function changeStatus(Request $request, $id)
{
    $hubrental = Hubrental::find($id);

    if (!$hubrental) {
        return response()->json(['success' => false, 'message' => 'Hubrental not found.'], 404);
    }

    $request->validate([
        'status' => 'required|in:pending,paid',
    ]);

    $hubrental->status = $request->status;
    $hubrental->save();

    return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
}


    public function destroy($id)
{
    $hubrental = Hubrental::find($id);

    if (!$hubrental) {
        return redirect()->back()->with('error', 'Operator not found.');
    }

    $hubrental->delete();

    return redirect()->route('hubrentals.index')->with('success', 'Operator deleted successfully.');
    }

}
