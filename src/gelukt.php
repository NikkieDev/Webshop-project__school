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
</head>
<body>
    <section class="success-wrapper">
        <h2>Bedankt voor uw bestelling!</h2>
        <span>Bestel-nummer #<?php echo $orderId ?></span>
        <a href="/">Terug</a>
    </section>
</body>
</html>