<?php

declare(strict_types=1);

require_once 'repository/ProductRepository.php';

class ProductService
{
    private static ?ProductService $instance = null;
    private ProductRepository $productRepository;
    
    public static function getInstance()
    {
        return self::$instance ??= new ProductService();
    }

    private function __construct()
    {
        $this->productRepository = new ProductRepository();
    }

    public function getProductById(string $uuid)
    {
        return $this->productRepository->findById($uuid);
    }
}