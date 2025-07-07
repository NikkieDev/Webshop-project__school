<?php

declare(strict_types=1);

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