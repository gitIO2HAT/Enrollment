<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



class ProfileController extends Controller
{
    public function profile()
    {
        $viewPath = Auth::user()->user_type == 0
            ? 'superadmin.profile'
            : '';
        return view($viewPath, []);
    }

    public function updateprofile(Request $request)
{
    $id = Auth::user()->id;

    $messages = [
        'username.unique' => 'This username has already been taken.',
        'password.string' => 'Invalid password format.',
        'password.min' => 'The password must be at least 4 characters.',
        'questions.required' => 'The questions field is required.',
        'answer.required' => 'The answer field is required.',
    ];

    $request->validate([
        'name' => 'required|string|max:150',
        'sex' => 'nullable|in:1,2,3',
        'role' => 'nullable|string|max:30',
        'username' => 'nullable|string|unique:users,username,' . $id,
        'email' => 'nullable|email|unique:users,email,' . $id,
        'password' => 'nullable|string|min:4',
        'questions' => 'required|in:1,2,3,4,5,6,7,8,9,10',
        'answer' => 'required|string|max:150',
    ], $messages);

    $user = User::find($id);

    $user->name = $request->name;
    $user->sex = $request->sex;
    $user->role = $request->role;
    $user->username = $request->username;
    $user->email = $request->email;
    $user->questions = $request->questions;
    $user->answer =  trim($request->answer);


    if (!empty($request->password)) {
        $user->password = Hash::make($request->password);
    }

    if ($request->hasFile('profile_pic')) {
        $ext = $request->file('profile_pic')->getClientOriginalExtension();
        $file = $request->file('profile_pic');
        $randomStr = date('Ymdhis') . Str::random(20);
        $filename = strtolower($randomStr) . '.' . $ext;
        $file->move(public_path('public/accountprofile'), $filename);
        $user->profile_pic = $filename;
    }

    $user->save();
    return redirect()->back()->with('success', 'Your Profile successfully updated');
}

}
