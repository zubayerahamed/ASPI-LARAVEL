<?php

namespace App\Http\Middleware;

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
        if($request->ajax()){
            return $next($request);
        }

        Config::set('adminlte.menu', $this->buildMenu());
        return $next($request);
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
        $user = Auth::user();
        $menu = Config::get('adminlte.menu');

        // Add role-specific menus
        if ($user->is_system_admin) {
            $menu[] = ['header' => 'System Administrator'];
            $menu[] = [
                'text' => 'Business Category',
                'route' => 'SA05',
                'icon' => 'ph ph-copy-simple',
                'classes' => 'screen-item d-flex align-items-center',
                'data' => [
                    'screen' => 'SA05',
                ],
            ];
            $menu[] = [
                'text' => 'Business',
                'route' => 'SA10',
                'icon' => 'ph ph-briefcase',
                'classes' => 'screen-item d-flex align-items-center',
                'data' => [
                    'screen' => 'SA10',
                ],
            ];
            $menu[] = [
                'text' => 'Business Admins',
                'route' => 'SA15',
                'icon' => 'ph ph-user-circle',
                'classes' => 'screen-item d-flex align-items-center',
                'data' => [
                    'screen' => 'SA15',
                ],
            ];

            return $menu;
        }

        if ($user->is_business_admin) {
            return $menu;
        }

        return $menu;
    }
}
