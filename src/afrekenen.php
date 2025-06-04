<?php

declare(strict_types=1);

session_start();

require_once 'lib/FingerprintService.php';
require_once 'lib/CartManager.php';

$fingerprint = FingerprintService::getInstance();
$cartManager = CartManager::getInstance();

if ($fingerprint->isGuest()) {
    header('Location: account-aanmaken.php?referrer=afrekenen.php');
} else if ($cartManager->getCart() === null || $cartManager->getSize() === 0 ) {
    header('Location: index.php?referrer=afrekenen.php');
}

if ('POST' === $_SERVER['REQUEST_METHOD']) {
    $orderId = $this->//create order repository && handler
    header('Location: gelukt.php?OrderId=' . $orderId);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/lib.css">
    <!-- <link rel="stylesheet" href="/css/afrekenen.css"> -->
    <title>Afrekenen</title>
</head>
<body>
    <section class="form-wrapper">
        <h4>U gaat afrekenen</h4>
        <form method="post">
            <div class="input-wrapper">
                <label for="streetWithNumber">Straat en huisnummer</label>
                <input type="text" name="streetWithNumber" maxlength="80" placeholder="De Sumpel 4" required>
            </div>

            <div class="input-wrapper">
                <label for="zipcode">Postcode</label>
                <input type="text" name="zipcode" placeholder="0000 XX" maxlength="7" minlength="7" pattern="^[1-9][0-9]{3}\s?[A-Z]{2}$">
            </div>

            <div class="input-wrapper">
                <label for="location">Plaats</label>
                <input type="text" name="location" placeholder="Almelo">
            </div>

            <button type="submit">Betalen</button>
        </form>
    </section>
</body>
</html>