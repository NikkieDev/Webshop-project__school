<?php

declare(strict_types= 1);

$activeTab = 'bestellingen';

require_once __DIR__ .'/../lib/repository/OrderRepository.php';

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
                    <th>Aantal besteld</th>
                    <th>Bestelwaarde</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                <?php foreach ($orders as $order) { ?>
                    <tr>
                        <td><?= $order['uuid'] ?></td>
                        <td><?= $order['email'] ?></td>
                        <td><?= $order['orderCreatedAt'] ?></td>
                        <td><?= count($order['lineItems']) ?></td>
                    </tr>
                <?php } ?>
            </table>
        </main>
    </div>
</body>
</html>