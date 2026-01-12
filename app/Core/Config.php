<?php

namespace App\Core;

class Config
{
    private static array $config = [];

    /**
     * Load configuration from .env file
     */
    public static function load(string $envFile): void
    {
        if (!file_exists($envFile)) {
            return;
        }

        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue; // Skip comments
            }

            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            // Remove quotes if present
            $value = trim($value, '"\'');
            
            self::$config[$key] = $value;
        }
    }

    /**
     * Get configuration value
     */
    
    //  this get function is responsable for getting the value of the key from the config file
    // we mean by key every thing that is written after the dot in the config file for example if the key is APP_NAME then the value will be the value of the APP_NAME key in the config file
    // if we're going to talk about how  this function is exatly working and it's backend we can say that the function is getting the value of the key from the config file and returning it if the key is not found then the function is returning the default value which is null
    public static function get(string $key, $default = null)
    {
        return self::$config[$key] ?? $default;
    }

    /**
     * Set configuration value
     */
    public static function set(string $key, $value): void
    {
        self::$config[$key] = $value;
    }

    /**
     * Check if configuration key exists
     */
    public static function has(string $key): bool
    {
        return isset(self::$config[$key]);
    }
}
