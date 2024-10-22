<?php
include '_dbconnect.php';
include 'validation.php';

class Spending extends Validation {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function add_spending($user_id, $amount, $date, $description,$category) {
        $this->isRequired('User ID', $user_id);
        $this->isNumeric('Amount', $amount);
        $this->isRequired('Date', $date);
        $this->isDate('Date', $date);
        $this->isRequired('Description', $description);
        $this->isRequired('category', $category);
        $this->isAlphanumeric('Description', $description);

        if ($this->hasErrors()) {
            return ['status' => 'error', 'errors' => $this->getErrors()];
        }

        $allowedCategories = ['Food', 'Transport', 'Entertainment', 'Utilities', 'Rent', 'Loans', 'Other'];
    if (!in_array($category, $allowedCategories)) {
        // Handle error: invalid category
        return ['status' => 'error', 'errors' => 'please select category from dropdown'];
    }

        $user_id = mysqli_real_escape_string($this->conn, $user_id);
        $amount = mysqli_real_escape_string($this->conn, $amount);
        $date = mysqli_real_escape_string($this->conn, $date);
        $description = mysqli_real_escape_string($this->conn, $description);
        $find_purpose= "SELECT * FROM `spanding` WHERE purpose='$description' and date='$date'";
        $find_purpose_result=mysqli_query($this->conn,$find_purpose);
        $purpose_row=mysqli_fetch_row($find_purpose_result);
        // Insert into spending table
        if($purpose_row==0){
        $query = "INSERT INTO `spanding` (`user_id`, `purpose`, `price`, `date`,`category`) VALUES ('$user_id', '$description', '$amount', '$date','$category')";
        }else{
            return ['status' => 'error', 'errors' => 'purpose alredy there'];
        }
        if (mysqli_query($this->conn, $query)) {
            // Update the total for the day
            $this->update_total_spending($user_id, $date);
            return ['status' => 'success', 'message' => 'Spending added successfully'];
        } else {
            return ['status' => 'error', 'errors' => 'Addition failed. Please try again.'];
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
    $spending = new Spending($conn);
    $result = $spending->add_spending($user_id, $_POST['amount'], $_POST['date'], $_POST['purpose'],$_POST['category']);

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($result);
}
?>
