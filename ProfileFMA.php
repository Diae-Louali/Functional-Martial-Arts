<?php
require("MasterPHPFMA.php");    

usersOnly();


$edited = '';
$pfp="Icon\iconfinder-pfp.svg";


if (isset($_POST['edit-user-button'])) {
    echo '<pre>', print_r($_POST, true) ,'</pre>';
    $existingEmail = selectOne('user', ['Email'=> $_POST['Email']]);
    $i=0;
    foreach ($_POST as $postElement) {
        if (!empty($postElement)) {
            $i++;
        }
    }
    if ($i <= 1) {
        echo 'Action Denied. You cannot submit an empty form.To edit your profile information, make sure atleast one field is filled.';
        return;
    } 
    // echo '<pre>', print_r($existingEmail, true) ,'</pre>';
    if ((is_array($existingEmail) < 1) || ((is_array($existingEmail) > 0) && ($existingEmail['Id'] === $_POST['Id']))){
        $id = $_POST['Id'];        
        // echo '<pre>', print_r($_POST, true) ,'</pre>';
        unset($_POST['edit-user-button'], $_POST['Id'], $_POST['Password']);
        unsetEmptyVars();
        // echo '<pre>', print_r($_POST, true) ,'</pre>';
        $user_ID = update('user', $id, $_POST);
        if (isset($_POST['Name']))      {  $_SESSION['Connected-UserFname'] = $_POST['Name']; }
        if (isset($_POST['Lastname']))  {  $_SESSION['Connected-UserLastname'] = $_POST['Lastname']; }
        if (isset($_POST['Age']))       {  $_SESSION['Connected-UserAge'] = $_POST['Age'] ; }
        if (isset($_POST['Address']))   {  $_SESSION['Connected-UserAddress'] = $_POST['Address']; }
        if (isset($_POST['Email']))     {  $_SESSION['Connected-UserEmail'] = $_POST['Email']; }
        if (isset($_POST['Username']))  {  $_SESSION['Connected-UserUsername'] = $_POST['Username']; }
        if (isset($_POST['Password']))  {  $_SESSION['Connected-UserPassword'] = $_POST['Password']; }
        if (isset($_POST['Role']))      {  $_SESSION['Connected-UserRole'] = $_POST['Role']; }
        $_SESSION['Message']="<div class='alert alert-success w-100 text-center px-0 mt-4 mb-1 position-absolute' role='alert' style='top:-19px;'>'Your Profile was updated successfully'</div>";
        $_SESSION['type'] = "profile";
        echo $_SESSION['type'];
        header('Location:ProfileFMA.php');
        exit(0);
    } else {      
        $_SESSION['Message'] = "<div class='alert alert-danger w-100 text-center px-0 mt-4 mb-1 position-absolute' role='alert' style='top:-19px;'>'This Email has already been registered by another user'</div>";
        $_SESSION['type'] = "profile";
        $id = $_POST['Id'];
        $userEditName = $_POST['Name'];
        $userEditLastname =  $_POST['Lastname'];
        $userEditUsername= $_POST['Username'];
        $userEditEmail= $_POST['Email'];
        $userEditAge= $_POST['Age'];
        $userEditAddress =  $_POST['Address'];
        }

}



if (isset($_POST['edit_password'])) {
        $id = $_POST['Id']; 
        $oldPass = $_POST['Old-Password'];       
        unset($_POST['edit_password'], $_POST['Id'], $_POST['Old-Password']);
        unsetEmptyVars();
        if (password_verify ( $oldPass , $_SESSION['Connected-UserPassword'] )) {
            $_POST['Password'] = password_hash($_POST['Password'], PASSWORD_DEFAULT);       
            $user_ID = update('user', $id, $_POST);   
            $_SESSION['Message']="<div class='alert alert-success w-100 text-center px-0 mt-4 mb-1 position-absolute' role='alert' style='top:-19px;'>'Your Password was updated successfully'</div>";
            $_SESSION['type'] = "password";
            echo $_SESSION['type'];
            header('Location:ProfileFMA.php');
            exit(0);
        } else {
            $_SESSION['Message'] = "<div class='alert alert-danger w-100 text-center px-0 mt-4 mb-1 position-absolute' role='alert' style='top:-19px;'>'The old password you have entered is incorrect'</div>";
            // $_SESSION['type'] = "password";

        }
    } else {      
        // $_SESSION['Message'] = "<div class='alert alert-danger w-100 text-center px-0 mt-4 mb-1 position-absolute' role='alert' style='top:-19px;'>'The old password you have entered is incorrect is invalid.'</div>";
        // $_SESSION['type'] = "password";

    }


        
