<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\ProductOption;
use App\Models\ProductOptionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MD07Controller extends ZayaanController
{
    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N');

        if ($request->ajax()) {
            if ($frommenu == 'Y') {

                $productOption = new ProductOption();

                if ("RESET" != $id && is_numeric($id) && $id > 0) {
                    try {
                        $productOption = ProductOption::findOrFail($id);
                    } catch (\Throwable $th) {
                        Log::error("MD07Controller index error: " . $th->getMessage());
                    }
                }

                return response()->json([
                    'page' => view('pages.MD07.MD07', [
                        'productOption' => $productOption,
                        'detailList' => $productOption->id == null ? Collection::empty() : ProductOptionDetail::with(['productOption'])->where('product_option_id', $productOption->id)->get()
                    ])->render(),
                    'content_header_title' => 'Product Option Management',
                    'subtitle' => 'Product Options',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.MD07.MD07-main-form', [
                        'productOption' => new ProductOption(),
                        'detailList' => Collection::empty(),
                    ])->render(),
                ]);
            }

            try {
                $productOption = ProductOption::findOrFail($id);

                return response()->json([
                    'page' => view('pages.MD07.MD07-main-form', [
                        'productOption' => $productOption,
                        'detailList' => ProductOptionDetail::with(['productOption'])->where('product_option_id', $productOption->id)->get()
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.MD07.MD07-main-form', [
                        'productOption' => new ProductOption(),
                        'detailList' => Collection::empty(),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.MD07.MD07',
            'content_header_title' => 'Product Option Management',
            'subtitle' => 'Product Options',
            'productOption' => new ProductOption(),
            'detailList' => Collection::empty(),
        ]);
    }

    public function detailTable(Request $request)
    {

        $id = $request->query('id', 'RESET'); // Returns null if not present
        $productOptionId = $request->query('product_option_id', 'RESET'); // Returns null if not present

        return response()->json([
            'page' => view('pages.MD07.MD07-detail-table', [
                'productOptionDetail' => $id == 'RESET' ? (new ProductOptionDetail())->fill(['product_option_id' => $productOptionId, 'additional_price' => 0.0, 'price_type' => 'fixed', 'seqn' => 0]) : ProductOptionDetail::find($id),
                'detailList' => $productOptionId == 'RESET' ? Collection::empty() : ProductOptionDetail::with(['productOption'])->where('product_option_id', $productOptionId)->get()
            ])->render(),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'type' => 'required|in:dropdown,radio,checkbox',
        ], [
            'name.required' => 'The Name field is required.',
            'name.max' => 'The Name may not be greater than 20 characters.',
            'type.required' => 'The Type field is required.',
            'type.in' => 'The selected Type is invalid.',
        ]);

        $validator->validate();

        $request['is_required'] = $request->has('is_required');
        $request->merge(['business_id' => getBusinessId()]);

        $productOption = ProductOption::create($request->only([
            'name',
            'type',
            'is_required',
            'business_id',
        ]));

        if ($productOption) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD07', ['id' => 'RESET'])),
                new ReloadSection('detail-table-container', route('MD07.detail-table')),
            ]);
            $this->setSuccessStatusAndMessage("Product Option created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Product Option creation failed");
        return $this->getResponse();
    }

    public function detailCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_option_id' => 'required|exists:product_options,id',
            'label' => 'required|string|max:100',
            'additional_price' => 'required|numeric|min:0',
            'price_type' => 'required|in:fixed,percentage',
            'seqn' => 'required|integer|min:0',
        ], [
            'product_option_id.required' => 'The Product Option field is required.',
            'product_option_id.exists' => 'The selected Product Option is invalid.',
            'label.required' => 'The Label field is required.',
            'label.max' => 'The Label may not be greater than 100 characters.',
            'additional_price.required' => 'The Additional Price field is required.',
            'additional_price.numeric' => 'The Additional Price must be a number.',
            'additional_price.min' => 'The Additional Price must be at least 0.',
            'price_type.required' => 'The Price Type field is required.',
            'price_type.in' => 'The selected Price Type is invalid.',
            'seqn.required' => 'The Sequence field is required.',
            'seqn.integer' => 'The Sequence must be an integer.',
            'seqn.min' => 'The Sequence must be at least 0.',
        ]);

        $validator->validate();

        $productOptionDetail = ProductOptionDetail::create($request->only([
            'label',
            'additional_price',
            'price_type',
            'product_option_id',
            'seqn',
        ]));

        if ($productOptionDetail) {
            $this->setReloadSections([
                new ReloadSection('detail-table-container', route('MD07.detail-table', ['id' => 'RESET', 'product_option_id' => $productOptionDetail->product_option_id])),
            ]);
            $this->setSuccessStatusAndMessage("Product Option Detail created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Product Option Detail creation failed");
        return $this->getResponse();
    }

}
