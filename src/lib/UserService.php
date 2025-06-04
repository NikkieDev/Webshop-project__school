<?php

declare(strict_types=1);

require_once "repository/UserRepository.php";

class UserService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
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
}