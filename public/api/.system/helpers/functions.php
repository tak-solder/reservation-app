<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('app_url')) {
    /**
     * @param string|null $path
     * @return string
     */
    function app_url(?string $path = null): string
    {
        $url = config('app.url');
        if ($path) {
            return $url . '/' . ltrim($path, '/');
        } else {
            return $url;
        }
    }
}

if (!function_exists('api_url')) {
    /**
     * @param string|null $path
     * @return string
     */
    function api_url(?string $path = null): string
    {
        $url = config('app.api_url');
        if ($path) {
            return $url . '/' . ltrim($path, '/');
        } else {
            return $url;
        }
    }
}

if (!function_exists('transaction')) {
    /**
     * @template T
     * @param Closure $callback
     * @param $attempts
     * @return T
     */
    function transaction(\Closure $callback, $attempts = 1)
    {
        if (in_array(config('app.infrastructure'), ['mock', 'session'], true)) {
            return $callback();
        } else {
            return DB::transaction($callback, $attempts);
        }
    }
}
