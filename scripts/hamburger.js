jQuery.noConflict()
// Slide hamburger menu in and out
jQuery(document).ready(function() {
	(function($) {
	    $('#hamburger').click(function(e) {


	        $('.sidebar').animate({height: "toggle",
								   opacity: "toggle"
								  }, 200);
	    });
    })(jQuery);
});

// Reset hamburger sidebar if page expanded
jQuery(document).ready(function() {
	(function($) {
	    // run test on initial page load
	    checkSize();

	    // run test on resize of the window
	    $(window).resize(checkSize);
    })(jQuery);
});

function checkSize(){
	// show normal sidebar when window expanded
	if (jQuery("#hamburger").css("display") == "none" ){
        jQuery('.sidebar').show();
    }

    // reset toggle when window shrunk
    if (jQuery(".sidebar").css("right") == "0px" ){
    	jQuery('.sidebar').hide();
    }
}
