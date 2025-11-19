<?php

declare(strict_types=1);

require_once "repository/CartRepository.php";
require_once 'FingerprintService.php';
require_once 'SessionManager.php';

class CartManager
{
    private CartRepository $cartRepository;
    private FingerprintService $fingerprintService;
    private SessionManager $session;
    private ?string $cart;
    private static ?CartManager $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new CartManager();
        }

        return self::$instance;
    }
    
    private function __construct()
    {
        $this->fingerprintService = FingerprintService::getInstance();
        $this->cartRepository = new CartRepository();
        $this->session = new SessionManager();

        $this->cart = $this->cartRepository->getUserActiveCart($this->fingerprintService->getUser());
        $this->session->set('cart', $this->cart);
    }

    public function getCart()
    {
        return $this->session->get('cart');
    }

    public function createCart(): string
    {
        $uuid = $this->cartRepository->generateCart($this->fingerprintService->getUser());
        
        return $uuid;
    }

    public function addToCart($productUuid)
    {
        try {
            $this->cartRepository->addToCart($this->getCart(), $productUuid);
        } catch (Exception $e) {
            $this->resetCart();
        }
    }

    public function removeFromCart($productUuid)
    {
        try {
            $this->cartRepository->removeFromCart($this->getCart(), $productUuid);
        } catch (Exception $e) {
            $this->resetCart();
        }
    }

    public function getSize()
    {
        return $this->cartRepository->getCartSize($this->cart);
    }

    public function getItems()
    {
        $items = $this->cartRepository->getUserActiveCartWithItems($this->fingerprintService->getUser());
        $quantified = $this->quantifyItems($items);

        return $quantified;
    }

    public function getCartValue(): float
    {
        $value = 0.00;

        $items = $this->cartRepository->getUserActiveCartWithItems($this->fingerprintService->getUser());

        foreach ($items as $item) {
            $value += (float) $item['productPrice'];
        }

        return $value;
    }

    public function closeCart()
    {
        $this->cartRepository->closeCart($this->getCart());
        $this->resetCart();
    }

    private function resetCart()
    {
        $this->session->unset('cart');
        $this->createCart();
    }

    public function quantifyItems(array $items): mixed
    {
        $quantified = [];

        foreach ($items as $item) {
            if (!isset($quantified[$item['productTitle']])) {
                $quantified[$item['productTitle']] = $item;
                $quantified[$item['productTitle']]['quantity'] = 0;
            }

            $quantified[$item['productTitle']]['quantity']++;
        }

        return $quantified;
    }
}