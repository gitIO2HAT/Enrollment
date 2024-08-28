<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class LoginDashboardController extends Controller
{
    public function login(Request $request)
    {

        return view('loginform.login');
    }

    public function AuthLogin(Request $request)
{
    // Check if the user has agreed to data privacy terms

    // Retrieve the user by username
    $user = User::where('username', $request->username)->first();

    // Check if the user exists and if the 'deleted' flag is set to '2'
    if ($user && $user->deleted == '2') {
        return redirect()->back()->with('error', 'This account is not allowed to log in.');
    }

    $credentials = [
        'username' => $request->username,
        'password' => $request->password,
    ];

    if (Auth::attempt($credentials, true)) {
        $viewPath = Auth::user()->user_type == 0
            ? 'SuperAdmin/Enrollment'
            : '';

        return redirect($viewPath);
    } else {
        return redirect()->back()->with('error', 'Please input the correct username and password');
    }
}


    public function logoutButton()
    {
        Auth::logout();
        return redirect(url(''));
    }

}

