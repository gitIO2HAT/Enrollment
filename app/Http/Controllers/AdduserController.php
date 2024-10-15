<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AdduserController extends Controller
{
    public function adduser(Request $request)
    {
        // Ensure the user is authenticated and authorized to access this method
        if (Auth::check() && Auth::user()->admin_id == '2024-adm-001') {
            // Fetch all users
            // or paginate if needed, e.g., User::paginate(10);

            $search = $request->input('search');

            $users = User::query();
            if ($search) {
                $users->where(function ($q) use ($search) {
                    $q->whereRaw("CONCAT(name, ' ', id) LIKE ?", ["%$search%"]);
                    $q->whereRaw("CONCAT(email, ' ', id) LIKE ?", ["%$search%"]);
                });
            }
            $users->where('deleted', '=', 1);
            $users = $users->paginate(10);
            // Render the appropriate view
            return view('superadmin.adduser', ['users' => $users]);
        }
        // Handle unauthorized access
        return redirect('/')->with('error', 'Unauthorized access');

    }
    public function deleteuser(Request $request)
    {
        // Ensure the user is authenticated and authorized to access this method
        if (Auth::check() && Auth::user()->admin_id == '2024-adm-001') {
            // Fetch all users
            // or paginate if needed, e.g., User::paginate(10);

            $search = $request->input('search');

            $users = User::query();
            if ($search) {
                $users->where(function ($q) use ($search) {
                    $q->whereRaw("CONCAT(name, ' ', id) LIKE ?", ["%$search%"]);
                    $q->whereRaw("CONCAT(email, ' ', id) LIKE ?", ["%$search%"]);
                });
            }
            $users->where('deleted', '=', 2);
            $users = $users->paginate(10);
            // Render the appropriate view
            return view('superadmin.deleteuser', ['users' => $users]);
        }
        // Handle unauthorized access
        return redirect('/')->with('error', 'Unauthorized access');

    }
    public function addadmin(Request $request)
    {
        // Maximum length for the name
        $maxNameLength = 150;
    
        // Check if the name field is empty or exceeds the max length
        if (empty($request->name) || strlen($request->name) > $maxNameLength) {
            // Log that the name is invalid
            Log::warning('Name field is invalid:', ['name' => $request->name]);
    
            // Redirect back with an error message for name validation
            return redirect()->back()->with(['error' => 'The name field is required and must not exceed ' . $maxNameLength . ' characters.']);
        }
    
        // Check if the username already exists
        if (User::where('username', $request->username)->exists()) {
            // Log that the username is already taken
            Log::warning('Username already exists:', ['username' => $request->username]);
    
            // Redirect back with an error message for username uniqueness
            return redirect()->back()->with(['error' => 'This username has already been taken.']);
        }
    
        // Check if the email is valid and already exists
        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            // Log that the email format is invalid
            Log::warning('Invalid email format:', ['email' => $request->email]);
    
            // Redirect back with an error message for email format
            return redirect()->back()->with(['error' => 'The email format is invalid.']);
        }
    
        if (User::where('email', $request->email)->exists()) {
            // Log that the email is already taken
            Log::warning('Email already exists:', ['email' => $request->email]);
    
            // Redirect back with an error message for email uniqueness
            return redirect()->back()->with(['error' => 'This email has already been taken.']);
        }
    
        // Proceed with adding the user if no validation errors
        $user = new User;
        $user->name = $request->name;
        $user->username = trim($request->username);
        $user->role = $request->role;
        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
    
        // Generate custom ID
        $currentYear = Carbon::now()->format('Y');
        $latestUserId = User::latest('id')->first(); // Get the latest user ID
        $nextUserId = ($latestUserId) ? $latestUserId->id + 1 : 1; // Increment the latest user ID
        $admin_id = $currentYear . '-' . 'adm' . '-' . sprintf('%03d', $nextUserId); // Format the custom ID
        $user->admin_id = $admin_id;
    
        // Save the user to the database
        $user->save();
    
        return redirect()->back()->with('success', 'User successfully added');
    }
    
    public function updateuser($id, Request $request)
{
    // Retrieve the user by ID
    $user = User::find($id);
    if (!$user) {
        // Log that the user was not found
        Log::warning('User not found:', ['id' => $id]);

        // Redirect back with an error message if the user does not exist
        return redirect()->back()->with(['error' => 'User not found.']);
    }

    // Maximum length for the name
    $maxNameLength = 150;

    // Check if the name field is empty or exceeds the max length
    if (empty($request->name) || strlen($request->name) > $maxNameLength) {
        // Log that the name is invalid
        Log::warning('Name field is invalid:', ['name' => $request->name]);

        // Redirect back with an error message for name validation
        return redirect()->back()->with(['error' => 'The name field is required and must not exceed ' . $maxNameLength . ' characters.']);
    }

    // Check if the email is valid
    if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
        // Log that the email format is invalid
        Log::warning('Invalid email format:', ['email' => $request->email]);

        // Redirect back with an error message for email format
        return redirect()->back()->with(['error' => 'The email format is invalid.']);
    }

    // Check if the email already exists in the database, excluding the current user
    if (User::where('email', $request->email)->where('id', '!=', $id)->exists()) {
        // Log that the email is already taken
        Log::warning('Email already exists:', ['email' => $request->email]);

        // Redirect back with an error message for email uniqueness
        return redirect()->back()->with(['error' => 'This email has already been taken.']);
    }

    // Update user properties
    $user->name = $request->name;
    $user->email = trim($request->email);
    $user->username = trim($request->username);
    $user->role = $request->role;

    // Save the updated user to the database
    $user->save();

    // Redirect back with a success message
    return redirect()->back()->with('success', 'User successfully updated');
}

    public function delete($id)
    {
        $user = User::getId($id);
        $user->deleted = 2;
        $user->save();
        return redirect()->back()->with('success', 'User successfully deleted!');
    }
    public function restore($id)
    {
        $user = User::getId($id);
        $user->deleted = 1;
        $user->save();
        return redirect()->back()->with('success', 'User successfully restored!');
    }
}
