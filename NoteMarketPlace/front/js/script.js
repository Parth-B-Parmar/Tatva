$(function () {
    
    showHideNav();
    
    $(window).scroll(function() {
        
        showHideNav();
    });
    
    function showHideNav() {
        if( $(window).scrollTop() > 50) {
           // show white bar
            $("nav").addClass("white-nav-top");
            
            $(".navbar-brand img").attr("src", "images/Contact-Us/logo.png")
        } else {
            //hide white bar
            $("nav").removeClass("white-nav-top");
            
            $(".navbar-brand img").attr("src", "images/images/top-logo.png")
        }
    }
});