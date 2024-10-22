<?php
include '_dbconnect.php';
include 'validation.php';

class UpdateSpending extends Validation {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function update_spending($id, $user_id, $amount, $date, $description,$olddesc) {
        // Validate inputs
        $this->isRequired('User ID', $user_id);
        $this->isNumeric('Amount', $amount);
        $this->isRequired('Date', $date);
        $this->isDate('Date', $date);
        $this->isRequired('Description', $description);
        $this->isAlphanumeric('Description', $description);

        if ($this->hasErrors()) {
            return ['status' => 'error', 'errors' => $this->getErrors()];
        }
        if ($olddesc === 'total') {
            return ['status' => 'error', 'errors' => 'You cannot update the "Total" value.'];
        }

        // Sanitize inputs
        $user_id = mysqli_real_escape_string($this->conn, $user_id);
        $amount = mysqli_real_escape_string($this->conn, $amount);
        $date = mysqli_real_escape_string($this->conn, $date);
        $description = mysqli_real_escape_string($this->conn, $description);

        // Fetch current spending details
        $current_query = "SELECT `date`, `purpose` FROM `spanding` WHERE `id` = '$id' AND `user_id` = '$user_id'";
        $current_result = mysqli_query($this->conn, $current_query);

        if (mysqli_num_rows($current_result) === 0) {
            return ['status' => 'error', 'errors' => 'No spending found with this ID.'];
        }

        $current_spending = mysqli_fetch_assoc($current_result);
        $current_date = $current_spending['date'];
        $current_purpose = $current_spending['purpose'];

        // Determine the changes to make
        if ($date !== $current_date) {
            // Update all records with the old date to the new date
            $update_date_query = "UPDATE `spanding` SET `date` = '$date' WHERE `user_id` = '$user_id' AND `date` = '$current_date'";
            mysqli_query($this->conn, $update_date_query);
        }
      
        if ($description !== $current_purpose) {
            // Update only the purpose for this specific record
            $update_purpose_query = "UPDATE `spanding` SET `purpose` = '$description' WHERE `id` = '$id' AND `user_id` = '$user_id'";
            mysqli_query($this->conn, $update_purpose_query);
        }
    
        // Update the price for this specific record
        $update_amount_query = "UPDATE `spanding` SET `price` = '$amount' WHERE `id` = '$id' AND `user_id` = '$user_id'";
        if (mysqli_query($this->conn, $update_amount_query)) {
            // Update the total for the day
            $this->update_total_spending($user_id, $date);
            return ['status' => 'success', 'message' => 'Spending added successfully'];
        } 
    }

    private function update_total_spending($user_id, $date) {
        // Calculate the total spending for the given date
        $query = "SELECT SUM(`price`) as total_spending FROM `spanding` WHERE `user_id` = '$user_id' AND `date` = '$date' AND soft_delete='0'";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);
        $total_spending = $row['total_spending'];

        // Check if an entry already exists in the total table for that date
        $check_query = "SELECT * FROM `total` WHERE `user_id` = '$user_id' AND `date` = '$date'";
        $check_result = mysqli_query($this->conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // Update the existing total
            $update_query = "UPDATE `total` SET `total` = '$total_spending' WHERE `user_id` = '$user_id' AND `date` = '$date'";
            mysqli_query($this->conn, $update_query);
        } else {
            // Insert a new total record
            $insert_query = "INSERT INTO `total` (`user_id`, `date`, `total`) VALUES ('$user_id', '$date', '$total_spending')";
            mysqli_query($this->conn, $insert_query);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $user_id = $_SESSION['user_id'];
    $updateSpending = new UpdateSpending($conn);
    $result = $updateSpending->update_spending($_POST['id'], $user_id, $_POST['price'], $_POST['date'], $_POST['purpose'],$_POST['oldperpose']);

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($result);
}