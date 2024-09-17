<?php
// Database connection
include "_dbconnect.php";
session_start();
// Example user_id and the current month for which you want to fetch data
if(isset($_SESSION['user_id'])){
$user_id = $_SESSION['user_id'];
$current_month_start = date('Y-m-01');  // First day of the current month
$current_month_end = date('Y-m-t');     // Last day of the current month

// Fetch purposes and prices for the entire month
$sql = "SELECT date,purpose,price FROM spanding WHERE user_id=? AND date BETWEEN ? AND ? ORDER BY date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $user_id, $current_month_start, $current_month_end);
$stmt->execute();
$result = $stmt->get_result();

// Initialize an array to group purposes by date
$data_by_date = [];
$total_by_date = [];
while ($row = $result->fetch_assoc()) {
    $date = $row['date'];
    $data_by_date[$date][] = [
        'purpose' => $row['purpose'],
        'price' => $row['price']
    ];
    if (!isset($total_by_date[$date])) {
      $total_by_date[$date] = 0;
  }
  $total_by_date[$date] += $row['price'];
}

// Output the table header
echo '
<thead>
  <tr>
    <th scope="col">SNo</th>
    <th scope="col">Date</th>
    <th scope="col">Purpose</th>
    <th scope="col">Amount</th>
    <th scope="col"></th>
    <th scope="col"></th>
  </tr>
</thead>
<tbody>';

$sno = 1;
// Loop through each date and display the purposes in the dropdown
foreach ($data_by_date as $date => $purposes) {
    // Total amount for this date
    $totalAmount = $total_by_date[$date];

    echo '
    <tr>
      <th scope="row">' . $sno . '</th>
      <td>' . date('d-m-Y', strtotime($date)) . '</td>
      <td>
        <select class="purpose-dropdown" data-date="' . $date . '">
            <!-- First option shows the total amount -->
            <option value="total" data-price="' . $totalAmount . '">Total</option>';

    // Populate the dropdown with purposes for this specific date
    foreach ($purposes as $purpose) {
        echo '<option value="' . $purpose['purpose'] . '" data-price="' . $purpose['price'] . '">' . $purpose['purpose'] . '</option>';
    }

    echo '
        </select>
      </td>
      <td class="amount" id="amount-' . $sno . '">' . $totalAmount . '</td>
      <td><i class="bi bi-pencil-square"></i></td>
      <td><i class="bi bi-info-circle"></i></td>
    </tr>';
    $sno++;
}

echo '</tbody>';

// Close the database connection
$conn->close();
}
?>
