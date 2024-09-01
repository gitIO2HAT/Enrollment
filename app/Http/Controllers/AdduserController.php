<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class AdduserController extends Controller
{
    public function adduser(Request $request)
{
    // Ensure the user is authenticated and authorized to access this method
    if (Auth::check() && Auth::user()->user_type == 0) {
        // Fetch all users
        // or paginate if needed, e.g., User::paginate(10);

        $search = $request->input('search');

        $users = User::query();
        if ($search) {
            $users->where(function ($q) use ($search) {
                $q->whereRaw("CONCAT(name, ' ', id) LIKE ?", ["%$search%"]);
            });
        }
        $users->where('deleted', '=', 1);
        $users = $users->paginate(10);
        // Render the appropriate view
        return view('superadmin.adduser', ['users' => $users]);
    }
    // Handle unauthorized access
    return redirect()->route('home')->with('error', 'Unauthorized access');
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
        $admin_id = $currentYear . '-'.'adm' . sprintf('%03d', $nextUserId); // Format the custom ID
        // Assign the custom ID to the user
        $user->admin_id = $admin_id;
        // Save the user to the database
        $user->save();
        return redirect()->back()->with('success', 'User successfully added');
    }
    public function updateuser($id, Request $request)
    {

        $user = User::getId($id);
        $request->validate([
            'name' => 'required|string|max:50|unique:users,name,' . $request->id,
        ],[
            'name.unique' => 'This name has already been taken.',
        ]);
        $user->name = $request->name;
        $user->username = trim($request->username);
        $user->description = $request->description;
        $user->save();
        return redirect()->back()->with('success', 'Department successfully updated');
    }
    public function delete($id)
    {
        $user = User::getId($id);
        $user->deleted = 2;
        $user->save();
        return redirect()->back()->with('success', 'User successfully deleted!');

    }
}
