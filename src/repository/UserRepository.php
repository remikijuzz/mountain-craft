<?php

require_once 'Database.php';

class UserRepository {
    // Wzorzec Singleton
    private static $instance;
    private $database;

    private function __construct() {
        $this->database = new Database();
    }

    public static function getInstance() {
        return self::$instance ??= new UserRepository();
    }

    // Pobieranie użytkownika z bazy po emailu (używamy bindowania parametrów)
    public function getUserByEmail(string $email) {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            return null;
        }

        return $user;
    }

    // Dodawanie nowego użytkownika przy rejestracji
    public function createUser(string $email, string $password, string $username) {
        // Zgodnie z naszą bazą, domyślna rola 'Klient' to id = 1
        $stmt = $this->database->connect()->prepare('
            INSERT INTO users (role_id, username, email, password) 
            VALUES (1, :username, :email, :password)
        ');
        
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR); // Tutaj trafi już zahaszowane hasło
        
        $stmt->execute();
    }
}