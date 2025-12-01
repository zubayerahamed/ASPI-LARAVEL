<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\Brand;
use App\Models\Cadoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MD11Controller extends ZayaanController
{
    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N');

        if ($request->ajax()) {
            if ($frommenu == 'Y') {
                return response()->json([
                    'page' => view('pages.MD11.MD11', [
                        'brand' => (new Brand())->fill(['is_active' => true]),
                        'detailList' => Brand::with(['thumbnail'])->where('business_id', getBusinessId())->get()
                    ])->render(),
                    'content_header_title' => 'Brand',
                    'subtitle' => 'Brand',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.MD11.MD11-main-form', [
                        'brand' => (new Brand())->fill(['is_active' => true]),
                    ])->render(),
                ]);
            }

            try {
                $Brand = Brand::findOrFail($id);

                return response()->json([
                    'page' => view('pages.MD11.MD11-main-form', [
                        'brand' => $Brand,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.MD11.MD11-main-form', [
                        'brand' => (new Brand())->fill(['is_active' => true]),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.MD11.MD11',
            'content_header_title' => 'Brand',
            'subtitle' => 'Brand',
            'brand' => (new Brand())->fill(['is_active' => true]),
            'detailList' => Brand::with(['parentBrand', 'thumbnail'])->orderBy('seqn', 'asc')->get()
        ]);
    }

    public function headerTable(Request $request)
    {
        return response()->json([
            'page' => view('pages.MD11.MD11-header-table', [
                'detailList' => Brand::with(['thumbnail'])->where('business_id', getBusinessId())->get()
            ])->render(),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 150 characters.',
        ]);

        $validator->validate();


        $request['is_active'] = $request->has('is_active');
        $request['is_featured'] = $request->has('is_featured');
        $request['is_popular'] = $request->has('is_popular');
        $request['is_highlighted'] = $request->has('is_highlighted');
        $request['is_listed'] = $request->has('is_listed');

        $request->merge(['business_id' => getBusinessId()]); // For now, set business_id to null

        if ($request->has('thumbnail')) {
            // Assuming Cadoc is the model for handling file uploads
            $cadoc = Cadoc::find($request->input('thumbnail'));
            if ($cadoc) {
                $cadoc->temp = false; // Mark as permanent
                $cadoc->save();
            }
            $request->merge(['thumbnail_id' => $cadoc->id]);
        }

        $brand = Brand::create($request->only([
            'name',
            'thumbnail_id',
            'website',
            'description',
            'is_active',
            'is_featured',
            'is_popular',
            'is_highlighted',
            'is_listed',
            'country_of_origin',
            'support_email',
            'support_phone',
            'warranty_period',
            'business_id',
        ]));

        if ($brand) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD11', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('MD11.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Brand created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Brand creation failed");
        return $this->getResponse();
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 150 characters.',
        ]);

        $validator->validate();

        $request['is_active'] = $request->has('is_active');
        $request['is_featured'] = $request->has('is_featured');
        $request['is_popular'] = $request->has('is_popular');
        $request['is_highlighted'] = $request->has('is_highlighted');
        $request['is_listed'] = $request->has('is_listed');

        try {
            $brand = Brand::findOrFail($id);

            if ($request->has('thumbnail')) {
                // Assuming Cadoc is the model for handling file uploads
                $cadoc = Cadoc::find($request->input('thumbnail'));
                if ($cadoc) {
                    $cadoc->temp = false; // Mark as permanent
                    $cadoc->save();
                }
                $request->merge(['thumbnail_id' => $cadoc->id]);
                Log::debug('Thumbnail uploaded with ID: ' . $cadoc->id);

                // Optionally, you might want to delete the old thumbnail here
                if ($brand->thumbnail_id != null) {
                    $oldCadoc = Cadoc::find($brand->thumbnail_id);
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
                Log::debug('Removing thumbnail for category ID: ' . $brand->id);
                if ($brand->thumbnail_id != null) {
                    $oldCadoc = Cadoc::find($brand->thumbnail_id);
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



            $brand->update($request->only([
                'name',
                'thumbnail_id',
                'website',
                'description',
                'is_active',
                'is_featured',
                'is_popular',
                'is_highlighted',
                'is_listed',
                'country_of_origin',
                'support_email',
                'support_phone',
                'warranty_period',
            ]));

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD11', ['id' => $id])),
                new ReloadSection('header-table-container', route('MD11.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Brand updated successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("Brand update failed");
            return $this->getResponse();
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $brand = Brand::findOrFail($id);

            // Optionally, delete associated thumbnail
            if ($brand->thumbnail_id != null) {
                $oldCadoc = Cadoc::find($brand->thumbnail_id);
                if ($oldCadoc) {
                    $oldCadoc->delete(); // Delete old thumbnail record
                }
            }

            $brand->delete();

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD11', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('MD11.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Brand deleted successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("Brand deletion failed");
            return $this->getResponse();
        }
    }
}
