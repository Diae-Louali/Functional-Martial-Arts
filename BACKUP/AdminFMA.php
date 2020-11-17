<?php
session_start();
require("MasterPHPFMA.php");  
adminOnly();


// if (!isset($_SESSION["Connected-UserID"])) {
//     header("Location:LoginFMA.php");
//     exit;
// } elseif ($_SESSION["Connected-UserRole"] != "Admin") {
//     header("Location:HomeFMA.php");
//     exit;
// } 

// SHARED VARS 
$added = '';
$edited = '';
$deleted = '';
$manageType = '';

// TOPIC VARS
$topicId= '';
$topicAddName= '';
$topicAddDescription= '';
$topicEditName= '';
$topicEditDescription= '';

// POST VARS
$ImgErrorMsg ='';
$postId = '';
$postTopicId= '';
$postAddTitle= '';
$postAddContent= '';
$published= '';
$postEditTitle = '';
$postEditContent = '';
$postEditPublished = '';

// USER VARS
//add
$userAddName = '';
$userAddLastname = '';
$userAddUsername= '';
$userAddPassword= '';
$userAddEmail= '';
$userAddAge= '';
$userAddAddress = '';
//edit
$userEditName = '';
$userEditLastname =  '';
$userEditUsername= '';
$userEditPassword= '';
$userEditEmail= '';
$userEditRole= '';
$userEditAge= '';
$userEditAddress = '';


////////////////////GENERAL//////////////////////////////
if (isset($_GET['manageType'])) {
    if ($_GET['manageType'] === 'manage-post') {
        $manageType = 'manage-post';
    } elseif ($_GET['manageType'] === 'manage-topic') {
        $manageType = 'manage-topic';
    } elseif ($_GET['manageType'] === 'manage-user') {
        $manageType = 'manage-user';
    }
}

if (isset($_SESSION['Added'])) {
    $added = $_SESSION['Added'];
    unset($_SESSION['Added']);
} elseif (isset($_SESSION['Edited'])) {
    $edited = $_SESSION['Edited'];
    unset($_SESSION['Edited']);
} elseif (isset($_SESSION['Deleted'])) {
    $deleted = $_SESSION['Deleted'];
    unset($_SESSION['Deleted']);
}

/////////////////TOPIC///////////////////////
if (isset($_POST['add-topic-btn'])) {
    adminOnly();
    $existingTopic = selectOne('topics', ['Name'=>$_POST['name']]);
    if (is_array($existingTopic) < 1) {
        unset($_POST['add-topic-btn']);
        $_SESSION['Added'] = 'topic-add-success';
        $topic_ID = create('topics', $_POST);
        $_SESSION['Message'] = "<div class='alert alert-success w-100 text-center px-0 mt-4 mb-1' role='alert'>'Topic created successfully'</div>";
        header('Location:AdminFMA.php');
        exit(0);
    } else {      
        $_SESSION['Message'] = "<div class='alert alert-danger w-100 text-center px-0 mt-4 mb-1' role='alert'>'This topic name already exists'</div>";
        $_SESSION['Added'] = 'topic-add-fail';
        $topicAddName = $_POST['name'];;
        $topicAddDescription = $_POST['description'];
        header('Location:AdminFMA.php');
        exit(0);
    }
}

if (isset($_GET['id']) && ($_GET['manageType'] === 'manage-topic')) {
    $id = $_GET['id'];
    $topic = selectOne('topics',['Id' => $id]);
    $topicId = $topic['Id'];
    $topicEditName = $topic['Name'];
    $topicEditDescription = $topic['Description'];
}

if (isset($_POST['edit-topic-btn'])) {
    adminOnly();
     
    $existingTopic = selectOne('topics', ['Name'=>$_POST['name']]);
    if ((is_array($existingTopic) < 1) || ((is_array($existingTopic) > 0) && ($existingTopic['Id'] === $_POST['Id']))){
        $id = $_POST['Id'];
        unsetEmptyVars();
        unset($_POST['edit-topic-btn'], $_POST['Id']);
        $topic_ID = update('topics', $id, $_POST);
        $_SESSION['Edited'] = 'topic-edit-success';
        $_SESSION['Message'] = "<div class='alert alert-success w-100 text-center px-0 mt-4 mb-1' role='alert'>'Topic updated successfully'</div>";
        header('Location:AdminFMA.php');
        exit(0);
    } else {      
        $_SESSION['Message'] = "<div class='alert alert-danger w-100 text-center px-0 mt-4 mb-1' role='alert'>'Edit Failed. This topic name already exists'</div>";
        $_SESSION['Edited'] = 'topic-edit-fail';
        $topicEditName = $_POST['name'];
        $topicEditDescription = $_POST['description'];
        header('Location:AdminFMA.php');
        exit(0);
    }
}
/////////////////POST/////////////////////
if (isset($_POST['add-post-btn'])) {
    adminOnly();    
    uploadImg ($_FILES['Image'], $uploadFileDest);
    $_POST['Title'] = str_replace('"',"'",$_POST['Title']);
    $_POST['Content']= str_replace('"',"'",$_POST['Content']);
    $existingPost = selectOne('article', ['Title'=>$_POST['Title']]);
    if (empty($ImgErrorMsg) && (is_array($existingPost) < 1)) {
        unset($_POST['add-post-btn']);
        $_POST['ID_User'] = $_SESSION["Connected-UserID"];
        $_POST['Content'] = htmlentities($_POST['Content']);
        $_POST['Published'] = isset($_POST['Published']) ? 1 : 0; 
        $_SESSION['Added'] = 'post-add-success';
        $post_ID = create('article', $_POST);
        $_SESSION['Message'] = "<div class='alert alert-success w-100 text-center px-0 mt-4 mb-1' role='alert'>'Article created successfully'</div>";
        header('Location:AdminFMA.php');
        exit(0);
    } else {
        $_SESSION['Added'] = 'post-add-fail';
        $postTopicId = $_POST['ID_Topic'];
        $postAddTitle= $_POST['Title'];
        $postAddContent= $_POST['Content'];
        $published = !empty($post['Published']) ? 1 : 0;
        if  (is_array($existingPost) > 0){
            $_SESSION['Message'] = "<div class='alert alert-danger w-100 text-center px-0 mt-4 mb-1' role='alert'><span>'Another article already contains this title.'</span></div>";
        } elseif (!empty($ImgErrorMsg)) {
            $_SESSION['Message'] = "<div class='alert alert-danger w-100 text-center px-0 mt-4 mb-1' role='alert'>" . $ImgErrorMsg . "</div>";
        } 
        
        if  ((is_array($existingPost) > 0) && (!empty($ImgErrorMsg))) {
            $_SESSION['Message'] = "<div class='alert alert-danger w-100 text-center px-0 mt-4 mb-1' role='alert'><span>'Another article already contains this title.'</span><br>" . $ImgErrorMsg . "</div>";
        }
        header('Location:AdminFMA.php');
        exit(0);
    }
}

if (isset($_GET['id']) && ($_GET['manageType'] === 'manage-post')) {
    $id = $_GET['id'];
    $post = selectOne('article',['Id' => $id]);
    $postId = $post['Id'];
    $postTopicId = $post['ID_Topic'];
    $postEditTitle = $post['Title'];
    $postEditContent = $post['Content'];
    $published = !empty($post['Published']) ? 1 : 0;
}

