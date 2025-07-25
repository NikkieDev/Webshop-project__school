<?php

declare(strict_types=1);

require_once __DIR__ ."/../repository/ProductRepository.php";

$products = [];

if (!isset($_GET['cat'])) {
    return;
}

$productRepository = new ProductRepository();
$products = $productRepository->getByCategory($_GET['cat']);

?>