<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\TaxCategory;
use App\Models\TaxRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AD20Controller extends ZayaanController
{

    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N');

        if ($request->ajax()) {
            if ($frommenu == 'Y') {

                $taxRule = new TaxRule();

                if ("RESET" != $id && is_numeric($id) && $id > 0) {
                    try {
                        $taxRule = TaxRule::findOrFail($id);
                    } catch (\Throwable $th) {
                        Log::error("AD20Controller index error: " . $th->getMessage());
                    }
                }

                return response()->json([
                    'page' => view('pages.AD20.AD20', [
                        'taxCategories' => TaxCategory::where('business_id', getBusinessId())->get(),
                        'taxRule' => $taxRule,
                        'detailList' => TaxRule::where('business_id', getBusinessId())
                            ->with(['taxCategory', 'taxRuleComponents.taxComponent'])
                            ->orderBy('tax_category_id', 'asc')
                            ->orderBy('transaction_type', 'asc')
                            ->orderBy('effective_from', 'desc')
                            ->get()
                    ])->render(),
                    'content_header_title' => 'TAX Rule',
                    'subtitle' => 'TAX Rule',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.AD20.AD20-main-form', [
                        'taxCategories' => TaxCategory::where('business_id', getBusinessId())->get(),
                        'taxRule' => new TaxRule(),
                    ])->render(),
                ]);
            }

            try {
                $taxRule = TaxRule::findOrFail($id);

                return response()->json([
                    'page' => view('pages.AD20.AD20-main-form', [
                        'taxCategories' => TaxCategory::where('business_id', getBusinessId())->get(),
                        'taxRule' => $taxRule,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.AD20.AD20-main-form', [
                        'taxCategories' => TaxCategory::where('business_id', getBusinessId())->get(),
                        'taxRule' => new TaxRule(),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.AD20.AD20',
            'content_header_title' => 'TAX Rule',
            'subtitle' => 'TAX Rule',
            'taxCategories' => TaxCategory::where('business_id', getBusinessId())->get(),
            'taxRule' => new TaxRule(),
            'detailList' => TaxRule::where('business_id', getBusinessId())
                ->with(['taxCategory', 'taxRuleComponents.taxComponent'])
                ->orderBy('tax_category_id', 'asc')
                ->orderBy('transaction_type', 'asc')
                ->orderBy('effective_from', 'desc')
                ->get()
        ]);
    }

    public function headerTable()
    {
        return response()->json([
            'page' => view('pages.AD20.AD20-header-table', [
                'taxCategories' => TaxCategory::where('business_id', getBusinessId())->get(),
                'detailList' => TaxRule::where('business_id', getBusinessId())
                    ->with(['taxCategory', 'taxRuleComponents.taxComponent'])
                    ->orderBy('tax_category_id', 'asc')
                    ->orderBy('transaction_type', 'asc')
                    ->orderBy('effective_from', 'desc')
                    ->get()
            ])->render(),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction_type' => 'required|in:sales,purchase',
            'effective_from' => 'required|date',
            'tax_category_id' => 'required|exists:tax_categories,id',
        ], [
            'transaction_type.required' => 'The transaction type field is required.',
            'transaction_type.in' => 'The selected transaction type is invalid.',
            'effective_from.required' => 'The effective from field is required.',
            'effective_from.date' => 'The effective from is not a valid date.',
            'tax_category_id.required' => 'The tax category field is required.',
            'tax_category_id.exists' => 'The selected tax category is invalid.',
        ]);

        $validator->validate();

        $request['business_id'] = getBusinessId();

        $taxRule = TaxRule::create($request->only([
            'notes',
            'transaction_type',
            'effective_from',
            'effective_to',
            'tax_category_id',
            'business_id',
        ]));

        if ($taxRule) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD20', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('AD20.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("TAX Rule created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("TAX Rule creation failed");
        return $this->getResponse();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'transaction_type' => 'required|in:sales,purchase',
            'effective_from' => 'required|date',
            'tax_category_id' => 'required|exists:tax_categories,id',
        ], [
            'transaction_type.required' => 'The transaction type field is required.',
            'transaction_type.in' => 'The selected transaction type is invalid.',
            'effective_from.required' => 'The effective from field is required.',
            'effective_from.date' => 'The effective from is not a valid date.',
            'tax_category_id.required' => 'The tax category field is required.',
            'tax_category_id.exists' => 'The selected tax category is invalid.',
        ]);

        $validator->validate();

        try {
            $taxRule = TaxRule::findOrFail($id);

            $taxRule->update($request->only([
                'notes',
                'transaction_type',
                'effective_from',
                'effective_to',
                'tax_category_id',
            ]));

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD20', ['id' => $id])),
                new ReloadSection('header-table-container', route('AD20.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("TAX Rule updated successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("TAX Rule update failed");
            return $this->getResponse();
        }
    }

    public function delete($id)
    {
        try {
            $taxRule = TaxRule::findOrFail($id);
            $taxRule->delete();

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD20', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('AD20.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("TAX Rule deleted successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("TAX Rule deletion failed");
            return $this->getResponse();
        }
    }
}
