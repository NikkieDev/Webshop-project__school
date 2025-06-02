<?php

session_start();

require_once '../lib/CartManager.php';

$cartManager = CartManager::getInstance();

$product = $_POST['product'];

header('Content-Type: application/json');

try {
    $cartManager->addToCart($product);

    http_response_code(200);
    
    echo json_encode([
        'success' => true
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
    ]);
}

return;