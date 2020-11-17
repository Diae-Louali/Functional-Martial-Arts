<!DOCTYPE html>
<!--
Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
-->
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<link type="text/css" href="sample/css/sample.css" rel="stylesheet" media="screen" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.16.0/css/mdb.min.css" rel="stylesheet">
    <!-- FONT FAMILY -->
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

	
	
	<title>CKEditor 5 – classic editor build sample</title>
</head>
<body>

<header>
	<div class="centered">
		<h1><a href="https://ckeditor.com/ckeditor-5"><img src="sample/img/logo.svg" alt="WYSIWYG editor - CKEditor 5" /></a></h1>

		<input type="checkbox" id="menu-toggle" />
		<label for="menu-toggle"></label>
		  
		<nav>
			<ul>
				<li><a href="https://ckeditor.com/ckeditor-5">Project homepage</a></li>
				<li><a href="https://ckeditor.com/docs/">Documentation</a></li>
				<li><a href="https://github.com/ckeditor/ckeditor5">GitHub</a></li>
			</ul>
		</nav>
	</div>
</header>

<main>
	<div class="container mx-md-0 mw-100 px-0 h-100">

        <div class="row h-100">

            <div class="admin-nav-wrapper col-xl-2 col-lg-3 px-0 h-100">
                <div class="admin-nav-container h-100">
                    <div class="nav flex-column nav-pills py-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active w-100 rounded-0" id="v-pills-Manage-Articles-tab" data-toggle="pill" href="#v-pills-Manage-Articles" role="tab" aria-controls="v-pills-Manage-Articles" aria-selected="true"><i class="fas fa-paste"></i> Manage Articles</a>
                        <a class="nav-link w-100 rounded-0" id="v-pills-change-Manage-Users-tab" data-toggle="pill" href="#v-pills-change-Manage-Users" role="tab" aria-controls="v-pills-change-Manage-Users" aria-selected="false"><i class="fas fa-users-cog"></i> Manage Users</a>
                        <a class="nav-link w-100 rounded-0" id="v-pills-Manage-Topics-tab" data-toggle="pill" href="#v-pills-Manage-Topics" role="tab" aria-controls="v-pills-Manage-Topics" aria-selected="false"><i class="fas fa-newspaper"></i> Manage Topics</a>
                        <a class="nav-link w-100 rounded-0" id="v-pills-logout-tab" data-toggle="pill" href="#v-pills-logout" role="tab" aria-controls="v-pills-logout" aria-selected="false"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        <a class="nav-link w-100 rounded-0" id="v-pills-add-post-tab" data-toggle="pill" href="#v-pills-add-post" role="tab" aria-controls="v-pills-add-post" aria-selected="true">Add Post</a>
                    </div>
                </div>

            </div>

            <div class="admin-content col-xl-10 col-lg-9 tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-Manage-Articles" role="tabpanel" aria-labelledby="v-pills-Manage-Articles-tab">                                    
                    
                    <div class="button-group">
                        <a href="#/" class="btn">Add Post</a>
                        <a href="#/" class="btn">Edit Posts</a>
                    </div>
                    <h2 class="page-title">Manage Articles</h2>

                    <div class="content">

                        <table>
                            <thead>
                                <th>N</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th colspan="3">Action</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>This is the first post</td>
                                    <td>Diae</td>
                                    <td><a href="#/" class="edit-post">Edit</a></td>
                                    <td><a href="#/" class="delete-post">Delete</a></td>
                                    <td><a href="#/" class="publish-post">Publish</a></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>This is the second post</td>
                                    <td>Diae</td>
                                    <td><a href="#/" class="edit-post">Edit</a></td>
                                    <td><a href="#/" class="delete-post">Delete</a></td>
                                    <td><a href="#/" class="publish-post">Publish</a></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>This is the third post</td>
                                    <td>Diae</td>
                                    <td><a href="#/" class="edit-post">Edit</a></td>
                                    <td><a href="#/" class="delete-post">Delete</a></td>
                                    <td><a href="#/" class="publish-post">Publish</a></td>
                                </tr>
                            </tbody>
                        </table>






                    </div>                    

                </div>
                
                <div class="tab-pane fade" id="v-pills-add-post" role="tabpanel" aria-labelledby="v-pills-add-post-tab">                                    
                    <h2 class="page-title">Create Article</h2>
                    <form action="">
                        
                        <div>
                            <label>Title</label>
                            <input type="text" name="title" class="text-input">
                        </div>

                        <div>
                            <label>Content</label>
                            <div id="editor">
                                <h2>The three greatest things you learn from traveling</h2>

                                <p>Like all the great things on earth traveling teaches us by example. Here are some of the most precious lessons I’ve learned over the years of traveling.</p>

                                <h3>Appreciation of diversity</h3>

                                <p>Getting used to an entirely different culture can be challenging. While it’s also nice to learn about cultures online or from books, nothing comes close to experiencing <a href="https://en.wikipedia.org/wiki/Cultural_diversity">cultural diversity</a> in person. You learn to appreciate each and every single one of the differences while you become more culturally fluid.</p>

                                <figure class="image image-style-side"><img src="sample/img/umbrellas.jpg" alt="Three Monks walking on ancient temple.">
                                    <figcaption>Leaving your comfort zone might lead you to such beautiful sceneries like this one.</figcaption>
                                </figure>

                                <h3>Confidence</h3>

                                <p>Going to a new place can be quite terrifying. While change and uncertainty makes us scared, traveling teaches us how ridiculous it is to be afraid of something before it happens. The moment you face your fear and see there was nothing to be afraid of, is the moment you discover bliss.</p>
                            </div>
                        </div>

                        <div>
                            <select name="Categorie" class="text-input">
                                <option value="Brazilian Jiu-jitsu">Brazilian Jiu-jitsu</option>
                                <option value="Boxing">Boxing</option>
                                <option value="Mixed Martial Arts">Mixed Martial Arts</option>
                                <option value="Muay Thai">Muay Thai</option>
                                <option value="Kickboxing">Kickboxing</option>
                                <option value="Judo">Judo</option>
                                <option value="Wrestling">Wrestling</option>
                            </select>
                        </div>
                        <button type="submit" class="btn"> Create</button>
                    </form>
                 </div>

                <div class="tab-pane fade" id="v-pills-change-Manage-Users" role="tabpanel" aria-labelledby="v-pills-change-Manage-Users-tab">
                                       
                </div>

                <div class="tab-pane fade" id="v-pills-Manage-Topics" role="tabpanel" aria-labelledby="v-pills-Manage-Topics-tab">
               
                </div>

                <div class="tab-pane fade" id="v-pills-logout" role="tabpanel" aria-labelledby="v-pills-logout-tab">

                </div>
            </div>
        </div>

    </div>

