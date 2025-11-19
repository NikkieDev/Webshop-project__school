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

    // public static function getInstance(): OrderService
    // {
    //     return self::$instance ??= new OrderService();
    // }

    public function __construct() {
        $this->orderRepository = new OrderRepository();
        $this->userService = new UserService();
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

    public function getUserMostRecentOrders(): mixed
    {
        $user = $this->userService->getUser();
        $orders = $this->orderRepository->getUserMostRecentOrders($user);

        return $orders;
    }
    
    public function cancelOrder(string $orderUuid)
    {
        $this->orderRepository->cancelOrder($orderUuid);
    }
    
    public function reOrder(string $orderUuid)
    {
        $existingOrder = $this->orderRepository->findById($orderUuid);

        if (0 == count($existingOrder)) {
            throw new Exception("Bestelling bestaat niet");
        }

        $props = new CreateOrderProps(
            $existingOrder['UserUuid'],
            $existingOrder['address'],
            $existingOrder['zipcode'],
            $existingOrder['location'],
            (float) $existingOrder['price'],
        );

        $this->orderRepository->createOrder($existingOrder['CartUuid'], $props);
    }
}