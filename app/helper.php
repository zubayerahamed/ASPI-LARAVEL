<?php

use App\Services\ZayaanSessionManager;

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

            if($loggedInUser['selected_business']) {
                return $loggedInUser['selected_business'];
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

