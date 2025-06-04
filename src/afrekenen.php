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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/lib.css">
    <link rel="stylesheet" href="/css/afrekenen.css">
    <title>Afrekenen</title>
</head>
<body>
    
</body>
</html>