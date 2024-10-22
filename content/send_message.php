<?php
session_start();  // Start the session
require '../vendor/autoload.php'; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form inputs
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    //Create an instance of PHPMailer
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                          
        $mail->Host       = 'smtp.gmail.com';                      
        $mail->SMTPAuth   = true;                                 
        $mail->Username   = 'arpan79dream@gmail.com';              
        $mail->Password   = 'fjhd jzsl luzw rpwe';                 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     
        $mail->Port       = 587;    

        $app_name="Apna Khata";
        $mail->setFrom($email, $app_name);  
        $mail->addAddress('arpanbera7407@gmail.com');   
        $mail->isHTML(true);       
        $mail->Subject = $subject; 
        $mail->Body    = "A new comment from <strong>$name</strong><br>
                          Email: <strong>$email</strong><br>
                          Subject: <strong>$subject</strong><br>
                          Message:<br><p>$message</p>";
                          
        // Plain text version for email clients that do not support HTML
        $mail->AltBody = "A new comment from $name\nEmail: $email\nSubject: $subject\nMessage: $message";

        // Send the email
        if ($mail->send()) {
            $_SESSION['status'] = 'success';  // Store the success status in the session
        } else {
            $_SESSION['status'] = 'error';    // Store the error status in the session
        }
        header("Location: ../contact.php");  // Redirect to contact.php
        exit();
    } catch (Exception $e) {
        $_SESSION['status'] = 'error';
        header("Location: ../contact.php");
    }
} else {
    header("Location: ../contact.php");
}
?>