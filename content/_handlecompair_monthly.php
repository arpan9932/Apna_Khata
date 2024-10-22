<?php
include '_dbconnect.php';
include 'validation.php';

class MonthlyCompaire extends Validation {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function update_month_compaire($user_id, $month, $year) {
        $this->isRequired('User ID', $user_id);
        $this->isYear('Amount', $year);

        if ($this->hasErrors()) {
            return ['status' => 'error', 'errors' => $this->getErrors()];
        }

        if ($month > 0) {
            // SQL query to fetch balance and spending for the last 5 months excluding the current month
            $sql = "SELECT b.month, b.year, b.balance, IFNULL(SUM(s.price), 0) AS total_spending
                    FROM monthly_balance AS b
                    LEFT JOIN spanding AS s 
                    ON b.user_id = s.user_id 
                    AND b.month = MONTH(s.date)
                    AND b.year = YEAR(s.date)
                    WHERE b.user_id = $user_id
                    AND (b.year < $year OR (b.year = $year AND b.month < $month))
                    GROUP BY b.month, b.year, b.balance
                    ORDER BY b.year DESC, b.month DESC
                    LIMIT 5";

            $result = mysqli_query($this->conn, $sql);

            $spending_data = [];
            $balance_data = [];
            $months = [];
            $max_balance = 0;

            $short_month_names = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            // Fetch the results
            while ($row = mysqli_fetch_assoc($result)) {
                $balance_data[] = $row['balance'];
                $spending_data[] = $row['total_spending'];
                $months[] = $short_month_names[$row['month'] - 1]; // Get the short month name

                // Find the maximum balance
                if ($row['balance'] > $max_balance) {
                    $max_balance = $row['balance'];
                }
            }

            return [
                'status' => 'success', 
                'spending_data' => $spending_data, 
                'balance_data' => $balance_data, 
                'months' => $months, 
                'max_balance' => $max_balance
            ];

        } else {
            return ['status' => 'error', 'errors' => 'Analysis failed'];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $user_id = $_SESSION['user_id'];
    $currentYear = date("Y");
    $currentMonth = date("m");
    $MonthlyCompaire = new MonthlyCompaire($conn);
    $result = $MonthlyCompaire->update_month_compaire($user_id, $currentMonth, $currentYear);

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($result);
}
