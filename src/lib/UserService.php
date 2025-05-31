<?php

declare(strict_types=1);

require_once "db.php";

class UserService
{
    private Db $dbManager;

    public function __construct() {
        $this->dbManager = new Db();
    }

    public function transformGuestToUser($username, $password, $email, $user)
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            return $this->dbManager->transformGuestToUser($username, $hashed_password, $email, $user);
        } catch (Exception $e) {
            throw $e;
        }
    }
}