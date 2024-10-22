<?php
class Auth {
    public function __construct() {
        // Start session if it hasn't been started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Method to log in the user (set session variables)
    public function login($user_id,$name) {
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['name']=$name;
    }

    

    // Method to check if the user is logged in
    public function isLoggedIn() {
        return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
    }

    // Method to redirect logged-in users away from login page
    public function redirectIfLoggedIn($redirectTo = 'home.php') {
        if ($this->isLoggedIn()) {
            header("Location: $redirectTo");
            exit;
        }
    }

    // Method to protect pages (only accessible when logged in)
    public function protectPage($redirectTo = 'index.php') {
        if (!$this->isLoggedIn()) {
            header("Location: $redirectTo");
            exit;
        }
    }
}
?>
