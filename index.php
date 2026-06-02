<?php

// Security Bingo (C3, E3): Zabezpieczenie ciasteczek sesyjnych przed XSS i CSRF
session_set_cookie_params([
    'lifetime' => 3600,
    'path' => '/',
    'secure' => false, // Zmienimy na true, jeśli włączysz HTTPS pod koniec projektu
    'httponly' => true,
    'samesite' => 'Lax'
]);


// 1. Zgodnie z instrukcją uruchamiamy sesję na samym początku życia aplikacji
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Podpinamy nasz router
require_once 'src/Routing.php';

// 3. Pobieramy aktualną ścieżkę z adresu URL (np. "login" z localhost:8080/login)
$path = trim($_SERVER['REQUEST_URI'], '/');

// 4. Definiujemy trasy (będziemy je uzupełniać w kolejnych dniach)
Routing::get('login', 'SecurityController', 'login');
Routing::post('login', 'SecurityController', 'login');
Routing::get('register', 'SecurityController', 'register');
Routing::post('register', 'SecurityController', 'register');
Routing::post('search', 'ProductController', 'search');
Routing::get('dashboard', 'ProductController', 'dashboard');
// Strona główna po wejściu na aplikację
Routing::get('', 'DefaultController', 'index');
// Trasa do wyświetlenia dostępnych makiet
Routing::get('kolekcja', 'ProductController', 'kolekcja');
// 5. Odpalamy dopasowanie ścieżki
Routing::run($path);