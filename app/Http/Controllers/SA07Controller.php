<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\Xcodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SA07Controller extends ZayaanController
{
    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N'); // Returns null if not present

        if ($request->ajax()) {
            if ($frommenu == 'Y') {
                return response()->json([
                    'page' => view('pages.SA07.SA07', [
                        'codeTypes' => Xcodes::where('type', 'Code Type')->orderBy('seqn', 'asc')->get(),
                        'xcodes' => (new Xcodes())->fill(['seqn' => 0]),
                        'detailList' => Xcodes::orderBy('type', 'asc')->orderBy('xcode', 'asc')->orderBy('seqn', 'asc')->get()
                    ])->render(),
                    'content_header_title' => 'Codes & Parameters',
                    'subtitle' => 'Codes & Parameters',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.SA07.SA07-main-form', [
                        'codeTypes' => Xcodes::where('type', 'Code Type')->orderBy('seqn', 'asc')->get(),
                        'xcodes' => (new Xcodes())->fill(['seqn' => 0]),
                    ])->render(),
                ]);
            }

            try {
                $xcodes = Xcodes::findOrFail($id);

                return response()->json([
                    'page' => view('pages.SA07.SA07-main-form', [
                        'codeTypes' => Xcodes::where('type', 'Code Type')->orderBy('seqn', 'asc')->get(),
                        'xcodes' => $xcodes,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.SA07.SA07-main-form', [
                        'codeTypes' => Xcodes::where('type', 'Code Type')->orderBy('seqn', 'asc')->get(),
                        'xcodes' => (new Xcodes())->fill(['seqn' => 0]),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.SA07.SA07',
            'content_header_title' => 'Business Category',
            'subtitle' => 'Business Category',
            'codeTypes' => Xcodes::where('type', 'Code Type')->orderBy('seqn', 'asc')->get(),
            'xcodes' => (new Xcodes())->fill(['seqn' => 0]),
            'detailList' => Xcodes::orderBy('type', 'asc')->orderBy('xcode', 'asc')->orderBy('seqn', 'asc')->get()
        ]);
    }

    public function headerTable()
    {
        return response()->json([
            'page' => view('pages.SA07.SA07-header-table', [
                'detailList' => Xcodes::orderBy('type', 'asc')->orderBy('xcode', 'asc')->orderBy('seqn', 'asc')->get()
            ])->render(),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:100',
            'xcode' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
        ], [
            'type.required' => 'The Type field is required.',
            'xcode.required' => 'The Code field is required.',
            'description.max' => 'The Description may not be greater than 255 characters.',
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

        $xcodes = Xcodes::create($request->only([
            'type',
            'xcode',
            'description',
            'seqn',
        ]));

        if ($xcodes) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('SA07', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('SA07.header-table')),
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
            'type' => 'required|string|max:100',
            'xcode' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
        ], [
            'type.required' => 'The Type field is required.',
            'xcode.required' => 'The Code field is required.',
            'description.max' => 'The Description may not be greater than 255 characters.',
        ]);

        $validator->validate();

        // check data exist with same type and xcode excluding current id
        $existingXcode = Xcodes::where('type', $request->input('type'))
            ->where('xcode', $request->input('xcode'))
            ->where('id', '!=', $id)
            ->first();

        if ($existingXcode) {
            $this->setErrorStatusAndMessage("The combination of Type and Code already exists.");
            return $this->getResponse();
        }

        $request['seqn'] = $request->input('seqn') ?? 0;

        $xcodes = Xcodes::find($id);
        if (!$xcodes) {
            $this->setErrorStatusAndMessage("Codes not found");
            return $this->getResponse();
        }

        $xcodes->update($request->only([
            'type',
            'xcode',
            'description',
            'seqn',
        ]));

        $this->setReloadSections([
            new ReloadSection('main-form-container', route('SA07', ['id' => $xcodes->id])),
            new ReloadSection('header-table-container', route('SA07.header-table')),
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
            new ReloadSection('main-form-container', route('SA07', ['id' => 'RESET'])),
            new ReloadSection('header-table-container', route('SA07.header-table')),
        ]);
        $this->setSuccessStatusAndMessage("Codes deleted successfully");
        return $this->getResponse();
    }
}
