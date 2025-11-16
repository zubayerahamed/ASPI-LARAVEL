<?php

namespace App\Services;

class ZayaanSessionManager
{
    /**
     * Add data to session
     */
    public static function add($key, $value)
    {
        session([$key => $value]);
        return true;
    }

    /**
     * Get data from session
     */
    public static function get($key = null, $default = null)
    {
        return session($key, $default);
    }

    /**
     * Update session data (supports nested arrays using dot notation)
     */
    public static function update($key, $value)
    {
        if (str_contains($key, '.')) {
            $data = session()->all();
            data_set($data, $key, $value);
            session($data);
        } else {
            session([$key => $value]);
        }
        return true;
    }

    /**
     * Remove data from session
     */
    public static function remove($key)
    {
        session()->forget($key);
        return true;
    }

    /**
     * Check if session key exists
     */
    public static function has($key)
    {
        return session()->has($key);
    }

    /**
     * Flash data for next request
     */
    public static function flash($key, $value)
    {
        session()->flash($key, $value);
        return true;
    }

    
    /**
     * Store array data (merge with existing)
     */
    public static function addToArray($key, $value)
    {
        $current = session($key, []);
        if (is_array($current)) {
            $current[] = $value;
            session([$key => $current]);
        }
        return true;
    }

    /**
     * Remove from array session data
     */
    public static function removeFromArray($key, $value)
    {
        $current = session($key, []);
        if (is_array($current)) {
            $current = array_filter($current, function($item) use ($value) {
                return $item !== $value;
            });
            session([$key => array_values($current)]);
        }
        return true;
    }

    /**
     * Get and clear session data
     */
    public static function pull($key, $default = null)
    {
        return session()->pull($key, $default);
    }

    /**
     * Clear all session data
     */
    public static function clearAll()
    {
        session()->flush();
        return true;
    }

    /**
     * Get all session data
     */
    public static function getAll()
    {
        return session()->all();
    }

    /**
     * Increment session value
     */
    public static function increment($key, $amount = 1)
    {
        return session()->increment($key, $amount);
    }

    /**
     * Decrement session value
     */
    public static function decrement($key, $amount = 1)
    {
        return session()->decrement($key, $amount);
    }

    /**
     * Push value to session array
     */
    public static function push($key, $value)
    {
        session()->push($key, $value);
        return true;
    }
}
