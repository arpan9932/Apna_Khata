<?php
include '_dbconnect.php'; // Include your database connection

class MonthlyBalancehandaler {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function check_and_add_balance($user_id,$month_num,$year) {
        // Fetch records where the next add date is due
        $query = "SELECT * FROM `monthly_balance` WHERE `user_id` = '$user_id' AND `month` = '$month_num' AND `year`='$year'";
        $result = mysqli_query($this->conn, $query);

        if (mysqli_num_rows($result) == 0) {
                $fetch_balance="SELECT current_balance FROM `user_balance` WHERE user_id='$user_id'";
                $fetch_result=mysqli_query($this->conn,$fetch_balance);
                $balance=mysqli_fetch_assoc($fetch_result);
                $current_balance=$balance['current_balance'];
                $createQuery = "INSERT INTO `monthly_balance` (`user_id`, `month`, `year`, `balance`) VALUES ('$user_id', '$month_num', '$year', '$current_balance')";
                mysqli_query($this->conn,$createQuery);
            return ['status' => 'success', 'message' => 'Monthly balance added successfully.'];
        } else {
            return ['status' => 'error', 'message' => 'No monthly balance to add yet.'];
        }
    }
}
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $month_num = date('n'); 
    $year = date('Y'); 
    $monthlyBalanceHandler = new MonthlyBalancehandaler($conn);
    $result = $monthlyBalanceHandler->check_and_add_balance($user_id, $month_num,$year); 
    echo json_encode($result);

}

?>
