<?php
include '_dbconnect.php';
include 'validation.php';

class UpdateBalance extends Validation
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function update_balance($user_id)
    {
        // Validate inputs
        $this->isRequired('User ID', $user_id);

        if ($this->hasErrors()) {
            return ['status' => 'error', 'errors' => $this->getErrors()];
        }

        // Fetch total balance from user_balance table
        $user_balance_query = "SELECT balance FROM `user_balance` WHERE user_id = $user_id";
        $user_balance_query_result = mysqli_query($this->conn, $user_balance_query);
        $user_balance_query_row = mysqli_fetch_assoc($user_balance_query_result);
        $total_balance = $user_balance_query_row['balance'];

        // Fetch total spending from total table
        $total_spending_query = "SELECT SUM(total) AS total_spent FROM total WHERE user_id = $user_id";
        $total_spending_query_result = mysqli_query($this->conn, $total_spending_query);
        $total_spending_query_row = mysqli_fetch_assoc($total_spending_query_result);
        $total_spending = $total_spending_query_row['total_spent'];

        // Calculate remaining balance
        $remaining_balance = $total_balance - $total_spending;

        // Update user balance
        $update_balance = "UPDATE `user_balance` SET `current_balance` = '$remaining_balance' WHERE user_id = $user_id";
        mysqli_query($this->conn, $update_balance);

        return ['status' => 'success', 'balance' => $remaining_balance];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    $updateBalance = new UpdateBalance($conn);
    $result = $updateBalance->update_balance($user_id);

    echo'
    <ul class="navbar-nav ms-auto my-2 my-lg-0">
                        <li class="nav-item"><a class="nav-link homebtn" href="home.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="analysis1.php">Spend Analysis</a></li>
                        <li class="nav-item" ><a class="nav-link historybtn" href="history.php " >History</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    </ul>
                    <ul class="navbar-nav ms-auto my-2 my-lg-0">
                     <li class="nav-item" style="color: white; font-size: 15px;">' . $_SESSION['name'] . '</li>
            <li class="nav-item"><a class="nav-link" href="#" id="logout">logout</a></li>
            <li class="nav-item" id="balance"><a class="nav-link" href="#" id="wallet"><i class="bi bi-wallet2"></i> <span style="margin-left: 5px;">' .$result['balance'].'</span></a></li>
                    </ul>';
           
    }
}
