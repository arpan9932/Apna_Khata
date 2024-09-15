<?php
include '_dbconnect.php';
include 'validation.php';

class Spending extends Validation {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function add_spending($user_id, $amount, $date, $description) {
        $this->isRequired('User ID', $user_id);
        $this->isNumeric('Amount', $amount);
        $this->isRequired('Date', $date);
        $this->isDate('Date', $date);
        $this->isRequired('Description', $description);
        $this->isAlphanumeric('Description', $description);

        if ($this->hasErrors()) {
            return ['status' => 'error', 'errors' => $this->getErrors()];
        }

        $user_id = mysqli_real_escape_string($this->conn, $user_id);
        $amount = mysqli_real_escape_string($this->conn, $amount);
        $date = mysqli_real_escape_string($this->conn, $date);
        $description = mysqli_real_escape_string($this->conn, $description);

        $query = "INSERT INTO `spanding` (`user_id`, `purpose`, `price`, `date`) VALUES ('$user_id', '$description', '$amount', '$date')";

        if (mysqli_query($this->conn, $query)) {
            return ['status' => 'success', 'message' => 'Spending added successfully'];
        } else {
            return ['status' => 'error', 'errors' => 'Addition failed. Please try again.'];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $user_id = $_SESSION['user_id'];
    $spending = new Spending($conn);
    $result = $spending->add_spending($user_id, $_POST['amount'], $_POST['date'], $_POST['purpose']);

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($result);
}
?>
