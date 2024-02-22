<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $userData = [
            'email' => $request->email,
            'email_password_separator' => $request->email_password_separator,
        ];

        if (!empty($request->password)) {
            $userData['password'] = bcrypt($request->password);
        }

        // Check if email already exists for another user
        $existingUser = User::where('email', $request->email)->where('id', '!=', $user->id)->first();
        if ($existingUser) {
            return redirect()->back()->with('error', 'Email already exists');
        }

        $user->fill($userData)->save();

        return redirect()->route('settings')->with('success', 'Settings updated successfully');
    }

}