if (isset($_POST['edit-post-btn'])) {
    adminOnly();
    uploadImg ($_FILES['Image'], $uploadFileDest);
    $_POST['Title'] = str_replace('"',"'",$_POST['Title']);
    $_POST['Content']= str_replace('"',"'",$_POST['Content']);
    $existingPost = selectOne('article', ['Title'=>$_POST['Title']]);

    if (empty($ImgErrorMsg) && ((is_array($existingPost) < 1) || ((is_array($existingPost) > 0) && ($existingPost['Id'] === $_POST['Id'])))) {
        $id = $_POST['Id'];
        unset($_POST['edit-post-btn'], $_POST['Id']);
        unsetEmptyVars();
        $_POST['ID_User'] = $_SESSION["Connected-UserID"];
        $_POST['Content'] = htmlentities($_POST['Content']);
        $_POST['Published'] = isset($_POST['Published']) ? 1 : 0; 
        $_SESSION['Edited'] = 'post-edit-success';
        $post_ID = update('article', $id, $_POST);
        $_SESSION['Message'] = "<div class='alert alert-success w-100 text-center px-0 mt-4 mb-1' role='alert'>'Article Updated successfully'</div>";
        header('Location:AdminFMA.php');
        exit(0);

    } else {
        $_SESSION['Edited'] = 'post-edit-fail';
        $postId = $_POST['Id'];
        $postTopicId = $_POST['ID_Topic'];
        $postEditTitle= $_POST['Title'];
        $postEditContent= $_POST['Content'];
        $published = !empty($post['Published']) ? 1 : 0;
        if  (is_array($existingPost) > 0){
            $_SESSION['Message'] = "<div class='alert alert-danger w-100 text-center px-0 mt-4 mb-1' role='alert'><span>'Another article already contains this title.'</span></div>";
        } elseif (!empty($ImgErrorMsg)) {
            $_SESSION['Message'] = "<div class='alert alert-danger w-100 text-center px-0 mt-4 mb-1' role='alert'>" . $ImgErrorMsg . "</div>";
        } 
        
        if  ((is_array($existingPost) > 0) && (!empty($ImgErrorMsg))) {
            $_SESSION['Message'] = "<div class='alert alert-danger w-100 text-center px-0 mt-4 mb-1' role='alert'><span>'Another article already contains this title.'</span><br>" . $ImgErrorMsg . "</div>";
        }
        header('Location:AdminFMA.php');
        exit(0);

    }
}

if (isset($_GET['published']) && ($_GET['p_id'])) {
    $published = $_GET['published'];
    $p_id = $_GET['p_id'];
    $p_num = $_GET['p_num'];
    $count = update('article', $p_id, ['Published' => $published]);
    if ($published) {
        $_SESSION['Message'] = "<div class='alert alert-success w-100 text-center px-0 mt-4 mb-1' role='alert'>'Article n°". $p_num ." published successfully</div>";
    } else {
        $_SESSION['Message'] = "<div class='alert alert-success w-100 text-center px-0 mt-4 mb-1' role='alert'>'Article n°". $p_num ." unpublished successfully</div>";
    }
}
/////////////////USER/////////////////////

if (isset($_POST['add-user-button'])) {
    adminOnly();
    $existingEmail = selectOne('user', ['Email'=>$_POST['Email']]);
    if (is_array($existingEmail) < 1) {
        unset($_POST['add-user-button']);
        $_POST['Password'] = password_hash($_POST['Password'], PASSWORD_DEFAULT);
        $user_id = create('user', $_POST);
        $user = selectOne('user', ['Id'=> $user_id]);
        $_SESSION['Added'] = "user-add-success";
        $_SESSION['Message'] = "<div class='alert alert-success w-100 text-center px-0 mt-4 mb-1' role='alert'>'User created successfully'</div>";
        header('Location:AdminFMA.php');
        exit(0);

    } else {        
        $_SESSION['Message'] = "<div class='alert alert-danger w-100 text-center px-0 mt-4 mb-1' role='alert'><span>'This Email already exists'</span></div>";
        $_SESSION['Added'] = "user-add-fail";
        // $added = "user-add-fail";
        $userAddName = $_POST['Name'];
        $userAddLastname =  $_POST['Lastname'];
        $userAddUsername= $_POST['Username'];
        $userAddPassword= $_POST['Password'];
        $userAddEmail= $_POST['Email'];
        $userAddAge= $_POST['Age'];
        $userAddAddress =  $_POST['Address'];
        echo $userAddName;
        // $_SESSION['userAddName'] = $_POST['Name'];
        // $_SESSION['userAddLastname'] =  $_POST['Lastname'];
        // $_SESSION['userAddUsername']= $_POST['Username'];
        // $_SESSION['userAddPassword']= $_POST['Password'];
        // $_SESSION['userAddEmail']= $_POST['Email'];
        // $_SESSION['userAddAge']= $_POST['Age'];
        // $_SESSION['userAddAddress'] =  $_POST['Address'];
        // header('Location:AdminFMA.php');
        // exit(0);
    }
}

if (isset($_GET['id']) && ($_GET['manageType'] === 'manage-user')) {
    $id = $_GET['id'];
    $user= selectOne('user',['Id' => $id]);
    $userName = $user['Name'];
    $userLastname =  $user['Lastname'];
    $userUsername= $user['Username'];
    // $userPassword= $user['Password'];
    $userEmail= $user['Email'];
    $userRole= $user['Role'];
    $userAge= $user['Age'];
    $userAddress =  $user['Address'];
}

if (isset($_POST['edit-user-button'])) {
    adminOnly();
    $existingEmail = selectOne('user', ['Email'=> $_POST['Email']]);
    // echo '<pre>', print_r($existingEmail, true) ,'</pre>';
    if ((is_array($existingEmail) < 1) || ((is_array($existingEmail) > 0) && ($existingEmail['Id'] === $_POST['Id']))){
        $id = $_POST['Id'];        
        unset($_POST['edit-user-button'], $_POST['Id']);
        unsetEmptyVars();
        $_POST['Password'] = password_hash($_POST['Password'], PASSWORD_DEFAULT);
        $user_ID = update('user', $id, $_POST);
        $_SESSION['Edited'] = 'user-edit-success';
        $_SESSION['Message']="<div class='alert alert-success w-100 text-center px-0 mt-4 mb-1' role='alert'>'User updated successfully'</div>";
        header('Location:AdminFMA.php');
        exit(0);
    } else {      
        $_SESSION['Message'] = "<div class='alert alert-danger w-100 text-center px-0 mt-4 mb-1' role='alert'>'This Email has already been registered by another user'</div>";
        $_SESSION['Edited'] = 'user-edit-fail';
        $id = $_POST['Id'];
        $userEditName = $_POST['Name'];
        $userEditLastname =  $_POST['Lastname'];
        $userEditUsername= $_POST['Username'];
        $userEditPassword= $_POST['Password'];
        $userEditEmail= $_POST['Email'];
        $userEditAge= $_POST['Age'];
        $userEditAddress =  $_POST['Address'];
        $userName = $_POST['Name'];
        $userLastname =  $_POST['Lastname'];
        $userUsername= $_POST['Username'];
        $userEmail= $_POST['Email'];
        $userRole= $_POST['Role'];
        $userAge= $_POST['Age'];
        $userAddress =  $_POST['Address'];
        echo '<pre>', print_r($_POST, true) ,'</pre>' ;
            }

}

