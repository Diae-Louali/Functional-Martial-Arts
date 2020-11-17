// TOGGLE HAMBURGER MENU //

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
    
/////////// SHOW PASSWORD////////////////

    var passVis1 = document.getElementById("password1");
    var eyeIcon1 = document.getElementById("EYEICON1");
    var passVis2 = document.getElementById("password2");
    var eyeIcon2 = document.getElementById("EYEICON2");
           
    eyeIcon1.addEventListener('click', () => {

    if (passVis1.type === "password") {
        passVis1.type = "text";
        eyeIcon1.classList.remove("fa-eye");
        eyeIcon1.classList.add("fa-eye-slash");
        eyeIcon1.classList.add("eye-icon-gray");
    } else {
        passVis1.type = "password";
        eyeIcon1.classList.remove("fa-eye-slash");
        eyeIcon1.classList.remove("eye-icon-gray");
        eyeIcon1.classList.add("fa-eye");
    }
    });

    eyeIcon2.addEventListener('click', () => {

    if (passVis2.type === "password") {
        passVis2.type = "text";
        eyeIcon2.classList.remove("fa-eye");
        eyeIcon2.classList.add("fa-eye-slash");
        eyeIcon2.classList.add("eye-icon-gray");
    } else {
        passVis2.type = "password";
        eyeIcon2.classList.remove("fa-eye-slash");
        eyeIcon2.classList.remove("eye-icon-gray");
        eyeIcon2.classList.add("fa-eye");
    }
    });


///////// SWITCH TAB MANAGE/ADD //////////////

    $('.Post-Add-Btn').click(function() {
        $('#v-pills-add-post-tab').removeClass('active');  
        $('#v-pills-add-post-tab').click(); 
        $('#v-pills-Manage-Posts-tab').addClass('active');  
    });
    $('.Post-Manage-Btn').click(function() {
        $('#v-pills-Manage-Posts-tab').removeClass('active');  
        $('#v-pills-Manage-Posts-tab').click();  
    });

    $('.User-Add-Btn').click(function() {
        $('#v-pills-add-Users-tab').removeClass('active');    
        $('#v-pills-add-Users-tab').click(); 
        $('#v-pills-Manage-Users-tab').addClass('active');   
    });
    $('.User-Manage-Btn').click(function() {
        $('#v-pills-Manage-Users-tab').removeClass('active');    
        $('#v-pills-Manage-Users-tab').click();  
    });

    $('.Topic-Add-Btn').click(function() {
        $('#v-pills-add-Topic-tab').removeClass('active');  
        $('#v-pills-add-Topic-tab').click(); 
        $('#v-pills-Manage-Topics-tab').addClass('active');   
    });
    $('.Topic-Manage-Btn').click(function() {
        $('#v-pills-Manage-Topics-tab').removeClass('active');  
        $('#v-pills-Manage-Topics-tab').click();  
    });

    $('#cancel-logout').click(function() {
        $('#v-pills-logout-tab').removeClass('active');  
        $('#v-pills-Dashboard-tab').click();  
    });

    

// Modal Delete

    $('.confirm_delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));           
        $('.debug-url').html('<span class="font-weight-bold">Delete :</span> <p class="span2 font-weight-normal p-2" style="font-size:1rem">' + $(this).find('.btn-ok').attr('href').split('*')[1] + '</p>');
        $('input[name="Id-delete"]').val($(this).find('.btn-ok').attr('href').split('*')[0]);
        $('input[name="delete-type"]').val($(this).find('.btn-ok').attr('href').split('*')[2]);
        console.log($(this).find('.btn-ok').attr('href'));
    });

// HIDE ERROR MSG
    setTimeout(function() {
        $('.nav-link').click(function() {
            $('.alert').addClass('d-none');
        });
    }, 5000);
 //////////////////////////////////////////////////////////// 


 //line chart
var ctxL = document.getElementById("lineChart").getContext('2d');
var configL = {
type: 'line',
data: {
    labels: ["January", "February", "March", "April", "May", "June", "July"],
    datasets: [{
        label: "My First dataset",
        data: [65, 59, 80, 81, 56, 55, 40],
        backgroundColor: [
            'rgba(105, 0, 132, .2)',
        ],
        borderColor: [
            'rgba(200, 99, 132, .7)',
        ],
        borderWidth: 1
    },
    {
        label: "My Second dataset",
        data: [28, 48, 40, 19, 86, 27, 90],
        backgroundColor: [
            'rgba(0, 137, 132, .2)',
        ],
        borderColor: [
            'rgba(0, 10, 130, .7)',
        ],
        borderWidth: 2
    }
  ]
},
options: {
    responsive: true,
    legend: {
        labels: {
        padding: 10,
        boxWidth: 10,
        fontSize : 10
      }
    }
}
};    
var Linechart = new Chart(ctxL, configL);

//pie
var ctxP = document.getElementById("pieChart").getContext('2d');
var configP = {
  type: 'pie',
  data: {
    labels: ["Red", "Green", "Yellow", "Grey", "Dark Grey"],
    datasets: [{
      data: [300, 50, 100, 40, 120],
      backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1", "#4D5360"],
      hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5", "#616774"]
    }]
  },
  options: {
    animation: {
        easing: 'easeInOutQuint',
        duration: 1500
    },
    responsive: true,
    legend: {
      position: 'right',
      labels: {
        padding: 10,
        boxWidth: 10
      }
    },
    plugins: {
      datalabels: {
        formatter: (value, ctx) => {
          let sum = 0;
          let dataArr = ctx.chart.data.datasets[0].data;
          dataArr.map(data => {
            sum += data;
          });
          let percentage = (value * 100 / sum).toFixed(2) + "%";
          return percentage;
        },
        color: 'white',
        labels: {
          title: {
            font: {
              size: '20'
            }
          }
        }
      }
    }
  }
};
var Piechart = new Chart(ctxP, configP);




