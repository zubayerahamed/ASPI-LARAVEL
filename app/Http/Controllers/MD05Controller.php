<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MD05Controller extends ZayaanController
{
    
     public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N');

        $businessId = getBusinessId();
        $allowCustomTags = getSelectedBusiness()['is_allow_custom_tags'] ?? false;
        if (!$allowCustomTags) {
            $businessId = null;
        }

        if ($request->ajax()) {
            if ($frommenu == 'Y') {

                $att = (new Tag())->fill(['is_active' => true]);

                if("RESET" != $id && is_numeric($id) && $id > 0) {
                    try {
                        $att = Tag::findOrFail($id);
                    } catch (\Throwable $th) {
                        Log::error("MD05Controller index error: " . $th->getMessage());
                    }
                }

                return response()->json([
                    'page' => view('pages.MD05.MD05', [
                        'allowCustomTags' => getSelectedBusiness() == null ? true : $allowCustomTags,
                        'tag' => $att,
                        'detailList' => Tag::relatedBusiness()->get()
                    ])->render(),
                    'content_header_title' => 'Tags Management',
                    'subtitle' => 'Tags',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.MD05.MD05-main-form', [
                        'allowCustomTags' => getSelectedBusiness() == null ? true : $allowCustomTags,
                        'tag' => (new Tag())->fill(['is_active' => true]),
                    ])->render(),
                ]);
            }

            try {
                $tag = Tag::findOrFail($id);

                return response()->json([
                    'page' => view('pages.MD05.MD05-main-form', [
                        'allowCustomTags' => getSelectedBusiness() == null ? true : $allowCustomTags,
                        'tag' => $tag,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.MD05.MD05-main-form', [
                        'allowCustomTags' => getSelectedBusiness() == null ? true : $allowCustomTags,
                        'tag' => (new Tag())->fill(['is_active' => true]),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.AD04.AD04',
            'content_header_title' => 'Tags Management',
            'subtitle' => 'Tags',
            'allowCustomTags' => getSelectedBusiness() == null ? true : $allowCustomTags,
            'tag' => (new Tag())->fill(['is_active' => true]),
            'detailList' => Tag::relatedBusiness()->get()
        ]);
    }

    public function headerTable()
    {
        $allowCustomTags = getSelectedBusiness()['is_allow_custom_tags'] ?? false;

        return response()->json([
            'page' => view('pages.MD05.MD05-header-table', [
                'allowCustomTags' => getSelectedBusiness() == null ? true : $allowCustomTags,
                'detailList' => Tag::relatedBusiness()->get()
            ])->render(),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 50 characters.',
        ]);

        $validator->validate();

        $request['is_active'] = $request->has('is_active');

        $request->merge(['business_id' => getBusinessId()]); // For now, set business_id to null

        $tag = Tag::create($request->only([
            'name',
            'description',
            'is_active',
            'business_id',
        ]));

        if ($tag) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD05', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('MD05.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Tag created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Tag creation failed");
        return $this->getResponse();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 50 characters.',
        ]);

        $validator->validate();

        $request['is_active'] = $request->has('is_active');

        try {
            $tag = Tag::findOrFail($id);

            $tag->update($request->only([
                'name',
                'description',
                'is_active',
            ]));

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD05', ['id' => $id])),
                new ReloadSection('header-table-container', route('MD05.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Tag updated successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            Log::error("MD05Controller update error: " . $th->getMessage());
            $this->setErrorStatusAndMessage("Tag update failed");
            return $this->getResponse();
        }
    }

    public function delete($id)
    {
        $tag = Tag::find($id);
        if (!$tag) {
            $this->setErrorStatusAndMessage("Tag not found");
            return $this->getResponse();
        }

        if ($tag->delete()) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD05', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('MD05.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Tag deleted successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Tag deletion failed");
        return $this->getResponse();
    }

}
