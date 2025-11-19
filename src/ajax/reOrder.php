<?php

declare(strict_types=1);
session_start();

require_once __DIR__ . "/../lib/OrderService.php";

if ('POST' !== $_SERVER['REQUEST_METHOD']) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid request method']);

    exit;
}

if (!isset($_POST['order'])) {
    http_response_code(401);
    echo json_encode(['message'=> 'Missing \'order\' parameter']);

    exit;
}

$order = $_POST['order'];

try {
    (new OrderService())->reOrder($order);
    http_response_code(200);
    echo json_encode(['message'=> 'Order re-placed']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['message'=> $e->getMessage()]);
}

exit;