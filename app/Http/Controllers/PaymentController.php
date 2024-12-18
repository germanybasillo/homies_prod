<?php

namespace App\Http\Controllers;

use App\Models\Bed;
use App\Models\Billing;
use App\Models\Payment;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index(): View
    {
        // Fetch rooms only for the currently authenticated user
        return view('payment.view', [
            'payments' => Payment::where('user_id', Auth::id())->get(),
        ]);
    }

    public function create(): View
    {
        return view('payment.add', [
            'billings' => Billing::all() // Pass the tenant profiles to the view
        ]);
    }

    public function show(string $id): View
    {
        // Fetch the room only if it belongs to the authenticated user
        $payment = Payment::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

                    return view('payment.edit', ['payment' => $payment]);
                }
            
                public function store(Request $request)
                {
                    $request->validate([
                    'name' => 'required|string|max:255',
                    'paymentmethod' => 'required|string|max:255',
                    'ownername' => 'nullable|string|max:255',
                    'number' => 'nullable|string|max:255',
                    'status' => 'required|string|max:50',
                    'total' => 'nullable|numeric',
                    'fee' => 'nullable|numeric',
                                        'room' => 'nullable|string',
                    'bed' => 'nullable|string',
                    'roomMonthly' => 'nullable|numeric',
                    'bedMonthly' => 'nullable|numeric',
                    'billingnameprice' => 'required|string|max:255',
                    ]);

                    $payment = new Payment($request->all());
            
                    // Assign the room to the currently authenticated user
                    $payment->user_id = Auth::id();
                    $payment->save();
            
                    return redirect('/tenantprofiles')->with('success', "Payment has been inserted");
                }
            
                public function update(Request $request, $id)
                {
                    // Validate the request
                    $request->validate([
                        'status' => 'required|string|max:50',
                    ]);
                
                    // Find the payment record
                    $payment = Payment::findOrFail($id);
                
                    // Update the status
                    $payment->status = $request->input('status');
                    $payment->save(); // Save the updated payment status
                
                    // Redirect back with a success message
                    return redirect()->back()->with('success', 'Payment status updated successfully!');
                }
                public function destroy($id)
                {
                    $payment = Payment::where('id', $id)
                                ->where('user_id', Auth::id())
                                ->firstOrFail();
            
                    $payment->delete();
            
                    return redirect('/payments')->with('success', 'Payment has been deleted successfully');
                }
            }
            
