<?php
include '_dbconnect.php';
include 'validation.php';

class Analysis extends Validation {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function update_analysis($user_id, $monthvalue,$year) {
        $this->isRequired('User ID', $user_id);
        $this->isNumeric('Amount', $monthvalue);
        $this->isYear('Amount', $year);
        if ($this->hasErrors()) {
            return ['status' => 'error', 'errors' => $this->getErrors()];
        }
        if($monthvalue>0){
            $sql="SELECT category, SUM(price) AS total_spending
                  FROM spanding
                  WHERE MONTH(date) = $monthvalue
                  AND YEAR(date) = $year
                  AND soft_delete = 0
                  AND user_id=$user_id
                  GROUP BY category";
                 
            $result=mysqli_query($this->conn,$sql);
            $non_zero_categories = array();
            
            while($row=mysqli_fetch_assoc($result)) {
                if ($row['total_spending'] > 0) {
                    // Add the category and total spending to the array
                    $non_zero_categories[] = array(
                        'category' => $row['category'],
                        'total_spending' => $row['total_spending']
                    );
                }
            }
            return ['status' => 'success', 'data' => $non_zero_categories];
        }
        elseif($monthvalue==0){
            $sql1="SELECT category, SUM(price) AS total_spending FROM spanding WHERE YEAR(date) = '$year' AND soft_delete = 0 AND user_id = $user_id GROUP BY category";
           
           
      $result1=mysqli_query($this->conn,$sql1);
      $non_zero_categories = array();
      
      while($row=mysqli_fetch_assoc($result1)) {
          if ($row['total_spending'] > 0) {
              // Add the category and total spending to the array
              $non_zero_categories[] = array(
                  'category' => $row['category'],
                  'total_spending' => $row['total_spending']
              );
          }
      }
      return ['status' => 'success', 'data' => $non_zero_categories];
        }
        else{
            return ['status' => 'error', 'errors' => 'analysis failed'];
        }
    }

    
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $user_id = $_SESSION['user_id'];
    $request_value = $_POST['value'];
    list($month_text, $year) = explode(' ', $request_value);
    $valid_months = array('jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec');
    $month_text = strtolower($month_text);
    $month_num ;
    if (in_array($month_text, $valid_months)){
        $month_num = date('m', strtotime($month_text));
    }
    else{
        $month_num = 0;
    }
    $analysis = new Analysis($conn);
    $result = $analysis->update_analysis($user_id,$month_num,$year);

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($result);
}
?>
