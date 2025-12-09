<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\TaxCategory;
use App\Models\Xcodes;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MD12Controller extends ZayaanController
{
    
    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N');

        $businessId = getBusinessId();
        $categoryBusinessId = allowCondition('is_allow_custom_category') ? $businessId : null;

        $productTypes = Xcodes::relatedBusiness()->active()->where('type', 'Product Type')->orderBy('seqn', 'asc')->get();
        $productBehaviours = Xcodes::relatedBusiness()->active()->where('type', 'Product Behaviour')->orderBy('seqn', 'asc')->get();
        $brands = Brand::active()->where('business_id', $businessId)->orderBy('name', 'asc')->get();
        $categories = Category::generateCategoryTree($categoryBusinessId);
        $attributes = Attribute::relatedBusiness()->with(['terms'])->orderBy('seqn', 'asc')->get();
        $uoms = Xcodes::relatedBusiness()->active()->where('type', 'Unit of Measurement')->orderBy('seqn', 'asc')->get();
        $countriesOfOrigins = Xcodes::relatedBusiness()->active()->where('type', 'Country of Origin')->orderBy('seqn', 'asc')->get();
        $stockStatus = Xcodes::relatedBusiness()->active()->where('type', 'Stock Status')->orderBy('seqn', 'asc')->get();
        $backOrderTypes = Xcodes::relatedBusiness()->active()->where('type', 'Back Order Type')->orderBy('seqn', 'asc')->get();
        $consumptionTypes = Xcodes::relatedBusiness()->active()->where('type', 'Consumption Type')->orderBy('seqn', 'asc')->get();
        $discountTypes = Xcodes::relatedBusiness()->active()->where('type', 'Discount Type')->orderBy('seqn', 'asc')->get();
        $taxCategories = TaxCategory::where('business_id', getBusinessId())->orderBy('name', 'asc')->get();

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
                        'uoms' => $uoms,
                        'countriesOfOrigins' => $countriesOfOrigins,
                        'stockStatus' => $stockStatus,
                        'backOrderTypes' => $backOrderTypes,
                        'taxCategories' => $taxCategories,
                        'consumptionTypes' => $consumptionTypes,
                        'discountTypes' => $discountTypes,
                        'product' => $product,
                        'productAttributes' => $product->productAttributes()->with(['attribute', 'term'])->get(),
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
                        'uoms' => $uoms,
                        'countriesOfOrigins' => $countriesOfOrigins,
                        'stockStatus' => $stockStatus,
                        'backOrderTypes' => $backOrderTypes,
                        'taxCategories' => $taxCategories,
                        'consumptionTypes' => $consumptionTypes,
                        'discountTypes' => $discountTypes,
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
                        'uoms' => $uoms,
                        'countriesOfOrigins' => $countriesOfOrigins,
                        'stockStatus' => $stockStatus,
                        'backOrderTypes' => $backOrderTypes,
                        'taxCategories' => $taxCategories,
                        'consumptionTypes' => $consumptionTypes,
                        'discountTypes' => $discountTypes,
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
                        'uoms' => $uoms,
                        'countriesOfOrigins' => $countriesOfOrigins,
                        'stockStatus' => $stockStatus,
                        'backOrderTypes' => $backOrderTypes,
                        'taxCategories' => $taxCategories,
                        'consumptionTypes' => $consumptionTypes,
                        'discountTypes' => $discountTypes,
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
            'uoms' => $uoms,
            'countriesOfOrigins' => $countriesOfOrigins,
            'stockStatus' => $stockStatus,
            'backOrderTypes' => $backOrderTypes,
            'taxCategories' => $taxCategories,
            'consumptionTypes' => $consumptionTypes,
            'discountTypes' => $discountTypes,
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

    public function attributeSelectionForm(Request $request)
    {
        $attributeId = $request->query('attribute_id', null);

        $attribute = Attribute::relatedBusiness()
                        ->with(['terms'])
                        ->where('id', $attributeId)
                        ->first();

        return response()->json([
            'page' => view('pages.MD12.MD12-attribute-list', [
                'attribute' => $attribute,
            ])->render(),
        ]);
    }

    public function saveProductAttribute(Request $request)
    {
        $productId = $request->input('product_id');

        // Basic validation
        if (!$productId) {
            return response()->json([
                'status' => 'error',
                'message' => 'product_id is required.',
            ], 422);
        }

        // Check product exists
        $product = Product::with(['productAttributes'])
            ->where('business_id', getBusinessId())
            ->where('id', $productId)
            ->first();

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found.',
            ], 404);
        }

        try {
            DB::beginTransaction();

            // Normalize attributes — always an array (possibly empty)
            $attributes = $request->input('attributes', []); // returns [] if missing

            // If attributes is not an array (malformed request), cast to empty
            if (!is_array($attributes)) {
                $attributes = [];
            }

            // If there are no attributes in the request => delete all existing and return success
            if (empty($attributes)) {
                ProductAttribute::where('product_id', $productId)->delete();

                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'displayMessage' => true,
                    'message' => 'All product attributes removed successfully.',
                ]);
            }

            // STEP 1: Build new desired records
            $newRecords = [];

            foreach ($attributes as $attributeId) {
                // ensure attributeId is valid-ish
                if (!$attributeId) {
                    continue;
                }

                $terms = $request->input("terms_$attributeId", []);
                if (!is_array($terms)) {
                    $terms = [];
                }

                // VALIDATION: attribute must have at least one term
                if (empty($terms)) {
                    DB::rollBack();
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Each selected attribute must contain at least one term.',
                    ], 422);
                }

                $useInVariation = (int) $request->input("use_in_variation_$attributeId", 0);

                foreach ($terms as $termId) {
                    if ($termId === null || $termId === '') {
                        continue;
                    }

                    $key = "{$attributeId}-{$termId}";

                    $newRecords[$key] = [
                        'product_id'       => $productId,
                        'attribute_id'     => $attributeId,
                        'term_id'          => $termId,
                        'use_in_variation' => $useInVariation,
                    ];
                }
            }

            // STEP 2: Fetch existing
            $existing = ProductAttribute::where('product_id', $productId)->get();
            $existingKeys = [];

            foreach ($existing as $row) {
                $key = "{$row->attribute_id}-{$row->term_id}";
                $existingKeys[$key] = $row;
            }

            // STEP 3A: INSERT new rows
            foreach ($newRecords as $key => $record) {
                if (!isset($existingKeys[$key])) {
                    ProductAttribute::create($record);
                }
            }

            // STEP 3B: UPDATE existing rows (only use_in_variation here)
            foreach ($newRecords as $key => $record) {
                if (isset($existingKeys[$key])) {
                    $existing = $existingKeys[$key];

                    // Only update if value changed (optional but reduces DB writes)
                    if ((int) $existing->use_in_variation !== (int) $record['use_in_variation']) {
                        $existing->update([
                            'use_in_variation' => $record['use_in_variation']
                        ]);
                    }
                }
            }

            // STEP 3C: DELETE removed rows
            foreach ($existingKeys as $key => $row) {
                if (!isset($newRecords[$key])) {
                    $row->delete();
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'displayMessage' => true,
                'message' => 'Product attributes saved successfully.',
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Product attribute sync failed', [
                'product_id' => $productId,
                'error'      => $e->getMessage(),
                'trace'      => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong while saving attributes.',
            ], 500);
        }
    }



}
