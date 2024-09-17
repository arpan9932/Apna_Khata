<?php
include '_dbconnect.php'; // Include your database connection

class MonthlyAddHandler {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function check_and_add_salary($user_id) {
        // Fetch records where the next add date is due
        $query = "SELECT * FROM `monthly_money` WHERE `user_id` = '$user_id' AND `next_add_date` <= CURDATE()";
        $result = mysqli_query($this->conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $amount = $row['amount'];
                $next_add_date = $row['next_add_date'];

                // Add the salary to the user's balance
                $updateQuery = "UPDATE `user_balance` SET `balance` = `balance` + '$amount' WHERE `user_id` = '$user_id'";
                if (!mysqli_query($this->conn, $updateQuery)) {
                    return ['status' => 'error', 'message' => 'Failed to update balance.'];
                }

                // Update the next add date to the next month
                $new_next_add_date = date('Y-m-d', strtotime('+1 month', strtotime($next_add_date)));
                $updateDateQuery = "UPDATE `monthly_money` SET `next_add_date` = '$new_next_add_date' WHERE `user_id` = '$user_id'";
                if (!mysqli_query($this->conn, $updateDateQuery)) {
                    return ['status' => 'error', 'message' => 'Failed to update next add date.'];
                }
            }

            return ['status' => 'success', 'message' => 'Monthly salary added successfully.'];
        } else {
            return ['status' => 'success', 'message' => 'No monthly salary to add yet.'];
        }
    }
}
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $monthlyHandler = new MonthlyAddHandler($conn);
    $result = $monthlyHandler->check_and_add_salary($user_id);
    echo json_encode($result);

}

?>
