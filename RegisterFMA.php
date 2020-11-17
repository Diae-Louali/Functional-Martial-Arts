<?php
session_start();
require('MasterPHPFMA.php');
gestsOnly();

$errorMsg="";
if (isset($_POST['submitRegister'])) {
    $existingEmail = selectOne('user', ['Email'=>$_POST['Email']]);
    if (is_array($existingEmail) < 1) {
        unset($_POST['submitRegister']);
        $_POST['Password'] = password_hash($_POST['Password'], PASSWORD_DEFAULT);
        $user_id = create('user', $_POST);
        $user = selectOne('user', ['Id'=> $user_id]);
        header('Location: LoginFMA.php');
        exit();
    } else {        
        $errorMsg = "<div class='alert alert-danger w-75 text-center p-0  m-0 position-absolute error-alert' role='alert'><span class='position-relative h-100'><i class='fas fa-caret-up position-absolute'></i></span>'This Email already exists'</div>";
    }
}
?>

<link href='//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css' rel='stylesheet' id='bootstrap-css'>
<script src='//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js'></script>
<script src='//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>


<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' type='text/css' href='Css\RegisterLogin.css'>
    <link rel='stylesheet' type='text/css' href='Css\RegisterFMA.css'>
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' integrity='sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh' crossorigin='anonymous'>
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.3.1/css/all.css' integrity='sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU' crossorigin='anonymous'>
    <title>F.M.A</title>        
</head>
<body>
    <head> 
        <!-- <div id='HEADERNavbar' class='MasterContainer'>
            <nav id='navbar' class='navbar'>
                <div id='BRANDcontainer' class=' BrandFMA d-flex flex-column vlhrparent justify-content-center'>
                    <div id='MaindivBRAND' class='d-flex align-items-center h-100'>
                        <div class='vlBRAND pr-xl-5 pr-lg-4 pr-md-3 pr-sm-2'></div>
                        <img src='Images\FunctionalMartialArtsLOGO.png' class='rounded-circle' alt=''>
                        <a class='pr-xl-5 pr-lg-4 pr-md-3 pr-sm-2' href='HomeFMA.php'>FMA</a>
                        <div class='vlBRAND'></div>
                    </div>
                    <div id='HrDivBRAND' class='d-flex justify-content-center position-relative'>
                        <hr class='hrBRAND position-absolute'>
                    </div>                                 
                </div>
                <a href='#/' id='HAMBURGER' class='toggle-button mt-2'>
                    <span class='bar'></span>
                    <span class='bar'></span>
                    <span class='bar'></span>
                </a>
                <div id='NAV-LINKS' class='navbar-links'>
                    <ul>
                        <li class='d-flex vlhrparent'>
                            <div class='vl'></div>
                            <div class='Adiv d-flex flex-column'><a href='ArticleFMA.php'> Article</a><hr class='align-self-center'></div>
                            <div class='vl pr-xl-4 pr-lg-3 pr-md-2'></div>
                        </li>
                        <li class='d-flex vlhrparent'>
                            <div class='vl'></div>
                            <div class='Adiv d-flex flex-column'><a href='AboutFMA.php'> About</a><hr class='align-self-center'></div>
                            <div class='vl pr-xl-4 pr-lg-3 pr-md-2'></div>
                        </li>
                        <li class='d-flex vlhrparent'>
                            <div class='vl'></div>
                            <div class='Adiv d-flex flex-column'><a href='ContactFMA.php'> Contact</a><hr class='align-self-center'></div>
                            <div class='vl pr-xl-4 pr-lg-3 pr-md-2'></div>
                        </li>
                        <li class='d-flex vlhrparent'>
                            <div class='vl'></div>
                            <div class='Adiv d-flex flex-column'><a href='LoginFMA.php'> Sign in</a><hr class='align-self-center'></div>
                            <div class='vl pr-xl-4 pr-lg-3 pr-md-2'></div>
                        </li>
                        <li class='d-flex vlhrparent'>
                            <div class='vl'></div>
                            <div class='Adiv d-flex flex-column'><a href='RegisterFMA.php'> Register</a><hr class='align-self-center'></div>
                            <div class='vl pr-xl-4 pr-lg-3 pr-md-2'></div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>-->           
        <?php include('Includes\Header\NormalNav.php'); ?>

    </head>

