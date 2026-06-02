<?php

require_once __DIR__ . '/AppController.php';

class DefaultController extends AppController {
    public function index() {
        // Strona główna nie wymaga logowania
        $this->render('home');
    }
}