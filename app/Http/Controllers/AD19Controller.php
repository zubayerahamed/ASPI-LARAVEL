<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\TaxCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AD19Controller extends ZayaanController
{
    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N');

        if ($request->ajax()) {
            if ($frommenu == 'Y') {

                $taxCategory = new TaxCategory();

                if ("RESET" != $id && is_numeric($id) && $id > 0) {
                    try {
                        $taxCategory = TaxCategory::findOrFail($id);
                    } catch (\Throwable $th) {
                        Log::error("AD19Controller index error: " . $th->getMessage());
                    }
                }

                return response()->json([
                    'page' => view('pages.AD19.AD19', [
                        'taxCategory' => $taxCategory,
                        'detailList' => TaxCategory::where('business_id', getBusinessId())->get()
                    ])->render(),
                    'content_header_title' => 'TAX Category',
                    'subtitle' => 'TAX Category',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.AD19.AD19-main-form', [
                        'taxCategory' => new TaxCategory(),
                    ])->render(),
                ]);
            }

            try {
                $taxCategory = TaxCategory::findOrFail($id);

                return response()->json([
                    'page' => view('pages.AD19.AD19-main-form', [
                        'taxCategory' => $taxCategory,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.AD19.AD19-main-form', [
                        'taxCategory' => new TaxCategory(),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.AD19.AD19',
            'content_header_title' => 'TAX Category',
            'subtitle' => 'TAX Category',
            'taxCategory' => new TaxCategory(),
            'detailList' => TaxCategory::where('business_id', getBusinessId())->get()
        ]);
    }

    public function headerTable()
    {
        return response()->json([
            'page' => view('pages.AD19.AD19-header-table', [
                'detailList' => TaxCategory::where('business_id', getBusinessId())->get()
            ])->render(),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
        ], [
            'name.required' => 'The TAX Category name is required.',
            'name.max' => 'The TAX Category name may not be greater than 100 characters.',
        ]);

        $validator->validate();

        // Check unique constraint
        $existing = TaxCategory::where('name', $request->input('name'))
            ->where('business_id', getBusinessId())
            ->first();

        if ($existing) {
            $this->setErrorStatusAndMessage("The TAX Category name has already been taken for this business.");
            return $this->getResponse();
        }

        $request->merge(['business_id' => getBusinessId()]);

        $taxCategory = TaxCategory::create($request->only([
            'name',
            'description',
            'business_id',
        ]));

        if ($taxCategory) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD19', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('AD19.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("TAX Category created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("TAX Category creation failed");
        return $this->getResponse();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
        ], [
            'name.required' => 'The TAX Category name is required.',
            'name.max' => 'The TAX Category name may not be greater than 100 characters.',
        ]);

        $validator->validate();

        try {
            $taxCategory = TaxCategory::findOrFail($id);

            // Check unique constraint
            $existing = TaxCategory::where('name', $request->input('name'))
                ->where('business_id', getBusinessId())
                ->where('id', '!=', $id)
                ->first();

            if ($existing) {
                $this->setErrorStatusAndMessage("The TAX Category name has already been taken for this business.");
                return $this->getResponse();
            }

            $taxCategory->name = $request->input('name');
            $taxCategory->description = $request->input('description');
            $taxCategory->save();

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD19', ['id' => $id])),
                new ReloadSection('header-table-container', route('AD19.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("TAX Category updated successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("TAX Category update failed: " . $th->getMessage());
            return $this->getResponse();
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $taxCategory = TaxCategory::findOrFail($id);
            $taxCategory->delete();

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD19', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('AD19.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("TAX Category deleted successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("TAX Category deletion failed: " . $th->getMessage());
            return $this->getResponse();
        }
    }
}
