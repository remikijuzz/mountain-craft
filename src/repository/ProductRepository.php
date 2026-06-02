<?php

require_once 'Database.php';
require_once __DIR__ . '/../models/Product.php';

class ProductRepository {
    private $database;

    public function __construct() {
        $this->database = new Database();
    }

    // Pobieranie wszystkich makiet gór ze sklepu
    public function getProducts(): array {
        $result = [];
        $stmt = $this->database->connect()->prepare('SELECT * FROM products');
        $stmt->execute();

        // Mapowanie: zamieniamy surowe wiersze z bazy na obiekty PHP
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($products as $product) {
            $result[] = new Product(
                $product['name'],
                $product['description'],
                $product['price'],
                $product['scale'],
                $product['image_url'],
                $product['id']
            );
        }

        return $result;
    }

    // Metoda wyszukująca makiety (przyda nam się później do FETCH API w JS)
    public function getProductByName(string $searchString): array {
        $searchString = '%' . strtolower($searchString) . '%';

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM products WHERE LOWER(name) LIKE :search
        ');
        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Aktualizacja ceny z wykorzystaniem TRANSAKCJI PDO
    public function updateProductPrice(int $id, float $newPrice) {
        $conn = $this->database->connect();
        
        try {
            $conn->beginTransaction(); // Start transakcji

            $stmt = $conn->prepare('UPDATE products SET price = :price WHERE id = :id');
            $stmt->bindParam(':price', $newPrice, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $conn->commit(); // Zatwierdzenie transakcji
        } catch (Exception $e) {
            $conn->rollBack(); // Wycofanie zmian w razie błędu
            throw new Exception("Błąd podczas aktualizacji produktu: " . $e->getMessage());
        }
    }
}