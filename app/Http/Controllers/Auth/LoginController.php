<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ZayaanSessionManager;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm()
    {
        // Check database, that the user exist with System Administrator role
        $admin = User::where('is_system_admin', 1)->first();

        if (!$admin) {
            return view('auth.login', [
                'systemAdminExist' => false,
            ]);
        }

        return view('auth.login', [
            'systemAdminExist' => true,
        ]);
    }

    /**
     * Handle a login request to the application.
     */
    public function login(Request $request)
    {
        // Step 1: Basic validation
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // Step 2: Retrieve user record
        $user = User::where('email', $request->email)->first();

        // If user doesn't exist, fall back to default invalid credentials message
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => __('These credentials do not match our records.'),
            ]);
        }

        // Step 3: Custom pre-login checks
        if ($user->status !== 'active') {
            throw ValidationException::withMessages([
                'email' => 'Your account is not active yet.',
            ]);
        }

        if ($user->register_type !== 'REGULAR') {
            throw ValidationException::withMessages([
                'email' => 'Please log in using your social account.',
            ]);
        }

        if ($user->is_driver || $user->is_customer) {
            throw ValidationException::withMessages([
                'email' => 'Drivers and customers cannot log in here.',
            ]);
        }

        // Step 4: Attempt login
        if (Auth::attempt($this->credentials($request), $request->filled('remember'))) {
            $request->session()->regenerate();

            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            // Add user information to session
            ZayaanSessionManager::add('user_info', [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'register_type' => $user->activation_token,
                'status' => $user->status,
                'latitude' => $user->latitude,
                'longitude' => $user->longitude,
                'is_system_admin' => $user->is_system_admin,
                'is_business_admin' => $user->is_business_admin,
                'is_driver' => $user->is_driver,
                'is_customer' => $user->is_customer,
                'selected_business' => null,
            ]);

            return redirect()->intended($this->redirectPath());
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        // Step 5: Invalid password
        throw ValidationException::withMessages([
            'email' => __('Invalid email or password.'),
        ]);
    }
}
