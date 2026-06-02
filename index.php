<?php
session_set_cookie_params(['lifetime' => 3600, 'path' => '/', 'secure' => false, 'httponly' => true, 'samesite' => 'Lax']);
if (session_status() === PHP_SESSION_NONE) session_start();

require_once 'src/Routing.php';
$path = trim($_SERVER['REQUEST_URI'], '/');

Routing::get('', 'DefaultController', 'index');
Routing::get('kolekcja', 'ProductController', 'kolekcja');
Routing::get('cart', 'CartController', 'viewCart');
Routing::post('cart/add', 'CartController', 'add');
Routing::post('checkout', 'CartController', 'checkout');
Routing::get('login', 'SecurityController', 'login');
Routing::post('login', 'SecurityController', 'login');
Routing::get('register', 'SecurityController', 'register');
Routing::post('register', 'SecurityController', 'register');
Routing::get('logout', 'SecurityController', 'logout');

Routing::run($path);