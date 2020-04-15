jQuery.noConflict()

var slideIndex = 0;

jQuery(document).ready(function() {
    (function($) {
        if(jQuery('.slideshow-container').length > 0 ){
            showSlides();
        }
    })(jQuery);
});

function showSlides() {
    var i;
    var slides = jQuery(".slides").toArray();
    // var dots = jQuery(".dot").toArray();
    for (i = 0; i < slides.length; i++) {
       slides[i].style.display = "none";  
    }
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}    
    // for (i = 0; i < dots.length; i++) {
    //     dots[i].className = dots[i].className.replace(" active", "");
    // }
    slides[slideIndex-1].style.display = "block";  
    // dots[slideIndex-1].className += " active";
    setTimeout(showSlides, 10000); // Change image every 10 seconds
}
