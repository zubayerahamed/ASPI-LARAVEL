<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\Business;
use App\Models\Profile;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AD06Controller extends ZayaanController
{

    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N'); // Returns null if not present
        $currentBusinessId = getBusinessId();

        // $users = User::with([
        //         'businesses', 
        //         'profiles' => function ($q) use ($currentBusinessId) {
        //             $q->wherePivot('business_id', $currentBusinessId);
        //         }
        //     ])
        //     ->where('is_system_admin', 0)
        //     ->where('is_business_admin', 0)
        //     ->where('is_driver', 0)
        //     ->where('is_customer', 0)
        //     ->get();
        // dd($users->toArray());


        // Get Business Admins list
        $businessAdmin = Business::find(getBusinessId())
            ->users()
            ->wherePivot('is_active', true)
            ->where('is_system_admin', 0)
            ->where('is_business_admin', 1)
            ->where('is_driver', 0)
            ->where('is_customer', 0)
            ->first();

        if (!$businessAdmin) {
            // Throw exception if no business admin found
            throw new Exception("No business admin found for the current business.");
        }

        $assignedBusinesses = $businessAdmin->businesses()->wherePivot('is_active', true)->get();
        // Filter current business from the list
        $otherBusinesseses = $assignedBusinesses->filter(function ($business) {
            return $business->id !== getBusinessId();
        })->values();
        // dd($otherBusinesseses->toArray());


        if ($request->ajax()) {
            if ($frommenu == 'Y') {
                return response()->json([
                    'page' => view('pages.AD06.AD06', [
                        'otherBusinesseses' => $otherBusinesseses,
                        'profiles' => Profile::active()->where('business_id', getBusinessId())->get(),
                        'user' => (new User())->fill(['status' => 'active']),
                        'detailList' => Business::with([
                            'users' => function ($q) use ($currentBusinessId) {
                                $q->wherePivot('is_active', true)
                                    ->where('is_system_admin', 0)
                                    ->where('is_business_admin', 0)
                                    ->where('is_driver', 0)
                                    ->where('is_customer', 0);
                            },
                            'users.businesses',
                            'users.profiles' => function ($q) use ($currentBusinessId) {
                                $q->wherePivot('business_id', $currentBusinessId);
                            },
                        ])->find(getBusinessId())->users
                    ])->render(),
                    'content_header_title' => 'Manage Users',
                    'subtitle' => 'Manage Users',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.AD06.AD06-main-form', [
                        'otherBusinesseses' => $otherBusinesseses,
                        'profiles' => Profile::active()->where('business_id', getBusinessId())->get(),
                        'user' => (new User())->fill(['status' => 'active']),
                    ])->render(),
                ]);
            }

            try {
                $user = User::findOrFail($id);

                return response()->json([
                    'page' => view('pages.AD06.AD06-main-form', [
                        'otherBusinesseses' => $otherBusinesseses,
                        'profiles' => Profile::active()->where('business_id', getBusinessId())->get(),
                        'user' => $user,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.AD06.AD06-main-form', [
                        'otherBusinesseses' => $otherBusinesseses,
                        'profiles' => Profile::active()->where('business_id', getBusinessId())->get(),
                        'user' => (new User())->fill(['status' => 'active']),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.AD06.AD06',
            'content_header_title' => 'Manage Users',
            'subtitle' => 'Manage Users',
            'otherBusinesseses' => $otherBusinesseses,
            'profiles' => Profile::active()->where('business_id', getBusinessId())->get(),
            'user' => (new User())->fill(['status' => 'active']),
            'detailList' => Business::with([
                'users' => function ($q) use ($currentBusinessId) {
                    $q->wherePivot('is_active', true)
                        ->where('is_system_admin', 0)
                        ->where('is_business_admin', 0)
                        ->where('is_driver', 0)
                        ->where('is_customer', 0);
                },
                'users.businesses' => function ($q) use ($currentBusinessId) {
                    $q->where('business_id', $currentBusinessId)->wherePivot('is_active', true);
                },
                'users.profiles' => function ($q) use ($currentBusinessId) {
                    $q->wherePivot('business_id', $currentBusinessId);
                },
            ])->find(getBusinessId())->users
        ]);
    }

    public function headerTable()
    {
        $currentBusinessId = getBusinessId();

        return response()->json([
            'page' => view('pages.AD06.AD06-header-table', [
                'detailList' => Business::with([
                    'users' => function ($q) use ($currentBusinessId) {
                        $q->wherePivot('is_active', true)
                            ->where('is_system_admin', 0)
                            ->where('is_business_admin', 0)
                            ->where('is_driver', 0)
                            ->where('is_customer', 0);
                    },
                    'users.businesses' => function ($q) use ($currentBusinessId) {
                        $q->where('business_id', $currentBusinessId)->wherePivot('is_active', true);
                    },
                    'users.profiles' => function ($q) use ($currentBusinessId) {
                        $q->wherePivot('business_id', $currentBusinessId);
                    },
                ])->find(getBusinessId())->users
            ])->render(),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'password_confirmation' => ['required', 'string', 'same:password'],
            'profile_ids' => ['required', 'array', 'min:1'],
            'profile_ids.*' => ['exists:profiles,id'],
            'business_ids' => ['nullable', 'array'],
            'business_ids.*' => ['exists:businesses,id'],
        ], [
            // Custom error messages can be added here
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 50 characters.',
            'email.required' => 'The email field is required.',
            'email.string' => 'The email must be a string.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'The email may not be greater than 255 characters.',
            'email.unique' => 'This email address is already registered.',
            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 8 characters.',
            'password_confirmation.required' => 'The password confirmation field is required.',
            'password_confirmation.string' => 'The password confirmation must be a string.',
            'password_confirmation.same' => 'The password confirmation does not match.',
            'profile_ids.required' => 'At least one profile must be selected.',
            'profile_ids.array' => 'Profile IDs must be an array.',
            'profile_ids.min' => 'At least one profile must be selected.',
            'profile_ids.*.exists' => 'One or more selected profiles do not exist.',
            'business_ids.array' => 'Business IDs must be an array.',
            'business_ids.*.exists' => 'One or more selected businesses do not exist.',
        ]);

        $validator->validate();

        $request['activation_token'] = Str::random(60);
        $request['status'] = $request->has('is_active') ? 'active' : 'inactive';
        $request['register_type'] = 'REGULAR';
        $request['latitude'] = null;
        $request['longitude'] = null;
        $request['is_system_admin'] = false;
        $request['is_business_admin'] = false;
        $request['is_driver'] = false;
        $request['is_customer'] = false;
        $request['password'] = bcrypt($request->input('password'));

        $user = User::create($request->only([
            'name',
            'email',
            'password',
            'activation_token',
            'status',
            'register_type',
            'latitude',
            'longitude',
            'is_system_admin',
            'is_business_admin',
            'is_driver',
            'is_customer',
        ]));

        if ($user) {
            // Attach businesses to the user
            $businessIds = $request->input('business_ids', []);
            $user->businesses()->attach($businessIds, ['is_active' => true]);
            $user->businesses()->attach(getBusinessId(), ['is_active' => true]);

            // Attach profiles to the user
            $profileIds = $request->input('profile_ids', []);
            $user->profiles()->attach($profileIds, ['business_id' => getBusinessId()]);

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD06', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('AD06.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("User created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("User creation failed. Please try again.");
        return $this->getResponse();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'password' => ['nullable', 'string', 'min:8'],
            'password_confirmation' => ['nullable', 'string', 'same:password'],
            'profile_ids' => ['required', 'array', 'min:1'],
            'profile_ids.*' => ['exists:profiles,id'],
            'business_ids' => ['nullable', 'array'],
            'business_ids.*' => ['exists:businesses,id'],
        ], [
            // Custom error messages can be added here
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 50 characters.',
            'email.required' => 'The email field is required.',
            'email.string' => 'The email must be a string.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'The email may not be greater than 255 characters.',
            'email.unique' => 'This email address is already registered.',
            'profile_ids.required' => 'At least one profile must be selected.',
            'profile_ids.array' => 'Profile IDs must be an array.',
            'profile_ids.min' => 'At least one profile must be selected.',
            'profile_ids.*.exists' => 'One or more selected profiles do not exist.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 8 characters.',
            'password_confirmation.string' => 'The password confirmation must be a string.',
            'password_confirmation.same' => 'The password confirmation does not match.',
            'business_ids.array' => 'Business IDs must be an array.',
            'business_ids.*.exists' => 'One or more selected businesses do not exist.',
        ]);

        $validator->validate();

        try {
            $user = User::findOrFail($id);

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->status = $request->has('is_active') ? 'active' : 'inactive';
            if ($request->filled('password')) {
                $user->password = bcrypt($request->input('password'));
            }

            if ($user->save()) {
                // Sync businesses
                $businessIds = $request->input('business_ids', []);
                $businessIds[] = getBusinessId(); // Ensure current business is included
                $user->businesses()->sync($businessIds);

                // Sync profiles, only for current business
                $profileIds = $request->input('profile_ids', []);
                $syncData = [];
                foreach ($profileIds as $profileId) {
                    $syncData[$profileId] = ['business_id' => getBusinessId()];
                }
                $user->profiles()->wherePivot('business_id', getBusinessId())->sync($syncData);

                $this->setReloadSections([
                    new ReloadSection('main-form-container', route('AD06', ['id' => $user->id])),
                    new ReloadSection('header-table-container', route('AD06.header-table')),
                ]);

                $this->setSuccessStatusAndMessage("User updated successfully");
                return $this->getResponse();
            }
        } catch (\Throwable $th) {
            Log::error("AD06Controller@update: " . $th->getMessage());
            $this->setErrorStatusAndMessage("User not found");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("User update failed. Please try again.");
        return $this->getResponse();
    }

    public function delete($id)
    {
        try {
            $user = User::findOrFail($id);

            // Detach all associated businesses and profiles
            $user->businesses()->detach();
            $user->profiles()->detach();

            $user->delete();

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD06', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('AD06.header-table')),
            ]);

            $this->setSuccessStatusAndMessage("User deleted successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            Log::error("AD06Controller@delete: " . $th->getMessage());
            $this->setErrorStatusAndMessage("User not found");
            return $this->getResponse();
        }
    }
}
