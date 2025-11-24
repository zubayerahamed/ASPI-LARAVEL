<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\ProductLabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MD06Controller extends ZayaanController
{
    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N');

        $businessId = getBusinessId();
        $allowCustomProductLabels = getSelectedBusiness()['is_allow_custom_product_labels'] ?? false;
        if (!$allowCustomProductLabels) {
            $businessId = null;
        }

        if ($request->ajax()) {
            if ($frommenu == 'Y') {

                $productLabel = (new ProductLabel())->fill(['is_active' => true, 'bg_color' => '#fe9931', 'text_color' => '#ffffff']);

                if ("RESET" != $id && is_numeric($id) && $id > 0) {
                    try {
                        $productLabel = ProductLabel::findOrFail($id);
                    } catch (\Throwable $th) {
                        Log::error("MD06Controller index error: " . $th->getMessage());
                    }
                }

                return response()->json([
                    'page' => view('pages.MD06.MD06', [
                        'allowCustomProductLabels' => getSelectedBusiness() == null ? true : $allowCustomProductLabels,
                        'productLabel' => $productLabel,
                        'detailList' => ProductLabel::relatedBusiness()->get()
                    ])->render(),
                    'content_header_title' => 'Product Labels Management',
                    'subtitle' => 'Product Labels',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.MD06.MD06-main-form', [
                        'allowCustomProductLabels' => getSelectedBusiness() == null ? true : $allowCustomProductLabels,
                        'productLabel' => (new ProductLabel())->fill(['is_active' => true, 'bg_color' => '#fe9931', 'text_color' => '#ffffff']),
                    ])->render(),
                ]);
            }

            try {
                $productLabel = ProductLabel::findOrFail($id);

                return response()->json([
                    'page' => view('pages.MD06.MD06-main-form', [
                        'allowCustomProductLabels' => getSelectedBusiness() == null ? true : $allowCustomProductLabels,
                        'productLabel' => $productLabel,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.MD06.MD06-main-form', [
                        'allowCustomProductLabels' => getSelectedBusiness() == null ? true : $allowCustomProductLabels,
                        'productLabel' => (new ProductLabel())->fill(['is_active' => true, 'bg_color' => '#fe9931', 'text_color' => '#ffffff']),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.AD04.AD04',
            'content_header_title' => 'Product Labels Management',
            'subtitle' => 'Product Labels',
            'allowCustomProductLabels' => getSelectedBusiness() == null ? true : $allowCustomProductLabels,
            'productLabel' => (new ProductLabel())->fill(['is_active' => true, 'bg_color' => '#fe9931', 'text_color' => '#ffffff']),
            'detailList' => ProductLabel::relatedBusiness()->get()
        ]);
    }

    public function headerTable()
    {
        $allowCustomProductLabels = getSelectedBusiness()['is_allow_custom_product_labels'] ?? false;

        return response()->json([
            'page' => view('pages.MD06.MD06-header-table', [
                'allowCustomProductLabels' => getSelectedBusiness() == null ? true : $allowCustomProductLabels,
                'detailList' => ProductLabel::relatedBusiness()->get()
            ])->render(),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'bg_color' => 'required|string|size:7',
            'text_color' => 'required|string|size:7',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 50 characters.',
            'bg_color.required' => 'The background color field is required.',
            'bg_color.string' => 'The background color must be a string.',
            'bg_color.size' => 'The background color must be exactly 7 characters.',
            'text_color.required' => 'The text color field is required.',
            'text_color.string' => 'The text color must be a string.',
            'text_color.size' => 'The text color must be exactly 7 characters.',
        ]);

        $validator->validate();

        $request['is_active'] = $request->has('is_active');

        $request->merge(['business_id' => getBusinessId()]); // For now, set business_id to null

        $productLabel = ProductLabel::create($request->only([
            'name',
            'bg_color',
            'text_color',
            'is_active',
            'business_id',
        ]));

        if ($productLabel) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD06', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('MD06.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Product Label created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Product Label creation failed");
        return $this->getResponse();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'bg_color' => 'required|string|size:7',
            'text_color' => 'required|string|size:7',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 50 characters.',
            'bg_color.required' => 'The background color field is required.',
            'bg_color.string' => 'The background color must be a string.',
            'bg_color.size' => 'The background color must be exactly 7 characters.',
            'text_color.required' => 'The text color field is required.',
            'text_color.string' => 'The text color must be a string.',
            'text_color.size' => 'The text color must be exactly 7 characters.',
        ]);

        $validator->validate();

        $request['is_active'] = $request->has('is_active');

        try {
            $productLabel = ProductLabel::findOrFail($id);

            $productLabel->update($request->only([
                'name',
                'bg_color',
                'text_color',
                'is_active',
            ]));

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD06', ['id' => $productLabel->id])),
                new ReloadSection('header-table-container', route('MD06.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Product Label updated successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("Product Label update failed: " . $th->getMessage());
            return $this->getResponse();
        }
    }

    public function delete($id)
    {
        $productLabel = ProductLabel::find($id);
        if (!$productLabel) {
            $this->setErrorStatusAndMessage("Product Label not found");
            return $this->getResponse();
        }

        if ($productLabel->delete()) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD06', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('MD06.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Product Label deleted successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Product Label deletion failed");
        return $this->getResponse();
    }
}
