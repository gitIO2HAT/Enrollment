<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class LoginDashboardController extends Controller
{
    public function login(Request $request)
    {

        return view('loginform.login');
    }
    public function forgetpassword(Request $request)
    {
        return view('loginform.forgetpassword');
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

public function sendResetLinkEmail(Request $request)
{
    try {
        // Step 1: Validate the inputs
        $validatedData = $request->validate([
            'questions' => 'required|integer|in:1,2,3,4,5,6,7,8,9,10',
            'answer' => 'required|string',
            'email' => 'required|email',
        ]);

        Log::info('Validated Request Data:', $validatedData);

        // Step 2: Fetch the user based on email
        $user = User::where('email', $validatedData['email'])->first();

        if (!$user) {
            Log::warning('User not found for email:', ['email' => $validatedData['email']]);
            return back()->withErrors(['email' => 'The provided email address does not exist in our records.']);
        }

        // Corrected: Compare the stored question and answer with the provided ones
        if ($user->questions != $validatedData['questions'] || $user->answer != $validatedData['answer']) {
            Log::warning('Security question or answer is incorrect.');
            return back()->withErrors([
                'questions' => 'The security question or answer is incorrect.',
                'answer' => 'The security question or answer is incorrect.'
            ]);
        }

        // Step 5: Send the password reset link
        $status = Password::sendResetLink(['email' => $user->email]);

        Log::info('Password reset link status:', ['status' => $status]);

        // Step 6: Return the appropriate response
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);

    } catch (\Exception $e) {
        Log::error('Error in sending password reset link:', ['message' => $e->getMessage()]);
        return back()->withErrors(['email' => 'There was an error sending the password reset link. Try again later.']);
    }
}








    public function logoutButton()
    {
        Auth::logout();
        return redirect(url(''));
    }

}