<div class='container mr-lg-5'>
    <div class='d-flex justify-content-center justify-content-md-end h-100 mr-md-5'>
        <div class='card ml-lg-5 mr-md-5'>
            <div class='card-header border-bottom border-danger'>
                <h3 class='text-center'>Register</h3>
            </div>
            <div class='card-body'>
                <form method='post' action='RegisterFMA.php'>
                    <div class='input-group form-group float-left w-50 pr-2'>
                        <div class='input-group-prepend'>
                            <span class='input-group-text iconbg'><i class='fas fa-id-badge'></i></span>
                        </div>
                        <input type='text' value='' class='form-control' name='Name' placeholder='Name'>                     
                    </div>
                    <div class='input-group form-group float-right w-50 pl-2'>
                        <div class='input-group-prepend'>
                            <span class='input-group-text iconbg'><i class='fas fa-id-card'></i></span>
                        </div>
                        <input type='text' value='' class='form-control' name='Lastname' placeholder='Lastname'>                     
                    </div>
                    <div class='input-group form-group float-left w-75 pr-5 position-relative'>
                        <div class='input-group-prepend '>
                            <span class='input-group-text iconbg'><i class='fas fa-envelope'></i></span>
                        </div>
                        <input type='email' value='' class='form-control' name='Email' placeholder='Email' required>
                        <?php echo $errorMsg ?>
                    </div>
                    <div class='input-group form-group float-left w-25'>
                        <div class='input-group-prepend'>
                            <span class='input-group-text iconbg'><i class='fas fa-birthday-cake'></i></span>
                        </div>
                        <input type='number' value='' class='form-control' name='Age' placeholder='Age'>                     
                    </div>
                    <div class='input-group form-group float-left w-50 pr-2'>
                        <div class='input-group-prepend'>
                            <span class='input-group-text iconbg'><i class='fas fa-user'></i></span>
                        </div>
                        <input type='text' value='' class='form-control' name='Username' placeholder='Username' required>                     
                    </div>
                    <div class='input-group form-group float-right w-50 pl-2'>
                        <div class='input-group-prepend'>
                            <span class='input-group-text iconbg'><i class='fas fa-key'></i></span>
                        </div>
                        <input type='password' value='' id='IDLoginFormPassword' class='form-control border-0' name='Password' placeholder='Password' required>
                        <span id='Icon-field' class='toggle-password position-absolute'><i id='EYEICON' class='fa fa-fw fa-eye eye-icon-gray'></i></span>
                    </div>
                    <div class='input-group form-group'>
                        <div class='input-group-prepend'>
                            <span class='input-group-text iconbg'><i class='fas fa-map-marker-alt'></i></span>
                        </div>
                        <input type='text' value='' class='form-control' name='Address' placeholder='Address'>
                    </div>

                    <div class='row align-items-center remember float-left pt-2 ml-2'>
                        <input type='checkbox'>Subscribe to our Newsteller
                    </div>
                    <div class='form-group'>
                        <input type='submit' name='submitRegister' value='Register' class='btn float-right login_btn text-danger mr-4'>
                    </div>
                </form>
            </div>
            <div class='card-footer'>
                <div class='d-flex justify-content-center links'>
                    <span>Already have an account ?<a href='#' class='text-danger'>Sign in here !</a></span> 
                </div>
                <div class='d-flex justify-content-center'>
                    <a href='#' class='text-danger'>Want to know more about us ?</a>
                </div>
            </div>
        </div>
    </div>
</div>
    



<script src='https://code.jquery.com/jquery-3.4.1.slim.min.js' integrity='sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n' crossorigin='anonymous'></script>
<script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js' integrity='sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo' crossorigin='anonymous'></script>
<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js' integrity='sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6' crossorigin='anonymous'></script>
<script src='//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js'></script>
<script src='//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script src="Javascript\RegisterLogin.Js"></script>


</body>
</html>