<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class AdduserController extends Controller
{
    public function adduser()
    {
    
    $viewPath = Auth::user()->user_type == 0
            ? 'superadmin.adduser'
            : '' ;
        return view($viewPath
        );
    }

    public function addadmin(Request $request)
    {

         // Create a new user instance
         $user = new User;
         
        $request->validate([
            'name' => 'required|string|max:150',
            'username' => 'required|string|unique:users,username',
        ],[
            'name.required' => 'The name field is required.',
            'username.unique' => 'This username has already been taken.',
        ]);
    
       
    
        // Assign values to user properties
        $user->name = $request->name;
        $user->username = trim($request->username);
        $user->password = Hash::make($request->password);
    
        // Generate custom ID
        $currentYear = Carbon::now()->format('Y');
        $latestUserId = User::latest('id')->first(); // Get the latest user ID
        $nextUserId = ($latestUserId) ? $latestUserId->id + 1 : 1; // Increment the latest user ID
        $admin_id = $currentYear . '-' . sprintf('%05d', $nextUserId); // Format the custom ID
    
        // Assign the custom ID to the user
        $user->admin_id = $admin_id;
    
        // Save the user to the database
        $user->save();
    
        return redirect()->back()->with('success', 'Employee successfully added');
    }
}
