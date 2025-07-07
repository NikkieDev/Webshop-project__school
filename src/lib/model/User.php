<?php

declare(strict_types=1);

require_once "UserType.php";

class User
{
    protected string $uuid = "";
    protected string $username = "Guest";
    protected string $password = "";
    protected string $email = "";
    protected string $userType = UserType::GUEST;

    public function setType(string $userType)
    {
        $this->userType = $userType;
    }

    public function getType()
    {
        return $this->userType;
    }

    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}