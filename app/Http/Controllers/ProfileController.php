<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



class ProfileController extends Controller
{
    public function myaccount()
    {
        $viewPath = Auth::user()->user_type == 0
            ? 'superadmin.profile'
            : '';
        return view($viewPath, []);
    }

    public function updateprofile(Request $request)
    {
        // Debugging: Dump and Die to inspect the incoming request
        $id = Auth::user()->id;

        $messages = [
            'username.unique' => 'This email has already been taken.',
            'password.string' => 'Invalid password format.',
            'password.min' => 'The password must be at least 4 characters.',
            'questions.required' => 'The questions field is required.',
            'answer.required' => 'The answer of question field is required.',

        ];

        $request->validate([
            'name' => 'nullable|string|max:150',
            'sex' => 'nullable|in:Male,Female,Other',
            'civil_status' => 'nullable|in:Single,Married,Widowed',
            'fulladdress' => 'nullable|string|max:150',
            'username' => 'nullable|string|unique:users,username,' . $id,
            'password' => 'nullable|string|min:4',
            'questions' => 'required|string',
            'answer' => 'required|string|max:150',
        ], $messages);


        $user = User::getId($id);

        $user->name = $request->name;
        $user->sex = $request->sex;
        $user->civil_status = $request->civil_status;
        $user->fulladdress = $request->fulladdress;
        $user->username = $request->username;
        $user->questions = $request->questions;
        $user->answer = $request->answer;
    

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        if (!empty($request->file('profile_pic'))) {
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('public/accountprofile/', $filename);
            $user->profile_pic = $filename;
        }

        $user->save();
        return redirect()->back()->with('success', 'Your Profile successfully updated');
    }
}
