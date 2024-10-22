<?php
include_once 'Auth.php';
$auth=new Auth();
$auth->protectPage();
echo'
    <style>

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



        <div class="text-center my-4">
        </div>
            <div class="container p-4 rounded">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-4 bg">
                        <input type="text" id="purpose" class="form-control" style="color: white;"
                            placeholder="Write here your purpose...">
                    </div>
                      <div class="col-md-2 bg">
                    <select id="category" class="form-control">
                        <option disabled selected>Select category</option>
                        <option value="Food">Food</option>
                        <option value="Transport">Transport</option>
                        <option value="Entertainment">Entertainment</option>
                        <option value="Utilities">Utilities</option>
                        <option value="Rent">Rent</option>
                        <option value="Loans">Loans</option>
                        <option value="Other">Other</option>
                    </select>
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
    </header>';
    

    


    ?>