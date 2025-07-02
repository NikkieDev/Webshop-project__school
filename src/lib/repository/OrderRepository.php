<?php

declare(strict_types=1);

require_once "BaseRepository.php";
require_once "CartRepository.php";
require_once __DIR__ . '/../model/CreateOrderProps.php';

final class OrderRepository extends BaseRepository
{
    private CartRepository $cartRepository;

    public function __construct()
    {
        $this->cartRepository = new CartRepository();
    }

    public function createOrder(string $cartUuid, CreateOrderProps $props)
    {
        $orderUuid = $this->generateUUID();

        $stmt = $this->getConnection()->prepare("INSERT INTO `Order` (uuid, CartUuid, UserUuid, `address`, `zipcode`, `location`, price, vat) VALUES (:identifier, :cartUuid, :userUuid, :address, :zipcode, :location, :price, :vat)");
        $stmt->execute([
            ':identifier' => $orderUuid,
            ':cartUuid' => $cartUuid,
            ':userUuid' => $props->getUserUuid(),
            ':address' => $props->getStreetWithNumber(),
            ':zipcode' => $props->getZipCode(),
            ':location' => $props->getLocation(),
            ':price' => $props->getPrice(),
            ':vat' => $props->getVat(),
        ]);

        return $orderUuid;
    }

    public function doesOrderExist($orderUuid): bool
    {
        $stmt = $this->getConnection()->prepare("SELECT 1 FROM `Order` WHERE uuid = :orderUuid");
        $stmt->execute([':orderUuid' => $orderUuid]);

        $result = $stmt->fetch();
        return (bool) $result;
    }


    public function getUserMostRecentOrders(string $userUuid): array
    {
        $stmt = $this->getConnection()->prepare("
            SELECT `o.status`, `o.price`, `o.vat`, `o.createdAt` FROM `Order`
            WHERE o.UserUuid = :userId
        "); // get item count too

        $stmt->execute([':userId' => $userUuid]);
        $results = $stmt->fetchAll();

        if (!$results) {
            return [];
        }

        return $results;
    }
}