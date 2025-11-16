<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AD07Controller extends ZayaanController
{

    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N'); // Returns null if not present

        if ($request->ajax()) {
            if ($frommenu == 'Y') {
                return response()->json([
                    'page' => view('pages.AD07.AD07', [
                        'profile' => (new Profile())->fill(['seqn' => 0, 'is_active' => 1]),
                    ])->render(),
                    'content_header_title' => 'Access Profile',
                    'subtitle' => 'Access Profile',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.AD07.AD07-main-form', [
                        'profile' => (new Profile())->fill(['seqn' => 0, 'is_active' => 1]),
                    ])->render(),
                ]);
            }

            try {
                $profile = Profile::findOrFail($id);

                return response()->json([
                    'page' => view('pages.AD07.AD07-main-form', [
                        'profile' => $profile,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.AD07.AD07-main-form', [
                        'profile' => (new Profile())->fill(['seqn' => 0, 'is_active' => 1]),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.AD07.AD07',
            'content_header_title' => 'Access Profile',
            'subtitle' => 'Access Profile',
            'profile' => (new Profile())->fill(['seqn' => 0, 'is_active' => 1]),
        ]);
    }


    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'seqn' => 'required|integer',
        ], [
            'name.required' => 'Profile name is required',
            'seqn.required' => 'Sequence is required',
            'seqn.integer' => 'Sequence must be an integer',
        ]);

        $validator->validate();

        $request['is_active'] = $request->has('is_active');

        $profile = Profile::create($request->only([
            'name',
            'seqn',
            'is_active'
        ]));

        if ($profile) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD07', ['id' => 'RESET'])),
                // new ReloadSection('header-table-container', route('AD07.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Profile created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Profile creation failed");
        return $this->getResponse();
    }




}
