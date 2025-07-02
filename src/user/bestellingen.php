<?php

declare(strict_types=1);
session_start();

require_once __DIR__ . "/../lib/FingerprintService.php";
require_once __DIR__ . "/../lib/OrderService.php";
require_once __DIR__ . "/../lib/SessionManager.php";

$fingerprint = FingerprintService::getInstance();
$orderService = OrderService::getInstance();
$session = SessionManager::getInstance();

$orders = $orderService->getUserMostRecentOrders();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/lib.css">
    <link rel="stylesheet" href="/css/user/bestellingen.css">
    <script defer src="/js/order.js"></script>
    <title>Bestellingen</title>
</head>
<body>
    <?php include __DIR__ ."/../partials/header.php" ?>
    <section class="bestellingen-wrapper">
        <?php foreach ($orders as $order) { ?>
            <?php $orderId = $order['OrderId']; ?>
            <div class="bestelling-wrapper">
                <div class="bestelling">
                    <div class="bestel-info--wrapper">
                        <?php if (-1 === $order['OrderStatus']) { ?>
                            <p><strong>GEANNULEERD</strong></p>
                        <?php } ?>
                        <p>Bestelling #<?= $orderId ?></p>
                        <p>Totaal: &euro;<?= $order['OrderTotal']; ?></p>
                        <p>Besteld op: <?= $order['OrderDate']; ?></p>
                    </div>
                    <div class="bestel-acties--wrapper">
                        <button onclick="reOrder('<?= $orderId ?>')">Opnieuw bestellen</button>
                        <button onclick="cancelOrder('<?= $orderId ?>')"
                            <?php if (-1 === $order['OrderStatus']) { ?>
                                disabled
                                title="Deze bestelling is al geannuleerd"
                            <?php } else { ?>
                                title="Bestelling annuleren"
                            <?php } ?>
                            >Annuleren</button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </section>
</body>
</html>
