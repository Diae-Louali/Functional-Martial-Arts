<?php
// session_start();
require("MasterPHPFMA.php");    
gestsOnly();

$AccessDenied= "<br>"."<p id='ENTERLOGIN'> Enter your login information.</p>";

if (isset($_POST["submitlogin"])){
    $user = selectOne('user', ['Username' => $_POST['UsernameInput']]);
    echo '<pre>', print_r($user, true) ,'</pre>';
    if ($user && password_verify($_POST['PasswordInput'], $user['Password'])) {
        session_start();
        loginUser($user);
    } else {
        $AccessDenied= "<br>"."<p id='Acessdenied'> Your login information is incorrect."."<br>"." Please try again !</p>";
    }
    
//
    // $req = $conn-> prepare("select * from user where Username = ? and Password = ?");
    // $req->execute(array($_POST["UsernameInput"],$_POST["PasswordInput"]));
    // $data = $req->fetch();
    // if ($req->rowCount()== 1) {
    //     session_start();
    //     $_SESSION["Connected-UserID"]       = $data["Id"];
    //     $_SESSION["Connected-UserFname"]    = $data["Name"];
    //     $_SESSION["Connected-UserLastname"] = $data["Lastname"];
    //     $_SESSION["Connected-UserAge"]      = $data["Age"];
    //     $_SESSION["Connected-UserAddress"]  = $data["Address"];
    //     $_SESSION["Connected-UserEmail"]    = $data["Email"];
    //     $_SESSION["Connected-UserUsername"] = $data["Username"];
    //     $_SESSION["Connected-UserPassword"] = $data["Password"];
    //     $_SESSION["Connected-UserRole"]     = $data["Role"];
    //     $_SESSION["Connected-UserPfp"]      = $data["Image_pfp"];
    //     header("Location:HomeFMA.php");
    //     exit();
    // } else {
    //     $AccessDenied= "<br>"."<p id='Acessdenied'> Your login information is incorrect."."<br>"." Please try again !</p>";
    // }
//
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' href='Css\RegisterLogin.css'>
    <link rel="stylesheet" type="text/css" href="Css\LoginFMA.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!-- FONT FAMILY -->
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

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
        </div>     -->
        <?php include("Includes\Header\NormalNav.php"); ?>
    </head>

    <div class="container ml-lg-5 h-100">
        <div class="d-flex justify-content-center justify-content-md-end h-100 mr-md-5 d-flex">
            <div class="card ml-lg-5 mr-md-5 align-self-center">
                <div class="card-header border-bottom border-danger ">
                    <h3 class="text-center">Sign In</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="" autocomplete="off" >
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text iconbg"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" value="<?php if(isset($_POST["submitlogin"])) {echo $_POST["UsernameInput"];} ?>" class="form-control" name="UsernameInput" placeholder="Username" required>
                            
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text iconbg"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" value="<?php if(isset($_POST["submitlogin"])) {echo $_POST["PasswordInput"];} ?>" id="IDLoginFormPassword" class="form-control border-0" name="PasswordInput" placeholder="Password" required>
                            <span id="Icon-field" class="toggle-password position-absolute"><i id="EYEICON" class="fa fa-fw fa-eye eye-icon-gray"></i></span>
                        </div>
                        <div class="row align-items-center remember float-left pt-2">
                            <input type="checkbox">Remember Me
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submitlogin" value="Log in" class="btn float-right login_btn text-danger">
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
    



<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="Javascript\RegisterLogin.js"></script>

</body>
</html>