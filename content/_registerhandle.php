<?php
include_once '_dbconnect.php';
include_once 'validation.php';
include_once 'Auth.php';

class Register extends Validation {
    protected $conn;
    public function __construct($conn){
        $this->conn = $conn;
    }
    
    public function register_user($name, $email, $password1, $password2){
        $this->isRequired('Name', $name);
        $this->isAlphabetic('Name', $name);  
        $this->isRequired('Email', $email);
        $this->isEmail('Email', $email);
        $this->isRequired('Password', $password1);
        $this->isRequired('Confirm Password', $password2);
        $this->isMatch('Password', $password1, 'Confirm Password', $password2);
         // If validation fails, return errors
         if ($this->hasErrors()) {
            return ['status' => 'error', 'errors' => $this->getErrors()];
        } 
         // Sanitize inputs
         $name = mysqli_real_escape_string($this->conn, $name);
         $email = mysqli_real_escape_string($this->conn, $email);
         $password = mysqli_real_escape_string($this->conn, $password1);
          // Check if email is already registered
        $check_email = mysqli_query($this->conn, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($check_email) > 0) {
            return ['status' => 'error', 'errors' => ['Email already exists.']];
        }
       $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
        if(mysqli_query($this->conn,$query)){
            $user_id=mysqli_insert_id($this->conn);
            $query1="INSERT INTO `user_balance` (`user_id`, `balance`) VALUES ('$user_id', '0')";
            mysqli_query($this->conn,$query1);
            $auth = new Auth();
            $auth->login($user_id,$name);
            
            $token = bin2hex(random_bytes(16)); // Generate a secure token
            $hashedToken = password_hash($token, PASSWORD_DEFAULT); // Hash the token for storage

            mysqli_query($this->conn, "UPDATE users SET login_token='$hashedToken' WHERE id='$user_id'");

            // Set a cookie with the token that expires in 30 days
            setcookie('login_token', $token, time() + (86400 * 30), "/", "", true, true); // Cookie lasts 30 days, HttpOnly, Secure

            return ['status' => 'success', 'message' => 'Registration successful!'];
        }else {
            return ['status' => 'error', 'errors' => ['Database' => 'Registration failed. Please try again.']];
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $register = new Register($conn); 
    $result = $register->register_user($_POST['Name'], $_POST['Email'], $_POST['password1'], $_POST['password2']);

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($result);
}

?>