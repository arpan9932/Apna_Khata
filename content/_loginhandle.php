<?php
session_start();  // Start the session
require_once '_dbconnect.php';  // Include the database connection
require_once 'Validation.php';     // Include the validation class

class Login extends Validation {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function loginUser($email, $password) {
        // Validate input fields
        $this->isRequired('Email', $email);
        $this->isRequired('Password', $password);
        $this->isEmail('Email', $email);

        // If validation fails, return errors
        if ($this->hasErrors()) {
            return ['status' => 'error', 'errors' => $this->getErrors()];
        }

        // Sanitize inputs
        $email = mysqli_real_escape_string($this->conn, $email);
        $password = mysqli_real_escape_string($this->conn, $password);

        // Check if email exists in the database
        $result = mysqli_query($this->conn, "SELECT * FROM users WHERE email='$email'");

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Set session after successful login
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];

            $token = bin2hex(random_bytes(16)); // Generate a secure token
            $hashedToken = password_hash($token, PASSWORD_DEFAULT); // Hash the token for storage


            // Store the token in the database
            $userId = $user['id'];
            mysqli_query($this->conn, "UPDATE users SET login_token='$hashedToken' WHERE id='$userId'");

            // Set a cookie with the token that expires in 30 days
            setcookie('login_token', $token, time() + (86400 * 30), "/", "", true, true); // Cookie lasts 30 days, HttpOnly, Secure

                return ['status' => 'success', 'message' => 'Login successful!'];
            } else {
                return ['status' => 'error', 'errors' => ['Incorrect password.']];
            }
        } else {
            return ['status' => 'error', 'errors' => ['Email does not exist.']];
        }
    }
}

// Handle AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = new Login($conn);  // Pass the connection to the Login class
    $result = $login->loginUser($_POST['email'], $_POST['password']);

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($result);
}

?>
