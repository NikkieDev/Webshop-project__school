<?php

declare(strict_types=1);

require_once "model/User.php";
require_once 'repository/UserRepository.php';
require_once 'SessionManager.php';

class FingerprintService
{
    private User $user;
    private UserRepository $userRepository; 
    private SessionManager $session;
    
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
        $this->user = new User();
        
        if (empty($_COOKIE['user'])) {
            $this->setGuest();
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

    public function getUser()
    {
        return $this->session->getUser();
    }

    public function isGuest(): bool
    {
        return $this->user->getType() == UserType::GUEST;
    }

    public function login($email, $password)
    {
        $user = $this->userRepository->userWithEmailExists($email);

        if ($user) {
            $userData = $this->userRepository->getUserDataByCredentials($email, $password);

            $this->session->unset($this->getUser());
            $this->clearUser();
            $this->setUser($userData);
        } else {
            throw new Exception("Gebruiker bestaat niet!");
        }
    }
    
    public function logout(): void
    {
        $this->clearUser();
        $this->setGuest();
    }

    private function setUser($userData)
    {
        $this->user->setType($userData['type']);
        $this->user->setUsername($userData['username']);
        $this->user->setUuid($userData['uuid']);

        setcookie('user', $this->user->getUuid(), time() + (86400 * 90), '/');
        $_COOKIE['user'] = $this->user->getUuid();
    }

    private function setGuest(): void
    {
        $this->user->setUuid($this->userRepository->createGuest());
            
        setcookie('user', $this->user->getUuid(), time() + (86400 * 90), '/');
        $_COOKIE['user'] = $this->user->getUuid();        
    }

    private function clearUser()
    {
        setcookie('user', '', -1, '/');
        unset($_COOKIE['user']);
    }
}