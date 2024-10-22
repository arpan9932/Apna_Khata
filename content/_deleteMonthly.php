<?php
session_start();  // Start the session
require_once '_dbconnect.php';  // Include the database connection
require_once 'Validation.php';     // Include the validation class

class MonthlyDelete extends Validation{
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function delete_monthly($id,$user_id){
           // Validation
           $this->isRequired('ID', $id);
           $this->isRequired('User ID', $user_id);
           if ($this->hasErrors()) {
            return ['status' => 'error', 'errors' => $this->getErrors()];
        }
        $id=mysqli_real_escape_string($this->conn, $id);
        $user_id = mysqli_real_escape_string($this->conn, $user_id);
        $sql="UPDATE `monthly_money` SET `soft_delete` = '1' WHERE `id` = '$id' AND `user_id`='$user_id'";
         $result=mysqli_query($this->conn,$sql);
         if($result){
            return ['status' => 'success', 'message' => 'Monthly spending delete successfully'];
         }
         else{
            return ['status' => 'error', 'message' => 'Monthly spending not deleted'];
         }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $monthlydelete = new MonthlyDelete($conn); 

        // Correct the '$_POST['date']' typo and call the function
        $result = $monthlydelete->delete_monthly($_POST['id'],$user_id);

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($result);
    } else {
        echo json_encode(['status' => 'error', 'errors' => 'User not logged in']);
    }
}
?>