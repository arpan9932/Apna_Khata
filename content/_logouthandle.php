<?php
include '_dbconnect.php';

// Start the session
session_start();

class Logout {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function logoutUser() {
        // Fetch user ID before destroying the session
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        // Clear session
        session_unset();
        session_destroy();

        // Remove token from the database only if user ID exists
        if ($userId) {
            mysqli_query($this->conn, "UPDATE users SET login_token=NULL WHERE id='$userId'");
        }

        // Remove the cookie
        setcookie('login_token', '', time() - 3600, "/", "", true, true); // Delete the cookie by setting it in the past

        return ['status' => 'success', 'message' => 'Logout successful!'];
    }
}

$logout = new Logout($conn);  // Pass the connection to the Logout class
$result = $logout->logoutUser();  // Call logoutUser method

// Send JSON response
header('Content-Type: application/json');
echo json_encode($result);
?>
