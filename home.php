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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <style>
        .container {
            max-width: 600px;
        }

        .expense-item {
            margin-bottom: 15px;
        }

        .bg {
            background: transparent !important;
        }

        input {
            background: transparent !important;
        }

        ::placeholder {
            color: white;
            opacity: 1;
        }
    </style>
</head>

<body>
    <?php include "content/header.php";?>
    <header class="masthead">
        <div class="text-center my-4">
        </div>
            <div class="container p-4 rounded">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-6 bg">
                        <input type="text" id="purpose" class="form-control" style="color: white;"
                            placeholder="Write here your purpose...">
                    </div>
                    <div class="col-md-2 bg">
                        <input type="number" id="amount" class="form-control" placeholder="Amount" style="color: white;">
                    </div>
                    <div class="col-md-2 bg">
                        <input type="date" id="mydate" class="form-control" style="color: white;">
                    </div>
                    <div class="col-md-2 text-center">
                        <button id="add" class="btn btn-primary w-100">Add</button>
                    </div>
                </div>
            </div>
        <hr>
        <main class="container my-4">
        <div class="container">
        <table class="table " id="myTable">
        </table>
        </div>
    </main>
    </header>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="JQuery/jq.js"></script>
    
</body>

</html>
