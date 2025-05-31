<?php
declare(strict_types=1);

session_start();

require_once 'lib/FingerprintService.php';
require_once "lib/CartManager.php";

$fingerprint = FingerprintService::getInstance();
$cartManager = CartManager::getInstance();
$referrer = $_GET['referrer'];

?>

<html>
<head>
    <title><?php echo $cartManager->getSize() ?> producten in winkelwagen</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/lib.css">
    <link rel="stylesheet" href="/css/winkelwagen.css">
    <script src="/js/cart.js" defer></script>
</head>
<body>
    <a href="<?php echo $referrer ?>">Terug</a>
    
    <section>
        <?php if ($cartManager->getSize() === 0) { ?>
            <div class="flash-card flash-warning"><span class="flash-content">Uw winkelwagen is leeg!</span></div>
        <?php } else { ?>
            <div class="cart-content--wrapper">
                <h3>Deze <?php echo $cartManager->getSize() ?> producten zitten in uw winkelwagen</h3>

                <div class="cart-items--wrapper">
                    <?php foreach ($cartManager->getItems($fingerprint->getUser()) as $product) {?>
                        <?php $productUuid = $product['ProductId']; ?>

                        <div class="cart-item--wrapper">
                            <div class="cart-item">
                                <div class="cart-item__meta--wrapper">
                                    <h4><?php echo $product['ProductTitle']; ?></h4>
                                    <p>&euro; <?php echo $product['ProductPrice']; ?></p>
                                </div>
                                <div class="cart-item__dynamic--wrapper">
                                    <div class="cart-item__amount--wrapper">
                                        <p>Aantal: <span product-uuid="<?php echo $productUuid ?>" class="cart-item__amount"><?php echo $product['quantity'] ?></span></p>
                                    </div>
                                    <div class="cart-item__interaction--wrapper">
                                        <button onclick="decreaseCartItemCount('<?php echo $productUuid ?>', this)">-</button>
                                        <button onclick="increaseCartItemCount('<?php echo $productUuid ?>')">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </section>
</body>
</html>