<?php
require("MasterPHPFMA.php");

$AccessDenied= "<br>"."<p id='ENTERLOGIN'> Enter your login information.</p>";

if (isset($_POST["submitlogin"])){
    $user = selectOne('user', ['Username' => $_POST['UsernameInput']]);
    if ($user && password_verify($_POST['PasswordInput'], $user['Password'])) {
        loginUser($user);
    } else {
        $AccessDenied= "<br>"."<p id='Acessdenied'> Your login information is incorrect."."<br>"." Please try again !</p>";
    }
}
 
if (isset($_GET['id'])) {
    $AuthorId = searchForId($_GET['id'], $popularPosts);
    $Article = $popularPosts[$AuthorId];
    $_SESSION['Article_ID']= $Article['Id'];
} else {
    $Article = $popularPosts[3];
    $_SESSION['Article_ID']= $Article['Id'];
}






?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="Css\HomeFMA.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.16.0/css/mdb.min.css" rel="stylesheet">
        <!-- FONT FAMILY -->
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">


    <!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<!-- Google Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">

    <title><?php echo $Article['Title'];?></title>
</head>
<body>
    
<Section>
    <!-- sign in Modal -->
    <?php include("Includes\Modal\Modal-Login.php");?>
    <!-- sign out Modal -->
    <?php include("Includes\Modal\Modal-logout.php");?>

        <?php include("Includes\Header\StickyNav.php");?>
    <header  class="Article_Header">
        <?php include("Includes\Header\NormalNav.php"); ?> 
    </header>

    <main>
        <div class="content clearfix">
            <div class="main-content-wrapper">
                <div class="main-content article">
                    <h1 class="article-title"><?php echo $Article['Title'];?></h1>
                    <div class="written-by pt-2">  
                        By <span><i class="far fa-user"> <?php echo $Article['Username'];?></i> </span> | 
                        <a href="#/"> <i class="fab fa-twitter"> <?php echo '@'.$Article['Username'];?></a></i> | 
                        <i class="far fa-calendar"> <?php echo date('F j, Y h:i:s A', strtotime($Article['PublicationDate']));?></i> 
                    </div>               
                    <img class="image-article" src="<?php echo 'Uploads/' . $Article['Image'];?>" alt="">
                    
                    <div class="post-content">
                        <?php echo html_entity_decode($Article['Content']);?>
                    </div>

                    <div class="article-comment-section">
                        <!-- Comment section -->
                        <div id='comment-margin'>

                            <!-- comments section -->
                            <div style="display: none;" id="text-area" class=" comments-section">
                                <!-- comment form -->
                                <form class="clearfix comment_form0" action="" method="post" id="comment_form" onsubmit='return post_reply(0);'>
                                    <h4 class=''>Post a comment:</h4>
                                    <span id="comment_message"></span>
                                    <input type="hidden" class="parentID" value="0" name="parent_ID">
                                    <input type="hidden" class="userID" value="" name="user_ID">
                                    <input type="hidden" class="articleID" value="<?php echo $Article['Id'];?>" name="article_ID">
                                    <textarea id="comment_content" type="text" name="comment_content" cols="40" rows="5" class="comment_text form-control" placeholder="What are your thoughts ?"></textarea>
                                    <input type="submit" class='btn contact-btn' id="submit_comment" value="Submit comment" name="submitComment">
                                </form>
                                <span id='empty_comment' class='text-danger'></span>
                            </div>

                            
                                <div id="links" class='links text-dark'>
                                    <p style="padding-bottom:10px; margin-bottom: 0px;">To leave a comment, please <a data-toggle='modal' data-dismiss='modal' data-target='#exampleModal' href='#'> Sign In</a> .</p> 
                                    <p style="padding-top:10px; margin-top:0px;">Don't have an account? <a id='signIn' href='#' data-toggle='modal' data-dismiss='modal' data-target='#exampleModal2'> Sign Up</a> .</p> 
                                </div>
                            

                            <div>

                                <!-- Display total number of comments on this post  -->
                                <p class='gray my-2 text-dark'>"<span id="comment_count">0</span>" Comment(s)</p>
                                <div class="d-flex">
                                    <label for="Sort_by" class="mr-2">Sort By : </label>
                                    <select name="" id="Sort_by"> 
                                        <option value="">Top</option>
                                        <option value="">New</option>
                                        <option value="">Controversial</option>
                                        <option value="">Old</option>
                                    </select>
                                </div>
                                <hr class='m-0'>
                                <!-- comments wrapper -->
                                <div id="comments-wrapper">
                                    <div id="comment_section" class="comment clearfix">
                                            
                                        

                                    </div>
                                </div>
                                <!-- // comments wrapper -->
                            </div>
                            <!-- // comments section -->
                        </div>
                    
                    </div>
                </div>
            </div>

            <div class="sidebar article">

                <div class="section search mt-0">
                    <h2 class="section-title">Search</h2>
                    <form action="HomeFMA.php" method="post">
                        <input type="text" name="search-term" class="text-input" placeholder="Search...">
                    </form>
                </div>

                <div class="section popular px-0">
                    <h2 class="section-title px-3 mx-1">Popular</h2>
                    
                    <?php foreach ($popularPosts as $key => $popularPost) {
                        if ($Article['Id'] !== $popularPost['Id']) {?>
                            <div class="post clearfix px-3">
                                <img src="<?php echo 'Uploads/' . $popularPost['Image']; ?>" alt="">
                                <a href="ArticleFMA.php?id=<?php echo $popularPost['Id'];?>" class="title"><?php echo $popularPost['Title'];?></a>
                            </div>
                    <?php   }                                           
                        } ?>     



                </div>

                <div class="section topics">
                    <h2 class="section-title">Categories</h2>
                    <ul>
                    <?php foreach ($topics as $key => $topic) { ?>
                        <li><a href="HomeFMA.php?t_id=<?php echo $topic['Id'] . '&t_name=' . $topic['Name'];?>"><?php echo $topic['Name']; ?></a></li>
                    <?php } ?>
                    </ul>
                </div>
            </div>

        </div>
    </main>

    <aside>
        <div id="scrolltoodiv" class="scrolltodiv"></div>
    </aside>

    <footer>
        <?php include("Includes\Footer.php");?>
    </footer> 


</Section>   

<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>


<!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script> -->
<!-- JQuery -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
<!-- MDB core JavaScript -->
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.16.0/js/mdb.min.js"></script> -->
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script> -->

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="Javascript\General.js"></script>
<script src="Javascript\moment.js"></script>
<script src="Javascript\Comment.js"></script>
<script>
$(document).ready(function() {
    <?php if (isset($_GET['comment_Id'])) {?>
    var commentId = <?php echo $_GET['comment_Id']?>;
    setTimeout(function(){
        
        console.log($('#THEComment'+commentId).height());
        console.log('#THEComment'+commentId);
        console.log($('#THEComment'+commentId));
        $('#THEComment'+commentId).addClass("highlight");
    setTimeout(function () {
        $('#THEComment'+commentId).removeClass('highlight');
    }, 5000);

        
        $('html, body').animate({scrollTop:$('#THEComment'+commentId).position().top - $(window).height()/2 + ($('#THEComment'+commentId).height()/2)}, 'slow');
    }, 500);        
    <?php } else { ?>
    const string = window.location.href;
    const substring1 = "?id=";
    const substring2 = "?comment_Id=";
    IdCheck= string.includes(substring1);

    if (($(".article-title").length) && IdCheck) {
        $([document.documentElement, document.body]).animate({
            scrollTop: $(window).height() - 50
        }, 500);         
        }
    <?php } ?> 



});

</script>
</body>
</html>