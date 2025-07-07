<?php

declare(strict_types=1);

require_once "BaseRepository.php";

final class CategoryRepository extends BaseRepository
{
    public function getCategories()
    {
        $stmt = $this->getConnection()->prepare('
            SELECT title FROM Category
        ');

        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }
}