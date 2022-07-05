<?php

if (! function_exists('config')) {
    /**
     * Get configuration value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  string|int $key
     * @param  mixed  $default
     * @return mixed|\Illuminate\Config\Repository
     */
    function config(string $configName, $key = null, $default = null)
    {
        $configPath = __DIR__ . '/config/' . $configName . '.php';

        if (file_exists($configPath)) {
            $config = require_once($configPath);
            
            if ($key) {
                return $config[$key] ?? $default;
            }

            return $config ?? $default;
        }  

        return $default; 
    }
}