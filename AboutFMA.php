<?php
require("MasterPHPFMA.php");
// usersOnly();


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
} else {
    $Article = $popularPosts[3];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="Css\HomeFMA.css">
        <link rel="stylesheet" type="text/css" href="Css\AboutFMA.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.16.0/css/mdb.min.css" rel="stylesheet">
        <!-- FONT FAMILY -->
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <title><?php echo $Article['Title'];?></title>
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

    <main class="about_main">
     <div class="first_div text-center"> 
        <h1 class="mb-3">Functional martial art</h1> 
        <p class="start_quote">Lorem ipsum dolor, sit amet consectetur adipisicing 
        elit.</p>
     </div>
     <div class="even_odd_divs text-center first_div">
        <div class="font-italic"> Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officia explicabo 
        cumque aut necessitatibus reprehenderit architecto? Voluptatibus doloremque 
        facere illo in maxime quo alias quibusdam delectus magni incidunt ipsum 
        architecto, quasi laborum fugiat enim blanditiis placeat nulla veniam quidem
        cumque nemo modi eveniet! Debitis, voluptatibus. Accusantium maiores 
        exercitationem accusamus delectus quae, culpa labore facilis natus quas quasi 
        nisi voluptas pariatur excepturi illum vero aut soluta dolorum temporibus.</div>       
        <i class="fas fa-caret-down"></i>
     </div>
     <div class="even_odd_divs">
        <img src="Images\Carlos-Condit.jpg" alt="" class="Img_about">
        <h2 class="mb-4 mt-4">Lorem, ipsum dolor.</h2>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officia explicabo 
        cumque aut necessitatibus reprehenderit architecto? Voluptatibus doloremque 
        facere illo in maxime quo alias quibusdam delectus magni incidunt ipsum 
        architecto, quasi laborum fugiat enim blanditiis placeat nulla veniam quidem
        cumque nemo modi eveniet! Debitis, voluptatibus. Accusantium maiores 
        exercitationem accusamus delectus quae, culpa labore facilis natus quas quasi 
        nisi voluptas temporibus.</p>
        <i class="fas fa-caret-down"></i>
     </div>   
     <div class="even_odd_divs">
        <img src="Images\Carlos-Condit.jpg" alt="" class="Img_about">
        <h2 class="mb-4 mt-4">Lorem ipsum dolor sit.</h2>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officia explicabo 
        cumque aut necessitatibus reprehenderit architecto? Voluptatibus doloremque 
        facere illo in maxime quo alias quibusdam delectus magni incidunt ipsum 
        architecto, quasi laborum fugiat enim blanditiis placeat nulla veniam quidem
        cumque nemo modi eveniet! Debitis, voluptatibus. Accusantium maiores 
        exercitationem accusamus delectus quae, culpa labore facilis natus quas quasi 
        nisi voluptas pariatur excepturi.</p>
        <i class="fas fa-caret-down"></i>
     </div>   
     <div class="even_odd_divs">
        <img src="Images\Carlos-Condit.jpg" alt="" class="Img_about">
        <h2 class="mb-4 mt-4">Lorem, ipsum.</h2>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officia explicabo 
        cumque aut necessitatibus reprehenderit architecto? Voluptatibus doloremque 
        facere illo in maxime quo alias quibusdam delectus magni incidunt ipsum 
        architecto, quasi laborum fugiat enim blanditiis placeat nulla veniam quidem
        cumque nemo modi eveniet! Debitis, voluptatibus. Accusantium maiores 
        exercitationem accusamus delectus quae, illum vero aut soluta dolorum temporibus.</p>
        <i class="fas fa-caret-down"></i>
     </div>   
     <div class="even_odd_divs">
        <img src="Images\Carlos-Condit.jpg" alt="" class="Img_about">
        <h2 class="mb-4 mt-4">Lorem sit amet.</h2>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officia explicabo 
        cumque aut necessitatibus reprehenderit architecto? Voluptatibus doloremque 
        facere illo in maxime quo alias quibusdam delectus magni incidunt ipsum 
        architecto, quasi laborum fugiat enim blanditiis. Accusantium maiores 
        exercitationem accusamus delectus quae, culpa labore facilis natus quas quasi 
        nisi voluptas pariatur excepturi illum vero aut soluta dolorum temporibus.</p>
        <i class="fas fa-caret-down"></i>
     </div>   
     <div class="even_odd_divs">
        <img src="Images\Carlos-Condit.jpg" alt="" class="Img_about">
        <h2 class="mb-4 mt-4">Lorem ipsum dolor sit amet.</h2>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officia explicabo 
        cumque aut necessitatibus reprehenderit architecto? Voluptatibus doloremque 
        facere illo in maxime quo alias quibusdam delectus magni incidunt ipsum 
        architecto, quasi laborum fugiat enim blanditiis. Accusantium maiores 
        exercitationem accusamus delectus quae, culpa labore facilis natus quas quasi 
        nisi voluptas pariatur excepturi illum vero aut soluta dolorum temporibus.</p>
        <i class="fas fa-caret-down"></i>
     </div>   
     <div class="even_odd_divs end_div">
        <h2 class="text-center mb-4 mt-4">Lorem ipsum dolor sit amet consectetur?</h2>
        <div>
            <div class="position-relative end_quote font-italic">        
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officia explicabo 
                cumque aut necessitatibus reprehenderit architecto? Voluptatibus doloremque 
                facere illo in maxime quo alias quibusdam delectus magni incidunt ipsum 
                architecto, quasi laborum fugiat enim blanditiis placeat nulla veniam quidem
                cumque nemo modi eveniet! Debitis, voluptatibus. Accusantium maiores 
                exercitationem accusamus delectus quae, culpa labore facilis natus quas quasi 
                nisi voluptas pariatur excepturi illum vero aut soluta dolorum temporibus.
                <i class="fas fa-caret-down quote_caret"></i>
            </div>
            <div class="text-center">
                <img src="Images\me.jpg" alt="" class="picFounder">
                <p>
                    <span class="founder_name">Diae Louali</span>  
                    <br> 
                    Founder of <a href="HomeFMA.php">FMA</a>
                </p>   
            </div>

        </div>
        <!-- <i class="fas fa-caret-down"></i> -->
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
<script src="Javascript\General.js"></script>

</body>
</html>