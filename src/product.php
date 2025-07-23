<?php

declare(strict_types=1);

require_once __DIR__ . "/lib/ProductService.php";

if (!isset($_GET['pid'])) {
    header("Location: /error/404.php?return=/index.php");
    exit;
}

$pid = $_GET["pid"];

$product = ProductService::getInstance()->getProductById($pid);

if (!$product) {
    header("Location: /error/404.php?return=/index.php");
    exit;
}

$_GET['cat'] = $product['category'];
require_once "./lib/render/loadProductsByCategory.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/lib.css">
    <link rel="stylesheet" href="/css/product.css">

    <script src="/js/cart.js"></script>
    <title><?= $product['title'] ?></title>
</head>
<body>
    <?php include_once 'partials/header.php' ?>
    <section class="product-detail--wrapper">
        <div class="product-wrapper">
            <h3><?= $product['title'] ?></h3>
            <span><?= $product['category'] ?></span>

            <p><?= $product['description'] ?></p>
            <p>&euro; <?= $product['price'] ?></p>
            <button onclick="addToCart('<?= $pid ?>')">Toevoegen</button>
        </div>

        <div class="other-from-category--wrapper">
            <h3>Bekijk ook deze producten</h3>
            <div class="other-from-category">
                <?php foreach ($products as $productInCategory) { ?>
                    <?php if ($productInCategory['uuid'] == $pid) continue; ?>
                    <div class="product-wrapper">
                        <div class="product">
                            <?php $productUuid = $productInCategory['uuid']; ?>
                            <a href="/product.php?pid=<?= $productUuid ?>"><h3 class="product-name"><?= $productInCategory['title']; ?></h3></a>
                            <span class="product-price`">&euro; <?= $productInCategory['price']; ?></span>
                            <button onclick="addToCart('<?= $productUuid ?>')">Toevoegen</button>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
</body>
</html>

<!-- andere items in dezelfde category -->
<!-- laatst bekeken (cookies) -->