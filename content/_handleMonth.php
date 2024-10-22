<?php
include '_dbconnect.php';
// Get the current date
$currentDate = new DateTime();
session_start();
$user_id = $_SESSION['user_id'];
// Get the current year
$currentYear = $currentDate->format('Y');

// Array to hold the options
$options = [];

// Loop to get the last 4 months, including the current month
for ($i = 0; $i <= 3; $i++) {
    // Subtract months from the current date
    $date = (clone $currentDate)->modify("-$i month");
    
    // Get the abbreviated month (e.g., Oct) and year
    $month = $date->format('M'); // Abbreviated month name (e.g., Oct)
    $month_num = date('m', strtotime($month));
    $sql="SELECT *
                  FROM spanding
                  WHERE MONTH(date) = $month_num
                  AND YEAR(date) = $currentYear
                  AND soft_delete = 0
                  AND user_id=$user_id";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)){
    // Create an option array for each month with specific values
    $options[] = [
        'value' =>"$month $currentYear", 
        'text' => "$month $currentYear" // Format: "Month Year"
    ];
}
}

// Add the current year as the last option with a value of 5
$options[] = [
    'value' => "all ".(string)$currentYear , // Value for the current year
    'text' => (string)$currentYear // Current year as text
];

// Create a response array
$response = [
    'status' => 'success', // You can set this based on your logic
    'message' => 'Options retrieved successfully',
    'options' => $options // Include the options in the response
];

// Return the response array as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
