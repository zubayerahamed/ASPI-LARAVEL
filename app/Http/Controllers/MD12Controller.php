<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Xcodes;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class MD12Controller extends ZayaanController
{
    
    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N');

        $businessId = getBusinessId();
        $categoryBusinessId = allowCondition('is_allow_custom_category') ? $businessId : null;

        $productTypes = Xcodes::active()->where('type', 'Product Type')->orderBy('seqn', 'asc')->get();
        $productBehaviours = Xcodes::active()->where('type', 'Product Behaviour')->orderBy('seqn', 'asc')->get();
        $brands = Brand::active()->where('business_id', $businessId)->orderBy('name', 'asc')->get();
        $categories = Category::generateCategoryTree($categoryBusinessId);

        if ($request->ajax()) {
            if ($frommenu == 'Y') {

                $product = new Product();

                if ("RESET" != $id && is_numeric($id) && $id > 0) {
                    try {
                        $product = Product::findOrFail($id);
                    } catch (\Throwable $th) {
                        Log::error("MD12Controller index error: " . $th->getMessage());
                    }
                }

                return response()->json([
                    'page' => view('pages.MD12.MD12', [
                        'productTypes' => $productTypes,
                        'productBehaviours' => $productBehaviours,
                        'brands' => $brands,
                        'categoryTree' => $categories,
                        'product' => $product,
                        'detailList' => Collection::empty(),
                    ])->render(),
                    'content_header_title' => 'Product',
                    'subtitle' => 'Product',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.MD12.MD12-main-form', [
                        'productTypes' => $productTypes,
                        'productBehaviours' => $productBehaviours,
                        'brands' => $brands,
                        'categoryTree' => $categories,
                        'product' => new Product(),
                        'detailList' => Collection::empty(),
                    ])->render(),
                ]);
            }

            try {
                $product = Product::findOrFail($id);

                return response()->json([
                    'page' => view('pages.MD12.MD12-main-form', [
                        'productTypes' => $productTypes,
                        'productBehaviours' => $productBehaviours,
                        'brands' => $brands,
                        'categoryTree' => $categories,
                        'product' => $product,
                        'detailList' => Collection::empty(),
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.MD12.MD12-main-form', [
                        'productTypes' => $productTypes,
                        'productBehaviours' => $productBehaviours,
                        'brands' => $brands,
                        'categoryTree' => $categories,
                        'product' => new Product(),
                        'detailList' => Collection::empty(),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.MD12.MD12',
            'content_header_title' => 'Product',
            'subtitle' => 'Product',
            'productTypes' => $productTypes,
            'productBehaviours' => $productBehaviours,
            'brands' => $brands,
            'categoryTree' => $categories,
            'product' => new Product(),
            'detailList' => Collection::empty(),
        ]);
    }


}
