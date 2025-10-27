<?php

declare(strict_types=1);

require_once "BaseRepository.php";
require_once __DIR__ . '/../model/CreateOrderProps.php';

final class OrderRepository extends BaseRepository
{

    public function __construct()
    {
    }

    public function createOrder(string $cartUuid, CreateOrderProps $props)
    {
        $orderUuid = $this->generateUUID();

        $stmt = $this->getConnection()->prepare("INSERT INTO `Order` (uuid, CartUuid, UserUuid, `address`, `zipcode`, `location`, price) VALUES (:identifier, :cartUuid, :userUuid, :address, :zipcode, :location, :price)");
        $stmt->execute([
            ':identifier' => $orderUuid,
            ':cartUuid' => $cartUuid,
            ':userUuid' => $props->getUserUuid(),
            ':address' => $props->getStreetWithNumber(),
            ':zipcode' => $props->getZipCode(),
            ':location' => $props->getLocation(),
            ':price' => $props->getPrice(),
        ]);

        return $orderUuid;
    }

    public function findById(string $uuid): array
    {
        $stmt = $this->getConnection()->prepare("
            SELECT * FROM `Order` WHERE uuid = :uuid LIMIT 1
        ");

        $stmt->execute([':uuid' => $uuid]);
        $order = $stmt->fetch();

        if (!isset($order)) {
            return [];
        }

        return $order;
    }
    
    public function doesOrderExist($orderUuid): bool
    {
        $stmt = $this->getConnection()->prepare("SELECT 1 FROM `Order` WHERE uuid = :orderUuid");
        $stmt->execute([':orderUuid' => $orderUuid]);

        $result = $stmt->fetch();
        return (bool) $result;
    }

    public function getMostRecentOrdersFull(): array
    {
        $stmt = $this->getConnection()->prepare("
            SELECT * FROM `Order` ORDER BY createdAt DESC LIMIT 1
        ");

        $stmt->execute();
        $results = $stmt->fetchAll();

        if (!$results) {
            return [];
        }

        return $results;
    }

    public function getUserMostRecentOrders(string $userUuid): array
    {
        $stmt = $this->getConnection()->prepare("
            SELECT o.uuid AS OrderId, o.status AS OrderStatus, o.price AS OrderTotal, o.createdAt AS OrderDate, COUNT(ci.uuid) AS itemCount
            FROM `Order` AS o
            INNER JOIN CartItem AS ci ON ci.CartUuid = o.CartUuid
            WHERE o.UserUuid = :userId
            GROUP BY o.uuid
        ");

        $stmt->execute([':userId' => $userUuid]);
        $results = $stmt->fetchAll();

        if (!$results) {
            return [];
        }

        return $results;
    }

    public function cancelOrder(string $orderUuid): void
    {
        $stmt = $this->getConnection()->prepare('
            UPDATE `Order` SET `status` = -1 WHERE uuid = :uuid
        ');

        $stmt->execute([':uuid' => $orderUuid]);
    }

}