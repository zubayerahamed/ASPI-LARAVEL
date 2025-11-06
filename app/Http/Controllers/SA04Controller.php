<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SA04Controller extends ZayaanController
{
    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N'); // Returns null if not present

        if ($request->ajax()) {
            if ($frommenu == 'Y') {
                return response()->json([
                    'page' => view('pages.SA04.SA04', [
                        'screen' => new Screen(),
                        'detailList' => Screen::orderBy('seqn', 'asc')->get()
                    ])->render(),
                    'content_header_title' => 'Screen Management',
                    'subtitle' => 'Screen',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.SA04.SA04-main-form', [
                        'screen' => new Screen(),
                    ])->render(),
                ]);
            }

            try {
                $screen = Screen::findOrFail($id);

                return response()->json([
                    'page' => view('pages.SA04.SA04-main-form', [
                        'screen' => $screen,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.SA04.SA04-main-form', [
                        'screen' => new Screen(),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.SA04.SA04',
            'content_header_title' => 'Screen Management',
            'subtitle' => 'Screen',
            'screen' => new Screen(),
            'detailList' => Screen::orderBy('seqn', 'asc')->get()
        ]);
    }

    public function headerTable()
    {
        return response()->json([
            'page' => view('pages.SA04.SA04-header-table', [
                'detailList' => Screen::orderBy('seqn', 'asc')->get()
            ])->render(),
        ]);
    }

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'xscreen' => 'required|unique:screens,xscreen,except,id',
            'title' => 'required',
            'type' => 'required|in:SCREEN,REPORT,DEFAULT,SYSTEM',
        ], [
            'xscreen.required' => 'Screen code required.',
            'xscreen.unique' => 'Screen code must be unique.',
            'title.required' => 'Screen title required.',
            'type.required' => 'Screen type required.',
            'type.in' => 'Screen type must be one of Screen, Report, Default, System.',
        ]);

        $validator->validate();



        $request['xnum'] = $request->input('xnum') ?? 0;
        $request['seqn'] = $request->input('seqn') ?? 0;
        $request['icon'] = $request->input('icon') ?? 'ph ph-monitor';

        $businessCategory = Screen::create($request->only([
            'xscreen',
            'title',
            'icon',
            'keywords',
            'type',
            'xnum',
            'seqn'
        ]));

        if ($businessCategory) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('SA04', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('SA04.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Screen created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Screen creation failed");
        return $this->getResponse();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'xscreen' => 'required|unique:screens,xscreen,' . $id,
            'title' => 'required',
            'type' => 'required|in:SCREEN,REPORT,DEFAULT,SYSTEM',
        ], [
            'xscreen.required' => 'Screen code required.',
            'xscreen.unique' => 'Screen code must be unique.',
            'title.required' => 'Screen title required.',
            'type.required' => 'Screen type required.',
            'type.in' => 'Screen type must be one of Screen, Report, Default, System.',
        ]);

        $validator->validate();

        $screen = Screen::find($id);
        if (!$screen) {
            $this->setErrorStatusAndMessage("Screen not found");
            return $this->getResponse();
        }

        $request['xnum'] = $request->input('xnum') ?? 0;
        $request['seqn'] = $request->input('seqn') ?? 0;
        $request['icon'] = $request->input('icon') ?? 'ph ph-monitor';

        $screen->update($request->only([
            'xscreen',
            'title',
            'icon',
            'keywords',
            'type',
            'xnum',
            'seqn'
        ]));

        if ($screen) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('SA04', ['id' => $screen->id])),
                new ReloadSection('header-table-container', route('SA04.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Screen updated successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Screen update failed");
        return $this->getResponse();
    }

    public function delete($id)
    {
        $screen = Screen::find($id);
        if (!$screen) {
            $this->setErrorStatusAndMessage("Screen not found");
            return $this->getResponse();
        }

        $screen->delete();

        if (!$screen) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('SA04', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('SA04.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Screen deleted successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Screen deletion failed");
        return $this->getResponse();
    }
}
