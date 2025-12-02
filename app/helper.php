<?php

use App\Models\Xcodes;
use App\Services\ZayaanSessionManager;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;

if (!function_exists('getLoggedInUserDetails')) {
    function getLoggedInUserDetails()
    {
        if (ZayaanSessionManager::get('user_info')) {
            return ZayaanSessionManager::get('user_info');
        }

        return null;
    }
}

if (!function_exists('getSelectedBusiness')) {
    function getSelectedBusiness()
    {
        if (ZayaanSessionManager::get('user_info')) {
            $loggedInUser = ZayaanSessionManager::get('user_info');

            if ($loggedInUser['selected_business']) {
                return $loggedInUser['selected_business'];
            }
        }
        return null;
    }
}

if (!function_exists('getSelectedProfile')) {
    function getSelectedProfile()
    {
        if (ZayaanSessionManager::get('user_info')) {
            $loggedInUser = ZayaanSessionManager::get('user_info');

            if ($loggedInUser != null && array_key_exists('selected_profile', $loggedInUser) && $loggedInUser['selected_profile']) {
                return $loggedInUser['selected_profile'];
            }
        }
        return null;
    }
}

if (!function_exists('getBusinessId')) {
    function getBusinessId()
    {
        if (getSelectedBusiness()) {
            $selectedBusiness = getSelectedBusiness();
            return $selectedBusiness['id'];
        }
        return null;
    }
}


if (!function_exists('getProfileId')) {
    function getProfileId()
    {
        if (getSelectedProfile()) {
            $selectedProfile = getSelectedProfile();
            return $selectedProfile['id'];
        }
        return null;
    }
}


if (!function_exists('processQueueInBackground')) {
    function processQueueInBackground()
    {
        Artisan::call('queue:work', [
            '--stop-when-empty' => true,
            '--timeout' => 60,
            '--tries' => 3
        ]);
    }
}

if (!function_exists('allowCondition')) {
    function allowCondition($key)
    {
        return getSelectedBusiness()[$key] ?? false;
    }
}


if (!function_exists('productBehaviours')) {
    function productBehaviours($productType)
    {
        if($productType == null || $productType == ''){
            return Collection::empty();
        }

        $behaviours = [
            'STANDARD' => ['SIMPLE', 'VARIABLE', 'GROUPED', 'BUNDLE_PARENT', 'BUNDLE_ITEM', 'ADDON_PARENT', 'ADDON_ITEM', 'SET_MENU', 'CONFIGURABLE'],
            'MANUFACTURED' => ['SIMPLE', 'VARIABLE', 'GROUPED', 'BUNDLE_PARENT', 'BUNDLE_ITEM', 'ADDON_PARENT', 'ADDON_ITEM', 'CONFIGURABLE'],
            'RAW_MATERIAL' => ['SIMPLE', 'BUNDLE_ITEM', 'ADDON_ITEM'],
            'SERVICE' => ['SIMPLE', 'EXTERNAL', 'GROUPED', 'BUNDLE_PARENT', 'BUNDLE_ITEM', 'ADDON_PARENT', 'ADDON_ITEM', 'CONFIGURABLE', 'SUBSCRIPTION_RULES'],
            'DIGITAL' => ['SIMPLE', 'VARIABLE', 'EXTERNAL', 'GROUPED', 'BUNDLE_PARENT', 'BUNDLE_ITEM', 'ADDON_PARENT', 'ADDON_ITEM', 'CONFIGURABLE', 'SUBSCRIPTION_RULES'],
            'COMPOSITE' => ['SIMPLE', 'BUNDLE_PARENT', 'BUNDLE_ITEM', 'ADDON_PARENT', 'ADDON_ITEM', 'SET_MENU', 'CONFIGURABLE'],
            'SUBSCRIPTION' => ['SIMPLE', 'VARIABLE', 'BUNDLE_PARENT', 'BUNDLE_ITEM', 'ADDON_PARENT', 'ADDON_ITEM', 'CONFIGURABLE', 'SUBSCRIPTION_RULES'],
        ];

        $allowed =  $behaviours[$productType];

        // Check which on is exists in xcodes and active and return only those
        $xcodes = Xcodes::active()->where('type', 'Product Behaviour')->whereIn('xcode', $allowed)->orderBy('seqn', 'asc')->get();

        return $xcodes;
    }
}
