<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/ProductRepository.php';

class ProductController extends AppController {
    private $productRepository;

    public function __construct() {
        parent::__construct();
        $this->productRepository = new ProductRepository();
    }

    #[AllowedMethods(['GET'])]
    public function dashboard() {
        // Wymuszamy, by tylko zalogowani mieli dostęp do sklepu
        $this->requireLogin();

        // Pobieramy zmapowane obiekty
        $products = $this->productRepository->getProducts();

        // Przekazujemy je do widoku
        $this->render('dashboard', ['products' => $products]);
    }
}