</main>

<footer>
	<div>
		<p>CKEditor 5 – The text editor for the Internet – <a href="https://ckeditor.com/ckeditor-5">https://ckeditor.com/ckeditor-5</a></p>
		<p>Copyright © 2003-2019, <a href="https://cksource.com/">CKSource</a> – Frederico Knabben. All rights reserved.</p>
	</div>
</footer>

<script src="ckeditor.js"></script>
<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.16.0/js/mdb.min.js"></script>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
ClassicEditor
		.create( document.querySelector( '#editor' ), {
			// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
		} )
		.then( editor => {
			window.editor = editor;
		} )
		.catch( err => {
			console.error( err.stack );
		} );
</script>

<script type="text/javascript">

    var toggleButton = [document.getElementsByClassName('toggle-button')[0]];
    var navbarLinks = [document.getElementsByClassName('navbar-links')[0]];
    var myHeaderNavdiv = document.getElementById("HEADERNavbar");
    var brandHeadActive = [document.getElementsByClassName('BrandFMA')[0]];



    toggleButton.forEach(element => {
        element.addEventListener('click', () => {
            toggleButton.forEach(item => {
                item.classList.toggle('open');
            });
            navbarLinks.forEach(item => {
                item.classList.toggle('active');
            });
            myHeaderNavdiv.classList.toggle('padding-border-botom');
            brandHeadActive.forEach(item => {
                item.classList.toggle('BrandHeadActive');
            });
        });
    });

