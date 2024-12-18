<?php

namespace App\Http\Controllers;
use App\Models\Tenantprofile;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Room;
use App\Models\Bed;
use App\Models\Billing;
use App\Models\Selected;
use App\Models\Selectbed;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TenantprofileController extends Controller
{
    public function index(): View
    {
        // Show only the tenant profiles associated with the authenticated user
        return view('tenantprofile.view', [
            'tenantprofiles' => Tenantprofile::where('user_id', Auth::id())->get(),
	    'rooms' => Room::where('user_id', Auth::id())->get(),
	    'bookings' => Room::where('user_id', Auth::id())->get(),
            'beds' => Bed::where('user_id', Auth::id())->get(),
            'selecteds' => Selected::all(),
            'selectbeds' => Selectbed::all(),
        ]);
    }

    public function create(): View
    {
        return view('tenantprofile.add');
    }

    public function show(string $id): View
    {
        $tenantprofile = Tenantprofile::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('tenantprofile.edit', ['tenantprofile' => $tenantprofile]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'name' => ['required', 'string', 'min:1', 'max:100', 'regex:/^[\pL\s\-]+$/u'],
            'email' => 'required|email|unique:tenantprofiles,email|gmail',
            'contact' => ['required', 'string', 'unique:tenantprofiles,contact', 'regex:/^(\+63|0)9\d{9}$/'],
            'address' => 'required|string|min:10|max:100',
            'gender' => 'required|string',
                     
        ]);

        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $tenantprofile = new Tenantprofile($request->all());
        $tenantprofile->user_id = Auth::id(); // Associate the profile with the authenticated user

     
        $tenantprofile->save();
        return response()->json(['success' => 'Tenant profile added successfully!']);
        
    }
    
    public function update(Request $request, $id)
    {
        $tenantprofile = Tenantprofile::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:1', 'max:100', 'regex:/^[\pL\s\-]+$/u'],
            'email' => ['required', 'email', 'unique:tenantprofiles,email,' . $id, function ($attribute, $value, $fail) {
                if (strpos($value, '@gmail.com') === false) {
                    $fail('The '.$attribute.' must be a valid Gmail address.');
                }
            }],
            'contact' => ['required', 'string', 'regex:/^(\+63|0)9\d{9}$/', 'unique:tenantprofiles,contact,' . $id],
            'address' => 'required|string|min:10|max:50',
            'gender' => 'required|string',
                    ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        

        $tenantprofile->update($request->all());

       

        $tenantprofile->save();

        return response()->json(['success' => 'Tenant profile updated successfully!']);
    }
    
    public function destroy($id)
    {
        $tenantprofile = Tenantprofile::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $tenantprofile->delete();

        return redirect("/tenantprofiles")->with('success', 'Tenantprofile info deleted successfully');
    }
}
