<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'email_password_separator' => 'required|string'
        ]);

        $user = auth()->user();
        $user->email_password_separator = $request->email_password_separator;
        $user->save();

        return redirect()->route('settings')->with('success', 'Settings updated successfully');
    }
}
