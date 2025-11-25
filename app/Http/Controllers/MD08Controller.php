<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\ProductSpecificationGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MD08Controller extends ZayaanController
{
    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N');

        if ($request->ajax()) {
            if ($frommenu == 'Y') {

                $productSpecificationGroup = new ProductSpecificationGroup();

                if ("RESET" != $id && is_numeric($id) && $id > 0) {
                    try {
                        $productSpecificationGroup = ProductSpecificationGroup::findOrFail($id);
                    } catch (\Throwable $th) {
                        Log::error("MD08Controller index error: " . $th->getMessage());
                    }
                }

                return response()->json([
                    'page' => view('pages.MD08.MD08', [
                        'psGroup' => $productSpecificationGroup,
                        'detailList' => ProductSpecificationGroup::where('business_id', getBusinessId())->get()
                    ])->render(),
                    'content_header_title' => 'Product Specification Groups Management',
                    'subtitle' => 'Product Specification Groups',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.MD08.MD08-main-form', [
                        'psGroup' => new ProductSpecificationGroup(),
                    ])->render(),
                ]);
            }

            try {
                $productSpecificationGroup = ProductSpecificationGroup::findOrFail($id);

                return response()->json([
                    'page' => view('pages.MD08.MD08-main-form', [
                        'psGroup' => $productSpecificationGroup,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.MD08.MD08-main-form', [
                        'psGroup' => new ProductSpecificationGroup(),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.MD08.MD08',
            'content_header_title' => 'Product Specification Groups Management',
            'subtitle' => 'Product Specification Groups',
            'psGroup' => new ProductSpecificationGroup(),
            'detailList' => ProductSpecificationGroup::where('business_id', getBusinessId())->get()
        ]);
    }

    public function headerTable()
    {
        return response()->json([
            'page' => view('pages.MD08.MD08-header-table', [
                'detailList' => ProductSpecificationGroup::where('business_id', getBusinessId())->get()
            ])->render(),
        ]);
    }


    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 100 characters.',
        ]);

        $validator->validate();

        $request->merge(['business_id' => getBusinessId()]); // For now, set business_id to null

        $productSpecificationGroup = ProductSpecificationGroup::create($request->only([
            'name',
            'description',
            'business_id',
        ]));

        if ($productSpecificationGroup) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD08', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('MD08.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Product Specification Group created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Product Specification Group creation failed");
        return $this->getResponse();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 100 characters.',
        ]);

        $validator->validate();

        try {
            $productSpecificationGroup = ProductSpecificationGroup::findOrFail($id);

            $productSpecificationGroup->update($request->only([
                'name',
                'description',
            ]));

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD08', ['id' => $id])),
                new ReloadSection('header-table-container', route('MD08.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Product Specification Group updated successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("Product Specification Group update failed");
            return $this->getResponse();
        }
    }

    public function delete($id)
    {
        try {
            $productSpecificationGroup = ProductSpecificationGroup::findOrFail($id);
            $productSpecificationGroup->delete();

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD08', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('MD08.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Product Specification Group deleted successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("Product Specification Group deletion failed");
            return $this->getResponse();
        }
    }
}
