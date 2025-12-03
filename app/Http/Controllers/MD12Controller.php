<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
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
        $attributes = Attribute::relatedBusiness()->with(['terms'])->orderBy('seqn', 'asc')->get();

        if ($request->ajax()) {
            if ($frommenu == 'Y') {

                $product = new Product();

                if ("RESET" != $id && is_numeric($id) && $id > 0) {
                    try {
                        $product = Product::findOrFail($id);
                    } catch (\Throwable $th) {
                        Log::error("MD12Controller index error: " . $th->getMessage());
                        $product = $this->createDraftProduct();
                    }
                } else {
                    $product = $this->createDraftProduct();
                }

                return response()->json([
                    'page' => view('pages.MD12.MD12', [
                        'productTypes' => $productTypes,
                        'productBehaviours' => $productBehaviours,
                        'brands' => $brands,
                        'categoryTree' => $categories,
                        'attributes' => $attributes,
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
                        'attributes' => $attributes,
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
                        'attributes' => $attributes,
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
                        'attributes' => $attributes,
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
            'attributes' => $attributes,
            'product' => new Product(),
            'detailList' => Collection::empty(),
        ]);
    }

    public function createDraftProduct(){
        // Delete all draft products for this business first from previous dates
        $autodrafts = Product::where('business_id', '=', getBusinessId())
                    ->where('name', '=', 'AUTO-DRAFT')
                    ->whereDate('created_at', '<', now()->toDateString())
                    ->get();

        foreach ($autodrafts as $ad) {
            $ad->delete();
        }

        // Create a new product if not found with auto_draft status
        $p = new Product();
        $p->name = 'AUTO-DRAFT';
        $p->slug = 'AUTO-DRAFT';
        $p->business_id = getBusinessId();
        $p->product_type = 'STANDARD';
        $p->base_unit = 'pcs';
        $p->is_active = true;

        if($p->save()){
            return $p;
        } 

        return new Product();
    }




    // All ajax calls from main form to load partial dom will be set below

    // Load product behaviour dropdown based on product type
    public function productBehaviourDropdown(Request $request)
    {
        $productType = $request->query('product_type', '');

        return response()->json([
            'page' => view('pages.MD12.MD12-product-behaviour-dropdown', [
                'productType' => $productType,
            ])->render(),
        ]);
    }

}
