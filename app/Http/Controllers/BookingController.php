<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Booking;
use App\Models\Selected;
use App\Models\Selectbed;
use App\Models\Tenantprofile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(): View
    {
        // Show only the tenant profiles associated with the authenticated user
        return view('booking.view', [
		'bookings' => Booking::where('user_id', Auth::id())->get(),
		                        ]);
    }

    public function create(): View
    {
        return view('booking.add');
    }

    public function show(string $id): View
    {
        $booking = Booking::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('booking.edit', ['booking' => $booking]);
    }

    public function store(Request $request)
{
    // Validate the incoming request
	$validator = Validator::make($request->all(), [

        'selected_id' => 'nullable|exists:selecteds,id|unique:bookings,selected_id',
        'selectbed_id' => 'nullable|exists:selectbeds,id|unique:bookings,selected_id',
        'name' => ['nullable', 'string', 'min:1', 'max:50', 'regex:/^[\pL\s\-]+$/u'],
	'check_in' => 'required|date',
        'address' => 'required|string',
        'check_out' => 'required|date|after_or_equal:check_in',
	'status' => 'required|string|max:50',

    ]);
        
    // If validation fails, return a JSON response with errors
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }
        
    // Create a new booking if validation passes
    $booking = new Booking($request->all());
    $booking->user_id = Auth::id(); // Associate the profile with the authenticated user
    $booking->save();

return response()->json([
    'success' => 'Booking successful! Your room is reserved and wait for the owner to contact you and make approval!.'
]);

}    
    public function update(Request $request, $id)
    {
        $booking = Booking::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $validator = Validator::make($request->all(), [ 
		'status' => 'required|string|max:50',    
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
	}        

        $booking->update($request->all()); 
        $booking->save();

        return response()->json(['success' => 'Booking updated successfully!']);
    }
    
    public function destroy($id)
    {
        $booking = Booking::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $booking->delete();

        return redirect("/")->with('success', 'Booking info deleted successfully');
    }
}
