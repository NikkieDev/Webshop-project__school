<?php

declare(strict_types=1);

require_once 'UserService.php';

class SessionManager
{
    private static ?SessionManager $instance = null;
    private UserService $userService;

    public static function getInstance(): SessionManager|null
    {
        if (null === UserService::getInstance()->getUser()) {
            return null;
        }

        return self::$instance ??= new SessionManager();
    }

    private function __construct()
    {
        $this->userService = UserService::getInstance();

        if (!isset($_SESSION[$this->userService->getUser()])) {
            $_SESSION[$this->userService->getUser()] = [];
        }
    }

    public function get($name)
    {
        return $_SESSION[$this->userService->getUser()][$name] ?? null;
    }

    public function getData(string $propName)
    {
        $data = $_SESSION[$this->userService->getUser()]['data'];

        if (!isset($data)) {
            return null;
        }

        return $data[$propName];
    }

    public function set(string $name, $value)
    {
        $_SESSION[$this->userService->getUser()][$name] = $value;
    }

    public function setData(array $data)
    {
        $_SESSION[$this->userService->getUser()]['data'] = $data;
    }

    public function unset(string $name)
    {
        unset($_SESSION[$this->userService->getUser()][$name]);
    }
}