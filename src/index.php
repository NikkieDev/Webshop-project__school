<?php

declare(strict_types=1);

session_start();

require_once 'lib/loadProducts.php';
require_once 'lib/FingerprintService.php';

$fingerprint = FingerprintService::getInstance();
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
    <section class="header-wrapper">
        <?php if ($_SESSION['username']) { ?>
            <h3>Welcome, <?php echo $_SESSION['username'] ?></h3>
        <?php } ?>
        <nav>
            <div class="nav-item--wrapper">
                <a class="nav-item" href="#">Home</a>
                <a class="nav-item" href="winkelwagen.php?referrer=index.php">Winkelwagen</a>
            </div>
            <div class="fixed-right">
                <?php if ($fingerprint->isGuest()) { ?>
                    <a class="nav-item" href="account-aanmaken.php?referrer=index.php">Aanmelden</a>
                    <a class="nav-item" href="inloggen.php?referrer=index.php">Inloggen</a>
                <?php } else { ?>
                    <a class="nav-item" href="ajax/logout.php?referrer=index.php">Uitloggen</a>
                <?php } ?>
            </div>
        </nav>
    </section>
    <section class="products-wrapper">
        <div class="products">
            <?php foreach ($products as $product) { ?>
                <div class="product-wrapper">
                    <div class="product">
                        <?php $productUuid = $product['uuid']; ?>
                        <h3 class="product-name"><?php echo $product['title']; ?></h3>
                        <span class="product-price`">&euro; <?php echo $product['price']; ?></span>
                        <button onclick="addToCart('<?php echo $productUuid ?>')">Toevoegen</button>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
</body>
</html>