// Rating mechenism
$(document).ready(function () {
  for (i = 1; i < 9; i++) {
    for (j = 5; j >= 1; j--) {
      $(".rate" + i + " .rate").append(
        '<input type="radio" id="s_' +
          i +
          "_" +
          j +
          '" name="rate' +
          i +
          '" value="5" /><label for="s_' +
          i +
          "_" +
          j +
          '" title="text">5 stars</label>'
      );
    }
  }
});

// show hide password
$(".toggle-password").click(function () {
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});

//nav bar part
function sticky_header() {
  var header_height = jQuery(".site-header").innerHeight() / 2;
  var scrollTop = jQuery(window).scrollTop();
  if (scrollTop > header_height) {
    jQuery("body").addClass("sticky-header");

    //Show blue logo
    $(".site-header .header-wrapper .logo-wrapper a img").attr(
      "src",
      "images/blue-logo.png"
    );
  } else {
    jQuery("body").removeClass("sticky-header");

    //Show default logo
    $(".site-header .header-wrapper .logo-wrapper a img").attr(
      "src",
      "images/top-logo.png"
    );
  }
}

jQuery(document).ready(function () {
  var bodyId = $("body").attr("id");

  if (bodyId == "bodyForStickyHeader") sticky_header();
});

jQuery(window).scroll(function () {
  var bodyId = $("body").attr("id");

  if (bodyId == "bodyForStickyHeader") sticky_header();
});
jQuery(window).resize(function () {
  var bodyId = $("body").attr("id");

  if (bodyId == "bodyForStickyHeader") sticky_header();
});

// for mobile
$(function () {
  //Show mobile nav
  $("#mobile-nav-open-btn").click(function () {
    $("#mobile-nav").css("height", "100%");
  });

  //Hide mobile nav
  $("#mobile-nav-close-btn, .clickable-op, #mobile-nav-content button").click(
    function () {
      $("#mobile-nav").css("height", "0%");
    }
  );
  $(".dropdown-menu a").click(function () {
    $("#mobile-nav").css("height", "0%");
  });
});
