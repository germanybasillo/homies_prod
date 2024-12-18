<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
   public function create(): View
{
    // Check if rental owner and admin exist in the database
    $adminExists = User::where('user_type', 'admin')->exists();

    // Pass both variables to the view in one return statement
    return view('auth.register', [

        'adminExists' => $adminExists,
    ]);
}
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
 public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'min:2', 'max:50', 'regex:/^[\pL\s\-]+$/u', 'unique:' . User::class],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'user_type' => ['required', 'in:tenant,rental_owner,admin'],
        'number' => [
            'nullable',
            'string',
            'regex:/^(\+63|0)9\d{9}$/',
            'required_if:user_type,rental_owner',
        ],
        'status' => ['nullable', 'in:pending,approved', 'required_if:user_type,rental_owner'],
        'document' => ['nullable', 'mimes:pdf,doc,docx', 'max:2048', 'required_if:user_type,rental_owner'],
        'valid_id' => ['nullable', 'mimes:jpeg,jpg,png', 'max:2048', 'required_if:user_type,rental_owner'],
    ]);

    // Create the user first
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'user_type' => $request->user_type,
        'number' => $request->number,
        'status' => $request->status,
    ]);

    // Handle the document upload if present
       if ($request->hasFile('document')) {
            $file = $request->file('document');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('document', $filename, 'public');
            $user->document = 'storage/' . $path;
        }

    
   // Handle the file upload
        if ($request->hasFile('valid_id')) {
            $file = $request->file('valid_id');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('valid_id', $filename, 'public');
            $user->valid_id = 'storage/' . $path;
        }

    // Save the user with the uploaded files
    $user->save();

    event(new Registered($user));

    Auth::login($user);

    Session::flash('swal:register', 'Registration successful! Logging you in.');

    return redirect(RouteServiceProvider::HOME);
}    /**
     * Update the status of a user.
     */
    public function updateStatus(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:pending,approaved'],
        ]);

        $user->update(['status' => $request->status]);

        Session::flash('success', 'Status updated successfully.');

        return redirect()->back();
    }

    /**
     * Delete a user account.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        Session::flash('success', 'User account deleted successfully.');

        return redirect()->back();
    }
}

