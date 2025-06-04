<?php

declare(strict_types=1);

require_once "repository/CartRepository.php";
require_once 'FingerprintService.php';

class CartManager
{
    private CartRepository $cartRepository;
    private FingerprintService $fingerprintService;
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
        $this->dbManager = new Db();
        $this->fingerprintService = FingerprintService::getInstance();

        if (!isset($_SESSION['cart'])) {
            $this->cart = $this->cartRepository->getUserActiveCart($this->fingerprintService->getUser());

            if (empty($this->cart)) {
                $this->cart = $this->createCart();
            }

            $_SESSION['cart'] = $this->cart;
        } else {
            $this->cart = $_SESSION['cart'];
        }
    }

    public function getCart()
    {
        return $_SESSION['cart'];
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
            unset($_SESSION['cart']);
            $this->createCart();
        }
    }

    public function removeFromCart($productUuid)
    {
        try {
            $this->cartRepository->removeFromCart($this->getCart(), $productUuid);
        } catch (Exception $e) {
            unset($_SESSION['cart']);
            $this->createCart();
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