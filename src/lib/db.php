<?php

declare(strict_types=1);

require_once "model/UserType.php";

class Db
{
    private string $server = "127.0.0.1";
    private string $dbName = "shop";
    private string $user = "root";
    private string $pass = "password";

    private PDO|null $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=" . $this->server . ";dbname=" . $this->dbName, $this->user, $this->pass);
        } catch (PDOException $e) {
            echo "Couldn't log into database" . $e;
        }
    }

    public function getProducts(): array
    {
        $stmt = $this->conn->prepare("SELECT uuid, title, price FROM Product");
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function getUser($uuid): mixed
    {
        $stmt = $this->conn->prepare("SELECT username, `type` FROM User WHERE uuid = :uuid");
        $stmt->execute([':uuid' => $uuid]);
        
        $results = $stmt->fetchAll();
        
        if (0 == count($results)) {
            return null;
        }

        return $results[0];
    }

    public function getUserDataByCredentials($email, $password): mixed
    {
        $stmt = $this->conn->prepare("SELECT uuid, username, `password`, `type` FROM User WHERE email = :mail");
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

    public function userWithEmailExists($email): bool | string
    {
        $stmt = $this->conn->prepare("SELECT uuid FROM User WHERE email = :mail");
        $stmt->execute([':mail' => $email]);

        $result = $stmt->fetch();

        if (!$result) {
            return false;
        }

        return $result['uuid'];
    }

    public function generateCart($userUuid): string
    {
        $uuid = $this->generateUUID();

        $stmt = $this->conn->prepare("INSERT INTO Cart (uuid, userUuid) VALUES (:uuid, :userUuid)");
        $stmt->execute([':uuid' => $uuid, ':userUuid' => $userUuid]);

        return $uuid;
    }

    public function addToCart($cartUuid, $productUuid)
    {
        $cartStatus = $this->getCartStatus($cartUuid);

        if (0 !== $cartStatus) {
            throw new Exception("Cart is already processed");
        }

        $uuid = $this->generateUUID();
        $stmt = $this->conn->prepare("INSERT INTO CartItem (uuid, CartUuid, ProductUuid) VALUES (:uuid, :cart, :product)");
        $stmt->execute([':uuid' => $uuid, ':cart' => $cartUuid, ':product' => $productUuid]);
    }

    public function removeFromCart($cartUuid, $productUuid)
    {
        $cartStatus = $this->getCartStatus($cartUuid);

        if (0 !== $cartStatus) {
            throw new Exception("Cart is alreacy processed");
        }

        $stmt = $this->conn->prepare("DELETE FROM CartItem WHERE ProductUuid = :puuid AND CartUuid = :cuuid ORDER BY createdAt ASC LIMIT 1");
        $stmt->execute([':puuid' => $productUuid, ':cuuid' => $cartUuid]);
    }

    public function getCartStatus($cartUuid): int
    {
        $stmt = $this->conn->prepare("SELECT `status` FROM Cart WHERE uuid = :uuid");
        $stmt->execute([':uuid' => $cartUuid]);

        $result = $stmt->fetch();

        if (!$result) {
            return -1;
        }

        return (int) $result['status'];
    }

    public function getCartSize($cartUuid)
    {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) AS size FROM CartItem
            WHERE CartUuid = :uuid
        ");

        $stmt->execute([":uuid" => $cartUuid]);

        $result = $stmt->fetch();

        if (!$result) {
            throw new Exception("Cart doesn't exist");
        }

        return (int) $result['size'];
    }

    public function getUserActiveCartWithItems($userUuid): array|null
    {
        $stmt = $this->conn->prepare("
            SELECT p.uuid AS ProductId, p.title AS ProductTitle, p.price AS ProductPrice FROM Product as p
                INNER JOIN CartItem as ci ON ci.ProductUuid = p.uuid
                INNER JOIN Cart as c ON c.uuid = ci.CartUuid
            WHERE c.userUuid = :userUuid AND c.status = 0;
        ");

        $stmt->execute([':userUuid' => $userUuid]);
        $result = $stmt->fetchAll();

        if (!$result) {
            return null;
        }

        return $result;
    }

    public function getUserActiveCart($userUuid)
    {
        $stmt = $this->conn->prepare("
            SELECT c.uuid AS uuid FROM Cart as c
                INNER JOIN User as u ON u.uuid = :userUuid
            WHERE c.status = 0
        ");

        $stmt->execute([':userUuid' => $userUuid]);
        $result = $stmt->fetch();

        if (!$result) {
            return null;
        }

        return $result['uuid'];
    }

    public function createGuest()
    {
        $uuid = $this->generateUUID();
        $stmt = $this->conn->prepare("INSERT INTO User (uuid) VALUES (:uuid)");
        $stmt->execute([':uuid' => $uuid]);

        return $uuid;
    }

    public function transformGuestToUser($username, $password, $email, $guestUuid)
    {
        if ($this->userWithEmailExists($email)) {
            throw new Exception("Gebruiker met dit e-mail adres bestaat al!");
        }

        $stmt = $this->conn->prepare("
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

    public function close()
    {
        $this->conn = null;
    }

    public function generateUUID(): string
    {
        return $this->conn->query("SELECT UUID()")->fetchColumn();
    }
}