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

// Put address form