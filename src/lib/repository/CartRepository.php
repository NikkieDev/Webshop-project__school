<?php

declare(strict_types=1);

require_once 'BaseRepository.php';

final class CartRepository extends BaseRepository
{
    public function getUserActiveCartWithItems($userUuid): array|null
    {
        $stmt = $this->getConnection()->prepare("
            SELECT p.uuid AS productId, p.title AS productTitle, p.price AS productPrice FROM Product as p
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
        $stmt = $this->getConnection()->prepare("
            SELECT c.uuid AS uuid FROM Cart as c
                INNER JOIN User as u ON u.uuid = c.userUuid
            WHERE c.status = 0 AND c.userUuid = :userUuid
        ");

        $stmt->execute([':userUuid' => $userUuid]);
        $result = $stmt->fetch();

        if (!$result) {
            return null;
        }

        return $result['uuid'];
    }

    public function getCartStatus($cartUuid): int
    {
        $stmt = $this->getConnection()->prepare("SELECT `status` FROM Cart WHERE uuid = :uuid");
        $stmt->execute([':uuid' => $cartUuid]);

        $result = $stmt->fetch();

        if (!$result) {
            return -1;
        }

        return (int) $result['status'];
    }

    public function getCartSize($cartUuid)
    {
        $stmt = $this->getConnection()->prepare("
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

    public function addToCart($cartUuid, $productUuid)
    {
        $cartStatus = $this->getCartStatus($cartUuid);

        if (0 !== $cartStatus) {
            throw new Exception("Cart is already processed");
        }

        $uuid = $this->generateUUID();
        $stmt = $this->getConnection()->prepare("INSERT INTO CartItem (uuid, CartUuid, ProductUuid) VALUES (:uuid, :cart, :product)");
        $stmt->execute([':uuid' => $uuid, ':cart' => $cartUuid, ':product' => $productUuid]);
    }

    public function removeFromCart($cartUuid, $productUuid)
    {
        $cartStatus = $this->getCartStatus($cartUuid);

        if (0 !== $cartStatus) {
            throw new Exception("Cart is alreacy processed");
        }

        $stmt = $this->getConnection()->prepare("DELETE FROM CartItem WHERE ProductUuid = :puuid AND CartUuid = :cuuid ORDER BY createdAt ASC LIMIT 1");
        $stmt->execute([':puuid' => $productUuid, ':cuuid' => $cartUuid]);
    }

    public function generateCart($userUuid): string
    {
        $uuid = $this->generateUUID();

        $stmt = $this->getConnection()->prepare("INSERT INTO Cart (uuid, userUuid) VALUES (:uuid, :userUuid)");
        $stmt->execute([':uuid' => $uuid, ':userUuid' => $userUuid]);

        return $uuid;
    }

    public function closeCart($cartUuid)
    {
        $stmt = $this->getConnection()->prepare("UPDATE Cart SET `status` = 1 WHERE uuid = :cartUuid");
        $stmt->execute([':cartUuid' => $cartUuid]);
    }
}