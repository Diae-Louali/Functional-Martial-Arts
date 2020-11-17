<?php 
require("MasterPHPFMA.php");

// if (isset($_POST[])) {
//     # code...
// }



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <title>F.M.A</title>        
</head>
<body class="vh-100 d-flex justify-content-center">

    <div class="container  row h-100 p-0">
        <div class="d-flex justify-content-center col-12 p-0">
            <div class="card align-self-center col-xl-4 col-lg-5 col-md-6 col-8 p-0 shadow-lg ">
                <div class="card-header border-bottom border-danger">
                    <h3 class="text-center">Reset your Password</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="" autocomplete="off" >
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text iconbg"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" value="" class="form-control" name="EmailInput" placeholder="Enter your email . . ." required>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text iconbg"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" value="<?php if(isset($_POST["submit-pass-reset"])) {echo $_POST["New-Password-Input"];} ?>" class="form-control" name="New-Password-Input" placeholder="New Password" required>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text iconbg"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" value="<?php if(isset($_POST["submit-pass-reset"])) {echo $_POST["Conf-Password-Input"];} ?>" class="form-control" name="Conf-Password-Input" placeholder="Confirm Password" required>
                        </div>
                        <div class="form-group m-0">
                            <input type="submit" name="submit-pass-reset" value="Reset" class="btn bg-danger text-white login_btn w-100">
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        <span>Remember your password?</span>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="#" class="text-danger">Sign in</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>