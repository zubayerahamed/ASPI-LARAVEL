<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\TaxComponent;
use App\Models\TaxRule;
use App\Models\TaxRuleComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AD21Controller extends ZayaanController
{

    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N');

        // Get attribute_id from request parameter
        $taxRuleId = $request->query('tax_rule_id', null); // Returns null if not present
        if ($taxRuleId == null) {
            return redirect()->route('AD20');
        }

        $taxRule = TaxRule::with('taxCategory')->find($taxRuleId);
        if (!$taxRule) {
            return redirect()->route('AD20');
        }

        if ($request->ajax()) {
            if ($frommenu == 'Y') {
                return response()->json([
                    'page' => view('pages.AD21.AD21', [
                        'taxComponents' => TaxComponent::where('business_id', getBusinessId())->get(),
                        'taxRule' => $taxRule,
                        'taxRuleComponent' => (new TaxRuleComponent())->fill(['rate' => 0, 'tax_rule_id' => $taxRuleId]),
                        'detailList' => TaxRuleComponent::with(['taxRule'])->where('tax_rule_id', $taxRuleId)->orderBy('seqn', 'asc')->get()
                    ])->render(),
                    'content_header_title' => 'Components for TAX Rule : ' . $taxRule->taxCategory->name . ' - ' . ucfirst($taxRule->transaction_type),
                    'subtitle' => 'TAX Rule Components',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.AD21.AD21-main-form', [
                        'taxComponents' => TaxComponent::where('business_id', getBusinessId())->get(),
                        'taxRule' => $taxRule,
                        'taxRuleComponent' => (new TaxRuleComponent())->fill(['rate' => 0, 'tax_rule_id' => $taxRuleId]),
                    ])->render(),
                ]);
            }

            try {
                $taxRuleComponent = TaxRuleComponent::findOrFail($id);

                return response()->json([
                    'page' => view('pages.AD21.AD21-main-form', [
                        'taxComponents' => TaxComponent::where('business_id', getBusinessId())->get(),
                        'taxRule' => $taxRule,
                        'taxRuleComponent' => $taxRuleComponent,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.AD21.AD21-main-form', [
                        'taxComponents' => TaxComponent::where('business_id', getBusinessId())->get(),
                        'taxRule' => $taxRule,
                        'taxRuleComponent' => (new TaxRuleComponent())->fill(['rate' => 0, 'tax_rule_id' => $taxRuleId]),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.AD21.AD21',
            'content_header_title' => 'Components for TAX Rule : ' . $taxRule->taxCategory->name . ' - ' . ucfirst($taxRule->transaction_type),
            'subtitle' => 'TAX Rule Components',
            'taxComponents' => TaxComponent::where('business_id', getBusinessId())->get(),
            'taxRule' => $taxRule,
            'taxRuleComponent' => (new TaxRuleComponent())->fill(['rate' => 0, 'tax_rule_id' => $taxRuleId]),
            'detailList' => TaxRuleComponent::with(['taxRule'])->where('tax_rule_id', $taxRuleId)->orderBy('seqn', 'asc')->get()
        ]);
    }


    public function headerTable(Request $request)
    {
        $taxRuleId = $request->query('tax_rule_id', null); // Returns null if not present
        if ($taxRuleId == null) {
            return redirect()->route('AD20.header-table');
        }

        $taxRule = TaxRule::with('taxCategory')->find($taxRuleId);
        if (!$taxRule) {
            return redirect()->route('AD20.header-table');
        }

        return response()->json([
            'page' => view('pages.AD21.AD21-header-table', [
                'taxRule' => $taxRule,
                'detailList' => TaxRuleComponent::with(['taxRule'])->where('tax_rule_id', $taxRuleId)->orderBy('seqn', 'asc')->get()
            ])->render(),
        ]);
    }


    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rate' => 'required|numeric|min:0',
            'calc_type' => 'required|in:exclusive,inclusive,compound,exempt',
            'tax_rule_id' => 'required|exists:tax_rules,id',
            'tax_component_id' => 'required|exists:tax_components,id',
        ], [
            'rate.required' => 'The rate field is required.',
            'rate.numeric' => 'The rate must be a number.',
            'rate.min' => 'The rate must be at least 0.',
            'calc_type.required' => 'The calculation type field is required.',
            'calc_type.in' => 'The selected calculation type is invalid.',
            'tax_rule_id.exists' => 'The selected tax rule is invalid.',
            'tax_component_id.exists' => 'The selected tax component is invalid.',
        ]);

        $validator->validate();

        $request['seqn'] = $request->input('seqn') ?? 1;

        $tc = TaxComponent::where('business_id', getBusinessId())
            ->where('id', $request->input('tax_component_id'))
            ->first();

        $request['is_recoverable'] = $tc != null ? $tc->is_recoverable : false;

        $trc = TaxRuleComponent::create($request->only([
            'rate',
            'calc_type',
            'seqn',
            'is_recoverable',
            'tax_rule_id',
            'tax_component_id',
        ]));

        if ($trc) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD21', ['id' => 'RESET', 'tax_rule_id' => $request->input('tax_rule_id')])),
                new ReloadSection('header-table-container', route('AD21.header-table', ['tax_rule_id' => $request->input('tax_rule_id')])),
            ]);
            $this->setSuccessStatusAndMessage("TAX Rule Component created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("TAX Rule Component creation failed");
        return $this->getResponse();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'rate' => 'required|numeric|min:0',
            'calc_type' => 'required|in:exclusive,inclusive,compound,exempt',
            'tax_rule_id' => 'required|exists:tax_rules,id',
            'tax_component_id' => 'required|exists:tax_components,id',
        ], [
            'rate.required' => 'The rate field is required.',
            'rate.numeric' => 'The rate must be a number.',
            'rate.min' => 'The rate must be at least 0.',
            'calc_type.required' => 'The calculation type field is required.',
            'calc_type.in' => 'The selected calculation type is invalid.',
            'tax_rule_id.exists' => 'The selected tax rule is invalid.',
            'tax_component_id.exists' => 'The selected tax component is invalid.',
        ]);

        $validator->validate();

        $request['seqn'] = $request->input('seqn') ?? 1;

        $tc = TaxComponent::where('business_id', getBusinessId())
            ->where('id', $request->input('tax_component_id'))
            ->first();

        $request['is_recoverable'] = $tc != null ? $tc->is_recoverable : false;

        try {
            $trc = TaxRuleComponent::findOrFail($id);
            $updated = $trc->update($request->only([
                'rate',
                'calc_type',
                'seqn',
                'is_recoverable',
                'tax_rule_id',
                'tax_component_id',
            ]));

            if ($updated) {
                $this->setReloadSections([
                    new ReloadSection('main-form-container', route('AD21', ['id' => $id, 'tax_rule_id' => $request->input('tax_rule_id')])),
                    new ReloadSection('header-table-container', route('AD21.header-table', ['tax_rule_id' => $request->input('tax_rule_id')])),
                ]);
                $this->setSuccessStatusAndMessage("TAX Rule Component updated successfully");
                return $this->getResponse();
            }
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("TAX Rule Component not found");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("TAX Rule Component update failed");
        return $this->getResponse();
    }

    public function delete(Request $request, $id)
    {
        try {
            $trc = TaxRuleComponent::findOrFail($id);
            $taxRuleId = $trc->tax_rule_id;
            $deleted = $trc->delete();

            if ($deleted) {
                $this->setReloadSections([
                    new ReloadSection('main-form-container', route('AD21', ['id' => 'RESET', 'tax_rule_id' => $taxRuleId])),
                    new ReloadSection('header-table-container', route('AD21.header-table', ['tax_rule_id' => $taxRuleId])),
                ]);
                $this->setSuccessStatusAndMessage("TAX Rule Component deleted successfully");
                return $this->getResponse();
            }
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("TAX Rule Component not found");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("TAX Rule Component deletion failed");
        return $this->getResponse();
    }

}
