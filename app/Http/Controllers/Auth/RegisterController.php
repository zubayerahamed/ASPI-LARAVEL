<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ZayaanSessionManager;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_system_admin' => true,
            'is_business_admin' => false,
            'is_driver' => false,
            'is_customer' => false,
            'register_type' => 'REGULAR',
            'status' => 'active',
            'password_changed' => true,
        ]);

        return $user;
    }

    public function register(Request $request)
    {
        // Validation
        $this->validator($request->all())->validate();

        // Create user
        event(new Registered($user = $this->create($request->all())));

        // This is where authentication happens
        $this->guard()->login($user);

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

        Log::info('User registered and authenticated:', ['user_id' => $user->id, 'email' => $user->email]);

        // Redirect after registration
        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }
}
