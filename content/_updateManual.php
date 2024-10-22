<?php
include '_dbconnect.php'; // Include your database connection file
include 'validation.php'; // Include your validation class

class Manualedit extends Validation{
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function edit_manual($id,$user_id, $source, $amount){
          // Validation
          $this->isRequired('ID', $id);
          $this->isRequired('User ID', $user_id);
          $this->isNumeric('Amount', $amount);
          $this->isRequired('Source', $source);
          $this->isAlphanumeric('Source', $source);

          if ($this->hasErrors()) {
            return ['status' => 'error', 'errors' => $this->getErrors()];
        }
          $id=mysqli_real_escape_string($this->conn, $id);
          $user_id = mysqli_real_escape_string($this->conn, $user_id);
          $source = mysqli_real_escape_string($this->conn, $source);
          $amount = mysqli_real_escape_string($this->conn, $amount);
          
         $sql="UPDATE `manual_money` SET `source`='$source', `amount`='$amount' WHERE `id`='$id' AND `user_id`='$user_id'";
         $result=mysqli_query($this->conn,$sql);
         if($result){
            return ['status' => 'success', 'message' => 'Monthly spending edit successfully'];
         }
         else{
            return ['status' => 'error', 'message' => 'Monthly spending not edited'];
         }
    }   
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $manualedit = new Manualedit($conn); 

        // Correct the '$_POST['date']' typo and call the function
        $result = $manualedit->edit_manual($_POST['id'],$user_id, $_POST['source'], $_POST['amount']);

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($result);
    } else {
        echo json_encode(['status' => 'error', 'errors' => 'User not logged in']);
    }
}

?>
