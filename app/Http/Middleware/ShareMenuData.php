<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use App\Models\MenuScreen;
use App\Models\Profiledt;
use App\Services\ZayaanSessionManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ShareMenuData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->ajax()) {
            return $next($request);
        }

        Config::set('adminlte.menu', $this->buildMenu());
        Config::set('adminlte.title', $this->setSiteTitle());
        return $next($request);
    }

    protected function setSiteTitle()
    {
        $title = Config::get('adminlte.title');
        if (getSelectedBusiness() !== null) {
            $title = getSelectedBusiness()['name'];
        }
        return $title;
    }

    protected function buildMenu()
    {
        if (Auth::check()) {
            return $this->getAuthenticatedMenu();
        }

        return $this->getPublicMenu();
    }

    protected function getPublicMenu()
    {
        return Config::get('adminlte.menu');
    }

    protected function getAuthenticatedMenu()
    {
        $menu = Config::get('adminlte.menu');

        $loggedInUser = getLoggedInUserDetails();

        if ($loggedInUser === null) {
            return $menu;
        }

        // System Admin Menus
        if ($loggedInUser['is_system_admin'] ?? false) {

            // If no business is selected
            if (getSelectedBusiness() === null) {
                $menu[] = [
                    'text' => 'Business Selection',
                    'route' => 'business-selection',
                    'icon' => 'ph ph-swap',
                    'classes' => 'screen-item d-flex align-items-center',
                    'data' => [
                        'screen' => 'business-selection',
                    ],
                ];
                $menu[] = ['header' => 'Platform Administration'];
                $menu[] = [
                    'text' => 'Business Category',
                    'route' => 'SA01',
                    'icon' => 'ph ph-copy-simple',
                    'classes' => 'screen-item d-flex align-items-center',
                    'data' => [
                        'screen' => 'SA01',
                    ],
                ];
                $menu[] = [
                    'text' => 'Business',
                    'route' => 'SA02',
                    'icon' => 'ph ph-briefcase',
                    'classes' => 'screen-item d-flex align-items-center',
                    'data' => [
                        'screen' => 'SA02',
                    ],
                ];
                $menu[] = [
                    'text' => 'Business Admins',
                    'route' => 'SA03',
                    'icon' => 'ph ph-user-circle',
                    'classes' => 'screen-item d-flex align-items-center',
                    'data' => [
                        'screen' => 'SA03',
                    ],
                ];
                $menu[] = [
                    'text' => 'Pages',
                    'route' => 'SA04',
                    'icon' => 'ph ph-monitor',
                    'classes' => 'screen-item d-flex align-items-center',
                    'data' => [
                        'screen' => 'SA04',
                    ],
                ];
                $menu[] = ['header' => 'Administration'];
                $menu[] = [
                    'text' => 'Menus',
                    'route' => 'SA05',
                    'icon' => 'ph ph-align-left',
                    'classes' => 'screen-item d-flex align-items-center',
                    'data' => [
                        'screen' => 'SA05',
                    ],
                ];
                $menu[] = [
                    'text' => 'Navigation Management',
                    'route' => 'SA06',
                    'icon' => 'ph ph-anchor-simple',
                    'classes' => 'screen-item d-flex align-items-center',
                    'data' => [
                        'screen' => 'SA06',
                    ],
                ];
                $menu[] = [
                    'text' => 'Codes & Parameters',
                    'route' => 'SA07',
                    'icon' => 'ph ph-tree-structure',
                    'classes' => 'screen-item d-flex align-items-center',
                    'data' => [
                        'screen' => 'SA07',
                    ],
                ];
                $menu[] = ['header' => 'Master Data'];
                $menu[] = [
                    'text' => 'Category',
                    'route' => 'MD02',
                    'icon' => 'ph ph-sort-ascending',
                    'classes' => 'screen-item d-flex align-items-center',
                    'data' => [
                        'screen' => 'MD02',
                    ],
                ];
                $menu[] = [
                    'text' => 'Attribute',
                    'route' => 'MD03',
                    'icon' => 'ph ph-arrows-split',
                    'classes' => 'screen-item d-flex align-items-center',
                    'data' => [
                        'screen' => 'MD03',
                    ],
                ];
                $menu[] = [
                    'text' => 'Tags',
                    'route' => 'MD05',
                    'icon' => 'ph ph-tag-chevron',
                    'classes' => 'screen-item d-flex align-items-center',
                    'data' => [
                        'screen' => 'MD05',
                    ],
                ];

                return $menu;  // No selected business, return default menu
            } else {  // Business is selected
                $menu[] = [
                    'text' => 'Switch Business',
                    'route' => 'business-selection',
                    'icon' => 'ph ph-swap',
                    'classes' => 'screen-item d-flex align-items-center',
                    'data' => [
                        'screen' => 'business-selection',
                    ],
                ];

                // Constract Menu for selected business
                return $this->generateMenuForSelectedBusiness($menu, $loggedInUser);
            }
        }

        // Add role-specific menus
        // if ($loggedInUser['is_system_admin'] ?? false) {
        //     if (getSelectedBusiness() === null) {
        //         return $menu;  
        //     }

        //     $menu = Config::get('adminlte.menu');

        //     $menu[] = [
        //         'text' => 'Dashboard',
        //         'route' => 'DASH',
        //         'icon' => 'ph ph-speedometer',
        //         'classes' => 'screen-item d-flex align-items-center',
        //         'data' => [
        //             'screen' => 'DASH',
        //         ],
        //     ];
        //     $menu[] = [
        //         'text' => 'Access Profiles',
        //         'route' => 'AD02',
        //         'icon' => 'ph ph-fingerprint',
        //         'classes' => 'screen-item d-flex align-items-center',
        //         'data' => [
        //             'screen' => 'AD02',
        //         ],
        //     ];

        //     $menu[] = [
        //         'text' => 'Manage Users',
        //         'route' => 'AD03',
        //         'icon' => 'ph ph-fingerprint',
        //         'classes' => 'screen-item d-flex align-items-center',
        //         'data' => [
        //             'screen' => 'AD03',
        //         ],
        //     ];

        //     return $menu;
        // }

        // if ($loggedInUser['is_business_admin'] ?? false) {
        //     if (getSelectedBusiness() === null) {
        //         return $menu;  // No selected business, return default menu
        //     }

        //     $menu[] = [
        //         'text' => 'Access Profiles',
        //         'route' => 'AD02',
        //         'icon' => 'ph ph-fingerprint',
        //         'classes' => 'screen-item d-flex align-items-center',
        //         'data' => [
        //             'screen' => 'AD02',
        //         ],
        //     ];

        //     $menu[] = [
        //         'text' => 'Manage Users',
        //         'route' => 'AD03',
        //         'icon' => 'ph ph-fingerprint',
        //         'classes' => 'screen-item d-flex align-items-center',
        //         'data' => [
        //             'screen' => 'AD03',
        //         ],
        //     ];

        //     return $menu;
        // }

        return $menu;
    }

    public function generateMenuForSelectedBusiness($menu, $loggedInUser)
    {
        // Constract Menu for selected business

        $menusData = $this->getMenuGroup();

        // dd($menusData);

        foreach ($menusData as $m) {
            if ((!isset($m['menu_screens']) || count($m['menu_screens']) == 0) && (!isset($m['children']) || count($m['children']) == 0)) {
                continue;
            }

            $menu[] = ['header' => $m['title']];

            // Set Screens
            if (isset($m['menu_screens']) && count($m['menu_screens']) > 0) {
                foreach ($m['menu_screens'] as $ms) {
                    $menu[] = [
                        'text' => $ms['alternate_title'],
                        'route' => 'DASH', // You can modify this to point to the appropriate route
                        'icon' => $ms['screen_icon'] ?? '',
                        'classes' => 'screen-item d-flex align-items-center',
                        'data' => [
                            'screen' => $ms['screen_xscreen'],
                        ],
                    ];
                }
            }

            // Set Child Menus
            if (isset($m['children']) && count($m['children']) > 0) {
                // dd($m['children']);
                foreach ($m['children'] as $cm) {
                    $menu[] = [
                        'text' => $cm['title'],
                        'icon' => $cm['icon'] ?? '',
                        'submenu' => [
                            [
                                'text' => 'level_one',
                                'url' => '#',
                            ],
                        ], // Initialize submenu
                    ];
                }
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
        if (!$allowCustomeMenu) {
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
                $profiledt = Profiledt::where('profile_id', $profileId)
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
                    'screen_icon' => $ms->screen->icon,
                    'menu_xmenu' => $ms->menu->xmenu,
                    'screen_type' => $ms->screen->type,
                    'is_active' => $profiledt ? true : false,
                    'profile_id' => $profileId,
                ];
            }

            $menu = $this->recursiveToChilds($menu, $businessId, $profileId);
            $menuGroupWithScreen[] = $menu;
        }

        return $menuGroupWithScreen;
    }

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
                $profiledt = Profiledt::where('profile_id', $profileId)
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
                    'screen_icon' => $ms->screen->icon,
                    'menu_xmenu' => $ms->menu->xmenu,
                    'screen_type' => $ms->screen->type,
                    'is_active' => $profiledt ? true : false,
                    'profile_id' => $profileId,
                ];
                // REMOVE THIS: dd($child);
            }

            if (!empty($child['children'])) {
                $child = $this->recursiveToChilds($child, $businessId, $profileId, $count + 1);
            }
        }

        return $menu;
    }
}
