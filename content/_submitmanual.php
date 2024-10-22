<?php
include '_dbconnect.php'; // Include your database connection file
include 'validation.php'; // Include your validation class

class ManualHandle extends Validation {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function add_monthly($user_id, $source, $amount,$month,$year) {
        // Validation
        $this->isRequired('User ID', $user_id);
        $this->isNumeric('Amount', $amount);
        $this->isRequired('Source', $source);
        $this->isAlphanumeric('Source', $source);

        if ($this->hasErrors()) {
            return ['status' => 'error', 'errors' => $this->getErrors()];
        }

        // Escape input data
        $user_id = mysqli_real_escape_string($this->conn, $user_id);
        $source = mysqli_real_escape_string($this->conn, $source);
        $amount = mysqli_real_escape_string($this->conn, $amount);

        // Start transaction
        mysqli_begin_transaction($this->conn);

        try {
            // Insert data into the `manual_money` table
            $query = "INSERT INTO `manual_money` (`user_id`, `source`, `amount`) VALUES ('$user_id', '$source', '$amount')";

            if (!mysqli_query($this->conn, $query)) {
                throw new Exception('Failed to add spending.');
            }

            // Check if the user already has a record in the `user_balance` table
            $balanceQuery = "SELECT * FROM `user_balance` WHERE `user_id` = '$user_id'";
            $balanceResult = mysqli_query($this->conn, $balanceQuery);

            if (mysqli_num_rows($balanceResult) > 0) {
                // Update the existing balance
                $updateBalanceQuery = "UPDATE `user_balance` SET `balance` = `balance` + '$amount' WHERE `user_id` = '$user_id'";
                if (!mysqli_query($this->conn, $updateBalanceQuery)) {
                    throw new Exception('Failed to update balance.');
                }
            } else {
                // Insert a new record in `user_balance`
                $insertBalanceQuery = "INSERT INTO `user_balance` (`user_id`, `balance`) VALUES ('$user_id', '$amount')";
                if (!mysqli_query($this->conn, $insertBalanceQuery)) {
                    throw new Exception('Failed to insert balance.');
                }
            }
            $monthlybalanceQuery = "UPDATE `monthly_balance` SET `balance` = `balance`+'$amount'  WHERE `user_id`='$user_id' AND `month`='$month' AND `year` = '$year'";
            if (!mysqli_query($this->conn,  $monthlybalanceQuery)) {
                $error = mysqli_error($this->conn);  // Get the actual error message
                    return ['status' => 'error', 'message' => 'Failed to update balance.', 'error' => $error];
            }
            // Commit transaction
            mysqli_commit($this->conn);
            return ['status' => 'success', 'message' => 'Manual entry added and balance updated successfully'];
        } catch (Exception $e) {
            // Rollback transaction on error
            mysqli_rollback($this->conn);
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $month_num = date('n'); 
        $year = date('Y'); 
        $manualHandle = new ManualHandle($conn);
        $result = $manualHandle->add_monthly($user_id, $_POST['source'], $_POST['amount'],$month_num,$year);

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($result);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    }
}
?>
