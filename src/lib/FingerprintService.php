<?php

declare(strict_types=1);

require_once "model/User.php";
require_once 'repository/UserRepository.php';
require_once 'SessionManager.php';
require_once 'UserService.php';

class FingerprintService
{
    private User $user;
    private UserRepository $userRepository; 
    private SessionManager $session;
    private UserService $userService;
    
    private static ?FingerprintService $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new FingerprintService();
        }

        return self::$instance;
    }


    private function __construct()
    {
        $this->session = SessionManager::getInstance();
        $this->userRepository = new UserRepository();
        $this->userService = UserService::getInstance();
        $this->user = new User();
        
        if (empty($_COOKIE['user'])) {
            $this->userService->setGuest($this->user);
            header("Refresh:0");
        } else {
            $this->user->setUuid($_COOKIE['user']);
        }
        
        $user = $this->userRepository->getUser($this->user->getUuid());

        if ($user) {
            $this->user->setType($user['type']);
            $this->user->setUsername($user['username']);
    
            $this->session->set('username', $user['username']);
        } else {
            $this->logout();
        }
    }

    public function transformGuestIntoUserAccount($username, $password, $email, $user)
    {
        $this->userService->transformGuestToUser($username, $password, $email, $user);
        $this->logout();
        return;
    }

    public function getUser()
    {
        return $this->userService->getUser();
    }

    public function isGuest(): bool
    {
        return $this->user->getType() == UserType::GUEST;
    }

    public function isAdmin(): bool
    {
        return $this->user->getType() == UserType::ADMIN;
    }

    public function login($email, $password)
    {
        $currentGuest = $this->getUser();
        $user = $this->userRepository->userWithEmailExists($email);

        if ($user) {
            $userData = $this->userRepository->getUserDataByCredentials($email, $password);
            $userData['email'] = $email;

            $this->userRepository->deleteUser($currentGuest);
            $this->session->unset($currentGuest);
            $this->clearUserCookie();
            $this->userService->setUser($this->user, $userData);
            $this->session->setData($userData);
        } else {
            throw new Exception("Gebruiker bestaat niet!");
        }
    }
    
    public function logout(): void
    {
        $this->clearUserCookie();
        $this->userService->setGuest($this->user);
    }

    public function verifyPassword(string $password)
    {
        $userSavedPass = $this->userRepository->getUserCredentialsByUuid($this->getUser());

        if (!$userSavedPass) {
            return false;
        }

        return password_verify($password, $userSavedPass);
    }

    private function clearUserCookie()
    {
        setcookie('user', '', -1, '/');
        unset($_COOKIE['user']);
    }
}