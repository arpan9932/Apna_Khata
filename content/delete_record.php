<?php
session_start();  // Start the session
require_once '_dbconnect.php';  // Include the database connection
require_once 'Validation.php';     // Include the validation class

class DeleteRecord extends Validation{
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function delete_record($date,$user_id){
           // Validation
           $this->isRequired('User ID', $user_id);
           $this->isDate('Date', $date);
           if ($this->hasErrors()) {
            return ['status' => 'error', 'errors' => $this->getErrors()];
        }
        
        $sql="UPDATE `spanding` SET `soft_delete` = '1' WHERE `date` = '$date' AND `user_id`='$user_id'";
         $result=mysqli_query($this->conn,$sql);

         $sql1="UPDATE `total` SET `total` = '0' WHERE `date` = '$date' AND `user_id`='$user_id'";
         $result1=mysqli_query($this->conn,$sql1);

         if($result&&$result1){
            return ['status' => 'success', 'message' => 'spending delete successfully'];
         }
         else{
            return ['status' => 'error', 'message' => 'spending not deleted'];
         }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $deletedata = new DeleteRecord($conn); 

        // Correct the '$_POST['date']' typo and call the function
        $result = $deletedata->delete_record($_POST['date'],$user_id);

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($result);
    } else {
        echo json_encode(['status' => 'error', 'errors' => 'User not logged in']);
    }
}
?>