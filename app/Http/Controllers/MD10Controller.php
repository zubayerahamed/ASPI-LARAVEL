<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\ProductSpecificationGroup;
use App\Models\ProductSpecificationTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MD10Controller extends ZayaanController
{
    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N');

        if ($request->ajax()) {
            if ($frommenu == 'Y') {

                $psTable = new ProductSpecificationTable();

                if ("RESET" != $id && is_numeric($id) && $id > 0) {
                    try {
                        $psTable = ProductSpecificationTable::findOrFail($id);
                    } catch (\Throwable $th) {
                        Log::error("MD10Controller index error: " . $th->getMessage());
                    }
                }

                return response()->json([
                    'page' => view('pages.MD10.MD10', [
                        'psGroups' => ProductSpecificationGroup::where('business_id', getBusinessId())->get(),
                        'psTable' => $psTable,
                        'detailList' => ProductSpecificationTable::with(['groups'])->where('business_id', getBusinessId())->get()
                    ])->render(),
                    'content_header_title' => 'Product Specification Table Management',
                    'subtitle' => 'Product Specification Tables',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.MD10.MD10-main-form', [
                        'psGroups' => ProductSpecificationGroup::where('business_id', getBusinessId())->get(),
                        'psTable' => new ProductSpecificationTable(),
                    ])->render(),
                ]);
            }

            try {
                $psTable = ProductSpecificationTable::findOrFail($id);

                return response()->json([
                    'page' => view('pages.MD10.MD10-main-form', [
                        'psGroups' => ProductSpecificationGroup::where('business_id', getBusinessId())->get(),
                        'psTable' => $psTable,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.MD10.MD10-main-form', [
                        'psGroups' => ProductSpecificationGroup::where('business_id', getBusinessId())->get(),
                        'psTable' => new ProductSpecificationTable(),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.MD10.MD10',
            'content_header_title' => 'Product Specification Table Management',
            'subtitle' => 'Product Specification Tables',
            'psGroups' => ProductSpecificationGroup::where('business_id', getBusinessId())->get(),
            'psTable' => new ProductSpecificationTable(),
            'detailList' => ProductSpecificationTable::with(['groups'])->where('business_id', getBusinessId())->get()
        ]);
    }

    public function headerTable()
    {
        return response()->json([
            'page' => view('pages.MD10.MD10-header-table', [
                'detailList' => ProductSpecificationTable::with(['groups'])->where('business_id', getBusinessId())->get()
            ])->render(),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'group_ids' => 'required|array',
            'group_ids.*' => 'integer|exists:product_specification_groups,id',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 100 characters.',
            'group_ids.required' => 'At least one specification group must be selected.',
            'group_ids.array' => 'The group IDs must be an array.',
            'group_ids.*.integer' => 'Each group ID must be an integer.',
            'group_ids.*.exists' => 'One or more selected groups do not exist.',
        ]);

        $validator->validate();

        $request->merge(['business_id' => getBusinessId()]); // For now, set business_id to null

        $productSpecificationTable = ProductSpecificationTable::create($request->only([
            'name',
            'description',
            'business_id',
        ]));

        if ($productSpecificationTable) {
            // Now attach the selected groups with sequence
            $groupIds = $request->input('group_ids', []);
            $attachData = [];
            foreach ($groupIds as $index => $groupId) {
                $attachData[$groupId] = ['seqn' => $index + 1];
            }
            $productSpecificationTable->groups()->attach($attachData);

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD10', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('MD10.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Product Specification Table created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Product Specification Table creation failed");
        return $this->getResponse();
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'group_ids' => 'required|array',
            'group_ids.*' => 'integer|exists:product_specification_groups,id',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 100 characters.',
            'group_ids.required' => 'At least one specification group must be selected.',
            'group_ids.array' => 'The group IDs must be an array.',
            'group_ids.*.integer' => 'Each group ID must be an integer.',
            'group_ids.*.exists' => 'One or more selected groups do not exist.',
        ]);

        $validator->validate();

        try {
            $productSpecificationTable = ProductSpecificationTable::findOrFail($id);

            $productSpecificationTable->update($request->only([
                'name',
                'description',
            ]));

            // Sync the selected groups with sequence
            $groupIds = $request->input('group_ids', []);
            $syncData = [];
            foreach ($groupIds as $index => $groupId) {
                $syncData[$groupId] = ['seqn' => $index + 1];
            }
            $productSpecificationTable->groups()->sync($syncData);

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD10', ['id' => $id])),
                new ReloadSection('header-table-container', route('MD10.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Product Specification Table updated successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("Product Specification Table update failed: " . $th->getMessage());
            return $this->getResponse();
        }
    }

    public function delete($id)
    {
        try {
            $productSpecificationTable = ProductSpecificationTable::findOrFail($id);
            $productSpecificationTable->groups()->detach(); // Detach all related groups
            $productSpecificationTable->delete();

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD10', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('MD10.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Product Specification Table deleted successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("Product Specification Table deletion failed: " . $th->getMessage());
            return $this->getResponse();
        }
    }

    public function updateSequence(Request $request, $id, $groupId, $sequenceDirection)
    {
        try {
            $productSpecificationTable = ProductSpecificationTable::findOrFail($id);

            $currentSeqn = $productSpecificationTable->groups()->where('group_id', $groupId)->first()->pivot->seqn;

            if ($sequenceDirection === 'up' && $currentSeqn > 1) {
                $newSeqn = $currentSeqn - 1;
            } elseif ($sequenceDirection === 'down') {
                $newSeqn = $currentSeqn + 1;
            } else {
                throw new \Exception("Invalid sequence direction or already at boundary");
            }

            // Find the group currently at the new sequence
            $otherGroup = $productSpecificationTable->groups()
                ->wherePivot('seqn', $newSeqn)
                ->first();

            if ($otherGroup) {
                // Swap sequences
                $productSpecificationTable->groups()->updateExistingPivot($otherGroup->id, ['seqn' => $currentSeqn]);
            }

            // Update the sequence of the target group
            $productSpecificationTable->groups()->updateExistingPivot($groupId, ['seqn' => $newSeqn]);

            $this->setReloadSections([
                new ReloadSection('header-table-container', route('MD10.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Sequence updated successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("Sequence update failed: " . $th->getMessage());
            return $this->getResponse();
        }
    }
}
