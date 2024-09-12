<div class="modal fade" id="loginmodal" tabindex="-1" role="dialog" aria-labelledby="loginmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginmodalLabel">Sign In</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4 p-md-5">
                    <form  class="login-form" id="login-form">
                        <div class="form-group p-3">
                            <input type="email" class="form-control rounded-left" placeholder="Email" name="email">
                        </div>
                        <div class="form-group d-flex p-3">
                            <input type="password" class="form-control rounded-left" placeholder="Password" name="password">
                        </div>
                        <div class="form-group p-3">
                            <button type="submit" class="form-control btn btn-primary rounded submit px-3" form="login-form">Login</button>
                        </div>
                        <div class="form-group d-md-flex p-3">
                            <div class="text-md-right">
                                <a href="#">Forgot Password</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <p>Not a member? <a href="" data-toggle='modal' data-target='#registermodal' id='registerbtn'>Create an account</a></p>
                </div>
            </div>
        </div>
    </div>