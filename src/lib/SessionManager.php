<?php

declare(strict_types=1);

require_once 'UserService.php';

class SessionManager
{
    private static ?SessionManager $instance = null;
    private UserService $userService;

    public static function getInstance(): SessionManager
    {
        return self::$instance ??= new SessionManager();
    }

    private function __construct()
    {
        $this->userService = new UserService();

        if (!isset($_SESSION[$this->userService->getUser()])) {
            $_SESSION[$this->userService->getUser()] = [];
        }
    }

    public function get($name)
    {
        try {
            return $_SESSION[$this->userService->getUser()][$name];
        } catch (Exception) {
            return null;
        }
    }

    public function set(string $name, $value)
    {
        $_SESSION[$this->userService->getUser()][$name] = $value;
    }

    public function unset(string $name)
    {
        unset($_SESSION[$this->userService->getUser()][$name]);
    }
}