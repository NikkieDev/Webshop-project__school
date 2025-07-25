<?php

declare(strict_types=1);

require_once 'BaseRepository.php';

final class ProductRepository extends BaseRepository
{
    public function getProducts(): array
    {
        $stmt = $this->getConnection()->prepare("SELECT uuid, title, price FROM Product");
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function findById(string $uuid)
    {
        $stmt = $this->getConnection()->prepare("
            SELECT uuid, title, price, `description`, category FROM Product WHERE uuid = :uuid LIMIT 1
        ");

        $stmt->execute([':uuid' => $uuid]);
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        return $results;
    }

    public function getByCategory(string $category): array
    {
        $stmt = $this->getConnection()->prepare('
            SELECT uuid, title, price, `description` category FROM Product WHERE category = :category
        ');

        $stmt->execute([':category'=> $category]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
}