<?php

declare(strict_types=1);

require_once __DIR__ . "/../lib/FingerprintService.php";
require_once __DIR__ . "/../lib/OrderService.php";

$fingerprint = FingerprintService::getInstance();
$orderService = OrderService::getInstance();

$orders = $orderService->getUserMostRecentOrders();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestellingen</title>
</head>
<body>
    <section class="header-wrapper">
        <?php if ($session->get('username')) { ?>
            <h3>Welcome, <?php echo $session->get('username') ?></h3>
        <?php } ?>
        <nav>
            <div class="nav-item--wrapper">
                <a class="nav-item" href="#">Home</a>
                <a class="nav-item" href="winkelwagen.php?referrer=index.php">Winkelwagen</a>
                <a class="nav-item" href="/user/bestellingen.php?referrer=index.php">Bestellingen</a>
                <a class="nav-item" href="/user/instellingen.php?referrer=index.php">Instellingen</a>
            </div>
        </nav>
    </section>
    <section class="bestellingen-wrapper">
        <?php foreach ($orders as $order) { ?>
            <div class="bestelling-wrapper">
                <div class="bestelling">
                    
                </div>
            </div>
        <?php } ?>
    </section>
</body>
</html>
