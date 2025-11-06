<?php

declare(strict_types= 1);
session_start();

require_once __DIR__ .'/../../lib/FingerprintService.php';
require_once __DIR__ .'/../../lib/repository/ProductRepository.php';

$fp = FingerprintService::getInstance();

if (!$fp->isAdmin()) {
    http_response_code(401);
    echo json_encode(['message' => 'You are not allowed to do this.']);
    
    exit;
}

if (!isset($_POST['product'])) {
    http_response_code(400);
    echo json_encode(['message'=> 'No product specified']);

    exit;
}

if (!isset($_POST['newStock'])) {
    http_response_code(400);
    echo json_encode(['message'=> 'No product specified']);

    exit;
}

try {
    $productRepository = new ProductRepository();
    $productRepository->updateStock($_POST['product'], (int) $_POST['newStock']);
    
    http_response_code(200);
    echo json_encode(['message'=> 'ok']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['message'=> $e->getMessage()]);
}