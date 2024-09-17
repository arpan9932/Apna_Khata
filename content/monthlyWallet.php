<div class="modal fade" id="monthlyWallet" tabindex="-1" role="dialog" aria-labelledby="registermodalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <ul class="nav nav-tabs w-100">
                    <li class="nav-item" style="width: 50%; text-align: center;">
                        <a class="nav-link active" href="" data-toggle="tab">Monthly</a>
                    </li>
                    <li class="nav-item" style="width: 50%; text-align: center;">
                        <a class="nav-link" href="" data-toggle="tab" id="manual-btn">Manual</a>
                    </li>
                </ul>
            </div>
            <div class="modal-body p-4 p-md-5">
                    <form class="monthly-form" method="post" id="monthly-form">
                        <div class="form-group p-3">
                            <input type="text" class="form-control rounded-left" placeholder="Source" name="source">
                        </div>
                        <div class="form-group p-3">
                            <input type="number" class="form-control rounded-left" placeholder="Amount" name="amount">
                        </div>
                        <div class="form-group p-3">
                            <input type="date" class="form-control rounded-left" placeholder="date" name="date">
                        </div>
                        <div class="form-group p-3">
                            <button type="submit" class="form-control btn btn-primary rounded submit px-3" form="monthly-form">Submit</button>
                        </div>
                    </form>
                    <div class="container">
                        <table class="table">
                        <tbody>
                        <?php
                        include '_dbconnect.php';
                        session_start();
                        $user_id=$_SESSION['user_id'];
                        $sql="SELECT * FROM `monthly_money` WHERE user_id=$user_id";
                        $result=mysqli_query($conn,$sql);
                        while($row=mysqli_fetch_assoc($result)){
                        echo'
                        <tr>
                            <td style="color: black;">'.$row["source"].'</td>
                            <td style="color: black;">'.$row["amount"].'</td>
                            <td style="color: black;"><i class="bi bi-pencil-square"></i></td>
                            <td style="color: black;"><i class="bi bi-trash3-fill"></i></td>
                        </tr>';
                        }
                        ?>
                      </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</div>