<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\Acsub;
use App\Models\Xcodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FA02Controller extends ZayaanController
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
                        Log::error("FA02Controller index error: " . $th->getMessage());
                    }
                }

                return response()->json([
                    'page' => view('pages.FA02.FA02', [
                        'groups' => Xcodes::relatedBusiness()->active()->where('type', 'Supplier Group')->get(),
                        'acsub' => $acsub,
                        'detailList' => Acsub::where('business_id', getBusinessId())->where('type', 'Supplier')->get()
                    ])->render(),
                    'content_header_title' => 'Supplier Management',
                    'subtitle' => 'Suppliers',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.FA02.FA02-main-form', [
                        'groups' => Xcodes::relatedBusiness()->active()->where('type', 'Supplier Group')->get(),
                        'acsub' => new Acsub(),
                    ])->render(),
                ]);
            }

            try {
                $acsub = Acsub::findOrFail($id);

                return response()->json([
                    'page' => view('pages.FA02.FA02-main-form', [
                        'groups' => Xcodes::relatedBusiness()->active()->where('type', 'Supplier Group')->get(),
                        'acsub' => $acsub,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.FA02.FA02-main-form', [
                        'groups' => Xcodes::relatedBusiness()->active()->where('type', 'Supplier Group')->get(),
                        'acsub' => new Acsub(),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.FA02.FA02',
            'content_header_title' => 'Supplier Management',
            'subtitle' => 'Suppliers',
            'groups' => Xcodes::relatedBusiness()->active()->where('type', 'Supplier Group')->get(),
            'acsub' => new Acsub(),
            'detailList' => Acsub::where('business_id', getBusinessId())->where('type', 'Supplier')->get()
        ]);
    }

    public function headerTable()
    {
        return response()->json([
            'page' => view('pages.FA02.FA02-header-table', [
                'detailList' => Acsub::where('business_id', getBusinessId())->where('type', 'Supplier')->get()
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

        $request->merge(['type' => 'Supplier']);
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
                new ReloadSection('main-form-container', route('FA02', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('FA02.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Supplier created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Supplier creation failed");
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
                new ReloadSection('main-form-container', route('FA02', ['id' => $id])),
                new ReloadSection('header-table-container', route('FA02.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Supplier updated successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("Supplier update failed: " . $th->getMessage());
            return $this->getResponse();
        }
    }

    public function delete($id)
    {
        try {
            $acsub = Acsub::findOrFail($id);
            $acsub->delete();

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('FA02', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('FA02.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Supplier deleted successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("Supplier deletion failed");
            return $this->getResponse();
        }
    }
}
