<?php

// Importujemy nasz middleware
require_once 'src/middleware/checkRequestAllowed.php';

class Routing {
    public static array $routes = [];

    public static function get(string $url, string $controller, string $action): void {
        self::$routes[$url] = ['controller' => $controller, 'action' => $action];
    }

    public static function post(string $url, string $controller, string $action): void {
        self::$routes[$url] = ['controller' => $controller, 'action' => $action];
    }

    public static function run(string $path): void {
        $path = explode("?", $path)[0];

        if (!array_key_exists($path, self::$routes)) {
            http_response_code(404);
            if (file_exists('public/views/404.html')) {
                include 'public/views/404.html';
            } else {
                echo "404 Not Found - Strona nie istnieje.";
            }
            return;
        }

        $controller = self::$routes[$path]['controller'];
        $action = self::$routes[$path]['action'];

        if (file_exists("src/controllers/{$controller}.php")) {
            require_once "src/controllers/{$controller}.php";
        } else {
            throw new Exception("Kontroler $controller nie istnieje!");
        }

        $controllerObj = new $controller();
        
        // --- KLUCZOWY MOMENT ---
        // Sprawdzamy, czy żądanie jest dozwolone przez adnotacje
        checkRequestAllowed($controllerObj, $action);
        
        $controllerObj->$action();
    }
}