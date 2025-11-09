<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AD03Controller extends ZayaanController
{

    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N');


        if ($request->ajax()) {
            if ($frommenu == 'Y') {
                return response()->json([
                    'page' => view('pages.AD03.AD03', [
                        'categoryTree' => Category::generateCategoryTree(),
                        'category' => (new Category())->fill(['seqn' => 0]),
                        'detailList' => Category::with('parentCategory')->where('business_id', null)->orderBy('seqn', 'asc')->get()
                    ])->render(),
                    'content_header_title' => 'Category Management',
                    'subtitle' => 'Category',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.AD03.AD03-main-form', [
                        'categoryTree' => Category::generateCategoryTree(),
                        'category' => (new Category())->fill(['seqn' => 0]),
                    ])->render(),
                ]);
            }

            try {
                $category = Category::findOrFail($id);

                return response()->json([
                    'page' => view('pages.AD03.AD03-main-form', [
                        'categoryTree' => Category::generateCategoryTree($category->business_id, $category->id),
                        'category' => $category,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.AD03.AD03-main-form', [
                        'categoryTree' => Category::generateCategoryTree(),
                        'category' => (new Category())->fill(['seqn' => 0]),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.AD03.AD03',
            'content_header_title' => 'Category Management',
            'subtitle' => 'Category',
            'categoryTree' => Category::generateCategoryTree(),
            'category' => (new Category())->fill(['seqn' => 0]),
            'detailList' => Category::with('parentCategory')->where('business_id', null)->orderBy('seqn', 'asc')->get()
        ]);
    }

    public function headerTable()
    {
        return response()->json([
            'page' => view('pages.AD03.AD03-header-table', [
                'detailList' => Category::with('parentCategory')->where('business_id', null)->orderBy('seqn', 'asc')->get()
            ])->render(),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'slug' => 'required|string|max:50|unique:categories,slug,except,id',
            'icon' => 'nullable|string|max:50',
            'thumbnail' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'seqn' => 'nullable|integer',
            'parent_category_id' => 'nullable|exists:categories,id',
        ], [
            'name.required' => 'The category name is required.',
            'name.max' => 'The category name may not be greater than 50 characters.',
            'slug.required' => 'The category slug is required.',
            'slug.max' => 'The category slug may not be greater than 50 characters.',
            'icon.max' => 'The category icon may not be greater than 50 characters.',
            'thumbnail.max' => 'The category thumbnail may not be greater than 255 characters.',
            'description.max' => 'The category description may not be greater than 255 characters.',
            'seqn.integer' => 'The category sequence must be an integer.',
            'parent_category_id.exists' => 'The selected parent category is invalid.',
        ]);

        $validator->validate();

        $request['seqn'] = $request->input('seqn') ?? 0;
        $request['icon'] = $request->input('icon') ?? 'ph ph-sort-ascending';
        $request['is_featured'] = $request->has('is_featured');
        $request['is_system_defined'] = $request->has('is_system_defined');
        $request['is_active'] = $request->has('is_active');

        $request->merge(['business_id' => null]); // For now, set business_id to null

        $category = Category::create($request->only([
            'name',
            'slug',
            'icon',
            'thumbnail',
            'description',
            'is_featured',
            'is_system_defined',
            'is_active',
            'seqn',
            'parent_category_id',
            'business_id'
        ]));

        if ($category) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD03', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('AD03.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Category created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Category creation failed");
        return $this->getResponse();
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'slug' => 'required|string|max:50|unique:categories,slug,' . $id . ',id',
            'icon' => 'nullable|string|max:50',
            'thumbnail' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'seqn' => 'nullable|integer',
            'parent_category_id' => 'nullable|exists:categories,id',
        ], [
            'name.required' => 'The category name is required.',
            'name.max' => 'The category name may not be greater than 50 characters.',
            'slug.required' => 'The category slug is required.',
            'slug.max' => 'The category slug may not be greater than 50 characters.',
            'icon.max' => 'The category icon may not be greater than 50 characters.',
            'thumbnail.max' => 'The category thumbnail may not be greater than 255 characters.',
            'description.max' => 'The category description may not be greater than 255 characters.',
            'seqn.integer' => 'The category sequence must be an integer.',
            'parent_category_id.exists' => 'The selected parent category is invalid.',
        ]);

        $validator->validate();

        $category = Category::find($id);
        if(!$category){
            $this->setErrorStatusAndMessage("Category not found");
            return $this->getResponse();
        }

        $request['seqn'] = $request->input('seqn') ?? 0;
        $request['icon'] = $request->input('icon') ?? 'ph ph-sort-ascending';
        $request['is_featured'] = $request->has('is_featured');
        $request['is_system_defined'] = $request->has('is_system_defined');
        $request['is_active'] = $request->has('is_active');
        $category->update($request->only([
            'name',
            'slug',
            'icon',
            'thumbnail',
            'description',
            'is_featured',
            'is_system_defined',
            'is_active',
            'seqn',
            'parent_category_id',
        ]));

        if ($category) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD03', ['id' => $category->id])),
                new ReloadSection('header-table-container', route('AD03.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Category updated successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Category update failed");
        return $this->getResponse();
    }

    public function delete($id)
    {
        $category = Category::find($id);

        if (!$category) {
            $this->setErrorStatusAndMessage("Category not found");
            return $this->getResponse();
        }

        $category->delete();

        $this->setReloadSections([
            new ReloadSection('main-form-container', route('AD03', ['id' => 'RESET'])),
            new ReloadSection('header-table-container', route('AD03.header-table')),
        ]);
        $this->setSuccessStatusAndMessage("Category deleted successfully");
        return $this->getResponse();
    }
}
