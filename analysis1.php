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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Apna Khata</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico" />
    <!-- Bootstrap Icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/charts/chart-4/assets/css/chart-4.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="js/chart-4.js"></script>
    <link rel="stylesheet" href="css/button.css">

</head>

<body>
    <?php include_once "content/header.php";
    ?>

    <!-- Masthead-->
    <header class="masthead">
        <section class="py-1 py-md-3">
            <div class="container">
                <div class="row justify-content-center">
                <div class="col-3 col-lg-4 col-xl-3 col-xxl-2">  </div>
                    <div class="col-6 col-lg-4 col-xl-6 col-xxl-7">
                        <div class="card widget-card border-light shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-block d-sm-flex align-items-center justify-content-between mb-3">
                                    <div class="mb-3 mb-sm-0">
                                        <h5 class="card-title widget-card-title">Monthly Expenditure</h5>
                                    </div>
                                    <div>
                                        <select id="dynamicSelect" class="form-select text-secondary border-light-subtle dynamicSelect">
                                            
                                        </select>
                                    </div>
                                </div>
                                <div id="bsb-chart-4"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 col-lg-4 col-xl-3 col-xxl-3" style="display:flex; justify-content: space-around;">
                    <a href="analysis2.php"><button class=" button-17" role="button" >Compare IE</button></a>
                </div>
            </div>
        </section>
    </header>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="JQuery/jq.js"></script>
</body>

</html>