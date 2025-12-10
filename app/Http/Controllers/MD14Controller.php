<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\ProductCollection;
use App\Models\ProductCollectionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MD14Controller extends ZayaanController
{
    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N');

        if ($request->ajax()) {
            if ($frommenu == 'Y') {

                $productCollection = new ProductCollection();

                if ("RESET" != $id && is_numeric($id) && $id > 0) {
                    try {
                        $productCollection = ProductCollection::findOrFail($id);
                    } catch (\Throwable $th) {
                        Log::error("MD14Controller index error: " . $th->getMessage());
                    }
                }

                return response()->json([
                    'page' => view('pages.MD14.MD14', [
                        'productCollection' => $productCollection,
                        'detailList' => $productCollection->id == null ? Collection::empty() : ProductCollectionDetail::with(['product'])->where('product_collection_id', $productCollection->id)->get()
                    ])->render(),
                    'content_header_title' => 'Product Collections',
                    'subtitle' => 'Product Collections',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.MD14.MD14-main-form', [
                        'productCollection' => new ProductCollection(),
                        'detailList' => Collection::empty(),
                    ])->render(),
                ]);
            }

            try {
                $productCollection = ProductCollection::findOrFail($id);

                return response()->json([
                    'page' => view('pages.MD14.MD14-main-form', [
                        'productCollection' => $productCollection,
                        'detailList' => ProductCollectionDetail::with(['product'])->where('product_collection_id', $productCollection->id)->get()
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.MD14.MD14-main-form', [
                        'productCollection' => new ProductCollection(),
                        'detailList' => Collection::empty(),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.MD14.MD14',
            'content_header_title' => 'Product Collections',
            'subtitle' => 'Product Collections',
            'productCollection' => new ProductCollection(),
            'detailList' => Collection::empty(),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
        ], [
            'name.required' => 'The Name field is required.',
            'name.max' => 'The Name may not be greater than 100 characters.',
        ]);

        $validator->validate();

        $request['is_featured'] = $request->has('is_featured');
        $request['is_active'] = $request->has('is_active');
        $request->merge(['business_id' => getBusinessId()]);

        $productCollection = ProductCollection::create($request->only([
            'name',
            'description',
            'is_featured',
            'is_active',
            'business_id',
        ]));

        if ($productCollection) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD14', ['id' => 'RESET'])),
                new ReloadSection('detail-table-container', route('MD14.detail-table', ['id' => 'RESET', 'product_collection_id' => 'RESET'])),
            ]);
            $this->setSuccessStatusAndMessage("Product Collection created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Product Collection creation failed");
        return $this->getResponse();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
        ], [
            'name.required' => 'The Name field is required.',
            'name.max' => 'The Name may not be greater than 100 characters.',
        ]);

        $validator->validate();

        $request['is_featured'] = $request->has('is_featured');
        $request['is_active'] = $request->has('is_active');

        try {
            $productCollection = ProductCollection::findOrFail($id);

            $productCollection->update($request->only([
                'name',
                'description',
                'is_featured',
                'is_active',
            ]));

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD14', ['id' => $productCollection->id])),
                new ReloadSection('detail-table-container', route('MD14.detail-table', ['id' => 'RESET', 'product_collection_id' => $productCollection->id])),
            ]);
            $this->setSuccessStatusAndMessage("Product Collection updated successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("Product Collection update failed: " . $th->getMessage());
            return $this->getResponse();
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $productCollection = ProductCollection::findOrFail($id);
            $productCollection->delete();

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD14', ['id' => 'RESET'])),
                new ReloadSection('detail-table-container', route('MD14.detail-table', ['id' => 'RESET', 'product_collection_id' => 'RESET'])),
            ]);
            $this->setSuccessStatusAndMessage("Product Collection deleted successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("Product Collection deletion failed: " . $th->getMessage());
            return $this->getResponse();
        }
    }


}
