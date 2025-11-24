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
use Illuminate\Support\Facades\Route;
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
                    'route' => 'AD02',
                    'icon' => 'ph ph-align-left',
                    'classes' => 'screen-item d-flex align-items-center',
                    'data' => [
                        'screen' => 'AD02',
                    ],
                ];
                $menu[] = [
                    'text' => 'Navigation Management',
                    'route' => 'AD03',
                    'icon' => 'ph ph-anchor-simple',
                    'classes' => 'screen-item d-flex align-items-center',
                    'data' => [
                        'screen' => 'AD03',
                    ],
                ];
                $menu[] = [
                    'text' => 'Codes & Parameters',
                    'route' => 'AD04',
                    'icon' => 'ph ph-tree-structure',
                    'classes' => 'screen-item d-flex align-items-center',
                    'data' => [
                        'screen' => 'AD04',
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
                $menu[] = [
                    'text' => 'Product Labels',
                    'route' => 'MD06',
                    'icon' => 'ph ph-sticker',
                    'classes' => 'screen-item d-flex align-items-center',
                    'data' => [
                        'screen' => 'MD06',
                    ],
                ];

                return $menu;  // No selected business, return default menu
            } else {  // Business is selected
                $menu[] = [
                    'text' => getSelectedBusiness()['name'],
                    'route' => 'home',
                    'topnav' => true,
                    'classes' => 'business-brand',
                    'data' => [
                        'screen' => 'home',
                    ],
                ];


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


        if ($loggedInUser['is_business_admin'] ?? false) {
            // If no business is selected
            if (getSelectedBusiness() === null) {
                $menu[] = [
                    'text' => 'Select Business',
                    'route' => 'business-selection',
                    'icon' => 'ph ph-swap',
                    'classes' => 'screen-item d-flex align-items-center',
                    'data' => [
                        'screen' => 'business-selection',
                    ],
                ];

                return $menu;  // No selected business, return default menu
            }

            $menu[] = [
                'text' => getSelectedBusiness()['name'],
                'route' => 'home',
                'topnav' => true,
                'classes' => 'business-brand',
                'data' => [
                    'screen' => 'home',
                ],
            ];

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

        // For other users
        if (getSelectedBusiness() === null) {
            $menu[] = [
                'text' => 'Select Business',
                'route' => 'business-selection',
                'icon' => 'ph ph-swap',
                'classes' => 'screen-item d-flex align-items-center',
                'data' => [
                    'screen' => 'business-selection',
                ],
            ];

            return $menu;  // No selected business, return default menu
        }

        $menu[] = [
            'text' => 'Switch Business',
            'route' => 'business-selection',
            'icon' => 'ph ph-swap',
            'classes' => 'screen-item d-flex align-items-center',
            'data' => [
                'screen' => 'business-selection',
            ],
        ];

        if (getSelectedProfile() === null) {
            $menu[] = [
                'text' => 'Select Profile',
                'route' => 'profile-selection',
                'icon' => 'ph ph-swap',
                'classes' => 'screen-item d-flex align-items-center',
                'data' => [
                    'screen' => 'profile-selection',
                ],
            ];

            return $menu; // No profile selected, return default menu
        }

        $menu[] = [
            'text' => 'Switch Profile',
            'route' => 'profile-selection',
            'icon' => 'ph ph-swap',
            'classes' => 'screen-item d-flex align-items-center',
            'data' => [
                'screen' => 'profile-selection',
            ],
        ];

        // Constract Menu for selected business
        return $this->generateMenuForSelectedBusiness($menu, $loggedInUser);
    }

    public function isAnyScreenExistsOnChildMenus($menusData)
    {
        foreach ($menusData as $m) {
            // Check Screens
            if (isset($m['menu_screens']) && count($m['menu_screens']) > 0) {
                return true;
            }

            // Check Child Menus
            if (isset($m['children']) && count($m['children']) > 0) {
                if ($this->isAnyScreenExistsOnChildMenus($m['children'])) {
                    return true;
                }
            }
        }

        return false;
    }

    public function generateMenuForSelectedBusiness($menu, $loggedInUser)
    {
        // Constract Menu for selected business

        $menusData = $this->getMenuGroup(getProfileId());

        // dd($menusData);

        $marginCounter = 0;

        foreach ($menusData as $m) {
            if (!$this->isAnyScreenExistsOnChildMenus($m['children'])) {
                continue;
            }

            $menu[] = ['header' => $m['title']];

            // Set Screens
            if (isset($m['menu_screens']) && count($m['menu_screens']) > 0) {
                foreach ($m['menu_screens'] as $ms) {

                    // Check Route exists for the screen
                    if (Route::has($ms['screen_xscreen']) == false) {
                        Log::warning("Route not found for screen: " . $ms['screen_xscreen'] . " - " . $ms['alternate_title']);
                        continue;
                    }

                    // Skipable screens
                    if (in_array($ms['screen_xscreen'], $this->skipableScreens())) {
                        continue;
                    }

                    $menu[] = [
                        'text' => $ms['alternate_title'],
                        'route' => $ms['screen_xscreen'], // You can modify this to point to the appropriate route
                        'icon' => $ms['screen_icon'] ?? '',
                        'classes' => 'screen-item d-flex align-items-center ml-' . $marginCounter,
                        'data' => [
                            'screen' => $ms['screen_xscreen'],
                        ],
                    ];
                }
            }

            // Set Child Menus
            if (isset($m['children']) && count($m['children']) > 0) {
                $menu = $this->setChildMenus($menu, $m, $marginCounter);
            }
        }

        return $menu;
    }

    public function setChildMenus($menu, $m, $marginCounter = 1)
    {

        $menuData = $m['children'];

        foreach ($menuData as $m) {
            if ((!isset($m['menu_screens']) || count($m['menu_screens']) == 0) && (!isset($m['children']) || count($m['children']) == 0)) {
                continue;
            }

            $submenu = [];

            // Set Screens
            if (isset($m['menu_screens']) && count($m['menu_screens']) > 0) {
                foreach ($m['menu_screens'] as $ms) {
                    // Check Route exists for the screen
                    if (Route::has($ms['screen_xscreen']) == false) {
                        Log::warning("Route not found for screen: " . $ms['screen_xscreen'] . " - " . $ms['alternate_title']);
                        continue;
                    }

                    // Skipable screens
                    if (in_array($ms['screen_xscreen'], $this->skipableScreens())) {
                        continue;
                    }

                    $submenu[] = [
                        'text' => $ms['alternate_title'],
                        'route' => $ms['screen_xscreen'], // You can modify this to point to the appropriate route
                        'icon' => $ms['screen_icon'] ?? '',
                        'classes' => 'screen-item d-flex align-items-center ml-' . $marginCounter + 2,
                        'data' => [
                            'screen' => $ms['screen_xscreen'],
                        ],
                    ];
                }
            }

            // Set Child Menus
            if (isset($m['children']) && count($m['children']) > 0) {
                $submenu = $this->setChildMenus($submenu, $m, $marginCounter + 2);
            }

            $menu[] = [
                'text' => $m['title'],
                'icon' => $m['icon'] ?? '',
                'classes' => 'd-flex align-items-center ml-' . $marginCounter,
                'submenu' => [
                    ...$submenu
                ], // Initialize submenu
            ];
        }

        return $menu;
    }

    public function skipableScreens()
    {
        return [
            'MD04',
        ];
    }

    public function getMenuGroup($profileId = null)
    {

        // dd($profileId);

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
                
                Log::debug("---- Profiledt Check: " . ($profiledt ? 'Found' : 'Not Found'));

                // Continue if user is not system admin or business admin and menu screen is not in profile details
                if (!getLoggedInUserDetails()['is_system_admin'] && !getLoggedInUserDetails()['is_business_admin'] && !$profiledt) {
                    continue;
                }

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
                
                Log::debug("---- Profiledt Check: " . ($profiledt ? 'Found' : 'Not Found'));

                // Continue if user is not system admin or business admin and menu screen is not in profile details
                if (!getLoggedInUserDetails()['is_system_admin'] && !getLoggedInUserDetails()['is_business_admin'] && !$profiledt) {
                    continue;
                }

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
