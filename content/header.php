<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
        <title>Apna Khata</title>
        <link rel="icon" type="image/x-icon" href="images/favicon.ico" />
        <!-- Bootstrap Icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>

        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#page-top" style="color: white;">Apna Khata</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto my-2 my-lg-0">
                        <li class="nav-item"><a class="nav-link" href="#about">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#services">Spend Analysis</a></li>
                        <li class="nav-item"><a class="nav-link" href="#portfolio">History</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    </ul>
                    <?php
                    include '_dbconnect.php';
                    session_start();
                    if(isset($_SESSION['user_id'])){
                        $user_id=$_SESSION['user_id'];
                        $sql="SELECT * FROM `user_balance` WHERE user_id=$user_id";
                        $result=mysqli_query($conn,$sql);
                        $row=mysqli_fetch_assoc($result);
                        echo'<ul class="navbar-nav ms-auto my-2 my-lg-0">
                        <li class="nav-item" style="color: white; font-size: 15px;">'.$_SESSION['name'].'</li>
                        <li class="nav-item"><a class="nav-link" href="#" id="logout">logout</a></li>
                        <li class="nav-item"><a class="nav-link" href="#" id="wallet"><i class="bi bi-wallet2"></i> <span style="margin-left: 5px;"> '.$row['balance'].'</span></a></li>
                    </ul>';
                    }
                    ?>
                </div>
            </div>
        </nav>          
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    </body>
    </html>
