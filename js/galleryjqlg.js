/**
 * 
 */
;( function($){
	var separation = $('<div">').html("<p>Animated by: <a href='http://sachinchoolur.github.io/lightGallery/index.html' target='blank'>JQuery Light Gallery</a></p>").addClass("jqlg-copyright");
	$(".jqlg-container").after(separation);//http://api.jquery.com/after/ to make a separation between the gallery and the reste of the article !!!
	$(".light-gallery-serie").lightGallery();
	$('[data-toggle="tooltip"]').tooltip(); 
        //test of Gridify for social networks !!!!
            var options =
            {
                srcNode: 'img',             // grid items (class, node)
                margin: '10px',             // margin in pixel, default: 0px
                width: '150px',             // grid item width in pixel, default: 220px
                max_width: '',              // dynamic gird item width if specified, (pixel)
                resizable: true,            // re-layout if window resize
                transition: 'all 0.5s ease' // support transition for CSS3, default: all 0.5s ease
            }
            $('.rsmpicasagrid').gridify(options);
})(jQuery);