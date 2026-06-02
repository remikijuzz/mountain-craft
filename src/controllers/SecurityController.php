<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../Attribute/AllowedMethods.php';

class SecurityController extends AppController {
    private $userRepository;

    public function __construct() {
        $this->userRepository = UserRepository::getInstance();
    }

    #[AllowedMethods(['GET', 'POST'])]
    public function login() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!$this->isPost()) {
            // Przechwytujemy komunikat o sukcesie (np. po rejestracji)
            $success = $_SESSION['success_message'] ?? null;
            unset($_SESSION['success_message']); // Od razu usuwamy, żeby wyświetlił się tylko raz
            
            return $this->render('login', ['success' => $success]);
        }

        $email = $_POST["email"] ?? '';
        $password = $_POST["password"] ?? '';

        if (empty($email) || empty($password)) {
            return $this->render('login', ['messages' => ['Wypełnij wszystkie pola']]);
        }

        $user = $this->userRepository->getUserByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->render('login', ['messages' => ['Nieprawidłowy email lub hasło']]);
        }
        
        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['role_id'] = $user['role_id'];

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/kolekcja"); // Po zalogowaniu wracamy do sklepu
        exit();
    }

    #[AllowedMethods(['GET', 'POST'])]
    public function register() {
        if (!$this->isPost()) {
            return $this->render('register');
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $username = trim($_POST['username'] ?? '');

        if (empty($email) || empty($password) || empty($username)) {
            return $this->render('register', ['messages' => ['Wypełnij wszystkie pola']]);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->render('register', ['messages' => ['Nieprawidłowy format email']]);
        }

        if ($this->userRepository->getUserByEmail($email)) {
            return $this->render('register', ['messages' => ['Konto z tym adresem już istnieje.']]);
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $this->userRepository->createUser($email, $hashedPassword, $username);

        // Zapisujemy komunikat o sukcesie w sesji
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION['success_message'] = "Konto zostało pomyślnie utworzone. Proszę się zalogować!";

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/login");
        exit();
    }

    #[AllowedMethods(['GET'])]
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION = [];
        session_destroy();
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/login");
        exit();
    }
}