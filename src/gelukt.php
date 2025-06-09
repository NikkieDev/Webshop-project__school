<?php

declare(strict_types=1);

require_once 'lib/OrderService.php';

if (!isset($_GET['orderId'])) {
    header("Location: index.php");
}

$orderId = $_GET['orderId'];

$orderService = OrderService::getInstance();

$orderExists = $orderService->verifyOrderExistance($orderId);

if (!$orderExists) {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestelling gelukt!</title>
    <link rel="stylesheet" href="/css/lib.css">

    <style>
        h2 {
            font-size: 32px;
        }
        .success-bestelnummer {
            font-size: 12px;
            font-weight: 600;
            margin: 0 0 16px 0;
        }
    </style>
</head>
<body>
    <section class="success-wrapper center col">
        <h2>Bedankt voor uw bestelling!</h2>
        <span class="success-bestelnummer">#<?php echo $orderId ?></span>
        <a href="/" class="btn">Terug</a>
    </section>
</body>
</html>