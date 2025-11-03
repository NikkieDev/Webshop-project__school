<?php

declare(strict_types= 1);

$activeTab = 'bestellingen';

require_once __DIR__ .'/../lib/repository/OrderRepository.php';
require_once __DIR__ .'/../lib/model/OrderStatus.php';

$orderRepository = new OrderRepository();
$orders = $orderRepository->getMostRecentOrdersFull();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestellingen | Beheer portaal</title>
    <link rel="stylesheet" href="/css/lib.css">
    <link rel="stylesheet" href="/css/admin.css">
    <script src="/js/order.js" defer></script>
</head>
<body>
    <div class="admin-wrapper">
        <?php include_once './elements/_sidebar-nav.php' ?>
        <main class="admin-content">
            <table>
                <tr>
                    <th>Bestelling</th>
                    <th>Klant</th>
                    <th>Besteld op</th>
                    <th>Artikelen</th>
                    <th>Bestelwaarde</th>
                    <th>Status</th>
                    <th>Acties</th>
                </tr>
                <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td><?= $order->getOrderId() ?></td>
                        <td><?= $order->getUserEmail() ?></td>
                        <td><?= $order->getCreatedAt()->format('Y-m-d H:i:s') ?></td>
                        <td><?= $order->getLineItemCount() ?></td>
                        <td>€<?= $order->getValue() ?></td>
                        <td><?= $order->getStatusText() ?></td>
                        <td class="actions">
                            <?php if (OrderStatus::PROCESSING === $order->getStatus()) : ?>
                                <button onclick="cancelOrder('<?= $order->getOrderId() ?>')" class="icon-btn" title="Annuleren"><img class="icon" src="/assets/close.png"></a>
                                <button onclick="finishOrder('<?= $order->getOrderId() ?>')" class="icon-btn" title="Versturen"><img class="icon" src="/assets/sent.png"></a>
                            <?php endif ?>
                            <a href="/admin/order.php?uuid=<?= $order->getOrderId() ?>" class="icon-btn" title="Bekijken"><img src="/assets/eye.png" class="icon"></a>
                        </td>
                    </tr>
                <?php endforeach?>
            </table>
        </main>
    </div>
</body>
</html>