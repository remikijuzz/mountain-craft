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

// 1. Zawsze dostępne (Publiczne)
Routing::get('', 'DefaultController', 'index');               // Strona Główna (Home)
Routing::get('kolekcja', 'ProductController', 'kolekcja');    // Sklep z produktami
Routing::get('cart', 'CartController', 'viewCart');           // Koszyk
Routing::post('cart/add', 'CartController', 'add');           // Dodawanie do koszyka
Routing::post('checkout', 'CartController', 'checkout');      // Symulacja płatności

// 2. Autoryzacja (Publiczne)
Routing::get('login', 'SecurityController', 'login');
Routing::post('login', 'SecurityController', 'login');
Routing::get('register', 'SecurityController', 'register');
Routing::post('register', 'SecurityController', 'register');
Routing::get('logout', 'SecurityController', 'logout');

// 3. Strefa Zamknięta (Wymaga Logowania)
Routing::get('dashboard', 'ProductController', 'dashboard');  // Historia / Dziennik

// 4. Odpalamy dopasowanie ścieżki i ładujemy widok!
Routing::run($path);