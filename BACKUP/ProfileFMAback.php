<?php
require("MasterPHPFMA.php");    
session_start();

if (!isset($_SESSION["Connected-UserID"])) {
    echo "YOU ARE NOT CONNECTED";
    echo $_SESSION["Connected-UserID"];

    // header("Location:LoginFMA.php");
    }else {
    echo "YOU ARE CONNECTED";
    echo $_SESSION["Connected-UserID"];

}

$pfp="Icon\iconfinder-pfp.svg";

if (isset($_POST["submitPFP"])){
    $file = $_FILES["filePFP"];
    $fileName = $_FILES["filePFP"]["name"];
    $fileTmpName = $_FILES["filePFP"]["tmp_name"];
    $fileSize = $_FILES["filePFP"]["size"];
    $fileError = $_FILES["filePFP"]["error"];
    $fileType = $_FILES["filePFP"]["type"];

    $fileExtention= explode(".", $fileName);
    $LowerCasedActualExt= strtolower(end($fileExtention));
    $allowed= array("jpg","jpeg","svg","png","pdf",);

    if (in_array($LowerCasedActualExt, $allowed)) {
        if($fileError === 0) {
            if ($fileSize < 1000000) {
                $fileNewName = uniqid("", true).".".$LowerCasedActualExt;
                $fileDestination ="Uploads/".$fileNewName;
                move_uploaded_file($fileTmpName,$fileDestination);
                header("Location: ProfileFMA.php?uploadsucess");
            } else {
                echo "your file is too big !";
            }
        } else {
            echo "there was an error uploading the file";
        }
    } else {
        echo "u got a shit filetype in there... change it";
    }


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <link rel="stylesheet" type="text/css" href="ProfileFMA.css">
    <title>F.M.A</title>
</head>

<body>
    
    <?php if(isset($_SESSION["Connected-UserID"])){
        LogedInStickyNav();
        } else {
        LogedOutStickyNav();
    } ?>

<header class="row">
    <?php if(isset($_SESSION["Connected-UserID"])){
        LogedInNav();
        } else {
        LogedOutNav();
    } ?>

    <div class="row col-md-12">
        <div class="coverdiv col-md-9">
            <a href="#" class="btn btn-xs btn-primary pull-right" style="margin:10px;"><span class="glyphicon glyphicon-picture"></span> Change cover</a>
        </div>
        <!-- <div class="row">
            <div class="col-sm-10"><h1>User name</h1></div>
            <div class="col-sm-2"><a href="/users" class="pull-right"><img title="profile image" class="img-circle img-responsive" src="http://www.gravatar.com/avatar/28fd20ccec6865e2d5f0e1f4446eb7bf?s=100"></a></div>
        </div> -->
    </div>


</header>
<main>

    <!-- Modal -->
    <div id="uploadModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">            
                <form method='post' action='' enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">File upload form</h4>
                    </div> 
                    <div class="modal-body d-flex justify-content-center">
                        <!-- Form -->
                    
                        Select file :<input type="file" name="filePFP" onchange="previewImage(event)" id='file' class="text-center center-block file-upload form-control" accept="image/*"><br>
                        <!-- Preview-->
                        <div id="preview" class="d-flex justify-content-center">
                            <p>PFP preview :</p>
                            <img src="" width="0" height="0" id="moral-img-preview">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" name="submitPFP" value="Upload image" id='submit_upload' class="btn btn-info">                                                 
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container">

            <div class="row">

                <div class="col-md-3">
                    <div class="row">
                        <form method="POST" action="?" enctype="multipart/form-data">
                            <div class="pfpparentdiv">
                                <div class="text-center pfpdiv">
                                    <img src="<?php echo $pfp;?>" class="pfp avatar img-circle">                                    
                                    <i class="glyphicon glyphicon-camera img-circle" data-toggle="modal" data-target="#uploadModal"></i>                                        
                                </div>
                            </div>
                        </form> 
                    </div>
                    <ul class="nav nav-pills nav-stacked admin-menu" >
                        <li class="active"><a href="" data-target-id="profile"><i class="glyphicon glyphicon-user"></i> Personal Information</a></li>
                        <li><a href="" data-target-id="update-profile-form"><i class="glyphicon glyphicon-edit"></i> Update Profile</a></li>
                        <li><a href="" data-target-id="change-password"><i class="glyphicon glyphicon-lock"></i> Change Password</a></li>
                        <li><a href="" data-target-id="settings"><i class="glyphicon glyphicon-cog"></i> Settings</a></li>
                        <li><a href="" data-target-id="logout"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
                    </ul>
                </div>

                <div class="col-md-9 admin-content " id="profile">
                    <div class="panel panel-info" style="margin: 1em;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Name</h3>
                        </div>
                        <div class="panel-body">
                            Ashish Patel
                        </div>
                    </div>
                    <div class="panel panel-info" style="margin: 1em;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Email</h3>
                        </div>
                        <div class="panel-body">
                            ashishpatel0720@gmail.com
                        </div>
                    </div>
                    <div class="panel panel-info" style="margin: 1em;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Last Password Change</h3>

                        </div>
                        <div class="panel-body">
                            4 days Ago
                        </div>
                    </div>

                </div>

                <div class="col-md-9  admin-content profile-content" id="update-profile-form">
                    <form class="form" action="##" method="post" id="registrationForm">
                        <div class="form-group">
                            
                            <div class="col-xs-6">
                                <label for="first_name"><h4>First name</h4></label>
                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="first name" title="enter your first name if any.">
                            </div>
                        </div>
                        <div class="form-group">
                            
                            <div class="col-xs-6">
                            <label for="last_name"><h4>Last name</h4></label>
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="last name" title="enter your last name if any.">
                            </div>
                        </div>

                        <div class="form-group">
                            
                            <div class="col-xs-6">
                                <label for="phone"><h4>Phone</h4></label>
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="enter phone" title="enter your phone number if any.">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="mobile"><h4>Mobile</h4></label>
                                <input type="text" class="form-control" name="mobile" id="mobile" placeholder="enter mobile number" title="enter your mobile number if any.">
                            </div>
                        </div>
                        <div class="form-group">
                            
                            <div class="col-xs-6">
                                <label for="email"><h4>Email</h4></label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="you@email.com" title="enter your email.">
                            </div>
                        </div>
                        <div class="form-group">
                            
                            <div class="col-xs-6">
                                <label for="email"><h4>Location</h4></label>
                                <input type="email" class="form-control" id="location" placeholder="somewhere" title="enter a location">
                            </div>
                        </div>
                        <div class="form-group">
                            
                            <div class="col-xs-6">
                                <label for="password"><h4>Password</h4></label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="password" title="enter your password.">
                            </div>
                        </div>
                        <div class="form-group">
                            
                            <div class="col-xs-6">
                            <label for="password2"><h4>Verify</h4></label>
                                <input type="password" class="form-control" name="password2" id="password2" placeholder="password2" title="enter your password2.">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <br>
                                <button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                                <button class="btn btn-lg" type="reset"><i class="glyphicon glyphicon-repeat"></i> Reset</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-9  admin-content" id="settings">
                    <div class="panel panel-info" style="margin: 1em;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Notification</h3>
                        </div>
                        <div class="panel-body">
                            <div class="label label-success">allowed</div>
                        </div>
                    </div>
                    <div class="panel panel-info" style="margin: 1em;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Newsletter</h3>
                        </div>
                        <div class="panel-body">
                            <div class="badge">Monthly</div>
                        </div>
                    </div>
                    <div class="panel panel-info" style="margin: 1em;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Admin</h3>

                        </div>
                        <div class="panel-body">
                            <div class="label label-success">yes</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-9  admin-content" id="change-password">
                    <form action="/password" method="post">

            
                        <div class="panel panel-info" style="margin: 1em;">
                            <div class="panel-heading">
                                <h3 class="panel-title"><label for="new_password" class="control-label panel-title">New Password</label></h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="password" id="new_password" >
                                    </div>
                                </div>

                            </div>
                        </div>

                
                        <div class="panel panel-info" style="margin: 1em;">
                            <div class="panel-heading">
                                <h3 class="panel-title"><label for="confirm_password" class="control-label panel-title">Confirm password</label></h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="password_confirmation" id="confirm_password" >
                                    </div>
                                </div>
                            </div>
                        </div>

            
                        <div class="panel panel-info border" style="margin: 1em;">
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="pull-left">
                                        <input type="submit" class="form-control btn btn-primary" name="submit" id="submit">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="col-md-9  admin-content" id="logout">
                    <div class="panel panel-info" style="margin: 1em;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Confirm Logout</h3>
                        </div>
                        <div class="panel-body">
                            Do you really want to logout ?  
                            <a  href="#" class="label label-danger"
                                onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                <span >   Yes   </span>
                            </a>    
                            <a href="/account" class="label label-success"> <span >  No   </span></a>
                        </div>
                        <form id="logout-form" action="#" method="POST" style="display: none;">
                        </form>
                    </div>
                </div>

            </div>

    </div>
</main>

<footer>

</footer>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script type="text/javascript">

var toggleButton = [document.getElementsByClassName('toggle-button')[0], document.getElementsByClassName('toggle-button')[1]];
var navbarLinks = [document.getElementsByClassName('navbar-links')[0], document.getElementsByClassName('navbar-links')[1]];
var myStickyNavDiv = document.getElementById("stickyNavbar");
var myHeaderNavdiv = document.getElementById("HEADERNavbar");
var myNavBars = [myStickyNavDiv, myHeaderNavdiv];
var brandHeadActive = [document.getElementsByClassName('BrandFMA')[0], document.getElementsByClassName('BrandFMA')[1]];


toggleButton.forEach(element => {
    element.addEventListener('click', () => {
    toggleButton.forEach(item => {
        item.classList.toggle('open');
    });
    navbarLinks.forEach(item => {
        item.classList.toggle('active');
    });
    myNavBars.forEach(item => {
        item.classList.toggle('padding-border-botom');
    });
    brandHeadActive.forEach(item => {
    item.classList.toggle('BrandHeadActive');
    });
});
});

// SHOW STICKY NAVBAR

var myScrollFunc = function() {
  var y = window.scrollY;
  if (y >= 450) {
    myStickyNavDiv.classList.remove("hidesticky");
    myStickyNavDiv.classList.add("showsticky");
    // myStickyNavDiv.className = "MasterContainer stickyMenu showsticky";
  } else {
    myStickyNavDiv.classList.remove("showsticky");
    myStickyNavDiv.classList.add("hidesticky");
    // myStickyNavDiv.className = "MasterContainer stickyMenu hidesticky";
  }
};

window.addEventListener("scroll", myScrollFunc);




// HIDE SHOW PROFILE DIVISIONS

$(document).ready(function()
{
var navItems = $('.admin-menu li > a');
var navListItems = $('.admin-menu li');
var allWells = $('.admin-content');
var allWellsExceptFirst = $('.admin-content:not(:first)');
allWellsExceptFirst.hide();
navItems.click(function(e)
    {
        e.preventDefault();
        navListItems.removeClass('active');
        $(this).closest('li').addClass('active');
        allWells.hide();
        var target = $(this).attr('data-target-id');
        $('#' + target).show();
    });
});

// PREVIEW IMAGE

function previewImage(event){
    var previewdImage = document.getElementById("moral-img-preview");
    previewdImage.src = URL.createObjectURL(event.target.files[0]);
    previewdImage.width = "200";
    previewdImage.height = "200";
}

</script>
</body>
</html>