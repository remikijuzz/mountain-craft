<?php

require_once __DIR__ . '/../Attribute/AllowedMethods.php';

function checkRequestAllowed(object $controller, string $methodName) {
    // Używamy refleksji do zbadania klasy kontrolera i jej metody
    $reflection = new ReflectionMethod($controller, $methodName);
    
    // Szukamy naszego atrybutu AllowedMethods
    $attributes = $reflection->getAttributes(AllowedMethods::class);

    if (!empty($attributes)) {
        $instance = $attributes[0]->newInstance();
        $allowed = $instance->methods;

        // Sprawdzamy, czy aktualna metoda żądania (np. GET/POST) znajduje się w dozwolonych
        if (!in_array($_SERVER['REQUEST_METHOD'], $allowed)) {
            // Rzucamy wyjątek zamiast die(), co jest bezpieczne i wymagane
            throw new Exception("Method Not Allowed", 405);
        }
    }
}