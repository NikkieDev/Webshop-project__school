<?php

declare(strict_types=1);

require_once 'repository/ProductRepository.php';

$productRepository = new ProductRepository();
$products = $productRepository->getProducts();
?>
