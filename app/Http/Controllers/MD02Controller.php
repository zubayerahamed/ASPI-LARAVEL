<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\Cadoc;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MD02Controller extends ZayaanController
{

    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N');


        if ($request->ajax()) {
            if ($frommenu == 'Y') {
                return response()->json([
                    'page' => view('pages.MD02.MD02', [
                        'categoryTree' => Category::generateCategoryTree(),
                        'category' => (new Category())->fill(['seqn' => 0, 'is_active' => true, 'icon' => 'ph ph-sort-ascending']),
                        'detailList' => Category::with(['parentCategory', 'thumbnail'])->where('business_id', getBusinessId())->orderBy('seqn', 'asc')->get()
                    ])->render(),
                    'content_header_title' => 'Category Management',
                    'subtitle' => 'Category',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.MD02.MD02-main-form', [
                        'categoryTree' => Category::generateCategoryTree(),
                        'category' => (new Category())->fill(['seqn' => 0, 'is_active' => true, 'icon' => 'ph ph-sort-ascending']),
                    ])->render(),
                ]);
            }

            try {
                $category = Category::findOrFail($id);

                return response()->json([
                    'page' => view('pages.MD02.MD02-main-form', [
                        'categoryTree' => Category::generateCategoryTree($category->business_id, $category->id),
                        'category' => $category,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.MD02.MD02-main-form', [
                        'categoryTree' => Category::generateCategoryTree(),
                        'category' => (new Category())->fill(['seqn' => 0, 'is_active' => true, 'icon' => 'ph ph-sort-ascending']),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.MD02.MD02',
            'content_header_title' => 'Category Management',
            'subtitle' => 'Category',
            'categoryTree' => Category::generateCategoryTree(),
            'category' => (new Category())->fill(['seqn' => 0, 'is_active' => true, 'icon' => 'ph ph-sort-ascending']),
            'detailList' => Category::with(['parentCategory', 'thumbnail'])->where('business_id', getBusinessId())->orderBy('seqn', 'asc')->get()
        ]);
    }

    public function headerTable()
    {
        return response()->json([
            'page' => view('pages.MD02.MD02-header-table', [
                'detailList' => Category::with(['parentCategory', 'thumbnail'])->where('business_id', getBusinessId())->orderBy('seqn', 'asc')->get()
            ])->render(),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'icon' => 'nullable|string|max:50',
            'thumbnail' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'seqn' => 'nullable|integer',
            'parent_category_id' => 'nullable|exists:categories,id',
        ], [
            'name.required' => 'The category name is required.',
            'name.max' => 'The category name may not be greater than 50 characters.',
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

        $request->merge(['business_id' => getBusinessId()]); // For now, set business_id to null

        if ($request->has('thumbnail')) {
            // Assuming Cadoc is the model for handling file uploads
            $cadoc = Cadoc::find($request->input('thumbnail'));
            if ($cadoc) {
                // You might want to add additional logic here, like associating the Cadoc with the Category later
                $cadoc->temp = false; // Mark as permanent
                $cadoc->save();
            }
            $request->merge(['thumbnail_id' => $cadoc->id]);
        }

        $category = Category::create($request->only([
            'name',
            'slug',
            'icon',
            'description',
            'is_featured',
            'is_system_defined',
            'is_active',
            'seqn',
            'parent_category_id',
            'business_id',
            'thumbnail_id'
        ]));

        if ($category) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD02', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('MD02.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Category created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Category creation failed");
        return $this->getResponse();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'icon' => 'nullable|string|max:50',
            'thumbnail' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'seqn' => 'nullable|integer',
            'parent_category_id' => 'nullable|exists:categories,id',
        ], [
            'name.required' => 'The category name is required.',
            'name.max' => 'The category name may not be greater than 50 characters.',
            'icon.max' => 'The category icon may not be greater than 50 characters.',
            'thumbnail.max' => 'The category thumbnail may not be greater than 255 characters.',
            'description.max' => 'The category description may not be greater than 255 characters.',
            'seqn.integer' => 'The category sequence must be an integer.',
            'parent_category_id.exists' => 'The selected parent category is invalid.',
        ]);

        $validator->validate();

        $category = Category::find($id);
        if (!$category) {
            $this->setErrorStatusAndMessage("Category not found");
            return $this->getResponse();
        }

        $request['seqn'] = $request->input('seqn') ?? 0;
        $request['icon'] = $request->input('icon') ?? 'ph ph-sort-ascending';
        $request['is_featured'] = $request->has('is_featured');
        $request['is_system_defined'] = $request->has('is_system_defined');
        $request['is_active'] = $request->has('is_active');

        if ($request->has('thumbnail')) {
            // Assuming Cadoc is the model for handling file uploads
            $cadoc = Cadoc::find($request->input('thumbnail'));
            if ($cadoc) {
                // You might want to add additional logic here, like associating the Cadoc with the Category later
                $cadoc->temp = false; // Mark as permanent
                $cadoc->save();
            }
            $request->merge(['thumbnail_id' => $cadoc->id]);
            Log::debug('Thumbnail uploaded with ID: ' . $cadoc->id);

            // Optionally, you might want to delete the old thumbnail here
            if ($category->thumbnail_id != null) {
                $oldCadoc = Cadoc::find($category->thumbnail_id);
                if ($oldCadoc && $oldCadoc->id != $cadoc->id) {
                    $oldCadoc->delete(); // Delete old thumbnail record

                    // Remove the physical file if needed
                    // AD18Controller::deletePhysicalFiles([
                    //     'original_file' => 'storage' . $oldCadoc->file_path . $oldCadoc->file_name,
                    //     'compressed_file' => 'storage' . $oldCadoc->file_path_compressed . $oldCadoc->file_name,
                    //     'file_name' => $oldCadoc->file_name,
                    //     'original_name' => $oldCadoc->original_file_name
                    // ]);
                }
            }
        }

        // Remove Thumbnail Triggered
        if ($request->remove_thumbnail == 'YES' && !$request->has('thumbnail')) {
            Log::debug('Removing thumbnail for category ID: ' . $category->id);
            if ($category->thumbnail_id != null) {
                $oldCadoc = Cadoc::find($category->thumbnail_id);
                if ($oldCadoc) {
                    $oldCadoc->delete(); // Delete old thumbnail record

                    // Remove the physical file if needed
                    // AD18Controller::deletePhysicalFiles([
                    //     'original_file' => 'storage' . $oldCadoc->file_path . $oldCadoc->file_name,
                    //     'compressed_file' => 'storage' . $oldCadoc->file_path_compressed . $oldCadoc->file_name,
                    //     'file_name' => $oldCadoc->file_name,
                    //     'original_name' => $oldCadoc->original_file_name
                    // ]);
                }
            }

            $request->merge(['thumbnail_id' => null]);
        }

        $category->update($request->only([
            'name',
            'slug',
            'icon',
            'thumbnail_id',
            'description',
            'is_featured',
            'is_system_defined',
            'is_active',
            'seqn',
            'parent_category_id',
        ]));

        if ($category) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD02', ['id' => $category->id])),
                new ReloadSection('header-table-container', route('MD02.header-table')),
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

        // Optionally, delete associated thumbnail
        if ($category->thumbnail_id != null) {
            $oldCadoc = Cadoc::find($category->thumbnail_id);
            if ($oldCadoc) {
                $oldCadoc->delete(); // Delete old thumbnail record
            }
        }

        $category->delete();

        $this->setReloadSections([
            new ReloadSection('main-form-container', route('MD02', ['id' => 'RESET'])),
            new ReloadSection('header-table-container', route('MD02.header-table')),
        ]);
        $this->setSuccessStatusAndMessage("Category deleted successfully");
        return $this->getResponse();
    }
}
