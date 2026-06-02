<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../Attribute/AllowedMethods.php';

class SecurityController extends AppController {
    private $userRepository;

    public function __construct() {
        // Security Bingo (D1): Używamy Singletona, nie tworzymy nowych instancji bez sensu
        $this->userRepository = UserRepository::getInstance();
    }

    #[AllowedMethods(['GET', 'POST'])]
    public function login() {
        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST["email"] ?? '';
        $password = $_POST["password"] ?? '';

        if (empty($email) || empty($password)) {
            return $this->render('login', ['messages' => ['Wypełnij wszystkie pola']]);
        }

        $user = $this->userRepository->getUserByEmail($email);

        // Security Bingo (B1): Generyczny komunikat, aby nie zdradzać czy email istnieje
        if (!$user || !password_verify($password, $user['password'])) {
            return $this->render('login', ['messages' => ['Nieprawidłowy email lub hasło']]);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Security Bingo (B3): Regeneracja ID sesji zaraz po logowaniu (ochrona przed Session Fixation)
        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['role_id'] = $user['role_id'];

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/dashboard"); // Tymczasowo, potem zmienimy na stronę sklepu
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

        // Security Bingo (C1): Walidacja formatu email po stronie serwera
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->render('register', ['messages' => ['Nieprawidłowy format email']]);
        }

        // Security Bingo (C4): Jeśli email istnieje, dajemy mylący komunikat przeciwko enumeracji
        if ($this->userRepository->getUserByEmail($email)) {
            return $this->render('register', ['messages' => ['Jeśli w systemie istnieje konto z tym adresem, wysłaliśmy instrukcje na email.']]);
        }

        // Security Bingo (E2): Bezpieczne haszowanie haseł algorytmem BCRYPT
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $this->userRepository->createUser($email, $hashedPassword, $username);

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/login");
        exit();
    }

    #[AllowedMethods(['GET'])]
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Security Bingo (D5): Poprawne niszczenie sesji i ciasteczka
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/login");
        exit();
    }
}