<?php

if (!function_exists('get_locale')) {
    function get_locale(): string
    {
        if (isset($_GET['lang'])) {
            $lang = $_GET['lang'];
            setcookie('lang', $lang, time() + (86400 * 365), "/"); // 1 година
            return $lang;
        }

        if (isset($_COOKIE['lang'])) {
            return $_COOKIE['lang'];
        }

        return 'bg';
    }
}


if (!function_exists('lang')) {
    function lang(string $key, ?string $locale = null): string
    {
        static $translations = [];

        $locale = $locale ?? get_locale();

        if (!isset($translations[$locale])) {
            $path = __DIR__ . "/../languages/{$locale}.json";

            if (file_exists($path)) {
                $json = file_get_contents($path);
                $translations[$locale] = json_decode($json, true) ?? [];
            } else {
                $translations[$locale] = [];
            }
        }

        return $translations[$locale][$key] ?? $key;
    }
}

if (!function_exists('__')) {
    function __(string $key): string
    {
        return lang($key);
    }
}
