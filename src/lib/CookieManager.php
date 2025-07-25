<?php

declare(strict_types=1);

class CookieManager
{
    public function __construct()
    {
    }

    public function get(string $key)
    {
        return $_COOKIE[$key] ?? null;
    }

    public function set(string $key, $value)
    {
        $time = 86400 * 365; // 1 year;

        $_COOKIE[$key] = $value;
        setcookie($key, $value, time() + $time, "/");
    }
}