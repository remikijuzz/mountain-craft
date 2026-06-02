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

    #[AllowedMethods(['POST'])]
    public function search() {
        // 1. Sprawdzamy typ zawartości nagłówka
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        
        if ($contentType === "application/json") {
            // 2. Pobieramy surowy strumień danych z żądania HTTP
            $content = trim(file_get_contents("php://input"));
            
            // 3. Dekodujemy JSON-a do tablicy asocjacyjnej w PHP
            $decoded = json_decode($content, true);
            
            // 4. Ustawiamy nagłówki odpowiedzi jako JSON
            header('Content-type: application/json');
            http_response_code(200);
            
            // 5. Szukamy makiet w bazie i zwracamy wynik zakodowany z powrotem do JSON-a
            echo json_encode($this->productRepository->getProductByName($decoded['search']));
        }
    }
}