<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ForcePasswordChangeController extends Controller
{
    public function index(Request $request)
    {
        // Get data from session flash
        $status = $request->session()->get('status');
        $email = $request->session()->get('email');
        $userId = $request->session()->get('user_id');

        // If no session data, redirect to login
        if (!$email || !$userId) {
            return redirect()->route('login')->with('error', 'Invalid access to password setup.');
        }

        return view('auth.passwords.set_password', [
            'status' => $status,
            'email' => $email,
            'user_id' => $userId,
        ]);
    }

    public function setPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'user_id' => 'required|exists:users,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($request->user_id);

        // Check if user exists
        if (!$user) {
            return redirect()->back()->withInput()->withErrors(['user_id' => 'User not found.']);
        }

        // Check if user has already changed password
        if ($user->password_changed) {
            return redirect()->route('login')->with('status', 'Password has already been set. You can log in.');
        }

        // Check if email matches user ID
        if ($user->email !== $request->email) {
            return redirect()->back()->withInput()->withErrors(['email' => 'Email does not match the user ID.']);
        }

        // Update password and set password_changed to true
        $user->password = bcrypt($request->password);
        $user->password_changed = true;
        $user->save();

        return redirect()->route('login')->with('status', 'Password set successfully. You can log in.');
    }
}
