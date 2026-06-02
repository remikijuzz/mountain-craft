<?php

class Database {
    private string $username;
    private string $password;
    private string $host;
    private string $database;

    public function __construct() {
        // Zmienne środowiskowe z Twojego kontenera Docker
        $this->username = 'docker';
        $this->password = 'docker';
        $this->host = 'db'; // Nazwa usługi w Dockerze odpowiada za hosta
        $this->database = 'db';
    }

    public function connect() {
        try {
            $conn = new PDO(
                "pgsql:host=$this->host;port=5432;dbname=$this->database",
                $this->username,
                $this->password
            );

            // Wymuszamy rzucanie wyjątków zamiast cichego ignorowania błędów
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $conn;
        } catch (PDOException $e) {
            // Wykładowca zabrania używania funkcji die()! Rzucamy wyjątek z generycznym błędem,
            // aby nie pokazywać wrażliwych danych użytkownikowi (Security Bingo).
            throw new Exception("Błąd połączenia z bazą danych. Skontaktuj się z administratorem.");
        }
    }
}