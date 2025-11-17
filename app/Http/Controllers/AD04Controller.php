<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AD04Controller extends ZayaanController
{
    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N');


        if ($request->ajax()) {
            if ($frommenu == 'Y') {

                $att = (new Attribute())->fill(['seqn' => 0, 'is_active' => true]);

                if("RESET" != $id && is_numeric($id) && $id > 0) {
                    try {
                        $att = Attribute::findOrFail($id);
                    } catch (\Throwable $th) {
                        Log::error("AD04Controller index error: " . $th->getMessage());
                    }
                }

                return response()->json([
                    'page' => view('pages.AD04.AD04', [
                        'attribute' => $att,
                        'detailList' => Attribute::with(['terms'])->where('business_id', getBusinessId())->orderBy('seqn', 'asc')->get()
                    ])->render(),
                    'content_header_title' => 'Attribute Management',
                    'subtitle' => 'Attribute',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.AD04.AD04-main-form', [
                        'attribute' => (new Attribute())->fill(['seqn' => 0, 'is_active' => true]),
                    ])->render(),
                ]);
            }

            try {
                $attribute = Attribute::findOrFail($id);

                return response()->json([
                    'page' => view('pages.AD04.AD04-main-form', [
                        'attribute' => $attribute,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.AD04.AD04-main-form', [
                        'attribute' => (new Attribute())->fill(['seqn' => 0, 'is_active' => true]),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.AD04.AD04',
            'content_header_title' => 'Attribute Management',
            'subtitle' => 'Attribute',
            'attribute' => (new Attribute())->fill(['seqn' => 0, 'is_active' => true]),
            'detailList' => Attribute::with(['terms'])->where('business_id', getBusinessId())->orderBy('seqn', 'asc')->get()
        ]);
    }

    public function headerTable()
    {
        return response()->json([
            'page' => view('pages.AD04.AD04-header-table', [
                'detailList' => Attribute::with(['terms'])->where('business_id', getBusinessId())->orderBy('seqn', 'asc')->get()
            ])->render(),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'display_layout' => 'required|in:TEXT_SWATCH,DROPDOWN_SWATCH,VISUAL_SWATCH',
            'seqn' => 'nullable|integer|min:0',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 50 characters.',
            'display_layout.required' => 'The display layout field is required.',
            'display_layout.in' => 'The selected display layout is invalid.',
            'seqn.integer' => 'The sequence must be an integer.',
            'seqn.min' => 'The sequence must be at least 0.',
        ]);

        $validator->validate();

        $request['seqn'] = $request->input('seqn') ?? 0;
        $request['is_image_visual_swatch'] = $request->has('is_image_visual_swatch');
        $request['is_searchable'] = $request->has('is_searchable');
        $request['is_comparable'] = $request->has('is_comparable');
        $request['is_used_in_product_listing'] = $request->has('is_used_in_product_listing');
        $request['is_active'] = $request->has('is_active');

        $request->merge(['business_id' => getBusinessId()]); // For now, set business_id to null

        $attribute = Attribute::create($request->only([
            'name',
            'slug',
            'display_layout',
            'is_image_visual_swatch',
            'is_searchable',
            'is_comparable',
            'is_used_in_product_listing',
            'is_active',
            'seqn',
            'business_id',
        ]));

        if ($attribute) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD04', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('AD04.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Attribute created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Attribute creation failed");
        return $this->getResponse();
    }

    public function update(Request $request, $id)
    {
        // Similar validation and update logic as in create method
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'display_layout' => 'required|in:TEXT_SWATCH,DROPDOWN_SWATCH,VISUAL_SWATCH',
            'seqn' => 'nullable|integer|min:0',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 50 characters.',
            'display_layout.required' => 'The display layout field is required.',
            'display_layout.in' => 'The selected display layout is invalid.',
            'seqn.integer' => 'The sequence must be an integer.',
            'seqn.min' => 'The sequence must be at least 0.',
        ]);

        $validator->validate();

        $request['seqn'] = $request->input('seqn') ?? 0;
        $request['is_image_visual_swatch'] = $request->has('is_image_visual_swatch');
        $request['is_searchable'] = $request->has('is_searchable');
        $request['is_comparable'] = $request->has('is_comparable');
        $request['is_used_in_product_listing'] = $request->has('is_used_in_product_listing');
        $request['is_active'] = $request->has('is_active');

        $attribute = Attribute::find($id);
        if (!$attribute) {
            $this->setErrorStatusAndMessage("Attribute not found");
            return $this->getResponse();
        }

        $attribute->fill($request->only([
            'name',
            'display_layout',
            'is_image_visual_swatch',
            'is_searchable',
            'is_comparable',
            'is_used_in_product_listing',
            'is_active',
            'seqn',
        ]));

        if ($attribute->save()) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD04', ['id' => $attribute->id])),
                new ReloadSection('header-table-container', route('AD04.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Attribute updated successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Attribute update failed");
        return $this->getResponse();
    }

    public function delete($id)
    {
        $attribute = Attribute::find($id);
        if (!$attribute) {
            $this->setErrorStatusAndMessage("Attribute not found");
            return $this->getResponse();
        }

        if ($attribute->delete()) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD04', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('AD04.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Attribute deleted successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Attribute deletion failed");
        return $this->getResponse();
    }
}
