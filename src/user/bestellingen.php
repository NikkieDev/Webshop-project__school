<?php

declare(strict_types=1);
session_start();

require_once __DIR__ . "/../lib/FingerprintService.php";
require_once __DIR__ . "/../lib/OrderService.php";
require_once __DIR__ . "/../lib/SessionManager.php";

$fingerprint = FingerprintService::getInstance();
$orderService = new OrderService();
$session = new SessionManager();

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
        <?php if (0 === count($orders)) : ?>
            <div class="flash-wrapper">
                <div class="flash-card flash-warning">
                    <span class="flash-content">
                        U heeft geen bestellingen
                    </span>
                </div>
            </div>
        <?php else : ?>
            <?php foreach ($orders as $order) : ?>
                <div class="bestelling-wrapper">
                    <div class="bestelling">
                        <div class="bestel-info--wrapper">
                            <?php if (OrderStatus::CANCELLED === $order->getStatus()) : ?>
                                <p><strong>GEANNULEERD</strong></p>
                            <?php elseif (OrderStatus::COMPLETED === $order->getStatus()) : ?>
                                <p><strong>VERZONDEN</strong></p>
                            <?php endif ?>
                            <p>Bestelling #<?= $order->getOrderId(); ?></p>
                            <p>Totaal: &euro;<?= $order->getValue(); ?></p>
                            <p>Besteld op: <?= $order->getCreatedAt()->format('Y-m-d'); ?></p>
                        </div>
                        <div class="bestel-acties--wrapper">
                            <button onclick="reOrder('<?= $order->getOrderId(); ?>')">Opnieuw bestellen</button>
                            <button onclick="cancelOrder('<?= $order->getOrderId(); ?>')" <?= OrderStatus::PROCESSING !== $order->getStatus() ?'disabled':'' ?> >Annuleren</button>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        <?php endif ?>
    </section>
</body>
</html>