echo $added;
echo $edited;
echo $deleted;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <!-- <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.16.0/css/mdb.min.css" rel="stylesheet">
    <!-- FONT FAMILY -->
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="Css\AdminFMA.css">
    <title>F.M.A</title>
</head>

<body>
    <!-- sign out Modal -->
    <?php include("Includes\Modal\Modal-logout.php");?>
    <!-- Delete Modal -->
    <?php include("Includes\Modal\Modal-delete.php");?>

<header class="row">
    <?php include("Includes\Header\NormalNav.php");?>

</header>
<main>

    <div class="container mx-md-0 mw-100 px-0 h-100">

        <div class="row h-100">

            <div class="admin-nav-wrapper col-xl-2 col-lg-3 px-0 h-100">
                <div class="admin-nav-container h-100">
                    <div class="nav flex-column nav-pills py-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active w-100 rounded-0" id="v-pills-Dashboard-tab" data-toggle="pill" href="#v-pills-Dashboard" role="tab" aria-controls="v-pills-Dashboard" aria-selected="true"><i class="fas fa-chart-bar"></i> Dashboard</a>
                        <a class="nav-link w-100 rounded-0" id="v-pills-Manage-Posts-tab" data-toggle="pill" href="#v-pills-Manage-Posts" role="tab" aria-controls="v-pills-Manage-Posts" aria-selected="true"><i class="fas fa-paste"></i> Manage Posts</a>
                        <a class="nav-link w-100 rounded-0" id="v-pills-Manage-Users-tab" data-toggle="pill" href="#v-pills-Manage-Users" role="tab" aria-controls="v-pills-Manage-Users" aria-selected="false"><i class="fas fa-users-cog"></i> Manage Users</a>
                        <a class="nav-link w-100 rounded-0" id="v-pills-Manage-Topics-tab" data-toggle="pill" href="#v-pills-Manage-Topics" role="tab" aria-controls="v-pills-Manage-Topics" aria-selected="false"><i class="fas fa-newspaper"></i> Manage Topics</a>
                        <a class="nav-link w-100 rounded-0" id="v-pills-logout-tab" data-toggle="pill" href="#v-pills-logout" role="tab" aria-controls="v-pills-logout" aria-selected="false"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        <a class="nav-link w-100 rounded-0 hidden-links" id="v-pills-add-post-tab" data-toggle="pill" href="#v-pills-add-post" role="tab" aria-controls="v-pills-add-post" aria-selected="true">Add Post</a>
                        <a class="nav-link w-100 rounded-0 hidden-links" id="v-pills-add-Users-tab" data-toggle="pill" href="#v-pills-add-Users" role="tab" aria-controls="v-pills-add-Users" aria-selected="true">Add Users</a>
                        <a class="nav-link w-100 rounded-0 hidden-links" id="v-pills-add-Topic-tab" data-toggle="pill" href="#v-pills-add-Topic" role="tab" aria-controls="v-pills-add-Topic" aria-selected="true">Add Topic</a>
                        <a class="nav-link w-100 rounded-0 hidden-links" id="v-pills-edit-post-tab" data-toggle="pill" href="#v-pills-edit-post" role="tab" aria-controls="v-pills-edit-post" aria-selected="true">Edit Post</a>
                        <a class="nav-link w-100 rounded-0 hidden-links" id="v-pills-edit-Users-tab" data-toggle="pill" href="#v-pills-edit-Users" role="tab" aria-controls="v-pills-edit-Users" aria-selected="true">Edit Users</a>
                        <a class="nav-link w-100 rounded-0 hidden-links" id="v-pills-edit-Topic-tab" data-toggle="pill" href="#v-pills-edit-Topic" role="tab" aria-controls="v-pills-edit-Topic" aria-selected="true">Edit Topic</a>
                    </div>
                </div>

            </div>

            <div class="admin-content col-xl-10 col-lg-9 tab-content p-0" id="v-pills-tabContent">

                <div class="tab-pane fade show active row p-3" id="v-pills-Dashboard" role="tabpanel" aria-labelledby="v-pills-Dashboard-tab">                                    
                    
                    <h2 class="page-title text-center mb-4">Analytics</h2>

                    <div class="Analytics row col-12">

                    <div class="row col-12 mb-2">

                        <div id="card" class="flip-card-inner row col-lg-3 col-6 mb-3">

                            <div id="flip-front1" class="front stat-parent col-12">
                                <div class="card card-stats">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-between">
                                                <h5 class="card-category">Total Visitors</h5> <i class="fas fa-exchange-alt"></i>
                                            </div>
                                            <div class="col-12">
                                                <div class="numbers d-flex justify-content-between">
                                                    <i class="icon-numbers fas fa-users blue-grey-text"></i>
                                                    <p class="card-title text-primary"><span class="VisitorS-count">81</span>K</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer ">
                                        <hr>
                                        <div class="stats d-flex justify-content-between">
                                            <span><i class="fas fa-caret-down"></i> <i class="fa fa-calendar-o"></i> Last Day</span>  
                                            <i class="fa fa-refresh Vis pt-1"></i>                                   
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="flip-back1" class="back stat-parent col-12">
                                <div class="card card-stats">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-between">
                                                <h5 class="card-category">Unique Visitors</h5> <i class="fas fa-exchange-alt"></i>
                                            </div>
                                            <div class="col-12">
                                                <div class="numbers d-flex justify-content-between">
                                                    <i class="icon-numbers fas fa-user-tag text-default"></i>
                                                    <p class="card-title text-primary"><span class="Visitor-count">52</span>K</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer ">
                                        <hr>
                                        <div class="stats d-flex justify-content-between">
                                            <span><i class="fas fa-caret-down"></i> <i class="fa fa-calendar-o"></i> Last Day</span>  
                                            <i class="fa fa-refresh Vis pt-1"></i>                                   
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>                              

                        <div id="card-2" class="flip-card-inner row col-lg-3 col-6 mb-3">

                            <div id="flip-front2" class="front stat-parent col-12">
                                <div class="card card-stats">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-between">
                                                <h5 class="card-category">Traffic</h5> <i class="fas fa-exchange-alt"></i>
                                            </div>
                                            <div class="col-12">
                                                <div class="numbers d-flex justify-content-between">
                                                    <i class="icon-numbers fas fa-globe text-warning"></i>
                                                    <p class="card-title  text-primary"><span class="Traffic-count">102</span>K</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer ">
                                        <hr>
                                        <div class="stats d-flex justify-content-between">
                                            <span><i class="fas fa-caret-down"></i> <i class="fa fa-calendar-o"></i> Last Day</span>  
                                            <i class="fa fa-refresh TT pt-1"></i>                                   
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="flip-back2" class="back stat-parent col-12">
                                <div class="card card-stats">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-between">
                                                <h5 class="card-category">Impressions</h5> <i class="fas fa-exchange-alt"></i>
                                            </div>
                                            <div class="col-12">
                                                <div class="numbers d-flex justify-content-between">
                                                    <i class="icon-numbers fas fa-fire orange-text"></i>
                                                    <p class="card-title text-primary"><span class="Impressions-count">170</span>K</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer ">
                                        <hr>
                                        <div class="stats d-flex justify-content-between">
                                            <span><i class="fas fa-caret-down"></i> <i class="fa fa-calendar-o"></i> Last Day</span>  
                                            <i class="fa fa-refresh TV pt-1"></i>                                   
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>                              

                        <div id="card-3" class="flip-card-inner row col-lg-3 col-6 mb-3">

                            <div id="flip-front3" class="front stat-parent col-12">
                                <div class="card card-stats">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-between">
                                                <h5 class="card-category">Bounce Rate</h5> <i class="fas fa-exchange-alt"></i>
                                            </div>
                                            <div class="col-12">
                                                <div class="numbers d-flex justify-content-between">
                                                    <i class="icon-numbers fa fa-chart-pie text-danger"></i>
                                                    <p class="card-title text-primary"><span class="Bounce-count">33</span>%</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer ">
                                        <hr>
                                        <div class="stats d-flex justify-content-between">
                                            <span><i class="fas fa-caret-down"></i> <i class="fa fa-calendar-o"></i> Last Day</span>  
                                            <i class="fa fa-refresh BR pt-1"></i>                                   
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="flip-back3" class="back stat-parent col-12">
                                <div class="card card-stats">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-between">
                                                <h5 class="card-category">Conversion Rate</h5> <i class="fas fa-exchange-alt"></i>
                                            </div>
                                            <div class="col-12">
                                                <div class="numbers d-flex justify-content-between">
                                                    <i class="icon-numbers fas fa-funnel-dollar green-text"></i>
                                                    <p class="card-title text-primary"><span class="Conversion-count">21</span>%</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer ">
                                        <hr>
                                        <div class="stats d-flex justify-content-between">
                                            <span><i class="fas fa-caret-down"></i> <i class="fa fa-calendar-o"></i> Last Day</span>  
                                            <i class="fa fa-refresh BR pt-1"></i>                                   
                                        </div>
                                    </div>
                                </div>
                            </div>                               

                        </div>                              

                        <div id="card-4" class="flip-card-inner row col-lg-3 col-6 mb-3">

                            <div id="flip-front4" class="back stat-parent col-12">
                                <div class="card card-stats">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-between">
                                                <h5 class="card-category">New Users</h5> <i class="fas fa-exchange-alt"></i>
                                            </div>
                                            <div class="col-12">
                                                <div class="numbers d-flex justify-content-between">
                                                    <i class="icon-numbers fas fa-user-plus text-success"></i>
                                                    <p class="card-title text-primary"><span class="User-count">478</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer ">
                                        <hr>
                                        <div class="stats d-flex justify-content-between">
                                            <span><i class="fas fa-caret-down"></i> <i class="fa fa-calendar-o"></i> Last Day</span>  
                                            <i class="fa fa-refresh UV pt-1"></i>                                   
                                        </div>
                                    </div>
                                </div>
                            </div>                       
                            <div id="flip-back4" class="front stat-parent col-12">
                                <div class="card card-stats">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-between">
                                                <h5 class="card-category">Total users</h5> <i class="fas fa-exchange-alt"></i>
                                            </div>
                                            <div class="col-12">
                                                <div class="numbers d-flex justify-content-between">
                                                    <i class="icon-numbers fas fa-users text-default"></i>
                                                    <p class="card-title text-primary"><span class="Tusers-count">42</span>K</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer ">
                                        <hr>
                                        <div class="stats d-flex justify-content-between">
                                            <span><i class="fas fa-caret-down"></i><span class="invisible "><i class="fa fa-calendar-o invisible"></i> Last Day</span>  </span>  
                                            <i class="fa fa-refresh UV pt-1"></i>                                   
                                        </div>
                                    </div>
                                </div>
                            </div>                       

                        </div>                              

                    </div>


                        <div class="row col-12">
                            <div class="chart graph col-lg-7">
                                <div class="card card-chart">
                                    <div class="card-header d-flex justify-content-between">
                                        <h5 class="card-title"><i class="fas fa-chart-line"></i> FMA's Analytical History</h5> <i class="fa fa-refresh V-U pt-1"></i>
                                        <!-- <p class="card-category">Line Chart</p> -->
                                    </div>
                                    <div class="card-body">
                                        <canvas id="lineChart"></canvas>
                                    </div>
                                    <div class="card-footer">
                                        <div class="chart-legend">
                                        <i class="fa fa-circle text-info"></i> Users
                                        <i class="fa fa-circle text-warning"></i> Unique Visitors
                                        </div>
                                        <hr>
                                        <div class="card-stats">
                                        <span><i class="fa fa-check"></i> Data information certified</span>  <i class="fa fa-refresh V-U pt-1"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="flip-wrapper" class="PS-wrapper col-lg-5">
                                <div id="flip-container" class="row">

                                    <div id="flip-front" class="chart pie">
                                        <div class="card card-chart">
                                            <div class="card-header d-flex justify-content-between">
                                                <h5 class="card-title"><i class="fas fa-globe-americas"></i> Visitors By Demographics</h5><i class="fas fa-exchange-alt"></i><i class="fa fa-refresh Dem pt-1"></i>     
                                                <!-- <p class="card-category">Pine Chart</p> -->
                                            </div>
                                            <div class="card-body">
                                                <div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                                <canvas id="pieChart" class="chartjs-render-monitor"></canvas>
                                            </div>
                                            <div class="card-footer">
                                                <div class="chart-legend">
                                                <i class="fa fa-circle text-info"></i> Top Country 
                                                <i class="fa fa-circle text-warning"></i> Nb
                                                </div>
                                                <hr>
                                                <div class="card-stats">
                                                <i class="fa fa-check mr-sm-3"></i> Data information certified
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="flip-back" class="social-counter">
                                        <div class="container bootstrap snippet">
                                                <div class="col-md-12 social-header d-flex justify-content-between">                                              
                                                    <h5 class="Header-Title"><i class="fas fa-poll"></i> Social Media</h5> <i class="fas fa-exchange-alt pr-2"></i>  <i class="fa fa-refresh Soc pt-1"></i> 
                                                    <!-- <p class="card-category">Pine Chart</p>                                                                                                                                                                                                                                          -->
                                                </div>
                                            <div class="row social-body flex-column">
                                                <div class="col-md-12 social-div">
                                                    <a href="#">
                                                        <div class="panel panel-default twitter">
                                                            <div class="panel-body">
                                                                <small class="social-title">Twitter</small>
                                                                <h3 class="count T-count">12,000</h3>                                                                                                           
                                                                <i class="fa fa-twitter mr-md-4 mr-2"></i>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="col-md-12 social-div">
                                                    <a href="#">
                                                        <div class="panel panel-default youtube">
                                                            <div class="panel-body">
                                                                <small class="social-title">Youtube</small>
                                                                <h3 class="count Y-count">
                                                                    13,000</h3>
                                                                <i class="fa fa-youtube mr-md-4 mr-2"></i>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="col-md-12 social-div">
                                                    <a href="#">
                                                        <div class="panel panel-default facebook">
                                                            <div class="panel-body">
                                                                <small class="social-title">Facebook</small>
                                                                <h3 class="count F-count">
                                                                    14,000</h3>
                                                                <i class="fa fa-facebook mr-md-4 mr-2"></i>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                              
                            </div>                            

                        </div>
                   
                    </div>
                </div>

                <div class="tab-pane fade show p-5" id="v-pills-Manage-Posts" role="tabpanel" aria-labelledby="v-pills-Manage-Posts-tab">                                    
                    
                    <div class="button-group">
                        <a href="#/" class="btn Post-Manage-Btn General-btn">Manage</a>
                        <a href="#/" class="btn Post-Add-Btn General-btn">Add</a>
                    </div>
                    <h2 class="page-title">Manage Articles</h2>
                    <?php if (isset($_SESSION['Message']) && (($added == 'post-add-success') || ($edited == 'post-edit-success') || ($deleted == 'post-delete'))) { 
                        echo $_SESSION['Message']; 
                        unset($_SESSION['Message']); 
                    }?> 

                    <div class="content">
                        <table>
                            <thead>
                                <th>N</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th colspan="3">Action</th>
                            </thead>
                            <tbody>
                            <?php foreach ($posts as $key => $post) { ?>
                                <tr>
                                    <td><?php echo $key+1;?></td>
                                    <td><?php echo $post['Title']; ?></td>
                                    <td>Diae</td>
                                    <td><a href="AdminFMA.php?id=<?php echo $post['Id'] . '&manageType=manage-post';?>" class="edit-post manage-links">Edit</a></td>
                                    <td><a href="#/" class="delete-post manage-links" data-href="<?php echo $post['Id'] . '*' . $post['Title'] . '*' . "delete-post";?>" data-toggle="modal" data-target="#confirm-delete">Delete</a></td>
                                    <?php if ($post['Published']) { ?>
                                        <td><a href="AdminFMA.php?published=0&p_id=<?php echo $post['Id'];?>&p_num=<?php echo $key+1;?>" class="unpublish-post manage-links">Unpublish</a></td>
                                    <?php } else {?>
                                        <td><a href="AdminFMA.php?published=1&p_id=<?php echo $post['Id'];?>&p_num=<?php echo $key+1;?>" class="publish-post manage-links">Publish</a></td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>                    
                </div>
                
                <div class="tab-pane fade p-5" id="v-pills-add-post" role="tabpanel" aria-labelledby="v-pills-add-post-tab">                                    
                    
                    <div class="button-group">
                        <a href="#/" class="btn Post-Manage-Btn General-btn">Manage</a>
                        <a href="#/" class="btn Post-Add-Btn General-btn">Add</a>
                    </div>

                    <h2 class="page-title mb-4">Create Article</h2>
                    <?php if (isset($_SESSION['Message']) && ($added == 'topic-add-fail' )) { 
                        echo $_SESSION['Message']; 
                        unset($_SESSION['Message']); 
                    }?> 
 

                    <div class="form-container">
                        <form action="AdminFMA.php" method="post" class="d-flex flex-column" enctype="multipart/form-data">
                            <div class="mt-2 mb-3">
                                <label>Title</label>
                                <input type="text" name="Title" value="<?php echo $postAddTitle;?>" class="w-100" maxlength="70" required>
                            </div>
                            <div class="mb-4">
                                <label>Content</label>
                                <textarea id="editor1" name="Content" class="w-100"><?php echo $postAddContent;?></textarea>
                            </div>
                            <div class="mb-3 d-flex flex-row">  
                                <div class="input-group col-9 p-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" name="Image" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose Image</label>
                                    </div>
                                </div>
                                <div class="page__toggle col-3 ml-xl-5 ml-lg-3 ml-md-1 ml-sm-0">
                                    <?php if(empty($published)):?>
                                        <label class="toggle">
                                            <input class="toggle__input" type="checkbox" name="Published">
                                            <span class="toggle__label">
                                                <span class="toggle__text">Publish</span>
                                            </span>
                                        </label>
                                    <?php else: ?>
                                        <label class="toggle">
                                            <input class="toggle__input" type="checkbox" name="Published" checked>
                                            <span class="toggle__label">
                                                <span class="toggle__text">Publish</span>
                                            </span>
                                        </label>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="mb-3 w-100">
                                <div class="">
                                    <label for="Category" class="">Category</label>
                                    <select name="ID_Topic" class="w-100" required> 
                                        <option value="" disabled selected>Choose a Category</option>
                                        <?php foreach ($topics as $key => $topic) { 
                                            if (isset($postTopicId) && $postTopicId == $topic['Id']) {?>
                                                <option selected value="<?php echo $topic['Id'];?>"><?php echo $topic['Name'];?></option>
                                            <?php } else { ?>   
                                                <option value="<?php echo $topic['Id'];?>"><?php echo $topic['Name'];?></option>
                                            <?php }
                                        } ?>
                                    </select>
                                </div>                              
                            </div>                         
                            <button type="submit" name="add-post-btn" class="btn create-btn">Create</button>
                        </form>
                    </div>
                </div>

                <div class="tab-pane fade p-5" id="v-pills-edit-post" role="tabpanel" aria-labelledby="v-pills-edit-post-tab">                                    
                    
                    <div class="button-group">
                        <a href="#/" class="btn Post-Manage-Btn General-btn">Manage</a>
                        <a href="#/" class="btn Post-Add-Btn General-btn">Add</a>
                    </div>
                    <h2 class="page-title mb-4">Update Article</h2>
                    <?php if (isset($_SESSION['Message']) && ($edited == 'post-edit-fail' )) { 
                        echo $_SESSION['Message']; 
                        unset($_SESSION['Message']); 
                    }?> 

                    <div class="form-container">
                        <form action="AdminFMA.php" method="post" enctype="multipart/form-data" class="d-flex flex-column">
                            <input type="hidden" name="Id" value="<?php echo $id;?>">
                            <div class="mt-2 mb-3">
                                <label>Title</label>
                                <input type="text" name="Title" value="<?php echo $postEditTitle;?>" class="w-100" maxlength="70" required>
                            </div>
                            <div class="mb-4">
                                <label>Content</label>
                                <textarea id="editor2" name="Content" class="w-100"><?php echo $postEditContent;?></textarea>
                            </div>
                            <div class="mb-3 d-flex flex-row">  
                                <div class="input-group col-9 p-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" name="Image" class="custom-file-input" id="inputGroupFile02" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="inputGroupFile02">Choose Image</label>
                                    </div>
                                </div>
                                <div class="page__toggle col-3 ml-xl-5 ml-lg-3 ml-md-1 ml-sm-0">
                                    <?php if(empty($published)):?>
                                        <label class="toggle">
                                            <input class="toggle__input" type="checkbox" name="Published">
                                            <span class="toggle__label">
                                                <span class="toggle__text">Publish</span>
                                            </span>
                                        </label>
                                    <?php else: ?>
                                        <label class="toggle">
                                            <input class="toggle__input" type="checkbox" name="Published" checked>
                                            <span class="toggle__label">
                                                <span class="toggle__text">Publish</span>
                                            </span>
                                        </label>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="mb-3 w-100">
                                <div class="">
                                    <label for="Category" class="">Category</label>
                                    <select name="ID_Topic" class="w-100" required> 
                                        <option value="" disabled selected>Choose a Category</option>
                                        <?php foreach ($topics as $key => $topic) { 
                                            if (isset($postTopicId) && $postTopicId == $topic['Id']) {?>
                                                <option selected value="<?php echo $topic['Id'];?>"><?php echo $topic['Name'];?></option>
                                            <?php } else { ?>   
                                                <option value="<?php echo $topic['Id'];?>"><?php echo $topic['Name'];?></option>
                                            <?php }
                                        } ?>
                                    </select>
                                </div>                              
                            </div>
                            <button type="submit" name="edit-post-btn" class="btn create-btn"> Edit</button>
                        </form>
                    </div>
                </div>

                <div class="tab-pane fade p-5" id="v-pills-Manage-Users" role="tabpanel" aria-labelledby="v-pills-Manage-Users-tab">                                       
                    <div class="button-group">
                        <a href="#/" class="btn User-Manage-Btn General-btn">Manage</a>
                        <a href="#/" class="btn User-Add-Btn General-btn">Add</a>
                    </div>
                    <h2 class="page-title">Manage Users</h2>
                    <?php if (isset($_SESSION['Message']) && (($added == 'user-add-success') || ($edited == 'user-edit-success') || ($deleted == 'user-delete'))) { 
                        echo $_SESSION['Message']; 
                        unset($_SESSION['Message']); 
                    }?> 

                    <div class="content">
                        <table>
                            <thead>
                                <th>N</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th colspan="2">Action</th>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $key => $user) { ?>
                                    <tr>
                                        <td><?php echo $key+1;?></td>
                                        <td><?php echo $user['Username']; ?></td>
                                        <td><?php echo $user['Role']; ?></td>
                                        <td><a href="AdminFMA.php?id=<?php echo $user['Id'] . '&manageType=manage-user';?>" class="edit-post manage-links">Edit</a></td>
                                        <td><a href="AdminFMA.php?published=1&p_id=" class="delete-post manage-links"  data-href="<?php echo $user['Id'] . '*' . $user['Username'] . '*' . "delete-user";?>" data-toggle="modal" data-target="#confirm-delete">Delete</a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>  
                </div>

                <div class="tab-pane fade p-5" id="v-pills-add-Users" role="tabpanel" aria-labelledby="v-pills-add-Users-tab">                                                        
                    <div class="button-group">
                        <a href="#/" class="btn User-Manage-Btn General-btn">Manage</a>
                        <a href="#/" class="btn User-Add-Btn General-btn">Add</a>
                    </div>
                    <h2 class="page-title mb-5">Create User</h2>
                    <?php if (isset($_SESSION['Message']) && ($added == 'user-add-success' )) { 
                        echo $_SESSION['Message']; 
                        unset($_SESSION['Message']); 
                    }?> 

                    <div class="form-container">
                        <form action="AdminFMA.php" method="post" class="form mt-4" autocomplete="off">
                            <div class="d-inline-block profile-div-form mr-2">
                                <div class="d-flex">
                                    <div class="d-flex align-items-center font-weight-bolder finput-title enableEdit">First name :</div>
                                    <div class="md-form input-with-pre-icon profile-input-forms mx-0">
                                        <i class="fas fa-id-badge input-prefix enableEdit"></i>
                                        <input type="text" id="First-name1" name="Name" value="<?php echo $userAddName; ?>" class="form-control inputToDisable">
                                        <label for="First-name1" class="pl-2">First name </label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-inline-block profile-div-form">
                                <div class="d-flex">
                                    <div class="d-flex align-items-center font-weight-bolder finput-title enableEdit">Last name :</div>
                                    <div class="md-form input-with-pre-icon profile-input-forms mx-0">
                                        <i class="fas fa-id-card input-prefix enableEdit"></i>
                                        <input type="text" id="Last-name1" name="Lastname" value="<?php echo $userAddLastname; ?>" class="form-control inputToDisable">
                                        <label for="Last-name1" class="pl-2">Last name </label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-inline-block profile-div-form mr-2">
                                <div class="d-flex">
                                    <div class="d-flex align-items-center font-weight-bolder finput-title enableEdit">Username :</div>
                                    <div class="md-form input-with-pre-icon profile-input-forms mx-0">
                                        <i class="fas fa-user input-prefix enableEdit"></i>  
                                        <input type="text" id="username1" name="Username" value="<?php echo $userAddUsername; ?>" class="form-control inputToDisable" required>
                                        <label for="username1" class="pl-2">Username </label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-inline-block profile-div-form mr-2">
                                <div class="d-flex">
                                    <div class="d-flex align-items-center font-weight-bolder finput-title enableEdit">Password :</div>
                                    <div class="md-form input-with-pre-icon profile-input-forms mx-0">
                                        <i class="fas fa-lock input-prefix enableEdit"></i>  
                                        <input type='password' id="password1" name='Password' value="<?php echo $userAddPassword; ?>" class="form-control inputToDisable" autocomplete="new-password" required>
                                        <label for="password1" data-error="wrong" data-success="right" class="pl-2">Password</label>
                                        <span id="Icon-field" class="toggle-password position-absolute"><i id="EYEICON1" class="fa fa-fw fa-eye EYEICON"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex profile-div-form w-50 float-left">
                                <div class="d-flex align-items-center font-weight-bolder finput-title enableEdit">Email :</div>
                                <div class="md-form input-with-pre-icon w-100 profile-input-forms mx-0">
                                    <i class="fas fa-envelope input-prefix enableEdit"></i>
                                    <input type="email" id="Input-Email1" name="Email" value="<?php echo $userAddEmail; ?>" class="form-control inputToDisable validate mb-2" required>
                                    <label for="Input-Email1" data-error="wrong" data-success="right" class="pl-2">Email</label>
                                </div>                        
                            </div> 
                            <div class="d-inline-block profile-div-form">
                                <div class="d-flex">
                                    <div class="d-flex align-items-center font-weight-bolder mr-3 enableEdit">Age :</div>
                                    <div class="md-form input-with-pre-icon profile-input-forms mx-0">
                                        <i class="fas fa-birthday-cake input-prefix enableEdit"></i>
                                        <input type="number" id="Age1" name="Age" value="<?php echo $userAddAge; ?>" class="form-control inputToDisable">
                                        <label for="Age1" class="pl-2">Age </label>
                                    </div>
                                </div>
                            </div>                    
                            <div class="d-flex profile-div-form w-50 float-right mt-4">                                
                                <div class="d-flex align-items-center justify-content-end font-weight-bolder finput-title enableEdit pr-3 w-0">Role :</div>
                                <select name="Role" class="md-form w-50 mx-0"> 
                                <option value="" disabled selected>Choose Role</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Moderator">Moderator</option>
                                    <option value="User">User</option>                                    
                                </select>
                            </div>
                            <div class="d-flex profile-div-form w-50">
                                <div class="d-flex align-items-center font-weight-bolder finput-title enableEdit">Address :</div>
                                <div class="md-form input-with-pre-icon w-100 profile-input-forms mx-0">
                                    <i class="fas fa-map-marker-alt input-prefix enableEdit"></i>
                                    <input type="text" id="Address1" name="Address" value="<?php echo $userAddAddress; ?>" class="form-control inputToDisable">
                                    <label for="Address1" class="pl-2">Address </label>
                                </div>
                            </div>

                            <button type="submit" name="add-user-button" class="btn create-btn mt-3 float-right"> Create</button>
                        </form>
                    </div>
                </div>

                <div class="tab-pane fade p-5" id="v-pills-edit-Users" role="tabpanel" aria-labelledby="v-pills-edit-Users-tab">                                                        
                    <div class="button-group">
                        <a href="#/" class="btn User-Manage-Btn General-btn">Manage</a>
                        <a href="#/" class="btn User-Add-Btn General-btn">Add</a>
                    </div>
                    <h2 class="page-title mb-5">Update User</h2>
                    <?php if (isset($_SESSION['Message']) && ($edited == 'user-edit-fail' )) { 
                        echo $_SESSION['Message']; 
                        unset($_SESSION['Message']); 
                    }?> 

                    <div class="form-container">
                        <form action="AdminFMA.php" method="post" class="form mt-4" autocomplete="off">
                        <input type="hidden" name="Id" value="<?php echo $id;?>">
                        <div class="d-inline-block profile-div-form mr-2">
                                <div class="d-flex">
                                    <div class="d-flex align-items-center font-weight-bolder finput-title enableEdit">First name :</div>
                                    <div class="md-form input-with-pre-icon profile-input-forms mx-0">
                                        <i class="fas fa-id-badge input-prefix enableEdit"></i>
                                        <input type="text" id="First-name2" name="Name" value="<?php echo $userEditName; ?>" class="form-control inputToDisable">
                                        <label for="First-name2" class="pl-2"><?php echo $userName; ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-inline-block profile-div-form">
                                <div class="d-flex">
                                    <div class="d-flex align-items-center font-weight-bolder finput-title enableEdit">Last name :</div>
                                    <div class="md-form input-with-pre-icon profile-input-forms mx-0">
                                        <i class="fas fa-id-card input-prefix enableEdit"></i>
                                        <input type="text" id="Last-name2" name="Lastname" value="<?php echo $userEditLastname; ?>" class="form-control inputToDisable">
                                        <label for="Last-name2" class="pl-2"><?php echo $userLastname; ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-inline-block profile-div-form mr-2">
                                <div class="d-flex">
                                    <div class="d-flex align-items-center font-weight-bolder finput-title enableEdit">Username :</div>
                                    <div class="md-form input-with-pre-icon profile-input-forms mx-0">
                                        <i class="fas fa-user input-prefix enableEdit"></i>  
                                        <input type="text" id="username2" name="Username" value="<?php echo $userEditUsername; ?>" class="form-control inputToDisable">
                                        <label for="username2" class="pl-2"><?php echo $userUsername; ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-inline-block profile-div-form mr-2">
                                <div class="d-flex">
                                    <div class="d-flex align-items-center font-weight-bolder finput-title enableEdit">Password :</div>
                                    <div class="md-form input-with-pre-icon profile-input-forms mx-0">
                                        <i class="fas fa-lock input-prefix enableEdit"></i>  
                                        <input type='password' id="password2" name='Password' value="<?php echo $userEditPassword; ?>" class="form-control inputToDisable" autocomplete="new-password">
                                        <label for="password2" data-error="wrong" data-success="right" class="pl-2">Password</label>
                                        <span id="Icon-field" class="toggle-password position-absolute"><i id="EYEICON2" class="fa fa-fw fa-eye EYEICON"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex profile-div-form w-50 float-left">
                                <div class="d-flex align-items-center font-weight-bolder finput-title enableEdit">Email :</div>
                                <div class="md-form input-with-pre-icon w-100 profile-input-forms mx-0">
                                    <i class="fas fa-envelope input-prefix enableEdit"></i>
                                    <input type="email" id="Input-Email2" name="Email" value="<?php echo $userEditEmail; ?>" class="form-control inputToDisable validate mb-2">
                                    <label for="Input-Email2" data-error="wrong" data-success="right" class="pl-2"><?php echo $userEmail; ?></label>
                                </div>                        
                            </div> 
                            <div class="d-inline-block profile-div-form">
                                <div class="d-flex">
                                    <div class="d-flex align-items-center font-weight-bolder mr-3 enableEdit">Age :</div>
                                    <div class="md-form input-with-pre-icon profile-input-forms mx-0">
                                        <i class="fas fa-birthday-cake input-prefix enableEdit"></i>
                                        <input type="number" id="Age2" name="Age" value="<?php echo $userEditAge; ?>" class="form-control inputToDisable">
                                        <label for="Age2" class="pl-2"><?php echo $userAge; ?></label>
                                    </div>
                                </div>
                            </div>                    
                            <div class="d-flex profile-div-form w-50 float-right mt-4">                                
                                <div class="d-flex align-items-center justify-content-end font-weight-bolder finput-title enableEdit pr-3 w-0">Role :</div>
                                <select name="Role" class="md-form w-50 mx-0">
                                <?php if (isset($userRole) && ($userRole == 'Admin')) { ?> 
                                    <option value="" disabled>Choose Role</option>
                                    <option value="Admin" selected>Admin</option>
                                    <option value="Moderator">Moderator</option>
                                    <option value="User">User</option>                                    
                                <?php } elseif (isset($userRole) && ($userRole == 'Moderator')) { ?>
                                    <option value="" disabled>Choose Role</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Moderator" selected>Moderator</option>
                                    <option value="User">User</option>                                    
                                <?php } elseif (isset($userRole) && ($userRole == 'User')) { ?>
                                    <option value="" disabled>Choose Role</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Moderator">Moderator</option>
                                    <option value="User" selected>User</option>                                    
                                <?php } ?>                            
                                </select>
                            </div>
                            <div class="d-flex profile-div-form w-50">
                                <div class="d-flex align-items-center font-weight-bolder finput-title enableEdit">Address :</div>
                                <div class="md-form input-with-pre-icon w-100 profile-input-forms mx-0">
                                    <i class="fas fa-map-marker-alt input-prefix enableEdit"></i>
                                    <input type="text" id="Address2" name="Address" value="<?php echo $userEditAddress; ?>" class="form-control inputToDisable">
                                    <label for="Address2" class="pl-2"><?php echo $userAddress; ?></label>
                                </div>
                            </div>

                            <button type="submit" name="edit-user-button" class="btn create-btn mt-3 float-right"> Create</button>
                        </form>
                    </div>
                </div>

                <div class="tab-pane fade p-5" id="v-pills-Manage-Topics" role="tabpanel" aria-labelledby="v-pills-Manage-Topics-tab">
                    <div class="button-group">
                        <a href="#/" class="btn Topic-Manage-Btn General-btn">Manage</a>
                        <a href="#/" class="btn Topic-Add-Btn General-btn">Add</a>
                    </div>
                    <h2 class="page-title">Manage Topics</h2>  
                    <?php if (isset($_SESSION['Message']) && (($added == 'topic-add-success') || ($edited == 'topic-edit-success') || ($deleted == 'topic-delete'))) { 
                        echo $_SESSION['Message']; 
                        unset($_SESSION['Message']); 
                    }?> 

                    <div class="content">
                        <table>
                            <thead>
                                <th>N</th>
                                <th>Name</th>
                                <th colspan="2">Action</th>
                            </thead>
                            <tbody>
                                <?php foreach ($topics as $key => $topic) { ?>
                                <tr>
                                    <td> <?php echo $key+1; ?> </td>
                                    <td> <?php echo $topic['Name']; ?> </td>
                                    <td><a href="AdminFMA.php?id=<?php echo $topic['Id'] . '&manageType=manage-topic';?>"class="edit-post manage-links">Edit</a></td>
                                    <td><a href="#" class="delete-post manage-links" data-href="<?php echo $topic['Id'] . '*' . $topic['Name'] . '*' . "delete-topic";?>" data-toggle="modal" data-target="#confirm-delete">Delete</a></td>
                                </tr>
                                 <?php } ?>
                            </tbody>
                        </table>
                    </div>  

                </div>

                <div class="tab-pane fade p-5"  id="v-pills-add-Topic" role="tabpanel" aria-labelledby="v-pills-add-Topic-tab">                                    
                    
                    <div class="button-group">
                        <a href="#/" class="btn Topic-Manage-Btn General-btn">Manage</a>
                        <a href="#/" class="btn Topic-Add-Btn General-btn">Add</a>
                    </div>
                    <h2 class="page-title mb-5">Create Topic</h2>
                    <?php if (isset($_SESSION['Message']) && ($added == 'topic-add-success' )) { 
                        echo $_SESSION['Message']; 
                        unset($_SESSION['Message']); 
                    }?> 

                    <div class="form-container">
                        <form action="AdminFMA.php" method="post" class="d-flex flex-column">
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="name" value="<?php echo $topicAddName;?>" class="w-100" required>
                            </div>
                            <div class="mb-3">
                                <label>Description</label>
                                <textarea name="description" id="descriptionID1" rows="6" class="w-100"><?php echo $topicAddDescription;?></textarea>
                            </div>
                            <button type="submit" name="add-topic-btn" class="btn create-btn"> Create</button>
                        </form>
                    </div>
                </div>

                <div class="tab-pane fade p-5"  id="v-pills-edit-Topic" role="tabpanel" aria-labelledby="v-pills-edit-Topic-tab">                                    
                  
                    <div class="button-group">
                        <a href="#/" class="btn Topic-Manage-Btn General-btn">Manage</a>
                        <a href="#/" class="btn Topic-Add-Btn General-btn">Add</a>
                    </div>
                    <h2 class="page-title mb-5">Edit Topic</h2>
                    <?php if (isset($_SESSION['Message']) && ($edited == 'topic-edit-fail' )) { 
                        echo $_SESSION['Message']; 
                        unset($_SESSION['Message']); 
                    }?> 

                    <div class="form-container">
                        <form action="AdminFMA.php" method="post" class="d-flex flex-column">
                            <input type="hidden" name="Id" value="<?php echo $topicId;?>">
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="name" value="<?php echo $topicEditName;?>" class="w-100">
                            </div>
                            <div class="mb-3">
                                <label>Description</label>
                                <textarea id="descriptionID2" name="description" rows="6" class="w-100"><?php echo $topicEditDescription;?></textarea>
                            </div>
                            <button type="submit" name="edit-topic-btn" class="btn create-btn"> Edit</button>
                        </form>
                    </div>
                </div>

                <div class="tab-pane fade p-5" id="v-pills-logout" role="tabpanel" aria-labelledby="v-pills-logout-tab">
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


<script src="ckeditor5-build-classic\ckeditor.js"></script>
<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/nnattawat/flip/master/dist/jquery.flip.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.16.0/js/mdb.min.js"></script>

<!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script>
var textAreas = [document.querySelector( '#editor1' ), document.querySelector( '#editor2' )];

textAreas.forEach(element => {
    ClassicEditor.create( element,  {
        // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
    } )
    .then( editor => {
        window.editor = editor;
    } )
    .catch( err => {
        console.error( err.stack );
    } );
});

</script>
<!-- <script src="Javascript\General.js"></script> -->
<script src="Javascript\Admin.Js"></script>
<script type="text/javascript">

    ///////// SWITCH TAB MANAGE/ADD //////////////

        <?php if ($added === 'topic-add-success') {?>
            $('#v-pills-Manage-Topics-tab').click();  
        <?php } elseif ($added === 'topic-add-fail') {?>
            $('#v-pills-add-Topic-tab').click();  
            $('#v-pills-Manage-Topics-tab').addClass('active');
            <?php } elseif ($added === 'post-add-success') {?>          
            $('#v-pills-Manage-Posts-tab').click();  
            $('#v-pills-Manage-Posts-tab').addClass('active');
        <?php } elseif ($added === 'post-add-fail') {?>          
            $('#v-pills-add-post-tab').click();  
            $('#v-pills-Manage-Posts-tab').addClass('active');
        <?php } elseif ($added === 'user-add-success') {?>
            $('#v-pills-Manage-Users-tab').click();  
        <?php } elseif ($added === 'user-add-fail') {?>
            $('#v-pills-add-Users-tab').click();  
            $('#v-pills-Manage-Users-tab').addClass('active');    
        <?php }?>

        <?php if ($edited === 'topic-edit-success') {?>
            $('#v-pills-Manage-Topics-tab').click();  
        <?php } elseif ($edited === 'topic-edit-fail') {?>
            $('#v-pills-edit-Topic-tab').click();  
            $('#v-pills-Manage-Topics-tab').addClass('active');
        <?php } elseif ($edited === 'post-edit-success') {?>          
            $('#v-pills-Manage-Posts-tab').click();  
            $('#v-pills-Manage-Posts-tab').addClass('active');
        <?php } elseif ($edited === 'post-edit-fail') {?>
            $('#v-pills-edit-post-tab').click();  
            $('#v-pills-Manage-Posts-tab').addClass('active');
        <?php } elseif ($edited === 'user-edit-success') {?>
            $('#v-pills-Manage-Users-tab').click();  
        <?php } elseif ($edited === 'user-edit-fail') {?>
            $('#v-pills-edit-Users-tab').click();  
            $('#v-pills-Manage-Users-tab').addClass('active');    
        <?php }?>

        <?php if ($deleted === 'post-delete') {?>
            $('#v-pills-Manage-Posts-tab').click();  
        <?php } elseif ($deleted === 'topic-delete') {?>
            $('#v-pills-Manage-Topics-tab').click();  
        <?php } elseif ($deleted === 'user-delete') {?>
            $('#v-pills-Manage-Users-tab').click();  
        <?php } ?>

        <?php if ($manageType === 'manage-post') {?>
            $('#v-pills-edit-post-tab').click();  
            $('#v-pills-Manage-Posts-tab').addClass('active');
        <?php } elseif ($manageType === 'manage-topic') {?>
            $('#v-pills-edit-Topic-tab').click();  
            $('#v-pills-Manage-Topics-tab').addClass('active');
            <?php } elseif ($manageType === 'manage-user') {?>
            $('#v-pills-edit-Users-tab').click();  
            $('#v-pills-Manage-Users-tab').addClass('active');    
        <?php } ?>
</script>
</body>
</html>