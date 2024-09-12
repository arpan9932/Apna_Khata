<div class="modal fade" id="registermodal" tabindex="-1" role="dialog" aria-labelledby="registermodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registermodalLabel">Sign Up</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4 p-md-5">
                    <form class="register-form" method="post" id="register-form">
                        <div class="form-group p-3">
                            <input type="text" class="form-control rounded-left" placeholder="Name" name="Name">
                        </div>
                        <div class="form-group p-3">
                            <input type="email" class="form-control rounded-left" placeholder="Email" name="Email">
                        </div>
                        <div class="form-group d-flex p-3">
                            <input type="password" class="form-control rounded-left" placeholder="Password" name="password1">
                        </div>
                        <div class="form-group d-flex p-3">
                            <input type="password" class="form-control rounded-left" placeholder="Confirm Password" name="password2">
                        </div>
                        <div class="form-group p-3">
                            <button type="submit" class="form-control btn btn-primary rounded submit px-3" form="register-form">Register</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <p>Already a member? <a href="" data-toggle='modal' data-target='#loginmodal' id='login-btn'>Sign In</a></p>
                </div>
            </div>
        </div>
    </div>