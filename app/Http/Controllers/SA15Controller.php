<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Mail\EmailVerificationMail;
use App\Models\Business;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SA15Controller extends ZayaanController
{
    public function index(Request $request){
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N'); // Returns null if not present

        if ($request->ajax()) {
            if($frommenu == 'Y'){
                return response()->json([
                    'page' => view('pages.SA15.SA15', [
                        'businesses' => Business::orderBy('name', 'asc')->get(),
                        'user' => new User(),
                        'detailList' => User::with(['businesses'])->where('is_business_admin', true)->orderBy('id', 'desc')->get()
                    ])->render(),
                    'content_header_title' => 'Business Admins',
                    'subtitle' => 'Business Admins',
                ]);
            }

            if("RESET" == $id){
                return response()->json([
                    'page' => view('pages.SA15.SA15-main-form', [
                        'businesses' => Business::orderBy('name', 'asc')->get(),
                        'user' => new User(),
                    ])->render(),
                ]);
            }

            try {
                $user = User::findOrFail($id);

                return response()->json([
                    'page' => view('pages.SA15.SA15-main-form', [
                        'businesses' => Business::orderBy('name', 'asc')->get(),
                        'user' => $user,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.SA15.SA15-main-form', [
                        'businesses' => Business::orderBy('name', 'asc')->get(),
                        'user' => new User(),
                    ])->render(),
                ]);
            }
        }

         // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.SA15.SA15',
            'content_header_title' => 'Business Admins',
            'subtitle' => 'Business Admins',
            'businesses' => Business::orderBy('name', 'asc')->get(),
            'user' => new User(),
            'detailList' => User::with(['businesses'])->where('is_business_admin', true)->orderBy('id', 'desc')->get()
        ]);
    }

    public function headerTable(){
        return response()->json([
            'page' => view('pages.SA15.SA15-header-table', [
                'detailList' => User::with(['businesses'])->where('is_business_admin', true)->orderBy('id', 'desc')->get()
            ])->render(),
        ]);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'business_ids' => ['required', 'array', 'min:1'],
            'business_ids.*' => ['exists:businesses,id'],
        ], [
            'email.required' => 'The email field is required.',
            'email.string' => 'The email must be a string.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email may not be greater than 255 characters.',
            'email.unique' => 'The email has already been taken.',
            'business_ids.required' => 'Please select at least one business.',
            'business_ids.array' => 'Invalid business selection.',
            'business_ids.min' => 'Please select at least one business.',
            'business_ids.*.exists' => 'One or more selected businesses are invalid.',
        ]);

        $validator->validate();

        // Create new user
        $user = new User();
        $user->name = $request->input('name') ?: 'Business Admin';
        $user->email = $request->input('email');
        $user->password = bcrypt('12345678'); // Set a default password or generate one
        $user->is_business_admin = true;
        $user->status = 'pending'; // Set default status
        $user->register_type = 'REGULAR'; // Set default register type
        $user->activation_token = Str::random(60);
        
        if($user->save()){
            // Attach businesses to the user
            $businessIds = $request->input('business_ids', []);
            $user->businesses()->attach($businessIds, ['is_active' => true]);

            // Send verification email logic can be added here
            $verificationUrl = route("verification.verify", ['token' => $user->activation_token]);

            Mail::to($user->email)->send(new EmailVerificationMail($user, $verificationUrl));

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('SA15', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('SA15.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Business Admin created successfully and send verification email.");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Business Admin creation failed. Please try again.");
        return $this->getResponse();
    }
}
