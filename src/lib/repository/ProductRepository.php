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
}