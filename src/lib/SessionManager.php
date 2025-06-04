<?php

declare(strict_types=1);


class SessionManager
{
    private static ?SessionManager $instance = null;

    public static function getInstance(): SessionManager
    {
        return self::$instance ??= new SessionManager();
    }

    private function __construct()
    {
        if (!isset($_SESSION[$this->getUser()])) {
            $_SESSION[$this->getUser()] = [];
        }
    }

    public function getUser()
    {
        return $_COOKIE['user'];
    }

    public function get($name)
    {
        try {
            return $_SESSION[$this->getUser()][$name];
        } catch (Exception) {
            return null;
        }
    }

    public function set(string $name, $value)
    {
        $_SESSION[$this->getUser()][$name] = $value;
    }

    public function unset(string $name)
    {
        unset($_SESSION[$this->getUser()][$name]);
    }
    
    public function dump()
    {
        var_dump($_SESSION);
    }
}