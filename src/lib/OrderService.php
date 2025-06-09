<?php

declare(strict_types=1);

require_once 'model/CreateOrderProps.php';
require_once 'repository/OrderRepository.php';
require_once "UserService.php";
require_once "CartManager.php";

class OrderService
{
    private static ?OrderService $instance = null;
    private UserService $userService;
    private OrderRepository $orderRepository;
    private CartManager $cartManager;


    public static function getInstance(): OrderService
    {
        return self::$instance ??= new OrderService();
    }

    private function __construct() {
        $this->orderRepository = new OrderRepository();
        $this->userService = UserService::getInstance();
        $this->cartManager = CartManager::getInstance();
    }

    public function createOrderFromCart(CreateOrderProps $props): string
    {
        $cartUuid = $this->cartManager->getCart();
        
        $orderId = $this->orderRepository->createOrder($cartUuid, $props);
        $this->cartManager->closeCart();

        return $orderId;
    }

    public function verifyOrderExistance($orderUuid): bool
    {
        return $this->orderRepository->doesOrderExist($orderUuid);
    }
}