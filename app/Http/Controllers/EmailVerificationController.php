<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerificationMail;
use App\Models\User;
use App\Traits\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class EmailVerificationController extends Controller
{

    use ResponseHelper;

    public function sendVerificationEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->status === 'active') {
            $this->setErrorStatusAndMessage("Email is already verified.");
            return $this->getResponse();
        }

        // Generate activation token
        $user->activation_token = Str::random(60);
        $user->save();

        // Send verification email
        $verificationUrl = route("verification.verify", ['token' => $user->activation_token]);
        
        Mail::to($user->email)->send(new EmailVerificationMail($user, $verificationUrl));

        $this->setSuccessStatusAndMessage("Verification email resent successfully.");
        return $this->getResponse();
    }

    public function verifyEmail($token)
    {
        // Logic to verify the email using the token
        // This could involve finding the user by token, updating their status, etc.

        // For demonstration, let's assume we find the user and verify their email
        $user = User::where('activation_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Invalid verification token.');
        }

        if ($user->status === 'active') {
            return redirect()->route('login')->with('status', 'Email already verified. You can log in.');
        }

        $user->email_verified_at = now();
        $user->activation_token = null; // Clear the token after verification
        $user->status = 'active'; // Update status to active
        $user->save();

        return redirect()->route('login')->with('status', 'Email verified successfully. You can now log in.');
    }

    public function resendVerificationEmail(Request $request)
    {
        return $this->sendVerificationEmail($request);
    }
}
