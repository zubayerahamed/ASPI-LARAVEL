<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Validator;

class SA02Controller extends ZayaanController
{
    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N'); // Returns null if not present

        if ($request->ajax()) {
            if ($frommenu == 'Y') {
                return response()->json([
                    'page' => view('pages.SA02.SA02', [
                        'countries' => $this->countriesList(),
                        'currencies' => $this->currenciesList(),
                        'businessCategories' => BusinessCategory::orderBy('seqn', 'asc')->get(),
                        'business' => (new Business())->fill(['is_active' => true]),
                        'detailList' => Business::with(['businessCategory'])->orderBy('name', 'asc')->get()
                    ])->render(),
                    'content_header_title' => 'Business',
                    'subtitle' => 'Business',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.SA02.SA02-main-form', [
                        'countries' => $this->countriesList(),
                        'currencies' => $this->currenciesList(),
                        'businessCategories' => BusinessCategory::orderBy('seqn', 'asc')->get(),
                        'business' => (new Business())->fill(['is_active' => true]),
                    ])->render(),
                ]);
            }


            try {
                $business = Business::findOrFail($id);

                return response()->json([
                    'page' => view('pages.SA02.SA02-main-form', [
                        'countries' => $this->countriesList(),
                        'currencies' => $this->currenciesList(),
                        'businessCategories' => BusinessCategory::orderBy('seqn', 'asc')->get(),
                        'business' => $business,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.SA02.SA02-main-form', [
                        'countries' => $this->countriesList(),
                        'currencies' => $this->currenciesList(),
                        'businessCategories' => BusinessCategory::orderBy('seqn', 'asc')->get(),
                        'business' => (new Business())->fill(['is_active' => true]),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.SA02.SA02',
            'content_header_title' => 'Business',
            'subtitle' => 'Business',
            'countries' => $this->countriesList(),
            'currencies' => $this->currenciesList(),
            'businessCategories' => BusinessCategory::orderBy('seqn', 'asc')->get(),
            'business' => (new Business())->fill(['is_active' => true]),
            'detailList' => Business::with(['businessCategory'])->orderBy('name', 'asc')->get()
        ]);
    }

    public function headerTable()
    {
        return response()->json([
            'page' => view('pages.SA02.SA02-header-table', [
                'detailList' => Business::with(['businessCategory'])->orderBy('name', 'asc')->get()
            ])->render(),
        ]);
    }

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'country' => 'required',
            'currency' => 'required',
            'business_category_id' => 'required|exists:business_categories,id',
            'email' => 'required|email',
            'mobile' => 'required|string',
        ], [
            'name.required' => 'The business name field is required.',
            'country.required' => 'The country field is required.',
            'currency.required' => 'The currency field is required.',
            'business_category_id.required' => 'The business category field is required.',
            'business_category_id.exists' => 'The selected business category is invalid.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'mobile.required' => 'The mobile field is required.',
        ]);

        $validator->validate();

        $request['is_active'] = $request->has('is_active');
        $request['is_inhouse'] = $request->has('is_inhouse');
        $request['is_pickup'] = $request->has('is_pickup');
        $request['is_delivery'] = $request->has('is_delivery');
        $request['is_allow_custom_menu'] = $request->has('is_allow_custom_menu');
        $request['is_allow_custom_category'] = $request->has('is_allow_custom_category');
        $request['is_allow_custom_attribute'] = $request->has('is_allow_custom_attribute');
        $request['is_allow_custom_xcodes'] = $request->has('is_allow_custom_xcodes');

        // Atleast one service type must be selected
        if (!($request['is_inhouse'] || $request['is_pickup'] || $request['is_delivery'])) {
            $this->setErrorStatusAndMessage("Atleast one service type must be selected (Inhouse, Pickup, Delivery)");
            return $this->getResponse();
        }

        $business = Business::create($request->only([
            'name',
            'country',
            'currency',
            'email',
            'mobile',
            'is_active',
            'is_inhouse',
            'is_pickup',
            'is_delivery',
            'is_allow_custom_menu',
            'is_allow_custom_category',
            'is_allow_custom_attribute', 
            'is_allow_custom_xcodes',
            'business_category_id',
        ]));

        if ($business) {
            // Assign this business to current user as well
            $user = User::find(FacadesAuth::id());
            $user->businesses()->attach($business->id);

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('SA02', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('SA02.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Business created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Business creation failed");
        return $this->getResponse();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'country' => 'required',
            'currency' => 'required',
            'business_category_id' => 'required|exists:business_categories,id',
            'email' => 'required|email',
            'mobile' => 'required|string',
        ], [
            'name.required' => 'The business name field is required.',
            'country.required' => 'The country field is required.',
            'currency.required' => 'The currency field is required.',
            'business_category_id.required' => 'The business category field is required.',
            'business_category_id.exists' => 'The selected business category is invalid.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'mobile.required' => 'The mobile field is required.',
        ]);

        $validator->validate();

        $request['is_active'] = $request->has('is_active');
        $request['is_inhouse'] = $request->has('is_inhouse');
        $request['is_pickup'] = $request->has('is_pickup');
        $request['is_delivery'] = $request->has('is_delivery');
        $request['is_allow_custom_menu'] = $request->has('is_allow_custom_menu');
        $request['is_allow_custom_category'] = $request->has('is_allow_custom_category');
        $request['is_allow_custom_attribute'] = $request->has('is_allow_custom_attribute');
        $request['is_allow_custom_xcodes'] = $request->has('is_allow_custom_xcodes');

        // Atleast one service type must be selected
        if (!($request['is_inhouse'] || $request['is_pickup'] || $request['is_delivery'])) {
            $this->setErrorStatusAndMessage("Atleast one service type must be selected (Inhouse, Pickup, Delivery)");
            return $this->getResponse();
        }

        $business = Business::find($id);
        if (!$business) {
            $this->setErrorStatusAndMessage("Business not found");
            return $this->getResponse();
        }

        $business->fill($request->only([
            'name',
            'country',
            'currency',
            'email',
            'mobile',
            'is_active',
            'is_inhouse',
            'is_pickup',
            'is_delivery',
            'is_allow_custom_menu',
            'is_allow_custom_category',
            'is_allow_custom_attribute',
            'is_allow_custom_xcodes',
            'business_category_id',
        ]));

        if ($business->save()) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('SA02', ['id' => $business->id])),
                new ReloadSection('header-table-container', route('SA02.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Business updated successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Business update failed");
        return $this->getResponse();
    }

    public function delete($id)
    {
        $business = Business::find($id);
        if (!$business) {
            $this->setErrorStatusAndMessage("Business not found");
            return $this->getResponse();
        }

        if ($business->delete()) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('SA02', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('SA02.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Business deleted successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Business deletion failed");
        return $this->getResponse();
    }

    // country list with codes
    public function countriesList()
    {
        return [
            ['code' => 'BD', 'name' => 'Bangladesh'],
        ];
    }

    // currency list with codes and names and symbols
    public function currenciesList()
    {
        return [
            ['code' => 'BDT', 'name' => 'Bangladeshi Taka', 'symbol' => '৳'],
        ];
    }
}
