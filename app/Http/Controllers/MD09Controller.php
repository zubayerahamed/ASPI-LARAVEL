<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\ProductSpecificationAttribute;
use App\Models\ProductSpecificationAttributeOption;
use App\Models\ProductSpecificationGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MD09Controller extends ZayaanController
{
    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N');

        if ($request->ajax()) {
            if ($frommenu == 'Y') {

                $psa = new ProductSpecificationAttribute();

                if ("RESET" != $id && is_numeric($id) && $id > 0) {
                    try {
                        $psa = ProductSpecificationAttribute::findOrFail($id);
                    } catch (\Throwable $th) {
                        Log::error("MD09Controller index error: " . $th->getMessage());
                    }
                }

                return response()->json([
                    'page' => view('pages.MD09.MD09', [
                        'psGroups' => ProductSpecificationGroup::where('business_id', getBusinessId())->get(),
                        'psa' => $psa,
                        'detailList' => $psa->id == null ? Collection::empty() : ProductSpecificationAttributeOption::where('attribute_id', $psa->id)->get()
                    ])->render(),
                    'content_header_title' => 'Product Specification Attribute Management',
                    'subtitle' => 'Product Specification Attribute',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.MD09.MD09-main-form', [
                        'psGroups' => ProductSpecificationGroup::where('business_id', getBusinessId())->get(),
                        'psa' => new ProductSpecificationAttribute(),
                        'detailList' => Collection::empty(),
                    ])->render(),
                ]);
            }

            try {
                $psa = ProductSpecificationAttribute::findOrFail($id);

                return response()->json([
                    'page' => view('pages.MD09.MD09-main-form', [
                        'psGroups' => ProductSpecificationGroup::where('business_id', getBusinessId())->get(),
                        'psa' => $psa,
                        'detailList' => ProductSpecificationAttributeOption::where('attribute_id', $psa->id)->get()
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.MD09.MD09-main-form', [
                        'psGroups' => ProductSpecificationGroup::where('business_id', getBusinessId())->get(),
                        'psa' => new ProductSpecificationAttribute(),
                        'detailList' => Collection::empty(),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.MD09.MD09',
            'content_header_title' => 'Product Specification Attribute Management',
            'subtitle' => 'Product Specification Attribute',
            'psGroups' => ProductSpecificationGroup::where('business_id', getBusinessId())->get(),
            'psa' => new ProductSpecificationAttribute(),
            'detailList' => Collection::empty(),
        ]);
    }


    public function detailTable(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $attributeId = $request->query('attribute_id', 'RESET'); // Returns null if not present

        $psa = (new ProductSpecificationAttribute())->fill(['type' => 'text']);
        if ($attributeId != 'RESET' && is_numeric($attributeId) && $attributeId > 0) {
            try {
                $psa = ProductSpecificationAttribute::findOrFail($attributeId);
            } catch (\Throwable $th) {
                Log::error("MD09Controller detailTable error: " . $th->getMessage());
            }
        }

        return response()->json([
            'page' => view('pages.MD09.MD09-detail-table', [
                'psa' => $psa,
                'attributeDetail' => $id == 'RESET' ? (new ProductSpecificationAttributeOption())->fill(['attribute_id' => $attributeId]) : ProductSpecificationAttributeOption::find($id),
                'detailList' => $attributeId == 'RESET' ? Collection::empty() : ProductSpecificationAttributeOption::where('attribute_id', $attributeId)->get()
            ])->render(),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'type' => 'required|in:text,textarea,select,checkbox,radio',
            'default_value' => 'nullable|string|max:255',
            'group_id' => 'required|exists:product_specification_groups,id',
        ], [
            'name.required' => 'The Name field is required.',
            'name.max' => 'The Name may not be greater than 100 characters.',
            'type.required' => 'The Type field is required.',
            'type.in' => 'The selected Type is invalid.',
            'default_value.max' => 'The Default Value may not be greater than 255 characters.',
            'group_id.required' => 'The Associated Group field is required.',
            'group_id.exists' => 'The selected Associated Group is invalid.',
        ]);

        $validator->validate();

        $request->merge(['business_id' => getBusinessId()]);

        $psa = ProductSpecificationAttribute::create($request->only([
            'name',
            'type',
            'default_value',
            'group_id',
            'business_id',
        ]));

        if ($psa) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD09', ['id' => $psa->id])),
                new ReloadSection('detail-table-container', route('MD09.detail-table', ['id' => 'RESET', 'attribute_id' => $psa->id])),
            ]);
            $this->setSuccessStatusAndMessage("Product Specification Attribute created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Product Specification Attribute creation failed");
        return $this->getResponse();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'type' => 'required|in:text,textarea,select,checkbox,radio',
            'default_value' => 'nullable|string|max:255',
            'group_id' => 'required|exists:product_specification_groups,id',
        ], [
            'name.required' => 'The Name field is required.',
            'name.max' => 'The Name may not be greater than 100 characters.',
            'type.required' => 'The Type field is required.',
            'type.in' => 'The selected Type is invalid.',
            'default_value.max' => 'The Default Value may not be greater than 255 characters.',
            'group_id.required' => 'The Associated Group field is required.',
            'group_id.exists' => 'The selected Associated Group is invalid.',
        ]);

        $validator->validate();

        try {
            $psa = ProductSpecificationAttribute::findOrFail($id);

            $psa->update($request->only([
                'name',
                'type',
                'default_value',
                'group_id',
            ]));

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD09', ['id' => $psa->id])),
                new ReloadSection('detail-table-container', route('MD09.detail-table', ['id' => 'RESET', 'attribute_id' => $psa->id])),
            ]);
            $this->setSuccessStatusAndMessage("Product Specification Attribute updated successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("Product Specification Attribute update failed");
            return $this->getResponse();
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $psa = ProductSpecificationAttribute::findOrFail($id);
            $psa->delete();

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD09', ['id' => 'RESET'])),
                new ReloadSection('detail-table-container', route('MD09.detail-table', ['id' => 'RESET', 'attribute_id' => 'RESET'])),
            ]);
            $this->setSuccessStatusAndMessage("Product Specification Attribute deleted successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("Product Specification Attribute deletion failed");
            return $this->getResponse();
        }
    }

    public function detailCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'attribute_id' => 'required|exists:product_specification_attributes,id',
            'label' => 'required|string|max:100',
        ], [
            'attribute_id.required' => 'The Product Option field is required.',
            'attribute_id.exists' => 'The selected Product Option is invalid.',
            'label.required' => 'The Label field is required.',
            'label.max' => 'The Label may not be greater than 100 characters.',
        ]);

        $validator->validate();

        $productOptionDetail = ProductSpecificationAttributeOption::create($request->only([
            'label',
            'attribute_id',
        ]));

        if ($productOptionDetail) {
            $this->setReloadSections([
                new ReloadSection('detail-table-container', route('MD09.detail-table', ['id' => 'RESET', 'attribute_id' => $productOptionDetail->attribute_id])),
            ]);
            $this->setSuccessStatusAndMessage("Product Specification Attribute Detail created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Product Specification Attribute Detail creation failed");
        return $this->getResponse();
    }

    public function detailUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'attribute_id' => 'required|exists:product_specification_attributes,id',
            'label' => 'required|string|max:100',
        ], [
            'attribute_id.required' => 'The Product Option field is required.',
            'attribute_id.exists' => 'The selected Product Option is invalid.',
            'label.required' => 'The Label field is required.',
            'label.max' => 'The Label may not be greater than 100 characters.',
        ]);

        $validator->validate();

        try {
            $productOptionDetail = ProductSpecificationAttributeOption::findOrFail($id);

            $productOptionDetail->update($request->only([
                'label',
            ]));

            $this->setReloadSections([
                new ReloadSection('detail-table-container', route('MD09.detail-table', ['id' => $id, 'attribute_id' => $productOptionDetail->attribute_id])),
            ]);
            $this->setSuccessStatusAndMessage("Product Specification Attribute Detail updated successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("Product Specification Attribute Detail update failed");
            return $this->getResponse();
        }
    }

    public function detailDelete(Request $request, $id)
    {
        try {
            $productOptionDetail = ProductSpecificationAttributeOption::findOrFail($id);
            $attributeId = $productOptionDetail->attribute_id;
            $productOptionDetail->delete();

            $this->setReloadSections([
                new ReloadSection('detail-table-container', route('MD09.detail-table', ['id' => 'RESET', 'attribute_id' => $attributeId])),
            ]);
            $this->setSuccessStatusAndMessage("Product Specification Attribute Detail deleted successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("Product Specification Attribute Detail deletion failed");
            return $this->getResponse();
        }
    }
}
