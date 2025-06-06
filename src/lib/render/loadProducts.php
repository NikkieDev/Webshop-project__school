<?php

declare(strict_types=1);

require_once __DIR__ . '/../repository/ProductRepository.php';

$productRepository = new ProductRepository();
$products = $productRepository->getProducts();