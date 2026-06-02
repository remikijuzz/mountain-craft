<?php

require_once __DIR__ . '/AppController.php';
require_once __DIR__ . '/../repository/ProductRepository.php';

class CartController extends AppController {
    private $productRepository;

    public function __construct() {
        $this->productRepository = new ProductRepository();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function viewCart() {
        $cartIds = $_SESSION['cart'] ?? [];
        $allProducts = $this->productRepository->getProducts();
        
        $cartProducts = [];
        $total = 0;

        // Szukamy produktów, które użytkownik wrzucił do koszyka
        foreach ($cartIds as $id) {
            foreach ($allProducts as $product) {
                if ($product->getId() == $id) {
                    $cartProducts[] = $product;
                    $total += $product->getPrice();
                    break;
                }
            }
        }

        $this->render('cart', [
            'products' => $cartProducts, 
            'total' => $total,
            'isLoggedIn' => isset($_SESSION['user_id'])
        ]);
    }

    public function add() {
        $productId = $_POST['product_id'] ?? null;
        if ($productId) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            $_SESSION['cart'][] = $productId; // Dodajemy ID do koszyka
        }
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/cart");
        exit();
    }

    public function checkout() {
        // Symulacja zakupu - po prostu czyścimy koszyk i pokazujemy sukces
        unset($_SESSION['cart']);
        $this->render('checkout_success');
    }
}