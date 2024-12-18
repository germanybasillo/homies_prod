<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    public function index(): View
    {
        return view('billing.view', [
            'billings' => Billing::all(),
        ]);
    }

    public function create(): View
    {
        return view('billing.add');
    }

    public function show(string $id): View
    {
        return view('billing.edit', [
        'billing' => Billing::findOrFail($id)
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string',
		'billing' => 'required|numeric',

            ]
        );
    
        $billing = new Billing($request->all());
        $billing->user_id = auth()->id(); // Assign the authenticated user's ID
        $billing->save();
    
        return redirect('/billings')->with('success', "Billing Data Has Been inserted");
    }

   public function update(Request $request, $id)
{
    $request->validate(
        [
            'name' => 'required|string',
            'billing' => 'required|numeric',
        ]
    );

    $billing = Billing::findOrFail($id); // Use findOrFail to ensure the record exists

    // Optional: You can explicitly set the user_id again if needed
    $billing->user_id = auth()->id(); // Assign the authenticated user's ID
    $billing->update($request->all());

    return redirect('/billings')->with('success', "Billing Data Has Been updated");
}
    
    public function destroy($id)
    {
      $billing = Billing::find($id);
      $billing->delete();
      return redirect('/billings')
        ->with('success', 'Billing info deleted successfully');
    }
}
