<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\TaxComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AD17Controller extends ZayaanController
{

    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N');

        if ($request->ajax()) {
            if ($frommenu == 'Y') {

                $taxComponent = (new TaxComponent())->fill(['is_recoverable' => false]);

                if ("RESET" != $id && is_numeric($id) && $id > 0) {
                    try {
                        $taxComponent = TaxComponent::findOrFail($id);
                    } catch (\Throwable $th) {
                        Log::error("AD17Controller index error: " . $th->getMessage());
                    }
                }

                return response()->json([
                    'page' => view('pages.AD17.AD17', [
                        'taxComponent' => $taxComponent,
                        'detailList' => TaxComponent::where('business_id', getBusinessId())->get()
                    ])->render(),
                    'content_header_title' => 'TAX Component',
                    'subtitle' => 'TAX Components',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.AD17.AD17-main-form', [
                        'taxComponent' => (new TaxComponent())->fill(['is_recoverable' => false]),
                    ])->render(),
                ]);
            }

            try {
                $taxComponent = TaxComponent::findOrFail($id);

                return response()->json([
                    'page' => view('pages.AD17.AD17-main-form', [
                        'taxComponent' => $taxComponent,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.AD17.AD17-main-form', [
                        'taxComponent' => (new TaxComponent())->fill(['is_recoverable' => false]),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.AD17.AD17',
            'content_header_title' => 'TAX Component',
            'subtitle' => 'TAX Components',
            'taxComponent' => (new TaxComponent())->fill(['is_recoverable' => false]),
            'detailList' => TaxComponent::where('business_id', getBusinessId())->get()
        ]);
    }

    public function headerTable()
    {
        return response()->json([
            'page' => view('pages.AD17.AD17-header-table', [
                'detailList' => TaxComponent::where('business_id', getBusinessId())->get()
            ])->render(),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:10',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
        ], [
            'code.required' => 'The TAX Component code is required.',
            'code.max' => 'The TAX Component code may not be greater than 10 characters.',
            'name.required' => 'The TAX Component name is required.',
            'name.max' => 'The TAX Component name may not be greater than 100 characters.',
            'description.max' => 'The description may not be greater than 255 characters.',
        ]);

        $validator->validate();

        // Check unique constraint
        $existing = TaxComponent::where('code', $request->input('code'))
            ->where('business_id', getBusinessId())
            ->first();

        if ($existing) {
            $this->setErrorStatusAndMessage("The TAX Component code has already been taken for this business.");
            return $this->getResponse();
        }

        $request->merge(['is_recoverable' => $request->has('is_recoverable')]);
        $request->merge(['business_id' => getBusinessId()]);

        $taxComponent = TaxComponent::create($request->only([
            'code',
            'name',
            'description',
            'is_recoverable',
            'business_id',
        ]));

        if ($taxComponent) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD17', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('AD17.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("TAX Component created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("TAX Component creation failed");
        return $this->getResponse();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:10',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
        ], [
            'code.required' => 'The TAX Component code is required.',
            'code.max' => 'The TAX Component code may not be greater than 10 characters.',
            'name.required' => 'The TAX Component name is required.',
            'name.max' => 'The TAX Component name may not be greater than 100 characters.',
            'description.max' => 'The description may not be greater than 255 characters.',
        ]);

        $validator->validate();

        try {
            $taxComponent = TaxComponent::findOrFail($id);

            // Check unique constraint
            $existing = TaxComponent::where('code', $request->input('code'))
                ->where('business_id', getBusinessId())
                ->where('id', '!=', $id)
                ->first();

            if ($existing) {
                $this->setErrorStatusAndMessage("The TAX Component code has already been taken for this business.");
                return $this->getResponse();
            }

            $taxComponent->code = $request->input('code');
            $taxComponent->name = $request->input('name');
            $taxComponent->description = $request->input('description');
            $taxComponent->is_recoverable = $request->has('is_recoverable');

            if ($taxComponent->save()) {
                $this->setReloadSections([
                    new ReloadSection('main-form-container', route('AD17', ['id' => $id])),
                    new ReloadSection('header-table-container', route('AD17.header-table')),
                ]);
                $this->setSuccessStatusAndMessage("TAX Component updated successfully");
                return $this->getResponse();
            }

            $this->setErrorStatusAndMessage("TAX Component update failed");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("TAX Component not found");
            return $this->getResponse();
        }
    }

    public function delete($id)
    {
        try {
            $taxComponent = TaxComponent::findOrFail($id);
            $taxComponent->delete();

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD17', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('AD17.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("TAX Component deleted successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("TAX Component deletion failed");
            return $this->getResponse();
        }
    }
}
