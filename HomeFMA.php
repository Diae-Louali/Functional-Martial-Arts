<?php

$centerOnAlert=0;

if (isset($_SESSION["Center"])) {
    $centerOnAlert=1;
    unset($_SESSION["Center"]);
}

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

    <title>F.M.A</title>
</head>
<body>
<Section>   
    <!-- sign in Modal -->
    <?php include("Includes\Modal\Modal-Login.php");?>
    <!-- sign out Modal -->
    <?php include("Includes\Modal\Modal-logout.php");?>

        <?php include("Includes\Header\StickyNav.php");?>
    <header>
        <?php include("Includes\Header\NormalNav.php"); ?> 
    </header>
    <main>
    <?php if (isset($_SESSION['Error'])) { echo $_SESSION['Error']; } 
    unset($_SESSION['Error']);?> 
    <div class="post-slider">
        <h1 class="slider-title">Trending Posts</h1>
        <i class="fas fa-chevron-left prev"></i>
        <i class="fas fa-chevron-right next"></i>
        <div class="post-wrapper">
            
            <?php foreach ($popularPosts as $key => $popularPost) {?>
                <div class="post"> 
                    <img src="<?php echo 'Uploads/' . $popularPost['Image']; ?>" href="ArticleFMA.php?id=<?php echo $popularPost['Id'];?>" class="slider-image">
                    <div class="post-info">
                        <h5><a href="ArticleFMA.php?id=<?php echo $popularPost['Id'];?>" class="text-decoration-none post-slider-title"><?php echo $popularPost['Title'];?></a></h5>
                        <i class="far fa-user">  <?php echo $popularPost['Username'];?> </i>
                        &nbsp;
                        <i class="far fa-calendar">  <?php echo date('F j, Y', strtotime($popularPost['PublicationDate'])); ?></i>
                    </div>
                </div>
            <?php } ?>     
               
        </div>
    </div>

    <div class="content clearfix">

        <div class="main-content">
            <h1 class="post-title"> <?php echo $postMainTitle;?> </h1>
            
            <?php  if (isset($searchResult)) { echo $searchResult; } ?> 
            <?php foreach ($publishedPosts as $key => $publishedPost) {?>
                <div class="post clearfix">
                    <img src="<?php echo 'Uploads/' . $publishedPost['Image']; ?>" class="post-image">
                    <div class="post-preview">
                        <h3><a href="ArticleFMA.php?id=<?php echo $publishedPost['Id'];?>" class="text-decoration-none font-weight-bold"><?php echo $publishedPost['Title'];?></a></h3>
                        <i class="far fa-user">  <?php echo $publishedPost['Username'];?></i>
                        &nbsp;
                        <i class="far fa-calendar">  <?php echo date('F j, Y', strtotime($publishedPost['PublicationDate'])); ?></i>
                        <div class="preview-text">
                            <?php echo html_entity_decode(substr($publishedPost['Content'], 0, strpos($publishedPost['Content'],' ',150))).'...';;?>                           
                        </div>
                        <a href="ArticleFMA.php?id=<?php echo $publishedPost['Id'];?>" class="btn waves-effect"> Read more</a>
                    </div>
                </div>
            <?php } ?>     
       
        </div>
        
        <div class="sidebar">
            <div class="section search">
                <h2 class="section-title">Search</h2>
                <form action="HomeFMA.php" method="post">
                    <input type="text" name="search-term" class="text-input" placeholder="Search...">
                </form>
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
    </aside>

    <footer>
        <?php include("Includes\Footer.php");?>
    </footer> 


</Section>   
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<!-- JQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.16.0/js/mdb.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script  src="Javascript\General.js"></script> 
</body>
</html>