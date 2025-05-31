<?php

session_start();

require_once '../lib/CartManager.php';
require_once '../lib/FingerprintService.php';

$cartManager = CartManager::getInstance();
$cart = $cartManager->getCart();

$product = $_POST['product'];

header('Content-Type: application/json');

if (empty($cart)) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => "You don't have access to this cart.",
    ]);

    return;
}

if (empty($product)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => "No product was given.",
    ]);
}

$cartManager->removeFromCart($product);