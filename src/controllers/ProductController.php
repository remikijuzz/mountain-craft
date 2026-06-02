<?php

// AppController jest w tym samym folderze co ten plik
require_once __DIR__ . '/AppController.php';
// Repozytorium jest poziom wyżej w folderze repository
require_once __DIR__ . '/../repository/ProductRepository.php';

class ProductController extends AppController {
    private $productRepository;

    public function __construct() {
        // Celowo pomijamy parent::__construct(), aby uniknąć błędu PHP
        $this->productRepository = new ProductRepository();
    }

    public function dashboard() {
        $this->requireLogin();
        $products = $this->productRepository->getProducts();
        $this->render('dashboard', ['products' => $products]);
    }

    public function kolekcja() {
        // Ta strona jest publiczna (brak $this->requireLogin())
        $products = $this->productRepository->getProducts();
        $this->render('kolekcja', ['products' => $products]);
    }
}