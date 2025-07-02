<?php
declare(strict_types=1);

session_start();

require_once 'lib/FingerprintService.php';
require_once "lib/CartManager.php";
require_once "lib/SessionManager.php";

$fingerprint = FingerprintService::getInstance();
$cartManager = CartManager::getInstance();
$session = SessionManager::getInstance();
$referrer = $_GET['referrer'];

?>

<html>
<head>
    <title><?= $cartManager->getSize() ?> producten in winkelwagen</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/lib.css">
    <link rel="stylesheet" href="/css/winkelwagen.css">
    <script src="/js/cart.js" defer></script>
</head>
<body>
    <section class="header-wrapper">
        <?php if ($session->get('username')) { ?>
            <h3>Welcome, <?= $session->get('username') ?></h3>
        <?php } ?>
        <nav>
            <div class="nav-item--wrapper">
                <a class="nav-item" href="/">Home</a>
                <a class="nav-item" href="/winkelwagen.php?referrer=index.php">Winkelwagen</a>
                <?php if (!$fingerprint->isGuest()) { ?>
                    <a class="nav-item" href="user/bestellingen.php?referrer=index.php">Bestellingen</a>
                    <a class="nav-item" href="user/instellingen.php?referrer=index.php">Instellingen</a>
                <?php } ?>
            </div>
        </nav>
    </section>
    <section class="winkelwagen-wrapper">
        <?php if ($cartManager->getSize() === 0) { ?>
            <div class="flash-card flash-warning"><span class="flash-content">Uw winkelwagen is leeg!</span></div>
        <?php } else { ?>
            <div class="cart-content--wrapper">
                <h3>Deze <?= $cartManager->getSize() ?> producten zitten in uw winkelwagen</h3>

                <div class="cart-items--wrapper">
                    <?php foreach ($cartManager->getItems() as $product) {?>
                        <?php $productUuid = $product['ProductId']; ?>

                        <div class="cart-item--wrapper">
                            <div class="cart-item">
                                <div class="cart-item__meta--wrapper">
                                    <h4><?= $product['ProductTitle']; ?></h4>
                                    <p>&euro; <?= $product['ProductPrice']; ?></p>
                                </div>
                                <div class="cart-item__dynamic--wrapper">
                                    <div class="cart-item__amount--wrapper">
                                        <p>Aantal: <span product-uuid="<?= $productUuid ?>" class="cart-item__amount"><?= $product['quantity'] ?></span></p>
                                    </div>
                                    <div class="cart-item__interaction--wrapper">
                                        <button onclick="decreaseCartItemCount('<?= $productUuid ?>', this)">-</button>
                                        <button onclick="increaseCartItemCount('<?= $productUuid ?>')">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <a href="afrekenen.php">Afrekenen</a>
                </div>
            </div>
        <?php } ?>
    </section>
</body>
</html>