<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\Attribute;
use App\Models\Cadoc;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MD04Controller extends ZayaanController
{

    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N');

        // Get attribute_id from request parameter
        $attribute_id = $request->query('attribute_id', null); // Returns null if not present
        if ($attribute_id == null) {
            return redirect()->route('AD04');
        }

        $attribute = Attribute::find($attribute_id);
        if (!$attribute) {
            return redirect()->route('AD04');
        }

        if ($request->ajax()) {
            if ($frommenu == 'Y') {
                return response()->json([
                    'page' => view('pages.MD04.MD04', [
                        'attribute' => $attribute,
                        'term' => (new Term())->fill(['seqn' => 0, 'color' => '#ffffff', 'attribute_id' => $attribute_id]),
                        'detailList' => Term::with(['attribute', 'thumbnail'])->where('attribute_id', $attribute_id)->where('business_id', getBusinessId())->orderBy('seqn', 'asc')->get()
                    ])->render(),
                    'content_header_title' => 'Attribute Option for : ' . $attribute->name,
                    'subtitle' => 'Attribute Options',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.MD04.MD04-main-form', [
                        'term' => (new Term())->fill(['seqn' => 0, 'color' => '#ffffff', 'attribute_id' => $attribute_id]),
                        'attribute' => $attribute,
                    ])->render(),
                ]);
            }

            try {
                $term = Term::findOrFail($id);

                return response()->json([
                    'page' => view('pages.MD04.MD04-main-form', [
                        'term' => $term,
                        'attribute' => $attribute,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.MD04.MD04-main-form', [
                        'term' => (new Term())->fill(['seqn' => 0, 'color' => '#ffffff', 'attribute_id' => $attribute_id]),
                        'attribute' => $attribute,
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.MD04.MD04',
            'content_header_title' => 'Attribute Option for : ' . $attribute->name,
            'subtitle' => 'Attribute Options',
            'attribute' => $attribute,
            'term' => (new Term())->fill(['seqn' => 0, 'color' => '#ffffff', 'attribute_id' => $attribute_id]),
            'detailList' => Term::with(['attribute', 'thumbnail'])->where('attribute_id', $attribute_id)->where('business_id', getBusinessId())->orderBy('seqn', 'asc')->get()
        ]);
    }

    public function headerTable(Request $request)
    {
        $attribute_id = $request->query('attribute_id', null); // Returns null if not present
        if ($attribute_id == null) {
            return redirect()->route('AD04.header-table');
        }

        $attribute = Attribute::find($attribute_id);
        if (!$attribute) {
            return redirect()->route('AD04.header-table');
        }

        return response()->json([
            'page' => view('pages.MD04.MD04-header-table', [
                'attribute' => $attribute,
                'detailList' => Term::with(['attribute', 'thumbnail'])->where('attribute_id', $attribute_id)->where('business_id', getBusinessId())->orderBy('seqn', 'asc')->get()
            ])->render(),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'color' => 'nullable|string|max:7',
            'seqn' => 'nullable|integer|min:0',
            'thumbnail' => 'nullable|integer|exists:cadocs,id',
            'attribute_id' => 'required|integer|exists:attributes,id',
        ], [
            'name.required' => 'The name field is required.',
            'name.max' => 'The name may not be greater than 50 characters.',
            'color.max' => 'The color may not be greater than 7 characters.',
            'seqn.integer' => 'The sequence must be an integer.',
            'seqn.min' => 'The sequence must be at least 0.',
            'thumbnail.integer' => 'The thumbnail must be an integer.',
            'thumbnail.exists' => 'The selected thumbnail is invalid.',
            'attribute_id.required' => 'The attribute ID field is required.',
            'attribute_id.integer' => 'The attribute ID must be an integer.',
            'attribute_id.exists' => 'The selected attribute ID is invalid.',
        ]);

        $validator->validate();

        $request['seqn'] = $request->input('seqn') ?? 0;
        $request['is_default'] = $request->has('is_default');

        $request->merge(['business_id' => getBusinessId()]); // For now, set business_id to null

        if ($request->has('thumbnail')) {
            // Assuming Cadoc is the model for handling file uploads
            $cadoc = Cadoc::find($request->input('thumbnail'));
            if ($cadoc) {
                // You might want to add additional logic here, like associating the Cadoc with the Category later
                $cadoc->temp = false; // Mark as permanent
                $cadoc->save();
            }
            $request->merge(['thumbnail_id' => $cadoc->id]);
        }

        // if is_default is set, unset previous defaults
        if ($request->input('is_default')) {
            Term::where('attribute_id', $request->input('attribute_id'))
                ->where('business_id', getBusinessId())
                ->update(['is_default' => false]);
        }

        $term = Term::create($request->only([
            'name',
            'color',
            'is_default',
            'seqn',
            'thumbnail_id',
            'attribute_id',
            'business_id',
        ]));

        if ($term) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD04', ['id' => 'RESET', 'attribute_id' => $request->input('attribute_id')])),
                new ReloadSection('header-table-container', route('MD04.header-table', ['attribute_id' => $request->input('attribute_id')])),
            ]);
            $this->setSuccessStatusAndMessage("Attribute option created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Attribute option creation failed");
        return $this->getResponse();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'color' => 'nullable|string|max:7',
            'seqn' => 'nullable|integer|min:0',
            'thumbnail' => 'nullable|integer|exists:cadocs,id',
            'attribute_id' => 'required|integer|exists:attributes,id',
        ], [
            'name.required' => 'The name field is required.',
            'name.max' => 'The name may not be greater than 50 characters.',
            'color.max' => 'The color may not be greater than 7 characters.',
            'seqn.integer' => 'The sequence must be an integer.',
            'seqn.min' => 'The sequence must be at least 0.',
            'thumbnail.integer' => 'The thumbnail must be an integer.',
            'thumbnail.exists' => 'The selected thumbnail is invalid.',
            'attribute_id.required' => 'The attribute ID field is required.',
            'attribute_id.integer' => 'The attribute ID must be an integer.',
            'attribute_id.exists' => 'The selected attribute ID is invalid.',
        ]);

        $validator->validate();

        $term = Term::find($id);
        if (!$term) {
            $this->setErrorStatusAndMessage("Attribute option not found");
            return $this->getResponse();
        }

        $request['seqn'] = $request->input('seqn') ?? 0;
        $request['is_default'] = $request->has('is_default');

        $request->merge(['business_id' => null]); // For now, set business_id to null

        if ($request->has('thumbnail')) {
            // Assuming Cadoc is the model for handling file uploads
            $cadoc = Cadoc::find($request->input('thumbnail'));
            if ($cadoc) {
                // You might want to add additional logic here, like associating the Cadoc with the Category later
                $cadoc->temp = false; // Mark as permanent
                $cadoc->save();
            }
            $request->merge(['thumbnail_id' => $cadoc->id]);
            Log::debug('Thumbnail uploaded with ID: ' . $cadoc->id);

            // Optionally, you might want to delete the old thumbnail here
            if ($term->thumbnail_id != null) {
                $oldCadoc = Cadoc::find($term->thumbnail_id);
                if ($oldCadoc && $oldCadoc->id != $cadoc->id) {
                    $oldCadoc->delete(); // Delete old thumbnail record

                    // Remove the physical file if needed
                    // AD18Controller::deletePhysicalFiles([
                    //     'original_file' => 'storage' . $oldCadoc->file_path . $oldCadoc->file_name,
                    //     'compressed_file' => 'storage' . $oldCadoc->file_path_compressed . $oldCadoc->file_name,
                    //     'file_name' => $oldCadoc->file_name,
                    //     'original_name' => $oldCadoc->original_file_name
                    // ]);
                }
            }
        }

        // Remove Thumbnail Triggered
        if ($request->remove_thumbnail == 'YES' && !$request->has('thumbnail')) {
            Log::debug('Removing thumbnail for category ID: ' . $term->id);
            if ($term->thumbnail_id != null) {
                $oldCadoc = Cadoc::find($term->thumbnail_id);
                if ($oldCadoc) {
                    $oldCadoc->delete(); // Delete old thumbnail record

                    // Remove the physical file if needed
                    // AD18Controller::deletePhysicalFiles([
                    //     'original_file' => 'storage' . $oldCadoc->file_path . $oldCadoc->file_name,
                    //     'compressed_file' => 'storage' . $oldCadoc->file_path_compressed . $oldCadoc->file_name,
                    //     'file_name' => $oldCadoc->file_name,
                    //     'original_name' => $oldCadoc->original_file_name
                    // ]);
                }
            }

            $request->merge(['thumbnail_id' => null]);
        }

        // if is_default is set, unset previous defaults
        if ($request->input('is_default')) {
            Term::where('attribute_id', $request->input('attribute_id'))
                ->where('business_id', getBusinessId())
                ->update(['is_default' => false]);
        }

        $term->update($request->only([
            'name',
            'color',
            'is_default',
            'seqn',
            'thumbnail_id',
            'attribute_id',
            'business_id',
        ]));

        if ($term) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('MD04', ['id' => $term->id, 'attribute_id' => $request->input('attribute_id')])),
                new ReloadSection('header-table-container', route('MD04.header-table', ['attribute_id' => $request->input('attribute_id')])),
            ]);
            $this->setSuccessStatusAndMessage("Attribute option updated successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Attribute option update failed");
        return $this->getResponse();
    }

    public function delete(Request $request, $id)
    {
        $term = Term::find($id);
        if (!$term) {
            $this->setErrorStatusAndMessage("Attribute option not found");
            return $this->getResponse();
        }

        $attribute_id = $term->attribute_id;

        // Optionally, delete associated thumbnail
        if ($term->thumbnail_id != null) {
            $oldCadoc = Cadoc::find($term->thumbnail_id);
            if ($oldCadoc) {
                $oldCadoc->delete(); // Delete old thumbnail record

                // Remove the physical file if needed
                // AD18Controller::deletePhysicalFiles([
                //     'original_file' => 'storage' . $oldCadoc->file_path . $oldCadoc->file_name,
                //     'compressed_file' => 'storage' . $oldCadoc->file_path_compressed . $oldCadoc->file_name,
                //     'file_name' => $oldCadoc->file_name,
                //     'original_name' => $oldCadoc->original_file_name
                // ]);
            }
        }

        $term->delete();

        $this->setReloadSections([
            new ReloadSection('main-form-container', route('MD04', ['id' => 'RESET', 'attribute_id' => $attribute_id])),
            new ReloadSection('header-table-container', route('MD04.header-table', ['attribute_id' => $attribute_id])),
        ]);
        $this->setSuccessStatusAndMessage("Attribute option deleted successfully");
        return $this->getResponse();
    }
}
