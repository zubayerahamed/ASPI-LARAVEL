<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\BusinessUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AD07Controller extends ZayaanController
{
    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N');

        if ($request->ajax()) {
            if ($frommenu == 'Y') {

                $businessUnit = (new BusinessUnit())->fill(['seqn' => 0]);

                if ("RESET" != $id && is_numeric($id) && $id > 0) {
                    try {
                        $businessUnit = BusinessUnit::findOrFail($id);
                    } catch (\Throwable $th) {
                        Log::error("AD07Controller index error: " . $th->getMessage());
                    }
                }

                return response()->json([
                    'page' => view('pages.AD07.AD07', [
                        'businessUnit' => $businessUnit,
                        'detailList' => BusinessUnit::where('business_id', getBusinessId())->orderBy('seqn', 'asc')->get()
                    ])->render(),
                    'content_header_title' => 'Business Unit Management',
                    'subtitle' => 'Business Units',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.AD07.AD07-main-form', [
                        'businessUnit' => (new BusinessUnit())->fill(['seqn' => 0]),
                    ])->render(),
                ]);
            }

            try {
                $businessUnit = BusinessUnit::findOrFail($id);

                return response()->json([
                    'page' => view('pages.AD07.AD07-main-form', [
                        'businessUnit' => $businessUnit,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.AD07.AD07-main-form', [
                        'businessUnit' => (new BusinessUnit())->fill(['seqn' => 0]),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.AD07.AD07',
            'content_header_title' => 'Business Unit Management',
            'subtitle' => 'Business Units',
            'businessUnit' => (new BusinessUnit())->fill(['seqn' => 0]),
            'detailList' => BusinessUnit::where('business_id', getBusinessId())->orderBy('seqn', 'asc')->get()
        ]);
    }

    public function headerTable()
    {
        return response()->json([
            'page' => view('pages.AD07.AD07-header-table', [
                'detailList' => BusinessUnit::where('business_id', getBusinessId())->orderBy('seqn', 'asc')->get()
            ])->render(),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:20',
            'seqn' => 'required|numeric|min:0',
        ], [
            'name.required' => 'The Name field is required.',
            'name.max' => 'The Name may not be greater than 20 characters.',
            'seqn.required' => 'The Sequence Number field is required.',
            'seqn.numeric' => 'The Sequence Number must be a number.',
            'seqn.min' => 'The Sequence Number must be at least 0.',
        ]);

        $validator->validate();

        // Check unique constraint
        $existing = BusinessUnit::where('name', $request->input('name'))
            ->where('business_id', getBusinessId())
            ->first();

        if ($existing) {
            $this->setErrorStatusAndMessage("The Business Unit name has already been taken for this business.");
            return $this->getResponse();
        }

        $request->merge(['business_id' => getBusinessId()]);

        $businessUnit = BusinessUnit::create($request->only([
            'name',
            'description',
            'seqn',
            'business_id',
        ]));

        if ($businessUnit) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD07', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('AD07.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Business Unit created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Business Unit creation failed");
        return $this->getResponse();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:20',
            'seqn' => 'required|numeric|min:0',
        ], [
            'name.required' => 'The Name field is required.',
            'name.max' => 'The Name may not be greater than 20 characters.',
            'seqn.required' => 'The Sequence Number field is required.',
            'seqn.numeric' => 'The Sequence Number must be a number.',
            'seqn.min' => 'The Sequence Number must be at least 0.',
        ]);

        $validator->validate();

        try {
            $businessUnit = BusinessUnit::findOrFail($id);

            // Check unique constraint
            $existing = BusinessUnit::where('name', $request->input('name'))
                ->where('business_id', getBusinessId())
                ->where('id', '!=', $id)
                ->first();

            if ($existing) {
                $this->setErrorStatusAndMessage("The Business Unit name has already been taken for this business.");
                return $this->getResponse();
            }

            $businessUnit->update($request->only([
                'name',
                'description',
                'seqn',
            ]));

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD07', ['id' => $businessUnit->id])),
                new ReloadSection('header-table-container', route('AD07.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Business Unit updated successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("Business Unit update failed");
            return $this->getResponse();
        }
    }

    public function delete($id)
    {
        try {
            $businessUnit = BusinessUnit::findOrFail($id);
            $businessUnit->delete();

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD07', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('AD07.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Business Unit deleted successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("Business Unit deletion failed");
            return $this->getResponse();
        }
    }
}
