<?php

/**
 * Helper function to get router instance from global scope
 */
function router(): \App\Core\Router
{
    return $GLOBALS['router'] ?? new \App\Core\Router();
}

/**
 * Helper function to escape output for XSS protection
 */
function e(string $string): string
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Helper function to get configuration value
 */
function config(string $key, $default = null)
{
    return \App\Core\Config::get($key, $default);
}

/**
 * Helper function to generate URL
 */
function url(string $path = ''): string
{
    $basePath = config('APP_URL', '') ?: '/';
    return rtrim($basePath, '/') . '/' . ltrim($path, '/');
}