// PREVIEW IMAGE

    function previewImage(event){
        var previewdImage = document.getElementById("modal-img-preview");
        previewdImage.src = URL.createObjectURL(event.target.files[0]);
        previewdImage.width = "200";
        previewdImage.height = "200";
    }

// EDITPROFILE
    var toggleEditInputBtn = document.getElementById("toggleEditProfile");
    var EnableEditTxtStyle = document.querySelectorAll(".enableEdit");
    var inputDisableToggle = document.querySelectorAll('.inputToDisable');

    toggleEditInputBtn.addEventListener('click', () => {
        toggleEditInputBtn.classList.toggle('editbutn');
        toggleEditInputBtn.classList.toggle('editbutntoggled');
        inputDisableToggle.forEach(item => {
        if (toggleEditInputBtn.classList.contains("editbutn")) {
            item.setAttribute("disabled","");
        } else {
            item.removeAttribute("disabled","");
        }
        });
        EnableEditTxtStyle.forEach(item => {
            item.classList.toggle("enableEdit");
            item.classList.toggle("text-edit-style");

        });

    });

// SHOW PASSWORD
    var passOldVis = document.getElementById("Old-Password");
    var passNewVis = document.getElementById("New-Password");
    var passConfirmVis = document.getElementById("Confirm-Password");
    var eyeIcon1 = document.getElementById("EYEICON1");
    var eyeIcon2 = document.getElementById("EYEICON2");
    var eyeIcon3 = document.getElementById("EYEICON3");

    eyeIcon1.addEventListener('click', () => {

    if (passOldVis.type === "password") {
        passOldVis.type = "text";
        eyeIcon1.classList.remove("fa-eye");
        eyeIcon1.classList.add("fa-eye-slash");
        eyeIcon1.classList.add("eye-icon-gray");
    } else {
        passOldVis.type = "password";
        eyeIcon1.classList.remove("fa-eye-slash");
        eyeIcon1.classList.remove("eye-icon-gray");
        eyeIcon1.classList.add("fa-eye");
    }
    });

    eyeIcon2.addEventListener('click', () => {

        if (passNewVis.type === "password") {
        passNewVis.type = "text";
        eyeIcon2.classList.remove("fa-eye");
        eyeIcon2.classList.add("fa-eye-slash");
        eyeIcon2.classList.add("eye-icon-gray");
        } else {
        passNewVis.type = "password";
        eyeIcon2.classList.remove("fa-eye-slash");
        eyeIcon2.classList.remove("eye-icon-gray");
        eyeIcon2.classList.add("fa-eye");
        }
    });

    eyeIcon3.addEventListener('click', () => {

        if (passConfirmVis.type === "password") {
        passConfirmVis.type = "text";
        eyeIcon3.classList.remove("fa-eye");
        eyeIcon3.classList.add("fa-eye-slash");
        eyeIcon3.classList.add("eye-icon-gray");
        } else {
        passConfirmVis.type = "password";
        eyeIcon3.classList.remove("fa-eye-slash");
        eyeIcon3.classList.remove("eye-icon-gray");
        eyeIcon3.classList.add("fa-eye");
        }
    });

/////////// SHOW DROPDOWN MENU AND STYLE////////////////
    $('.dropdown-toggleCustom').click(function() {
        $('.dropdown-menuCUSTOM').toggleClass('ShowDropDownMenu');  
    });

</script>

</body>
</html>
