<?php

declare(strict_types=1);

require_once "BaseRepository.php";
require_once __DIR__ . '/../model/UserType.php';

final class UserRepository extends BaseRepository
{
    public function getCustomersWithOrderAmount(): array
    {
        $stmt = $this->getConnection()->prepare('
            SELECT u.uuid, u.username, u.email, u.createdAt FROM User u
            WHERE u.`type` = "user"
        ');
        $stmt->execute();
        $results = $stmt->fetchAll();
        if (!$results) {
            return [];
        }

        return $results;
    }

    public function getUser($uuid)
    {
        $stmt = $this->getConnection()->prepare("SELECT username, `type` FROM User WHERE uuid = :uuid");
        $stmt->execute([':uuid' => $uuid]);
        
        $results = $stmt->fetchAll();
        
        if (0 == count($results)) {
            return null;
        }

        return $results[0];
    }

    public function getUserDataByCredentials($email, $password): mixed
    {
        $stmt = $this->getConnection()->prepare("SELECT uuid, username, `password`, `type` FROM User WHERE email = :mail");
        $stmt->execute([':mail' => $email]);

        $result = $stmt->fetch();

        if (!$result) {
            throw new Exception("Gebruiker bestaat niet.");
        }

        if (password_verify($password, $result['password'])) {
            return $result;
        } else {
            throw new Exception("Uw wachtwoord klopt niet.");
        }
    }

    public function getUserCredentialsByUuid($uuid)
    {
        $stmt = $this->getConnection()->prepare("
            SELECT password FROM User WHERE uuid = :uuid LIMIT 1
        ");

        $stmt->execute([":uuid"=> $uuid]);
        $result = $stmt->fetch();

        if (!$result) {
            return null;
        }

        return $result['password'];
    }

    public function userWithEmailExists($email): bool | string
    {
        $stmt = $this->getConnection()->prepare("SELECT uuid FROM User WHERE email = :mail");
        $stmt->execute([':mail' => $email]);

        $result = $stmt->fetch();

        if (!$result) {
            return false;
        }

        return $result['uuid'];
    }

    public function createGuest()
    {
        $uuid = $this->generateUUID();
        $stmt = $this->getConnection()->prepare("INSERT INTO User (uuid) VALUES (:uuid)");
        $stmt->execute([':uuid' => $uuid]);

        return $uuid;
    }

    public function transformGuestToUser($username, $password, $email, $guestUuid)
    {
        if ($this->userWithEmailExists($email)) {
            throw new Exception("Gebruiker met dit e-mail adres bestaat al!");
        }

        $stmt = $this->getConnection()->prepare("
            UPDATE User SET username = :username, password = :hash, email = :mail, type = :userType
            WHERE uuid = :uuid
        ");

        $stmt->execute([
            ":username" => $username,
            ":hash" => $password,
            ":mail" => $email,
            ":userType" => UserType::USER,
            ":uuid" => $guestUuid
        ]);

        return $guestUuid;
    }

    public function deleteUser(string $uuid): void
    {
        $stmt = $this->getConnection()->prepare('DELETE FROM User WHERE uuid = :uuid');
        $stmt->execute([':uuid' => $uuid]);
    }

    public function updatePassword(string $uuid, string $passwordHash)
    {
        $stmt = $this->getConnection()->prepare('
            UPDATE User SET password = :hash WHERE uuid = :uuid
        ');

        $stmt->execute([':hash' => $passwordHash, ':uuid'=> $uuid]);
    }

    public function updateMail(string $uuid, string $mail)
    {
        $stmt = $this->getConnection()->prepare('
            UPDATE User SET email = :mail WHERE uuid = :uuid
        ');

        $stmt->execute([':mail' => $mail, ':uuid'=> $uuid]);
    }
}