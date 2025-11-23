<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\Menu;
use App\Models\MenuScreen;
use App\Models\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AD03Controller extends ZayaanController
{

    public function recursiveToChilds($menu, $count = 1)
    {
        foreach ($menu['children'] as &$child) { // Use reference to modify original array
            Log::debug(str_repeat('--', $count) . ' Child Menu: ' . $child['xmenu'] . ' - ' . $child['title']);

            // Initialize menu_screens array if not exists
            if (!isset($child['menu_screens'])) {
                $child['menu_screens'] = [];
            }

            // Find the menu screens associated with this menu
            $menuScreens = MenuScreen::relatedBusiness()->with(['menu', 'screen'])->where('menu_id', $child['id'])->orderBy('seqn', 'asc')->get();

            foreach ($menuScreens as $ms) {
                Log::debug(str_repeat('   ', $count) . '-> Menu Screen: ' . $ms->screen->xscreen . ' - ' . $ms->screen->title . ' (Alternate Title: ' . ($ms->alternate_title ?? 'N/A') . ')');
                $child['menu_screens'][] = [
                    'id' => $ms->id,
                    'menu_id' => $ms->menu_id,
                    'screen_id' => $ms->screen_id,
                    'alternate_title' => $ms->alternate_title ?? $ms->screen->title,
                    'seqn' => $ms->seqn,
                    'screen_xscreen' => $ms->screen->xscreen,
                    'menu_xmenu' => $ms->menu->xmenu,
                    'screen_type' => $ms->screen->type,
                ];
                // REMOVE THIS: dd($child);
            }

            if (!empty($child['children'])) {
                $child = $this->recursiveToChilds($child, $count + 1);
            }
        }

        return $menu;
    }

    public function getMenuGroup($businessId)
    {
        $menus = Menu::generateMenuTree($businessId);
        $menuGroupWithScreen = [];

        foreach ($menus as &$menu) { // Use reference to modify original array
            Log::debug("Menu: " . $menu['xmenu'] . " - " . $menu['title']);

            // Initialize menu_screens array if not exists
            if (!isset($menu['menu_screens'])) {
                $menu['menu_screens'] = [];
            }

            // Find the menu screens associated with this menu
            $menuScreens = MenuScreen::relatedBusiness()->with(['menu', 'screen'])->where('menu_id', $menu['id'])->orderBy('seqn', 'asc')->get();

            foreach ($menuScreens as $ms) {
                Log::debug("-> Menu Screen: " . $ms->screen->xscreen . " - " . $ms->screen->title . " (Alternate Title: " . ($ms->alternate_title ?? 'N/A') . ")");
                $menu['menu_screens'][] = [
                    'id' => $ms->id,
                    'menu_id' => $ms->menu_id,
                    'screen_id' => $ms->screen_id,
                    'alternate_title' => $ms->alternate_title ?? $ms->screen->title,
                    'seqn' => $ms->seqn,
                    'screen_xscreen' => $ms->screen->xscreen,
                    'menu_xmenu' => $ms->menu->xmenu,
                    'screen_type' => $ms->screen->type,
                ];
            }

            $menu = $this->recursiveToChilds($menu);
            $menuGroupWithScreen[] = $menu;
        }

        return $menuGroupWithScreen;
    }

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
                    'page' => view('pages.AD03.AD03', [
                        'allowCustomMenu' => getSelectedBusiness() == null ? true : $allowCustomMenu,
                        'menus' => Menu::generateMenuTree($businessId),
                        'screens' => Screen::whereIn('type', ['SCREEN', 'REPORT'])->orderBy('seqn', 'asc')->get(),
                        'menuScreen' => (new MenuScreen())->fill(['seqn' => 0]),
                        'detailList' => $this->getMenuGroup($businessId)
                    ])->render(),
                    'content_header_title' => 'Navigation Management',
                    'subtitle' => 'Navigation',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.AD03.AD03-main-form', [
                        'allowCustomMenu' => getSelectedBusiness() == null ? true : $allowCustomMenu,
                        'menus' => Menu::generateMenuTree($businessId),
                        'screens' => Screen::whereIn('type', ['SCREEN', 'REPORT'])->orderBy('seqn', 'asc')->get(),
                        'menuScreen' => (new MenuScreen())->fill(['seqn' => 0]),
                    ])->render(),
                ]);
            }

            try {
                $menuScreen = MenuScreen::findOrFail($id);

                return response()->json([
                    'page' => view('pages.AD03.AD03-main-form', [
                        'allowCustomMenu' => getSelectedBusiness() == null ? true : $allowCustomMenu,
                        'menus' => Menu::generateMenuTree($businessId),
                        'screens' => Screen::whereIn('type', ['SCREEN', 'REPORT'])->orderBy('seqn', 'asc')->get(),
                        'menuScreen' => $menuScreen,
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.AD03.AD03-main-form', [
                        'allowCustomMenu' => getSelectedBusiness() == null ? true : $allowCustomMenu,
                        'menus' => Menu::generateMenuTree($businessId),
                        'screens' => Screen::whereIn('type', ['SCREEN', 'REPORT'])->orderBy('seqn', 'asc')->get(),
                        'menuScreen' => (new MenuScreen())->fill(['seqn' => 0]),
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.AD03.AD03',
            'content_header_title' => 'Navigation Management',
            'subtitle' => 'Navigation',
            'allowCustomMenu' => getSelectedBusiness() == null ? true : $allowCustomMenu,
            'menus' => Menu::generateMenuTree($businessId),
            'screens' => Screen::whereIn('type', ['SCREEN', 'REPORT'])->orderBy('seqn', 'asc')->get(),
            'menuScreen' => (new MenuScreen())->fill(['seqn' => 0]),
            'detailList' => $this->getMenuGroup($businessId)
        ]);
    }

    public function headerTable()
    {
        $businessId = getBusinessId();
        $allowCustomMenu = getSelectedBusiness()['is_allow_custom_menu'] ?? false;
        if (!$allowCustomMenu) {
            $businessId = null;
        }

        return response()->json([
            'page' => view('pages.AD03.AD03-header-table', [
                'allowCustomMenu' => getSelectedBusiness() == null ? true : $allowCustomMenu,
                'detailList' => $this->getMenuGroup($businessId),
            ])->render(),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'menu_id' => 'required|exists:menus,id',
            'screen_id' => 'required|exists:screens,id',
            'alternate_title' => 'nullable|string|max:50',
        ], [
            'menu_id.required' => 'The menu field is required.',
            'menu_id.exists' => 'The selected menu is invalid.',
            'screen_id.required' => 'The screen field is required.',
            'screen_id.exists' => 'The selected screen is invalid.',
            'alternate_title.max' => 'The alternate title may not be greater than 50 characters.',
        ]);

        $validator->validate();

        $request['seqn'] = $request->input('seqn') ?? 0;
        $request->merge(['business_id' => getBusinessId()]); // For now, set business_id to null

        // CHeck uniqueness
        $exists = MenuScreen::where('menu_id', $request->input('menu_id'))
            ->where('screen_id', $request->input('screen_id'))
            ->where('business_id', getBusinessId())
            ->first();

        if ($exists) {
            $this->setErrorStatusAndMessage("The combination of Menu and Screen must be unique. This combination already exists.");
            return $this->getResponse();
        }

        $menuScreen = MenuScreen::create($request->only([
            'menu_id',
            'screen_id',
            'business_id',
            'alternate_title',
            'seqn',
        ]));

        if ($menuScreen) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD03', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('AD03.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Menu Screen created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Menu Screen creation failed");
        return $this->getResponse();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'menu_id' => 'required|exists:menus,id',
            'screen_id' => 'required|exists:screens,id',
            'alternate_title' => 'nullable|string|max:50',
        ], [
            'menu_id.required' => 'The menu field is required.',
            'menu_id.exists' => 'The selected menu is invalid.',
            'screen_id.required' => 'The screen field is required.',
            'screen_id.exists' => 'The selected screen is invalid.',
            'alternate_title.max' => 'The alternate title may not be greater than 50 characters.',
        ]);

        $validator->validate();

        $request['seqn'] = $request->input('seqn') ?? 0;

        // CHeck uniqueness
        $exists = MenuScreen::where('menu_id', $request->input('menu_id'))
            ->where('screen_id', $request->input('screen_id'))
            ->where('business_id', getBusinessId())
            ->where('id', '!=', $id)
            ->first();

        if ($exists) {
            $this->setErrorStatusAndMessage("The combination of Menu and Screen must be unique. This combination already exists.");
            return $this->getResponse();
        }

        try {
            $menuScreen = MenuScreen::findOrFail($id);
            $menuScreen->update($request->only([
                'menu_id',
                'screen_id',
                'alternate_title',
                'seqn',
            ]));

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD03', ['id' => $menuScreen->id])),
                new ReloadSection('header-table-container', route('AD03.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Menu Screen updated successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("Menu Screen update failed");
            return $this->getResponse();
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $menuScreen = MenuScreen::findOrFail($id);
            $menuScreen->delete();

            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD03', ['id' => 'RESET'])),
                new ReloadSection('header-table-container', route('AD03.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Menu Screen deleted successfully");
            return $this->getResponse();
        } catch (\Throwable $th) {
            $this->setErrorStatusAndMessage("Menu Screen deletion failed");
            return $this->getResponse();
        }
    }
}
