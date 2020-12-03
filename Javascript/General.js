var toggleButton = [
  document.getElementsByClassName("toggle-button")[0],
  document.getElementsByClassName("toggle-button")[1],
];
var navbarLinks = [
  document.getElementsByClassName("navbar-links")[0],
  document.getElementsByClassName("navbar-links")[1],
];
var myStickyNavDiv = document.getElementById("stickyNavbar");
var myHeaderNavdiv = document.getElementById("HEADERNavbar");
var myNavBars = [myStickyNavDiv, myHeaderNavdiv];
var brandHeadActive = [
  document.getElementsByClassName("BrandFMA")[0],
  document.getElementsByClassName("BrandFMA")[1],
];

toggleButton.forEach((element) => {
  element.addEventListener("click", () => {
    toggleButton.forEach((item) => {
      item.classList.toggle("open");
    });
    navbarLinks.forEach((item) => {
      item.classList.toggle("active");
    });
    myNavBars.forEach((item) => {
      item.classList.toggle("padding-border-botom");
    });
    brandHeadActive.forEach((item) => {
      item.classList.toggle("BrandHeadActive");
    });
  });
});

// SHOW STICKY NAVBAR

var myScrollFunc = function () {
  var y = window.scrollY;
  if (y >= 480) {
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

// SHOW PASSWORD
var passVis = document.getElementById("IDLoginFormPassword");
var eyeIcon = document.getElementById("EYEICON");

eyeIcon.addEventListener("click", () => {
  if (passVis.type === "password") {
    passVis.type = "text";
    eyeIcon.className = "fa fa-eye-slash";
  } else {
    passVis.type = "password";
    eyeIcon.className = "fa fa-eye eye-icon-gray";
  }
});

/////////// SHOW DROPDOWN MENU AND STYLE////////////////
$(".dropdown-toggleCustom").click(function () {
  $(".dropdown-menuCUSTOM").toggleClass("ShowDropDownMenu");
  $(".dropdown-toggleCustom").toggleClass("hovered");
  $(".vlfordropdown").toggleClass("vlhovered");
  $(".hrForMainContClass").toggleClass("hrhovered");
  $(".Arrow-Icon")
    .css("font-size", "0%")
    .delay(200)
    .queue(function (next) {
      $(this)
        .toggleClass("fa-chevron-down fa-chevron-up")
        .css("font-size", "13px");
      next();
    });
});

///////////////SLICK CAROUSEL//////////////////
$(".post-wrapper").slick({
  slidesToShow: 4,
  slidesToScroll: 1,
  slickSetOption: true,
  autoplay: true,
  autoplaySpeed: 3000,
  nextArrow: $(".next"),
  prevArrow: $(".prev"),
  responsive: [
    {
      breakpoint: 1100,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: true,
      },
    },
    {
      breakpoint: 815,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
      },
    },
    {
      breakpoint: 520,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
      },
    },
  ],
});

// COPY TO CLIPBOARD
var copyText = document.querySelectorAll(".text-to-copy");

copyText.forEach((element) => {
  element.onclick = function () {
    document.execCommand("copy");
  };
});

copyText.forEach((element) => {
  element.addEventListener("copy", function (event) {
    event.preventDefault();
    if (event.clipboardData) {
      event.clipboardData.setData(
        "text/plain",
        element.childNodes[1].nodeValue
      );
      console.log(event.clipboardData.getData("text"));
    }
  });
});

// CHANGE COPY TOOLTIP TEXT
$(".text-to-copy").click(function () {
  $(".tooltiptext").text("Copied!");
  $(".text-to-copy").mouseleave(function () {
    $(".tooltiptext").text("Copy to clipboard");
  });
});

// CENTER PAGE ON ELEMENT WHEN PRESENT IN DOM
const string = window.location.href;
const substring1 = "?id=";
const substring2 = "?comment_Id=";

IdCheck = string.includes(substring1);
commentIdCheck = string.includes(substring2);

if ($(".alert-danger").length) {
  $([document.documentElement, document.body]).animate(
    {
      scrollTop: $(".alert-danger").offset().top - $(window).height() / 2,
    },
    500
  );
} else if ($(".centerhere").length) {
  $([document.documentElement, document.body]).animate(
    {
      scrollTop: $(".centerhere").offset().top - $(window).height() / 2,
    },
    500
  );
}



// SLICKIMAGE HREF CLICK REDIRECT
$(".slider-image").each(function (index) {
  $(this).click(() => {
        console.log($(this)[0].attributes.href);
        window.location.href = $(this)[0].attributes.href.nodeValue
  });
});
