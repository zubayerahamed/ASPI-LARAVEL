<?php

namespace App\Http\Middleware;

use App\Services\ZayaanSessionManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
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

    protected function setSiteTitle(){
        $title = Config::get('adminlte.title');
        if(getSelectedBusiness() !== null){
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

        // dd(ZayaanSessionManager::get('user_info'));
        $loggedInUser = getLoggedInUserDetails();

        // dd($loggedInUser['is_business_admin'] ?? false);

        $menu = Config::get('adminlte.menu');

        // Add role-specific menus
        if ($loggedInUser['is_system_admin'] ?? false) {
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

            // dd(getSelectedBusiness());
            if (getSelectedBusiness() === null) {
                return $menu;  // No selected business, return default menu
            }

            $menu = Config::get('adminlte.menu');
            
            $menu[] = [
                'text' => 'Dashboard',
                'route' => 'DASH',
                'icon' => 'ph ph-speedometer',
                'classes' => 'screen-item d-flex align-items-center',
                'data' => [
                    'screen' => 'DASH',
                ],
            ];
            $menu[] = [
                'text' => 'Access Profiles',
                'route' => 'AD02',
                'icon' => 'ph ph-fingerprint',
                'classes' => 'screen-item d-flex align-items-center',
                'data' => [
                    'screen' => 'AD02',
                ],
            ];

            return $menu;
        }

        if ($loggedInUser['is_business_admin'] ?? false) {
            if (getSelectedBusiness() === null) {
                return $menu;  // No selected business, return default menu
            }

            $menu[] = [
                'text' => 'Access Profiles',
                'route' => 'AD02',
                'icon' => 'ph ph-fingerprint',
                'classes' => 'screen-item d-flex align-items-center',
                'data' => [
                    'screen' => 'AD02',
                ],
            ];

            return $menu;
        }

        return $menu;
    }
}
