<?php
include_once 'content/Auth.php';
$auth = new Auth();
$auth->protectPage();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Apna Khata</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic"
        rel="stylesheet" type="text/css" />
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/contact.css">
    <style>
        .form-group{
            margin-bottom: 2rem;
        }
    </style>

</head>

<body>
    <?php include "content/header.php"; ?>
    <header class="masthead">
    <?php
if (isset($_SESSION['status'])) {
    if ($_SESSION['status'] == 'success') {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>Your message has been sent successfully!</div>";
    } elseif ($_SESSION['status'] == 'error') {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Sorry, there was an error sending your message. Please try again later.</div>";
    }
    unset($_SESSION['status']);  // Clear the status message after displaying it
}
?>
        <div class="text-center my-4">
        </div>
        <div class="container p-4 rounded" style="width: 40%;">
            <div class="row justify-content-center align-items-center">

                <div class="contact">
                <form class="form" name="enq" method="post" action="content/send_message.php">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="Name" required="required">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="email" name="email" class="form-control" placeholder="Email" required="required">
                            </div>
                            <div class="form-group col-md-12">
                                <input type="text" name="subject" class="form-control" placeholder="Subject" required="required">
                            </div>
                            <div class="form-group col-md-12">
                                <textarea rows="6" name="message" class="form-control" placeholder="Your Message" required="required"></textarea>
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="submit" value="Send message" name="submit" id="submitButton" class="btn btn-contact-bg btn-primary"  title="Submit Your Message!">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </header>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="JQuery/jq.js"></script>
    <script>
        loadtable();
    </script>
<script>
    $(document).ready(function() {
        // Hide the alert after 5 seconds
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
    });
</script>

</body>

</html>