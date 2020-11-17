<div id="LoginModal" class="FATHER-CONTAINER modal fade m-auto w-100 h-100">
    <div class="login-modal-container loginCard m-auto" style="overflow: hidden;">
        <div class="m-auto modal-dialog">
            <div class="card card modal-content">
                <div class=" justify-content-center card-header border-bottom border-danger card-header modal-header">
                    <h3 class="text-center modal-title">SIGN IN</h3>
                    <a href="#/" class="float-right mr-1 close" data-dismiss="modal"></a>
                    <!-- <div class="d-flex justify-content-end social_icon">
                        <span><i class="fab fa-facebook-square"></i></span>
                        <span><i class="fab fa-google-plus-square"></i></span>
                        <span><i class="fab fa-twitter-square"></i></span>
                    </div> -->
                </div>
                <div class="card-body modal-body">
                    <form method="POST" action="" autocomplete="off" >
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text iconbg"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" value="<?php if(isset($_POST["submitlogin"])) {echo $_POST["UsernameInput"];} ?>" class="form-control" name="UsernameInput" placeholder="Username" required autofocus>
                            
                        </div>
                        <div class="input-group form-group position-relative">
                            <div class="input-group-prepend">
                                <span class="input-group-text iconbg"><i class="fas fa-key"></i></span>
                            </div>
                            <input id="IDLoginFormPassword" class="form-control border-0" type="password" value="<?php if(isset($_POST["submitlogin"])) {echo $_POST["PasswordInput"];} ?>"  name="PasswordInput" placeholder="Password" required>
                            <span id="Icon-field" class="toggle-password position-absolute"><i id="EYEICON" class="fa fa-fw fa-eye eye-icon-gray"></i></span>
                        </div>
                        <div class="row align-items-center remember float-left pt-2 text-danger">
                            <input type="checkbox">Remember Me
                        </div>
                        <div class="form-group button-message-wrapper">
                            <input type="submit" name="submitlogin" value="Log in" class="btn login_btn text-danger">
                            <?php echo $AccessDenied; ?>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        <span>Don't have an account?<a href="#" class="text-danger">Sign Up</a></span> 
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="#" class="text-danger">Forgot your password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
