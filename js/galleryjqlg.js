/**
 * 
 */
;( function($){
	var separation = $('<div">').html("<p>Animated by: <a href='http://sachinchoolur.github.io/lightGallery/index.html' target='blank'>JQuery Light Gallery</a></p>").addClass("jqlg-copyright");
	$(".jqlg-container").after(separation);//http://api.jquery.com/after/ to make a separation between the gallery and the reste of the article !!!
	$(".light-gallery-serie").lightGallery();
})(jQuery);