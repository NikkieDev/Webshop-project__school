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

        $stmt = $this->getConnection()->prepare("INSERT INTO `Order` (uuid, CartUuid, UserUuid, `address`, `zipcode`, `location`) VALUES (:identifier, :cartUuid, :userUuid, :address, :zipcode, :location)");
        $stmt->execute([
            ':identifier' => $orderUuid,
            ':cartUuid' => $cartUuid,
            ':userUuid' => $props->getUserUuid(),
            ':address' => $props->getStreetWithNumber(),
            ':zipcode' => $props->getZipCode(),
            ':location' => $props->getLocation(),
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
}