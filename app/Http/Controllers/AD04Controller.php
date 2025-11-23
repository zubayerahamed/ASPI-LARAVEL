<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\Xcodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AD04Controller extends ZayaanController
{
    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N'); // Returns null if not present

        $businessId = getBusinessId();
        $allowCustomXcodes = getSelectedBusiness()['is_allow_custom_xcodes'] ?? false;
        if (!$allowCustomXcodes) {
            $businessId = null;
        }

        if ($request->ajax()) {
            if ($frommenu == 'Y') {
                return response()->json([
                    'page' => view('pages.AD04.AD04', [
                        'allowCustomXcodes' => getSelectedBusiness() == null ? true : $allowCustomXcodes,
                        'codeTypes' => Xcodes::relatedBusiness()->where('type', 'Code Type')->orderBy('seqn', 'asc')->get(),
                        'xcodes' => (new Xcodes())->fill(['seqn' => 0, 'is_active' => true]),
                        'detailList' => Xcodes::relatedBusiness()->orderBy('type', 'asc')->orderBy('xcode', 'asc')->orderBy('seqn', 'asc')->get()
                    ])->render(),
                    'content_header_title' => 'Codes & Parameters',
                    'subtitle' => 'Codes & Parameters',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.AD04.AD04-main-form', [
                        'allowCustomXcodes' => getSelectedBusiness() == null ? true : $allowCustomXcodes,
                        'codeTypes' => Xcodes::relatedBusiness()->where('type', 'Code Type')->orderBy('seqn', 'asc')->get(),
                        'xcodes' => (new Xcodes())->fill(['seqn' => 0, 'is_active' => true]),
                    ])->render(),
                ]);
            }

            try {
                $xcodes = Xcodes::findOrFail($id);

                return response()->json([
                    'page' => view('pages.AD04.AD04-main-form', [
                        'allowCustomXcodes' => getSelectedBusiness() == null ? true : $allowCustomXcodes,
                        'codeTypes' => Xcodes::relatedBusiness()->where('type', 'Code Type')->orderBy('seqn', 'asc')->get(),
                        'xcodes' => $xcodes,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.AD04.AD04-main-form', [
                        'allowCustomXcodes' => getSelectedBusiness() == null ? true : $allowCustomXcodes,
                        'codeTypes' => Xcodes::relatedBusiness()->where('type', 'Code Type')->orderBy('seqn', 'asc')->get(),
                        'xcodes' => (new Xcodes())->fill(['seqn' => 0, 'is_active' => true]),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.AD04.AD04',
            'content_header_title' => 'Business Category',
            'subtitle' => 'Business Category',
            'allowCustomXcodes' => getSelectedBusiness() == null ? true : $allowCustomXcodes,
            'codeTypes' => Xcodes::relatedBusiness()->where('type', 'Code Type')->orderBy('seqn', 'asc')->get(),
            'xcodes' => (new Xcodes())->fill(['seqn' => 0, 'is_active' => true]),
            'detailList' => Xcodes::relatedBusiness()->orderBy('type', 'asc')->orderBy('xcode', 'asc')->orderBy('seqn', 'asc')->get()
        ]);
    }

    public function headerTable()
    {

        $allowCustomXcodes = getSelectedBusiness()['is_allow_custom_xcodes'] ?? false;

        return response()->json([
            'page' => view('pages.AD04.AD04-header-table', [
                'allowCustomXcodes' => getSelectedBusiness() == null ? true : $allowCustomXcodes,
                'detailList' => Xcodes::relatedBusiness()->orderBy('type', 'asc')->orderBy('xcode', 'asc')->orderBy('seqn', 'asc')->get()
            ])->render(),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:50',
            'xcode' => 'required|string|max:50',
            'description' => 'nullable|string|max:100',
            'symbol' => 'nullable|string|max:50',
        ], [
            'type.required' => 'The Type field is required.',
            'xcode.required' => 'The Code field is required.',
            'description.max' => 'The Description may not be greater than 100 characters.',
            'symbol.max' => 'The Symbol may not be greater than 50 characters.',
        ]);

        $validator->validate();

        // check data exist with same type and xcode
        $existingXcode = Xcodes::where('type', $request->input('type'))
            ->where('xcode', $request->input('xcode'))
            ->first();

        if ($existingXcode) {
            $this->setErrorStatusAndMessage("The combination of Type and Code already exists.");
            return $this->getResponse();
        }

        $request['seqn'] = $request->input('seqn') ?? 0;
        $request['is_active'] = $request->has('is_active') ?? false;
        $request['business_id'] = getBusinessId();


        $xcodes = Xcodes::create($request->only([
            'type',
            'xcode',
            'description',
            'symbol',
            'is_active',
            'seqn',
            'business_id',
        ]));

        if ($xcodes) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD04', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('AD04.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Codes created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Failed to create Codes");
        return $this->getResponse();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:50',
            'xcode' => 'required|string|max:50',
            'description' => 'nullable|string|max:100',
            'symbol' => 'nullable|string|max:50',
        ], [
            'type.required' => 'The Type field is required.',
            'xcode.required' => 'The Code field is required.',
            'description.max' => 'The Description may not be greater than 100 characters.',
            'symbol.max' => 'The Symbol may not be greater than 50 characters.',
        ]);

        $validator->validate();

        // check data exist with same type and xcode excluding current id
        $existingXcode = Xcodes::where('type', $request->input('type'))
            ->where('xcode', $request->input('xcode'))
            ->where('business_id', getBusinessId())
            ->where('id', '!=', $id)
            ->first();

        if ($existingXcode) {
            $this->setErrorStatusAndMessage("The combination of Type and Code already exists.");
            return $this->getResponse();
        }

        $request['seqn'] = $request->input('seqn') ?? 0;
        $request['is_active'] = $request->has('is_active') ?? false;
        $request['business_id'] = getBusinessId();

        $xcodes = Xcodes::find($id);
        if (!$xcodes) {
            $this->setErrorStatusAndMessage("Codes not found");
            return $this->getResponse();
        }

        $xcodes->update($request->only([
            'type',
            'xcode',
            'description',
            'symbol',
            'is_active',
            'seqn',
            'business_id',
        ]));

        $this->setReloadSections([
            new ReloadSection('main-form-container', route('AD04', ['id' => $xcodes->id])),
            new ReloadSection('header-table-container', route('AD04.header-table')),
        ]);
        $this->setSuccessStatusAndMessage("Codes updated successfully");
        return $this->getResponse();
    }

    public function delete($id)
    {
        $xcodes = Xcodes::find($id);
        if (!$xcodes) {
            $this->setErrorStatusAndMessage("Codes not found");
            return $this->getResponse();
        }

        $xcodes->delete();

        $this->setReloadSections([
            new ReloadSection('main-form-container', route('AD04', ['id' => 'RESET'])),
            new ReloadSection('header-table-container', route('AD04.header-table')),
        ]);
        $this->setSuccessStatusAndMessage("Codes deleted successfully");
        return $this->getResponse();
    }
}
