<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\Business;
use App\Models\BusinessUnit;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AD08Controller extends ZayaanController
{
    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N');

        if ($request->ajax()) {
            if ($frommenu == 'Y') {

                $store = (new Store())->fill(['seqn' => 0]);

                if ("RESET" != $id && is_numeric($id) && $id > 0) {
                    try {
                        $store = Store::findOrFail($id);
                    } catch (\Throwable $th) {
                        Log::error("AD08Controller index error: " . $th->getMessage());
                    }
                }

                return response()->json([
                    'page' => view('pages.AD08.AD08', [
                        'businessUnits' => BusinessUnit::where('business_id', getBusinessId())->orderBy('seqn', 'asc')->get(),
                        'store' => $store,
                        'detailList' => Store::with(['businessUnit'])->where('business_id', getBusinessId())->get()
                    ])->render(),
                    'content_header_title' => 'Store/Warehouse Management',
                    'subtitle' => 'Stores/Warehouses',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.AD08.AD08-main-form', [
                        'businessUnits' => BusinessUnit::where('business_id', getBusinessId())->orderBy('seqn', 'asc')->get(),
                        'store' => (new Store())->fill(['seqn' => 0]),
                    ])->render(),
                ]);
            }

            try {
                $store = Store::findOrFail($id);

                return response()->json([
                    'page' => view('pages.AD08.AD08-main-form', [
                        'businessUnits' => BusinessUnit::where('business_id', getBusinessId())->orderBy('seqn', 'asc')->get(),
                        'store' => $store,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.AD08.AD08-main-form', [
                        'businessUnits' => BusinessUnit::where('business_id', getBusinessId())->orderBy('seqn', 'asc')->get(),
                        'store' => (new Store())->fill(['seqn' => 0]),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.AD08.AD08',
            'content_header_title' => 'Store/Warehouse Management',
            'subtitle' => 'Stores/Warehouses',
            'store' => (new Store())->fill(['seqn' => 0]),
            'detailList' => Store::with(['businessUnit'])->where('business_id', getBusinessId())->orderBy('seqn', 'asc')->get()
        ]);
    }

    public function headerTable()
    {
        return response()->json([
            'page' => view('pages.AD08.AD08-header-table', [
                'detailList' => Store::with(['businessUnit'])->where('business_id', getBusinessId())->orderBy('seqn', 'asc')->get()
            ])->render(),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:20',
            'seqn' => 'required|numeric|min:0',
            'business_unit_id' => 'required|exists:business_units,id',
        ], [
            'name.required' => 'The Name field is required.',
            'name.max' => 'The Name may not be greater than 20 characters.',
            'seqn.required' => 'The Sequence Number field is required.',
            'seqn.numeric' => 'The Sequence Number must be a number.',
            'seqn.min' => 'The Sequence Number must be at least 0.',
            'business_unit_id.required' => 'The Business Unit field is required.',
            'business_unit_id.exists' => 'The selected Business Unit is invalid.',
        ]);

        $validator->validate();

        // Check unique constraint
        $existing = Store::where('name', $request->input('name'))
            ->where('business_unit_id', $request->input('business_unit_id'))
            ->where('business_id', getBusinessId())
            ->first();

        if ($existing) {
            $this->setErrorStatusAndMessage("The Store name has already been taken for this business unit in this business.");
            return $this->getResponse();
        }

        $request->merge(['business_id' => getBusinessId()]);

        $store = Store::create($request->only([
            'name',
            'description',
            'seqn',
            'business_unit_id',
            'business_id',
        ]));

        if ($store) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD08', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('AD08.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Store created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Store creation failed");
        return $this->getResponse();
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:20',
            'seqn' => 'required|numeric|min:0',
            'business_unit_id' => 'required|exists:business_units,id',
        ], [
            'name.required' => 'The Name field is required.',
            'name.max' => 'The Name may not be greater than 20 characters.',
            'seqn.required' => 'The Sequence Number field is required.',
            'seqn.numeric' => 'The Sequence Number must be a number.',
            'seqn.min' => 'The Sequence Number must be at least 0.',
            'business_unit_id.required' => 'The Business Unit field is required.',
            'business_unit_id.exists' => 'The selected Business Unit is invalid.',
        ]);

        $validator->validate();

        // Check unique constraint
        $existing = Store::where('name', $request->input('name'))
            ->where('business_unit_id', $request->input('business_unit_id'))
            ->where('business_id', getBusinessId())
            ->where('id', '!=', $id)
            ->first();

        if ($existing) {
            $this->setErrorStatusAndMessage("The Store name has already been taken for this business unit in this business.");
            return $this->getResponse();
        }

        try {
            $store = Store::findOrFail($id);

            $store->fill($request->only([
                'name',
                'description',
                'seqn',
                'business_unit_id',
            ]));

            if ($store->save()) {
                $this->setReloadSections([
                    new ReloadSection('main-form-container', route('AD08', ['id' => $store->id])),
                    new ReloadSection('header-table-container', route('AD08.header-table')),
                ]);
                $this->setSuccessStatusAndMessage("Store updated successfully");
                return $this->getResponse();
            }

            $this->setErrorStatusAndMessage("Store update failed");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("Store update failed: " . $th->getMessage());
            return $this->getResponse();
        }
    }

    public function delete($id)
    {
        try {
            $store = Store::findOrFail($id);
            $store->delete();

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD08', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('AD08.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Store deleted successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("Store deletion failed");
            return $this->getResponse();
        }
    }
}