if (isset($_SESSION['type'])) {
    $edited = $_SESSION['type'];
    unset($_SESSION['type']);
} 

// echo 'var :' . $edited . '<br> sess :' . $_SESSION['type'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.16.0/css/mdb.min.css" rel="stylesheet">
    <!-- FONT FAMILY -->
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="Css\ProfileFMA.css">
    <title>F.M.A</title>
</head>

<body>
    
<header class="row bg-dark">
    <?php include("Includes\Header\NormalNav.php");?>

    <div class="coverparent row col-md-12 h-100">
        <div class="coverdiv col-8 position-relative">
            <form method='post' action='ProfileFMA.php' enctype="multipart/form-data">
            </form>
            
        </div>
    </div>
</header>
<main>
    <!-- sign out Modal -->
    <?php include("Includes\Modal\Modal-logout.php");?>

    <!-- Image Upload Modal -->
    <div class="">
        <div id="uploadModal" class="modal_wrapper modal fade" role="dialog" style="overflow: hidden;">
            <div class="d-flex h-100 modal-dialog">
                <!-- Modal content-->
                <div class="card modal-content">            
                    <form id="upload_Img_Form" method='post' action='' enctype="multipart/form-data" onsubmit='return upload_pfp();'>
                        <div class="card-header modal-header border-danger">
                            <h2 class="modal-title font-weight-bold mx-auto">File upload form</h2>
                            <span aria-hidden="true">&times;</span>
                            <a href="#/" class="float-right mr-1 close" data-dismiss="modal"></a>
                        </div> 
                        <div class="card-body modal-body">
                            <input type="hidden" name="Id" value="<?php echo $_SESSION['Connected-UserID']; ?>"> 
                            <input type="file" name="filePFP" id='file-upload' class="text-center center-block file-upload form-control" onchange="previewImage(event)" accept="image/*" required><br>
                            <div id="preview" class="d-flex justify-content-center flex-column">
                                <p class="mb-0">PFP preview :</p>
                                <d id="error_upload" class="mx-auto mt-2 mb-3"></d>
                                <img src="" id="modal-img-preview" class="mx-auto pfp_preview">
                            </div>
                        </div>
                        <div class="card-footer modal-footer border-danger">
                            <button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
                            <button type="submit" id='submit_upload' name="submitPFP" class="btn btn-danger">Upload image</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container mx-md-0 mw-100">

        <div class="row">

            <div class="col-md-3 pr-md-5">
                <div class="row">
                    <form method="POST" action="?" enctype="multipart/form-data">
                        <div class="pfpparentdiv">
                            <div class="text-center pfpdiv">
                                <img src="<?php echo "uploads/" . $_SESSION['Connected-UserPfp'];?>" class="pfp avatar">                                    
                                <i class="fas fa-camera" data-toggle="modal" data-target="#uploadModal"></i>                                        
                            </div>
                        </div>
                    </form> 
                </div>
                <div class="nav flex-column nav-pills mt-5 pt-4" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="true"><i class="fas fa-user-circle"></i> Profile</a>
                    <a class="nav-link" id="v-pills-change-password-tab" data-toggle="pill" href="#v-pills-change-password" role="tab" aria-controls="v-pills-change-password" aria-selected="false"><i class="fas fa-lock-open"></i> Change Password</a>
                    <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false"><i class="fas fa-cog"></i> Settings</a>
                    <a class="nav-link" id="v-pills-logout-tab" data-toggle="pill" href="#v-pills-logout" role="tab" aria-controls="v-pills-logout" aria-selected="false"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>

            </div>

            <div class="col-md-9 tab-content mt-0 p-0" id="v-pills-tabContent">

                <div class="tab-pane fade mt-4 pt-3 show active " id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">                                    
                    <?php if (isset($_SESSION['Message']) && ($edited == 'profile')) { 
                        echo $_SESSION['Message']; 
                        unset($_SESSION['Message']); 
                    }?> 

                    <button id="toggleEditProfile" class="text-center btn btn-sm editbutn"><i class="far fa-edit"></i> Edit</button>
                    <button id="canceleditID" class="d-flex justify-content-center align-items-center text-center btn btn-sm canceledit mt-2"><i class="fas fa-times"></i></button>

                    <form class="form mt-3" action="ProfileFMA.php" method="post" id="editForm">

                        <button type="submit" name="edit-user-button" id="confirmeditID" class="text-center btn btn-sm confirmedit mt-2"><i class="fas fa-check"></i></button>

                        <input type="hidden" name="Id" value="<?php echo $_SESSION['Connected-UserID']; ?>"> 
                        <!-- input -->
                        <div class="d-inline-block profile-div-form mr-2">
                            <div class="d-flex">
                                <div class="d-flex align-items-center font-weight-bolder finput-title enableEdit">First name :</div>
                                <div class="md-form input-with-pre-icon profile-input-forms mx-0">
                                    <i class="fas fa-id-badge input-prefix enableEdit"></i>
                                    <input type="text" id="First-name" name="Name" value="<?php  if (isset($userEditName)) {echo $userEditName;}?>" class="form-control inputToDisable" disabled>
                                    <label for="First-name" class="pl-2"> <?php echo $_SESSION["Connected-UserFname"];?> </label>
                                </div>
                            </div>
                        </div>
                        <!-- input -->
                        <div class="d-inline-block profile-div-form">
                            <div class="d-flex">
                                <div class="d-flex align-items-center font-weight-bolder finput-title enableEdit">Last name :</div>
                                <div class="md-form input-with-pre-icon profile-input-forms mx-0">
                                    <i class="fas fa-id-card input-prefix enableEdit"></i>
                                    <input type="text" id="Last-name" name="Lastname" value="<?php  if (isset($userEditLastname)) {echo $userEditLastname;}?>" class="form-control inputToDisable" disabled>
                                    <label for="Last-name" class="pl-2"><?php echo $_SESSION["Connected-UserLastname"];?> </label>
                                </div>
                            </div>
                        </div>
                        <!-- input -->
                        <div class="d-inline-block profile-div-form mr-2">
                            <div class="d-flex">
                                <div class="d-flex align-items-center font-weight-bolder finput-title enableEdit">Username :</div>
                                <div class="md-form input-with-pre-icon profile-input-forms mx-0">
                                    <i class="fas fa-user input-prefix enableEdit"></i>  
                                    <input type="text" id="prefixInside" name="Username" value="<?php  if (isset($userEditUsername)) {echo $userEditUsername;}?>" class="form-control inputToDisable" disabled>
                                    <label for="prefixInside" class="pl-2"><?php echo $_SESSION["Connected-UserUsername"];?> </label>
                                </div>
                            </div>
                        </div>
                        <!-- input -->
                        <div class="d-inline-block profile-div-form">
                            <div class="d-flex">
                                <div class="d-flex align-items-center font-weight-bolder mr-3 enableEdit">Age :</div>
                                <div class="md-form input-with-pre-icon profile-input-forms mx-0">
                                    <i class="fas fa-birthday-cake input-prefix enableEdit"></i>
                                    <input type="number" id="Age" name="Age" value="<?php  if (isset($userEditAge)) {echo $userEditAge;}?>" class="form-control inputToDisable" disabled>
                                    <label for="Age" class="pl-2"><?php echo $_SESSION["Connected-UserAge"];?> </label>
                                </div>
                            </div>
                        </div>
                        <!-- input -->
                        <div class="d-flex profile-div-form w-75">
                            <div class="d-flex align-items-center font-weight-bolder finput-title enableEdit">Adress :</div>
                            <div class="md-form input-with-pre-icon w-100 profile-input-forms mx-0">
                                <i class="fas fa-map-marker-alt input-prefix enableEdit"></i>
                                <input type="text" id="Adress" name="Address" value="<?php  if (isset($userEditAddress)) {echo $userEditAddress;}?>" class="form-control inputToDisable" disabled>
                                <label for="Adress" class="pl-2"><?php echo $_SESSION["Connected-UserAddress"]; ?> </label>
                            </div>
                        </div>
                        <!-- input -->
                        <div class="d-flex profile-div-form w-75">
                            <div class="d-flex align-items-center font-weight-bolder finput-title enableEdit">Email :</div>
                            <div class="md-form input-with-pre-icon w-100 profile-input-forms mx-0">
                                <i class="fas fa-envelope input-prefix enableEdit"></i>
                                <input type="email" id="Input-Email" name="Email" value="<?php  if (isset($userEditEmail)) {echo $userEditEmail;}?>" class="form-control inputToDisable validate mb-2" disabled>
                                <label for="Input-Email" data-error="wrong" data-success="right" class="pl-2"><?php echo $_SESSION["Connected-UserEmail"]; ?></label>
                            </div>
                        
                        </div> 
                    </form> 
                             
                </div>

                <div class="tab-pane fade mt-4" id="v-pills-change-password" role="tabpanel" aria-labelledby="v-pills-change-password-tab">
                    <?php if (isset($_SESSION['Message']) && ($edited == 'password')) { 
                        echo $_SESSION['Message']; 
                        unset($_SESSION['Message']); 
                    }?> 
          
                    <form action="ProfileFMA.php#v-pills-change-password" method="post" class="mt-5 pt-4 mr-5 mb-0 pr-5 d-flex flex-column align-items-center">   
                        <input type="hidden" name="Id" value="<?php echo $_SESSION['Connected-UserID']; ?>">   
                        <!-- input -->
                        <div class="md-form w-50 m-0">
                            <i class="fas fa-unlock-alt prefix"></i>
                            <input type="password" id="Old-Password" name="Old-Password" class="form-control validate" required>
                            <label for="Old-Password" data-error="wrong" data-success="right">Old Password</label>
                            <span id="Icon-field" class="toggle-password position-absolute"><i id="EYEICON1" class="fa fa-fw fa-eye EYEICON"></i></span>
                        </div>
                        <!-- input -->
                        <div class="md-form w-50 m-0">
                            <i class="fas fa-lock prefix"></i>
                            <input type="password" id="New-Password" name="Password" class="form-control validate" required>
                            <label for="New-Password" data-error="wrong" data-success="right">New Password</label>
                            <span id="Icon-field" class="toggle-password position-absolute"><i id="EYEICON2" class="fa fa-fw fa-eye EYEICON"></i></span>
                        </div>
                        <!-- input -->
                        <div class="md-form w-50 m-0">
                            <i class="fas fa-lock prefix"></i>
                            <input type="password" id="Confirm-Password" class="form-control validate" required>
                            <label for="Confirm-Password" data-error="wrong" data-success="right">Confirm Password</label>
                            <span id="Icon-field" class="toggle-password position-absolute"><i id="EYEICON3" class="fa fa-fw fa-eye EYEICON"></i></span>
                        </div>
                   
                    
                        <div class="d-flex w-100 justify-content-center ml-5">
                            <button id="edit_password" name="edit_password" class="text-center btn btn-sm edit-pass"><i class="fas fa-check"></i> Confirm</button>
                            <!-- <button id="canceleditID" class="text-center btn btn-sm cancel-pass mt-2"><i class="fas fa-times"></i> Cancel</button>            -->
                        </div>
                    </form>
                </div>

                <div class="tab-pane fade mt-4" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                    <div class="card m-3">
                        <div class="card-header py-1 px-2">
                            <h3 class="card-title m-0">Notification</h3>
                        </div>
                        <div class="card-body p-2">
                            <div class="badge badge-success">Bjj</div>
                            <div class="badge badge-success">Mma</div>
                            <div class="badge badge-success">Boxing</div>
                        </div>
                    </div>
                    <div class="card m-3">
                        <div class="card-header py-1 px-2">
                            <h3 class="card-title m-0">Newsletter</h3>
                        </div>
                        <div class="card-body p-2">
                            <div class="badge badge-secondary">Allowed</div>
                        </div>
                    </div>
                    <div class="card mx-3 mt-3 mb-0">
                        <div class="card-header py-1 px-2">
                            <h3 class="card-title m-0">Admin</h3>

                        </div>
                        <div class="card-body p-2">
                            <div class="badge badge-warning"><?php echo $_SESSION["Connected-UserRole"]; ?></div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade mt-5" id="v-pills-logout" role="tabpanel" aria-labelledby="v-pills-logout-tab">
                    <div class="card m-0">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Confirm Logout</h3>
                        </div>
                        <form id="logout-form" action="#" method="POST">
                            <div class="card-body">
                                Do you want to logout ?  
                                <a  href="#/" class="badge badge-success" data-toggle='modal' data-target='#LogOutModal'><span >   Yes   </span></a>    
                                <a href="#/" id="cancel-logout" class="badge badge-danger"> <span >  No   </span></a>
                            </div>                        
                        </form>
                    </div>
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
<!-- JQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.16.0/js/mdb.min.js"></script>

<script src="Javascript\Profile.js"></script>

</body>
</html>