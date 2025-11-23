<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AD02Controller extends ZayaanController
{
    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N'); // Returns null if not present

        $businessId = getBusinessId();
        $allowCustomMenu = getSelectedBusiness()['is_allow_custom_menu'] ?? false;
        if (!$allowCustomMenu) {
            $businessId = null;
        }

        if ($request->ajax()) {
            if ($frommenu == 'Y') {
                return response()->json([
                    'page' => view('pages.AD02.AD02', [
                        'allowCustomMenu' => getSelectedBusiness() == null ? true : $allowCustomMenu,
                        'menuTree' => Menu::generateMenuTree($businessId),
                        'menu' => (new Menu())->fill(['seqn' => 0, 'icon' => 'ph ph-align-left']),
                        'detailList' => Menu:: relatedBusiness()->with('parentMenu')->orderBy('seqn', 'asc')->get()
                    ])->render(),
                    'content_header_title' => 'Menu Management',
                    'subtitle' => 'Menu',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.AD02.AD02-main-form', [
                        'allowCustomMenu' => getSelectedBusiness() == null ? true : $allowCustomMenu,
                        'menuTree' => Menu::generateMenuTree($businessId),
                        'menu' => (new Menu())->fill(['seqn' => 0, 'icon' => 'ph ph-align-left']),
                    ])->render(),
                ]);
            }

            try {
                $menu = Menu::findOrFail($id);

                return response()->json([
                    'page' => view('pages.AD02.AD02-main-form', [
                        'allowCustomMenu' => getSelectedBusiness() == null ? true : $allowCustomMenu,
                        'menuTree' => Menu::generateMenuTree($menu->business_id, $menu->id),
                        'menu' => $menu,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.AD02.AD02-main-form', [
                        'allowCustomMenu' => getSelectedBusiness() == null ? true : $allowCustomMenu,
                        'menuTree' => Menu::generateMenuTree($businessId),
                        'menu' => (new Menu())->fill(['seqn' => 0, 'icon' => 'ph ph-align-left']),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.AD02.AD02',
            'content_header_title' => 'Menu Management',
            'subtitle' => 'Menu',
            'allowCustomMenu' => getSelectedBusiness() == null ? true : $allowCustomMenu,
            'menuTree' => Menu::generateMenuTree($businessId),
            'menu' => (new Menu())->fill(['seqn' => 0, 'icon' => 'ph ph-align-left']),
            'detailList' => Menu::relatedBusiness()->with('parentMenu')->orderBy('seqn', 'asc')->get()
        ]);
    }

    public function headerTable()
    {
        $allowCustomMenu = getSelectedBusiness()['is_allow_custom_menu'] ?? false;

        return response()->json([
            'page' => view('pages.AD02.AD02-header-table', [
                'allowCustomMenu' => getSelectedBusiness() == null ? true : $allowCustomMenu,
                'detailList' => Menu::relatedBusiness()->with('parentMenu')->orderBy('seqn', 'asc')->get()
            ])->render(),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'xmenu' => 'required|string|max:10|unique:menus,xmenu,NULL,id,business_id,' . getBusinessId(),  // Menu must be unique per business
            'title' => 'required|string|max:50',
            'icon' => 'nullable|string|max:50',
            'seqn' => 'nullable|integer',
            'parent_menu_id' => 'nullable|exists:menus,id',
        ], [
            'xmenu.required' => 'The menu code is required.',
            'xmenu.max' => 'The menu code may not be greater than 10 characters.',
            'title.required' => 'The title is required.',
            'title.max' => 'The title may not be greater than 50 characters.',
            'icon.max' => 'The icon may not be greater than 50 characters.',
            'seqn.integer' => 'The sequence must be an integer.',
            'parent_menu_id.exists' => 'The selected parent menu is invalid.',
        ]);

        $validator->validate();

        $request['seqn'] = $request->input('seqn') ?? 0;
        $request['icon'] = $request->input('icon') ?? 'ph ph-align-left';
        $request->merge(['business_id' => getBusinessId()]); // For now, set business_id to null

        $menu = Menu::create($request->only([
            'xmenu',
            'title',
            'icon',
            'seqn',
            'parent_menu_id',
            'business_id'
        ]));

        if ($menu) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD02', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('AD02.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Menu created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Menu creation failed");
        return $this->getResponse();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'xmenu' => 'required|string|max:10|unique:menus,xmenu,' . $id . ',id,business_id,' . getBusinessId(),  // Menu must be unique per business
            'title' => 'required|string|max:50',
            'icon' => 'nullable|string|max:50',
            'seqn' => 'nullable|integer',
            'parent_menu_id' => 'nullable|exists:menus,id',
        ], [
            'xmenu.required' => 'The menu code is required.',
            'xmenu.max' => 'The menu code may not be greater than 10 characters.',
            'title.required' => 'The title is required.',
            'title.max' => 'The title may not be greater than 50 characters.',
            'icon.max' => 'The icon may not be greater than 50 characters.',
            'seqn.integer' => 'The sequence must be an integer.',
            'parent_menu_id.exists' => 'The selected parent menu is invalid.',
        ]);

        $validator->validate();

        $menu = Menu::find($id);
        if(!$menu){
            $this->setErrorStatusAndMessage("Menu not found");
            return $this->getResponse();
        }

        $request['seqn'] = $request->input('seqn') ?? 0;
        $request['icon'] = $request->input('icon') ?? 'ph ph-align-left';
        $menu->update($request->only([
            'xmenu',
            'title',
            'icon',
            'seqn',
            'parent_menu_id',
        ]));

        if ($menu) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD02', ['id' => $menu->id])),
                new ReloadSection('header-table-container', route('AD02.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Menu updated successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Menu update failed");
        return $this->getResponse();
    }

    public function delete($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            $this->setErrorStatusAndMessage("Menu not found");
            return $this->getResponse();
        }

        $menu->delete();

        $this->setReloadSections([
            new ReloadSection('main-form-container', route('AD02', ['id' => 'RESET'])),
            new ReloadSection('header-table-container', route('AD02.header-table')),
        ]);
        $this->setSuccessStatusAndMessage("Menu deleted successfully");
        return $this->getResponse();
    }
}
