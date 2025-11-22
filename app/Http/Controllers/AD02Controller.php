<?php

namespace App\Http\Controllers;

use App\Helpers\ReloadSection;
use App\Models\Menu;
use App\Models\MenuScreen;
use App\Models\Profile;
use App\Models\Profiledt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AD02Controller extends ZayaanController
{

    public function recursiveToChilds($menu, $businessId, $profileId = null, $count = 1)
    {
        foreach ($menu['children'] as &$child) { // Use reference to modify original array
            Log::debug(str_repeat('--', $count) . ' Child Menu: ' . $child['xmenu'] . ' - ' . $child['title']);

            // Initialize menu_screens array if not exists
            if (!isset($child['menu_screens'])) {
                $child['menu_screens'] = [];
            }

            // Find the menu screens associated with this menu
            $menuScreens = MenuScreen::with(['menu', 'screen'])->where('menu_id', $child['id'])->where('business_id', $businessId)->orderBy('seqn', 'asc')->get();

            foreach ($menuScreens as $ms) {
                Log::debug(str_repeat('   ', $count) . '-> Menu Screen: ' . $ms->screen->xscreen . ' - ' . $ms->screen->title . ' (Alternate Title: ' . ($ms->alternate_title ?? 'N/A') . ')');

                // Check Menu Screen is available in profiledt
                $profiledt = Profiledt::where('profile_id', getProfileId())
                    ->where('business_id', getBusinessId())
                    ->where('menu_screen_id', $ms->id)
                    ->first();
               
                $child['menu_screens'][] = [
                    'id' => $ms->id,
                    'menu_id' => $ms->menu_id,
                    'screen_id' => $ms->screen_id,
                    'alternate_title' => $ms->alternate_title ?? $ms->screen->title,
                    'seqn' => $ms->seqn,
                    'screen_xscreen' => $ms->screen->xscreen,
                    'menu_xmenu' => $ms->menu->xmenu,
                    'screen_type' => $ms->screen->type,
                    'is_active' => $profiledt ? true : false,
                    'profile_id' => $profileId,
                ];
                // REMOVE THIS: dd($child);
            }

            if (!empty($child['children'])) {
                $child = $this->recursiveToChilds($child, $count + 1);
            }
        }

        return $menu;
    }

    public function getMenuGroup($profileId = null)
    {
        $menus = Menu::generateMenuTree();
        $menuGroupWithScreen = [];

        $businessId = getBusinessId();
        $allowCustomeMenu = getSelectedBusiness()['is_allow_custom_menu'] ?? false;
        if(!$allowCustomeMenu){
            $businessId = null;
        }

        foreach ($menus as &$menu) { // Use reference to modify original array
            Log::debug("Menu: " . $menu['xmenu'] . " - " . $menu['title']);

            // Initialize menu_screens array if not exists
            if (!isset($menu['menu_screens'])) {
                $menu['menu_screens'] = [];
            }

            // Find the menu screens associated with this menu
            $menuScreens = MenuScreen::with(['menu', 'screen'])->where('menu_id', $menu['id'])->where('business_id', $businessId)->orderBy('seqn', 'asc')->get();

            foreach ($menuScreens as $ms) {
                Log::debug("-> Menu Screen: " . $ms->screen->xscreen . " - " . $ms->screen->title . " (Alternate Title: " . ($ms->alternate_title ?? 'N/A') . ")");

                // Check Menu Screen is available in profiledt
                $profiledt = Profiledt::where('profile_id', getProfileId())
                    ->where('business_id', getBusinessId())
                    ->where('menu_screen_id', $ms->id)
                    ->first();

                $menu['menu_screens'][] = [
                    'id' => $ms->id,
                    'menu_id' => $ms->menu_id,
                    'screen_id' => $ms->screen_id,
                    'alternate_title' => $ms->alternate_title ?? $ms->screen->title,
                    'seqn' => $ms->seqn,
                    'screen_xscreen' => $ms->screen->xscreen,
                    'menu_xmenu' => $ms->menu->xmenu,
                    'screen_type' => $ms->screen->type,
                    'is_active' => $profiledt ? true : false,
                    'profile_id' => $profileId,
                ];
            }

            $menu = $this->recursiveToChilds($menu, $businessId);
            $menuGroupWithScreen[] = $menu;
        }

        return $menuGroupWithScreen;
    }

    public function index(Request $request)
    {
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N'); // Returns null if not present

        if ($request->ajax()) {
            if ($frommenu == 'Y') {
                return response()->json([
                    'page' => view('pages.AD02.AD02', [
                        'profile' => (new Profile())->fill(['seqn' => 0, 'is_active' => 1]),
                        'detailList' => [],
                    ])->render(),
                    'content_header_title' => 'Access Profile',
                    'subtitle' => 'Access Profile',
                ]);
            }

            if ("RESET" == $id) {
                return response()->json([
                    'page' => view('pages.AD02.AD02-main-form', [
                        'profile' => (new Profile())->fill(['seqn' => 0, 'is_active' => 1]),
                        'detailList' => [],
                    ])->render(),
                ]);
            }

            try {
                $profile = Profile::findOrFail($id);

                return response()->json([
                    'page' => view('pages.AD02.AD02-main-form', [
                        'profile' => $profile,
                        'detailList' => $this->getMenuGroup($profile->id),
                    ])->render(),
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'page' => view('pages.AD02.AD02-main-form', [
                        'profile' => (new Profile())->fill(['seqn' => 0, 'is_active' => 1]),
                        'detailList' => [],
                    ])->render(),
                ]);
            }
        }

        // When url is directly hit from url bar
        return view('index', [
            'page' => 'pages.AD02.AD02',
            'content_header_title' => 'Access Profile',
            'subtitle' => 'Access Profile',
            'profile' => (new Profile())->fill(['seqn' => 0, 'is_active' => 1]),
            'detailList' => [],
        ]);
    }

    public function detailTable(Request $request)
    {
        $profileId = $request->query('profile_id', 'RESET');

        return response()->json([
            'page' => view('pages.AD02.AD02-detail-table', [
                'detailList' => $profileId == 'RESET' ? [] : $this->getMenuGroup($profileId)
            ])->render(),
        ]);
    }


    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'seqn' => 'required|integer',
        ], [
            'name.required' => 'Profile name is required',
            'seqn.required' => 'Sequence is required',
            'seqn.integer' => 'Sequence must be an integer',
        ]);

        $validator->validate();

        $request['is_active'] = $request->has('is_active');
        $request['business_id'] = getBusinessId();

        $profile = Profile::create($request->only([
            'name',
            'seqn',
            'is_active',
            'business_id'
        ]));

        if ($profile) {
            $this->setReloadSections([
                new ReloadSection('main-form-container', route('AD02', ['id' => 'RESET'])),
                // new ReloadSection('header-table-container', route('AD02.header-table')),
            ]);
            $this->setSuccessStatusAndMessage("Profile created successfully");
            return $this->getResponse();
        }

        $this->setErrorStatusAndMessage("Profile creation failed");
        return $this->getResponse();
    }




}
