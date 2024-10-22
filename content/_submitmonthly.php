<?php
include '_dbconnect.php'; // Include your database connection file
include 'validation.php'; // Include your validation class

class MonthlyHandle extends Validation {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function add_monthly($user_id, $source, $amount, $date) {
        // Validation
        $this->isRequired('User ID', $user_id);
        $this->isNumeric('Amount', $amount);
        $this->isRequired('Source', $source);
        $this->isAlphanumeric('Source', $source);
        $this->isRequired('Date', $date); // Check if date is provided
        $this->isDate('Date', $date);     // Validate date format

        if ($this->hasErrors()) {
            return ['status' => 'error', 'errors' => $this->getErrors()];
        }

        // Escape input data
        $user_id = mysqli_real_escape_string($this->conn, $user_id);
        $source = mysqli_real_escape_string($this->conn, $source);
        $amount = mysqli_real_escape_string($this->conn, $amount);
        $current_date = mysqli_real_escape_string($this->conn, $date); // Use the provided date

        // Calculate the next add date based on the provided date
        $next_add_date = date('Y-m-d', strtotime('+1 month', strtotime($current_date)));
        $month = date('m', strtotime($current_date)); 
        $year = date('Y', strtotime($current_date)); 

        // Start transaction
        mysqli_begin_transaction($this->conn);

        try {
            // Insert the monthly spending into the `monthly_money` table
            $query = "INSERT INTO `monthly_money` (`user_id`, `source`, `amount`, `datetime`, `next_add_date`) 
                      VALUES ('$user_id', '$source', '$amount', '$current_date', '$next_add_date')";

            if (!mysqli_query($this->conn, $query)) {
                throw new Exception('Failed to add spending.');
            }

            // Insert or update balance in `user_balance` table
            // Check if the user already has a record in the `user_balance` table
            $balanceQuery = "SELECT * FROM `user_balance` WHERE `user_id` = '$user_id'";
            $balanceResult = mysqli_query($this->conn, $balanceQuery);
          
            if (mysqli_num_rows($balanceResult) > 0) {
                $row=mysqli_fetch_assoc($balanceResult);
                $oldbalance=$row['balance'];
                // Update the existing balance
                $updateBalanceQuery = "UPDATE `user_balance` SET `balance` = $oldbalance+'$amount' WHERE `user_id` = '$user_id'";
                if (!mysqli_query($this->conn, $updateBalanceQuery)) {
                    throw new Exception('Failed to update balance.');
                }
                $check_month_balance="SELECT * FROM `monthly_balance` WHERE `user_id`='$user_id' AND `month`='$month' AND `year` = '$year' ";
                $res1=mysqli_query($this->conn,$check_month_balance);
                if(mysqli_fetch_row($res1)){
                $updateMonthlyQuery="UPDATE `monthly_balance` SET `balance` = `balance`+'$amount'  WHERE `user_id`='$user_id' AND `month`='$month' AND `year` = '$year' ";
                if (!mysqli_query($this->conn, $updateMonthlyQuery)) {
                    throw new Exception('Failed to update monthly balance.');
                }
            }else{
                $insertMonthlyQuery="INSERT INTO `monthly_balance` (`user_id`, `month`, `year`, `balance`) VALUES ('$user_id', '$month', '$year', '$amount') ";
                if (!mysqli_query($this->conn, $insertMonthlyQuery)) {
                    throw new Exception('Failed to add monthly balance.');
                }
            }
            } else {
                // Insert a new record in `user_balance`
                $insertBalanceQuery = "INSERT INTO `user_balance` (`user_id`, `balance`) VALUES ('$user_id', '$amount')";
                if (!mysqli_query($this->conn, $insertBalanceQuery)) {
                    throw new Exception('Failed to insert balance.');
                }
            }

            // Commit transaction
            mysqli_commit($this->conn);
            return ['status' => 'success', 'message' => 'Monthly spending added and balance updated successfully'];
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
        $monthlyHandle = new MonthlyHandle($conn);

        // Correct the '$_POST['date']' typo and call the function
        $result = $monthlyHandle->add_monthly($user_id, $_POST['source'], $_POST['amount'], $_POST['date']);

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($result);
    } else {
        echo json_encode(['status' => 'error', 'errors' => 'User not logged in']);
    }
}
?>
