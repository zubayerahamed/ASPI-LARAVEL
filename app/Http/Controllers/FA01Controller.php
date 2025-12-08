<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\Acsub;
use App\Models\Xcodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FA01Controller extends ZayaanController
{
    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N');

        if ($request->ajax()) {
            if ($frommenu == 'Y') {

                $acsub = new Acsub();

                if ("RESET" != $id && is_numeric($id) && $id > 0) {
                    try {
                        $acsub = Acsub::findOrFail($id);
                    } catch (\Throwable $th) {
                        Log::error("FA01Controller index error: " . $th->getMessage());
                    }
                }

                return response()->json([
                    'page' => view('pages.FA01.FA01', [
                        'groups' => Xcodes::relatedBusiness()->active()->where('type', 'Customer Group')->get(),
                        'acsub' => $acsub,
                        'detailList' => Acsub::where('business_id', getBusinessId())->where('type', 'Customer')->get()
                    ])->render(),
                    'content_header_title' => 'Customer Management',
                    'subtitle' => 'Customers',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.FA01.FA01-main-form', [
                        'groups' => Xcodes::relatedBusiness()->active()->where('type', 'Customer Group')->get(),
                        'acsub' => new Acsub(),
                    ])->render(),
                ]);
            }

            try {
                $acsub = Acsub::findOrFail($id);

                return response()->json([
                    'page' => view('pages.FA01.FA01-main-form', [
                        'groups' => Xcodes::relatedBusiness()->active()->where('type', 'Customer Group')->get(),
                        'acsub' => $acsub,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.FA01.FA01-main-form', [
                        'groups' => Xcodes::relatedBusiness()->active()->where('type', 'Customer Group')->get(),
                        'acsub' => new Acsub(),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.FA01.FA01',
            'content_header_title' => 'Customer Management',
            'subtitle' => 'Customers',
            'groups' => Xcodes::relatedBusiness()->active()->where('type', 'Customer Group')->get(),
            'acsub' => new Acsub(),
            'detailList' => Acsub::where('business_id', getBusinessId())->where('type', 'Customer')->get()
        ]);
    }

    public function headerTable()
    {
        return response()->json([
            'page' => view('pages.FA01.FA01-header-table', [
                'detailList' => Acsub::where('business_id', getBusinessId())->where('type', 'Customer')->get()
            ])->render(),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'group' => 'required|string|max:100',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 100 characters.',
            'group.required' => 'The group field is required.',
            'group.string' => 'The group must be a string.',
            'group.max' => 'The group may not be greater than 100 characters.',
        ]);

        $validator->validate();

        $request->merge(['type' => 'Customer']);
        $request->merge(['business_id' => getBusinessId()]); // For now, set business_id to null

        $acsub = Acsub::create($request->only([
            'name',
            'description',
            'type',
            'group',
            'business_id',
        ]));

        if ($acsub) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('FA01', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('FA01.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Customer created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Customer creation failed");
        return $this->getResponse();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'group' => 'required|string|max:100',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 100 characters.',
            'group.required' => 'The group field is required.',
            'group.string' => 'The group must be a string.',
            'group.max' => 'The group may not be greater than 100 characters.',
        ]);

        $validator->validate();

        try {
            $acsub = Acsub::findOrFail($id);

            $acsub->update($request->only([
                'name',
                'description',
                'group',
            ]));

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('FA01', ['id' => $id])),
                new ReloadSection('header-table-container', route('FA01.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Customer updated successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("Customer update failed: " . $th->getMessage());
            return $this->getResponse();
        }
    }

    public function delete($id)
    {
        try {
            $acsub = Acsub::findOrFail($id);
            $acsub->delete();

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('FA01', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('FA01.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Customer deleted successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("Customer deletion failed");
            return $this->getResponse();
        }
    }

}
