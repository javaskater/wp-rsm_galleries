/**
 * 
 */
;( function($){
	var separation = $('<div">').html("<p>Powered by: <a href='https://github.com/javaskater/wp-rsm_galleries' target='blank'>Javaskater's Images for Wordpress</a></p>").addClass("jqlg-copyright");
	$(".jqlg-container").after(separation);//http://api.jquery.com/after/ to make a separation between the gallery and the reste of the article !!!
	$(".light-gallery-serie").lightGallery();
	$('[data-toggle="tooltip"]').tooltip(); 
        //test of Gridify for social networks !!!!
           // var options =
            //{
              //  srcNode: 'img',             // grid items (class, node)
              //  margin: '10px',             // margin in pixel, default: 0px
                //width: '150px',             // grid item width in pixel, default: 220px
                //max_width: '',              // dynamic gird item width if specified, (pixel)
                ///resizable: true,            // re-layout if window resize
                //transition: 'all 0.5s ease' // support transition for CSS3, default: all 0.5s ease
            //}
            //$('.rsmpicasagrid').gridify(options);
            // init Masonry after all images have loaded cf  http://codepen.io/desandro/pen/bdgRzg
            var $grid = $('.grid').imagesLoaded( function() {
              $grid.masonry({
                itemSelector: '.grid-item',
                percentPosition: true,
                columnWidth: '.grid-sizer'
              }); 
              /*
                * Jquery caption on images ..
                * from http://web.enavu.com/tutorials/making-image-captions-using-jquery/
                */
               //for each description div...  
                $('div.description').each(function(){  
                    //...set the opacity to 0...  
                    $(this).css('opacity', 0);  
                    //..set width same as the image...  
                    $(this).css('width', $(this).siblings('img').width());  
                    //...get the parent (the wrapper) and set it's width same as the image width... '  
                    $(this).parent().css('width', $(this).siblings('img').width());  
                    //...set the display to block  
                    $(this).css('display', 'block');  
                });  

                $('div.wrapper').hover(function(){  
                    //when mouse hover over the wrapper div  
                    //get it's children elements with class description '  
                    //and show it using fadeTo  
                    $(this).children('.description').stop().fadeTo(500, 0.7);  
                },function(){  
                    //when mouse out of the wrapper div  
                    //use fadeTo to hide the div  
                    $(this).children('.description').stop().fadeTo(500, 0);  
                });  
            });
})(jQuery);


