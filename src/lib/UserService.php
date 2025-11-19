<?php

declare(strict_types=1);

require_once "repository/UserRepository.php";
require_once "CookieManager.php";
require_once "model/User.php";

class UserService
{
    // private static ?UserService $instance = null;

    private UserRepository $userRepository;
    private CookieManager $cookieManager;

    // public static function getInstance(): UserService
    // {
    //     return self::$instance ??= new UserService();
    // }

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->cookieManager = new CookieManager();
    }

    public function transformGuestToUser($username, $password, $email, $user)
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            return $this->userRepository->transformGuestToUser($username, $hashed_password, $email, $user);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getUser()
    {
        if (!isset($_COOKIE['user'])) {
            $this->setGuest();
        }

        return $_COOKIE['user'];
    }

    public function setGuest(?User &$user = null)
    {
        $newUserUuid = $this->userRepository->createGuest();

        if ($user !== null) {
            $user->setUuid($newUserUuid);
        }

        $this->cookieManager->set('user', $newUserUuid);
    }

    public function setUser(User &$user, $userData)
    {
        $user->setType($userData['type']);
        $user->setUsername($userData['username']);
        $user->setUuid($userData['uuid']);
        $user->setEmail($userData['email']);

        $this->cookieManager->set('user', $user->getUuid());
    }

    public function setPassword(string $password)
    {
        $passw = password_hash($password, PASSWORD_DEFAULT);
        $this->userRepository->updatePassword($this->getUser(), $passw);
    }

    public function setMail(string $mail)
    {
        $this->userRepository->updateMail($this->getUser(), $mail);
    }
}