
var toggleButton = [document.getElementsByClassName('toggle-button')[0]];
var navbarLinks = [document.getElementsByClassName('navbar-links')[0]];
var myHeaderNavdiv = document.getElementById("HEADERNavbar");
var brandHeadActive = [document.getElementsByClassName('BrandFMA')[0]];

// TOGGLE HAMBURGER MENU //

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
    $('#canceleditID').click(function() {
        $('#toggleEditProfile').removeClass('editbutntoggled');
        $('#toggleEditProfile').addClass('editbutn');
        $('#registrationForm input').val('').removeClass('valid invalid').attr("disabled", true);
        $('#registrationForm label').removeClass('active');

    })
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

// CONFIRM PASSWORD

function validatePassword(){
if(passNewVis.value != passConfirmVis.value) {
    passConfirmVis.setCustomValidity("Passwords Don't Match");
} else {
    passConfirmVis.setCustomValidity('');
}
}

passNewVis.onchange = validatePassword;
passConfirmVis.onkeyup = validatePassword;

/////////// SHOW DROPDOWN MENU AND STYLE////////////////
$('.dropdown-toggleCustom').click(function() {
    $('.dropdown-menuCUSTOM').toggleClass('ShowDropDownMenu'); 
    $('.dropdown-toggleCustom').toggleClass('hovered');   
    $(".vlfordropdown").toggleClass("vlhovered");
    $(".hrForMainContClass").toggleClass("hrhovered");    
    $(".Arrow-Icon").css("font-size", "0%").delay(200).queue(function (next) {
         $(this).toggleClass("fa-chevron-down fa-chevron-up").css("font-size", "13px"); 
         next();
    });
});

// CANCEL LOGOUT 

$('#cancel-logout').click(function() {
    $('#v-pills-logout-tab').removeClass('active');  
    $('#v-pills-profile-tab').click();  
});

// CLOAS ALL MODALS BEFORE OPENING ONE
$('.modal').on('show.bs.modal', function () {
    $('.modal').not($(this)).each(function () {
        $(this).modal('hide');
    });
});

// KEEP CURRENT TAB ACTIVE ON RELOAD

$('#v-pills-tab a').click(function(e) {
    e.preventDefault();
    $(this).tab('show');
  });
  
  // store the currently selected tab in the hash value
  $("#v-pills-tab > a").on("shown.bs.tab", function(e) {
    var id = $(e.target).attr("href").substr(1);
    window.location.hash = id;
  });
  
  // on load of the page: switch to the currently selected tab
  var hash = window.location.hash;
  $('#v-pills-tab a[href="' + hash + '"]').tab('show');
  
// HIDE ERROR MSG
setTimeout(function() {
    $('.nav-link').click(function() {
        $('.alert').addClass('d-none');
    });
}, 5000);

// AJAX
// PFP
function upload_pfp() {
    event.preventDefault()
    var form_data = new FormData($('#upload_Img_Form')[0]);
        console.log(form_data);
    $.ajax({
        url: 'PHP_AJAX_Queries/upload_image.php',
        type: 'post',
        data: form_data,
        dataType:"json",
        contentType: false,
        processData: false,
        success: function(data){
            console.log(data);
            if(data.validation === 1) {
                console.log(data.validation);
                $('.pfp').attr('src','uploads/' + data.pfp);
                $('.navpfp').attr('src','uploads/' + data.pfp);
                $("#uploadModal").modal("hide");
                $(".modal-backdrop").css({"height":"0%", "width":"0%"});
                $(".modal-open").css({"overflow":"visible"});
            } else {
                $('#error_upload').html(data.error);
                $('#uploadModal').on('hidden.bs.modal', function () {
                    $('#error_upload').html('');
                    $('.pfp_preview').attr('src','');
                    $('.pfp_preview').attr('width',0);
                    $('.pfp_preview').attr('height',0);
                    $('#file-upload').val('');

                  })
                  
            }
        },
    });
}

