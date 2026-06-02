<?php
require_once __DIR__ . '/AppController.php';
require_once __DIR__ . '/../repository/ProductRepository.php';

class ProductController extends AppController {
    private $productRepository;

    public function __construct() {
        $this->productRepository = new ProductRepository();
    }

    // PUBLICZNA STRONA SKLEPU (Każdy ma dostęp)
    public function kolekcja() {
        // NIE dajemy tu $this->requireLogin();
        $products = $this->productRepository->getProducts();
        $this->render('kolekcja', ['products' => $products]);
    }

    // PRYWATNY DZIENNIK (Wymaga konta)
    public function dashboard() {
        // Blokada dla niezalogowanych
        $this->requireLogin(); 
        $products = $this->productRepository->getProducts();
        $this->render('dashboard', ['products' => $products]);
    }
}