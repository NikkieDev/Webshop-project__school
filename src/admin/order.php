<?php

declare(strict_types= 1);

$activeTab = 'bestellingen';

require_once __DIR__ .'/../lib/OrderService.php';
require_once __DIR__ .'/../lib/model/OrderStatus.php';

if (!isset($_GET['uuid'])) {
    header('Location: /admin/bestellingen.php');
    exit(0);
}

$orderService = OrderService::getInstance();
$orderService->getOrderItems($_GET['uuid']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestelling #<?= $order->getOrderId() ?> | Beheer portaal</title>
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

            </table>
        </main>
    </div>
</body>
</html>