// Animate the element's value from x to y:
function countTo(elem, finalNum) {
    $({ someValue: 0 }).animate({ someValue: Math.floor(finalNum) }, {
        duration: 3000,
        easing: 'swing', // can be anything
        step: function () { // called on every step
        // Update the element's text with rounded-up value:                    
        elem.text(commaSeparateNumber(Math.round(this.someValue)));
        }
    });               
}

function commaSeparateNumber(val) {
    while (/(d+)(d{3})/.test(val.toString())) {
        val = val.toString().replace(/(d)(?=(ddd)+(?!d))/g, "$1,");
    }
    return val;
} 

function startCounterAt(maxWidth1050) {
    if (maxWidth1050.matches) { // If media query matches
        countTo($('.T-count'), 12438);
        countTo($('.Y-count'), 4591);
        countTo($('.F-count'), 52173);
        $('#flip-wrapper').removeClass('flip-card');
        $('#flip-container').removeClass('flip-card-inner');
        $('#flip-front').removeClass('flip-card-front');
        $('#flip-back').removeClass('flip-card-back');
        console.log('AUTO SCROLL ACTIVATED');
    } else {
        $('#flip-wrapper').addClass('flip-card');
        $('#flip-container').addClass('flip-card-inner');
        $('#flip-front').addClass('flip-card-front');
        $('#flip-back').addClass('flip-card-back');
    }

    if (($('#v-pills-Dashboard').hasClass('active')) && !maxWidth1050.matches) {
        $('.admin-content').css('overflow-y', 'hidden');
    } else {
        $('.admin-content').css('overflow-y', 'auto');
    }    
  }

var maxWidth1050 = window.matchMedia("(max-width: 1050px)")
startCounterAt(maxWidth1050) // Call listener function at run time
maxWidth1050.addListener(startCounterAt) // Attach listener function on state changes
  


///////////////FLIP ANIMATIONS///////////////
$('.nav-link').click(function() {    
    if (($(this).is('#v-pills-Dashboard-tab')) && ($( window ).width() > 1050)) {
        $('.admin-content').css('overflow-y', 'hidden');
    } else {
        $('.admin-content').css('overflow-y', 'auto');
    }
});


$('.PS-wrapper .fa-exchange-alt').click(function() {
    $('.flip-card').toggleClass('Rotactive');
    if ($('.flip-card').hasClass('Rotactive')) {
        countTo($('.T-count'), 12438)
        countTo($('.Y-count'), 4591)
        countTo($('.F-count'), 52173)
    } else {
        Piechart.destroy();
        Piechart = new Chart(ctxP, configP);
    }
});   

////// FLIP CARDS ANIMATION ///////

$("#card").flip({trigger: 'manual'});
$("#card-2").flip({trigger: 'manual'});
$("#card-3").flip({trigger: 'manual'});
$("#card-4").flip({trigger: 'manual'});

$('#card .fa-exchange-alt').click(function() {
    $("#card").flip('toggle');
});   
$('#card-2 .fa-exchange-alt').click(function() {
    $("#card-2").flip('toggle');
});   
$('#card-3 .fa-exchange-alt').click(function() {
    $("#card-3").flip('toggle');
});   
$('#card-4 .fa-exchange-alt').click(function() {
    $("#card-4").flip('toggle');
});   

//////////////// TRIGGER UPDATE/COUNT ANIMATION FOR STAT CARDS//////////////////

function countStartClick(trigger, target, number) {
    trigger.click(function() {
        countTo(target, number);
    }); 
}

countStartClick($('#card .front .fa-refresh'), $('#card .front .card-title span'), 81);
countStartClick($('#card .back .fa-refresh'), $('#card .back .card-title span'), 52);
countStartClick($('#card-2 .front .fa-refresh'), $('#card-2 .front .card-title span'), 102);
countStartClick($('#card-2 .back .fa-refresh'), $('#card-2 .back .card-title span'), 170);
countStartClick($('#card-3 .front .fa-refresh'), $('#card-3 .front .card-title span'), 33);
countStartClick($('#card-3 .back .fa-refresh'), $('#card-3 .back .card-title span'), 21);
countStartClick($('#card-4 .front .fa-refresh'), $('#card-4 .front .card-title span'), 42);
countStartClick($('#card-4 .back .fa-refresh'), $('#card-4 .back .card-title span'), 478);


if ($('#v-pills-Dashboard').hasClass('active')) {

    countTo($('.VisitorS-count'), 81);
    countTo($('.Visitor-count'), 52);

    countTo($('.Traffic-count'), 102);
    countTo($('.Impressions-count'), 170);

    countTo($('.Bounce-count'), 33);
    countTo($('.Conversion-count'), 21);

    countTo($('.Tusers-count'), 42);
    countTo($('.User-count'), 478);

}   

$('.fa-refresh.V-U').click(function() {
    Linechart.destroy();
    Linechart = new Chart(ctxL, configL);
});   
$('.fa-refresh.Dem').click(function() {
    Piechart.destroy();
    Piechart = new Chart(ctxP, configP);
});   
$('.fa-refresh.Soc').click(function() {
    countTo($('.T-count'), 12438)
    countTo($('.Y-count'), 4591)
    countTo($('.F-count'), 52173)
});   

















