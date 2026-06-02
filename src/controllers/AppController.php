<?php

class AppController {
    // Sprawdzanie metody HTTP
    protected function isGet(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    protected function isPost(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    // Metoda do renderowania widoków HTML
    protected function render(string $template = null, array $variables = []) {
        $templatePath = 'public/views/' . $template . '.php'; // Będziemy używać rozszerzenia .php dla widoków
        $output = 'File not found';
        
        if (file_exists($templatePath)) {
            extract($variables); // Zmienia tablicę asocjacyjną na zmienne, np. $messages
            
            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }
        
        print $output;
    }

    // Strażnik dostępu dla zalogowanych użytkowników
    protected function requireLogin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['user_id'])) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/login");
            exit();
        }
    }
}