<?php

namespace App\Http\Controllers;

use App\Helpers\DatatableRequestHelper;
use App\Helpers\DatatableResponseHelper;
use App\Services\ProfileService;
use Illuminate\Http\Request;


class SearchSuggestController extends ZayaanController
{

    public function __construct(private ProfileService $profileService)
    {
        parent::__construct();
    }

    public function index(Request $request, string $fragmentcode, int $suffix)
    {
        $hint = $request->query('hint');
        $dependentparam = $request->query('dependentparam');
        $resetparam = $request->query('resetparam');
        $hasdeletebtn = $request->query('hasdeletebtn', false);

        return view('pages.search.search-' . $fragmentcode , [
            'suffix' => $suffix,
            'searchValue' => $hint,
            'dependentParam' => $dependentparam,
            'resetParam' => $resetparam,
            'fieldId' => $request->get('fieldId'),
            'mainscreen' => $request->get('mainscreen', false),
            'mainreloadurl' => $request->get('mainreloadurl'),
            'mainreloadid' => $request->get('mainreloadid'),
            'extrafieldcontroller' => $request->get('extrafieldcontroller'),
            'detailreloadurl' => $request->get('detailreloadurl'),
            'detailreloadid' => $request->get('detailreloadid'),
            'additionalreloadurl' => $request->get('additionalreloadurl'),
            'additionalreloadid' => $request->get('additionalreloadid'),
            'tablename' => time(),
            'fragmentcode' => $fragmentcode,
            'hasdeletebtn' => $hasdeletebtn,
        ])->render();
    }

    public function LAD05(Request $request, int $suffix)
    {
        $helper = DatatableRequestHelper::fromRequest($request);

        // dd($helper);

        $dependentParam = $request->query('dependentparam');
        
        // Get paginated data
        $list = $this->profileService->LAD05(
            length: $helper->length,
            start: $helper->start,
            orderColumn: $helper->columns->get($helper->orderColumnNo)->name,
            orderType: $helper->orderType,
            searchValue: $helper->searchValue,
            suffix: $suffix,
            dependentParam: $dependentParam
        );

        // Get total rows count
        $totalRows = $this->profileService->LAD05Count(
            orderColumn: $helper->columns->get($helper->orderColumnNo)->name,
            orderType: $helper->orderType,
            searchValue: $helper->searchValue,
            suffix: $suffix,
            dependentParam: $dependentParam
        );

        // Create response
        $response = new DatatableResponseHelper(
            draw: $helper->draw,
            recordsTotal: $totalRows,
            recordsFiltered: $totalRows,
            data: $list
        );

        return $response->toResponse();
    }
}
