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
        $this->session = SessionManager::getInstance();

        echo "Cart received for user  " . $this->fingerprintService->getUser();
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

    public function getItems($userUuid)
    {
        $items = $this->cartRepository->getUserActiveCartWithItems($userUuid);
        $quantified = $this->quantifyItems($items);

        return $quantified;
    }

    private function resetCart()
    {
        $this->session->unset('cart');
        $this->createCart();
    }

    private function quantifyItems(array $items): mixed
    {
        $quantified = [];

        foreach ($items as $item) {
            if (!isset($quantified[$item['ProductTitle']])) {
                $quantified[$item['ProductTitle']] = $item;
                $quantified[$item['ProductTitle']]['quantity'] = 0;
            }

            $quantified[$item['ProductTitle']]['quantity']++;
        }

        return $quantified;
    }
}