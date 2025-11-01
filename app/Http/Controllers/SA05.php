<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Helpers\ReloadSectionParams;
use App\Models\BusinessCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class SA05 extends ZayaanController
{
    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N'); // Returns null if not present

        if ($request->ajax()) {
            if($frommenu == 'Y'){
                return response()->json([
                    'page' => view('pages.SA05.SA05', [
                        'businessCategory' => new BusinessCategory(),
                        'detailList' => BusinessCategory::all()
                    ])->render(),
                    'content_header_title' => 'Business Category',
                    'subtitle' => 'Business Category',
                ]);
            }

            if("RESER" == $id){
                return response()->json([
                    'page' => view('pages.SA05.SA05-main-form', [
                        'businessCategory' => new BusinessCategory(),
                    ])->render(),
                ]);
            }

            try {
                $businessCategory = BusinessCategory::findOrFail($id);

                return response()->json([
                    'page' => view('pages.SA05.SA05-main-form', [
                        'businessCategory' => $businessCategory,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.SA05.SA05-main-form', [
                        'businessCategory' => new BusinessCategory(),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.SA05.SA05',
            'content_header_title' => 'Business Category',
            'subtitle' => 'Business Category',
            'businessCategory' => new BusinessCategory(),
            'detailList' => BusinessCategory::all()
        ]);
    }

    public function headerTable(){
        return response()->json([
            'page' => view('pages.SA05.SA05-header-table', [
                'detailList' => BusinessCategory::all()
            ])->render(),
        ]);
    }

    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'xcode' => 'required|unique:business_categories,xcode,except,id',
        ], [
            'name.required' => 'Category name required.',
            'xcode.required' => 'Category code required.',
        ]);

        $validator->validate();

        $request['is_active'] = $request->has('is_active');

        $businessCategory = BusinessCategory::create($request->only([
            'name', 
            'xcode',
            'is_active'
        ]));

        if($businessCategory){
            $this->setReloadSections([
                new ReloadSection('main-form-container', '/SA05?id=RESET'),
                new ReloadSection('header-table-container', '/SA05/header-table'),
            ]);
            $this->setSuccessStatusAndMessage("Category created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Category creation failed");
        return $this->getResponse();
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'xcode' => 'required|unique:business_categories,xcode,'.$id,
        ], [
            'name.required' => 'Category name required.',
            'xcode.required' => 'Category code required.',
        ]);

        $validator->validate();

        $request['is_active'] = $request->has('is_active');

        $businessCategory = BusinessCategory::findOrFail($id);
        $businessCategory->update($request->only([
            'name', 
            'xcode',
            'is_active'
        ]));

        if($businessCategory){
            $this->setReloadSections([
                new ReloadSection('main-form-container', '/SA05?id='.$id),
                new ReloadSection('header-table-container', '/SA05/header-table'),
            ]);
            $this->setSuccessStatusAndMessage("Category updated successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Category update failed");
        return $this->getResponse();
    }

    public function delete($id){
        $businessCategory = BusinessCategory::findOrFail($id);
        $businessCategory->delete();

        if($businessCategory){
            $this->setReloadSections([
                new ReloadSection('main-form-container', '/SA05?id=RESET'),
                new ReloadSection('header-table-container', '/SA05/header-table'),
            ]);
            $this->setSuccessStatusAndMessage("Category deleted successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Category deletion failed");
        return $this->getResponse();
    }
}
