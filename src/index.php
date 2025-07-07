<?php

declare(strict_types=1);

session_start();

require_once isset($_GET['cat']) ? 'lib/render/loadProductsByCategory.php' : 'lib/render/loadProducts.php';

require_once 'lib/render/loadCategories.php';
require_once 'lib/FingerprintService.php';
require_once 'lib/SessionManager.php';

$fingerprint = FingerprintService::getInstance();
$session = SessionManager::getInstance();
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/lib.css">
    <link rel="stylesheet" href="/css/home.css">
    <script src="/js/cookie.js" defer></script>
    <script src="/js/cart.js" defer></script>
</head>
<body>
    <?php include "partials/header.php" ?>
    <section class="home-wrapper">
        <div class="category-wrapper">
            <?php foreach ($categories as $category) { ?>
                <?php $cat = $category['title']; ?>
                <a href="index.php?cat=<?= $cat ?>" class="category"> <?= $cat ?></a>
            <?php } ?>
        </div>
        <div class="products">
            <?php foreach ($products as $product) { ?>
                <div class="product-wrapper">
                    <div class="product">
                        <?php $productUuid = $product['uuid']; ?>
                        <a href="/product.php?pid=<?= $productUuid ?>"><h3 class="product-name"><?= $product['title']; ?></h3></a>
                        <span class="product-price`">&euro; <?= $product['price']; ?></span>
                        <button onclick="addToCart('<?= $productUuid ?>')">Toevoegen</button>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
</body>
</html>