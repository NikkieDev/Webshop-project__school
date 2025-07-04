<?php

declare(strict_types=1);

require_once __DIR__ . "/lib/ProductService.php";

if (!isset($_GET['pid'])) {
    header("Location: /error/404.php?return=/index.php");
    exit;
}

$product = ProductService::getInstance()->getProductById($_GET["pid"]);

if (!$product) {
    header("Location: /error/404.php?return=/index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/lib.css">
    <title><?= $product['title'] ?></title>
</head>
<body>
    <?php include_once 'partials/header.php' ?>
    <section class="product-wrapper">
        <div class="product-data">
            <h3><?= $product['title'] ?></h3>
            <span><?= $product['category'] ?></span>

            <p><?= $product['description'] ?></p>
            <p>&euro; <?= $product['price'] ?></p>
        </div>
    </section>
</body>
</html>