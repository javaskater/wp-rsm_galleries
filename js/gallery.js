;( function($)
	{
		var activityIndicatorOn = function()
			{
				$( '<div id="imagelightbox-loading"><div></div></div>' ).appendTo( 'body' );
			},
			activityIndicatorOff = function()
			{
				$( '#imagelightbox-loading' ).remove();
			},

			overlayOn = function()
			{
				$( '<div id="imagelightbox-overlay"></div>' ).appendTo( 'body' );
			},
			overlayOff = function()
			{
				$( '#imagelightbox-overlay' ).remove();
			},

			closeButtonOn = function( instance )
			{
				$( '<a href="#" id="imagelightbox-close">Close</a>' ).appendTo( 'body' ).on( 'click', function(){ $( this ).remove(); instance.quitImageLightbox(); return false; });
			},
			closeButtonOff = function()
			{
				$( '#imagelightbox-close' ).remove();
			},

			captionOn = function()
			{
				var description = $( 'a[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"] img' ).attr( 'alt' );
				if( description.length > 0 )
					$( '<div id="imagelightbox-caption">' + description + '</div>' ).appendTo( 'body' );
			},
			captionOff = function()
			{
				$( '#imagelightbox-caption' ).remove();
			},

			navigationOn = function( instance, selector )
			{
				var images = $( selector );
				if( images.length )
				{
					var nav = $( '<div id="imagelightbox-nav"></div>' );
					for( var i = 0; i < images.length; i++ )
						nav.append( '<a href="#"></a>' );

					nav.appendTo( 'body' );
					nav.on( 'click touchend', function(){ return false; });

					var navItems = nav.find( 'a' );
					navItems.on( 'click touchend', function()
					{
						var $this = $( this );
						if( images.eq( $this.index() ).attr( 'href' ) != $( '#imagelightbox' ).attr( 'src' ) )
							instance.switchImageLightbox( $this.index() );

						navItems.removeClass( 'active' );
						navItems.eq( $this.index() ).addClass( 'active' );

						return false;
					})
					.on( 'touchend', function(){ return false; });
				}
			},
			navigationUpdate = function( selector )
			{
				var items = $( '#imagelightbox-nav a' );
				items.removeClass( 'active' );
				items.eq( $( selector ).filter( '[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"]' ).index( selector ) ).addClass( 'active' );
			},
			navigationOff = function()
			{
				$( '#imagelightbox-nav' ).remove();
			};

		//adds a lightbox effect around each thumbnail of a WP-Gallery
		//replacement https://api.jquery.com/each/ et http://api.jquery.com/data/
		$( "img[data-imagelightbox]").each(function( index ) {
				var type = $( this ).data("imagelightbox");
				var lien = $( this ).parent();
				if(lien[0].tagName.toLowerCase() == "a"){
					lien.attr("data-imagelightbox",type);
				}
		});
			
			
		//	WITH ACTIVITY INDICATION
			
		$( 'a[data-imagelightbox="a"]' ).imageLightbox(
		{
			onLoadStart:	function() { activityIndicatorOn(); },
			onLoadEnd:		function() { activityIndicatorOff(); },
			onEnd:	 		function() { activityIndicatorOff(); }
		});


		//	WITH OVERLAY & ACTIVITY INDICATION

		$( 'a[data-imagelightbox="b"]' ).imageLightbox(
		{
			onStart: 	 function() { overlayOn(); },
			onEnd:	 	 function() { overlayOff(); activityIndicatorOff(); },
			onLoadStart: function() { activityIndicatorOn(); },
			onLoadEnd:	 function() { activityIndicatorOff(); }
		});


		//	WITH "CLOSE" BUTTON & ACTIVITY INDICATION

		var instanceC = $( 'a[data-imagelightbox="c"]' ).imageLightbox(
		{
			quitOnDocClick:	false,
			onStart:		function() { closeButtonOn( instanceC ); },
			onEnd:			function() { closeButtonOff(); activityIndicatorOff(); },
			onLoadStart: 	function() { activityIndicatorOn(); },
			onLoadEnd:	 	function() { activityIndicatorOff(); }
		});


		//	WITH CAPTION & ACTIVITY INDICATION

		$( 'a[data-imagelightbox="d"]' ).imageLightbox(
		{
			onLoadStart: function() { captionOff(); activityIndicatorOn(); },
			onLoadEnd:	 function() { captionOn(); activityIndicatorOff(); },
			onEnd:		 function() { captionOff(); activityIndicatorOff(); }
		});


		//	WITH DIRECTION REFERENCE

		var selectorE = 'a[data-imagelightbox="e"]';
		var instanceE = $( selectorE ).imageLightbox(
		{
			onStart:	 function() { navigationOn( instanceE, selectorE ); },
			onEnd:		 function() { navigationOff(); activityIndicatorOff(); },
			onLoadStart: function() { activityIndicatorOn(); },
			onLoadEnd:	 function() { navigationUpdate( selectorE ); activityIndicatorOff(); }
		});


		//	ALL COMBINED
		
		var selectorF = 'a[data-imagelightbox="f"]';
		var instanceF = $( selectorF ).imageLightbox(
		{
			onStart:		function() { overlayOn(); closeButtonOn( instanceF ); },
			onEnd:			function() { overlayOff(); captionOff(); closeButtonOff(); activityIndicatorOff(); },
			onLoadStart: 	function() { captionOff(); activityIndicatorOn(); },
			onLoadEnd:	 	function() { captionOn(); activityIndicatorOff(); }
		});
		
		/*
		 * Partie Elastiside Plugin https://github.com/codrops/Elastislide
		 
		$('.elastislide-list').elastislide({
			minItems: 2,
			start: 2
		});*/
		//adding the Image Lightbox effect to the Elastiside Image Slider
		//$(".elastislide-list").each(function(){
		//var href_image=$(this).attr("src");
		//var lien_image = $('<a>');
		//lien_image.attr('href',href_image);
		//lien_image.attr('data-imagelightbox','f');
		//lien_image.addClass("carousel_lien_for_lightbox");
			//http://api.jquery.com/wrap/ adding a < a href="" link around an image
		//$(this).wrap(lien_image);
		//});
		/*
		 * https://github.com/codrops/Slicebox/ voir exemples
		 * Adaptation pour prendr en compte plusieurs objets de type SliceBox sur la même page !!!!!
		 * On ne garde que les classes CSS et on oblie les identifiants
		 */
		$('.sliceBoxWrapperDiv').each(function( index ) {
			//$(this) représente l'objet <div> wrapper principal
			  var $wrapperDiv = $(this);
		      var Page = (function() {
		        var $navArrows = $wrapperDiv.find('.nav-arrows').hide(),
		          $navDots = $wrapperDiv.find('.nav-dots').hide(),
		          $nav = $navDots.children('span'),
		          $shadow = $wrapperDiv.find('.shadow').hide(),
		          slicebox = $wrapperDiv.find('.sb-slider').slicebox( {
		            onReady: function() {
		              $navArrows.show();
		              $navDots.show();
		              $shadow.show();
		            },
		            onBeforeChange: function(pos) {
		              $nav.removeClass('nav-dot-current');
		              $nav.eq(pos).addClass('nav-dot-current');
		            }
		          } ),
		          init = function() {
		            initEvents();
		          },
		          initEvents = function() {
		            $navArrows.children(':first').on('click', function() {
		              slicebox.next();
		              return false;
		            } );
		            $navArrows.children(':last').on('click', function() {
		              slicebox.previous();
		              return false;
		            } );
		            $nav.each( function(i) {
		              $(this).on('click', function(event) {
		                var $dot = $(this);
		                if(!slicebox.isActive()) {
		                  $nav.removeClass('nav-dot-current');
		                  $dot.addClass('nav-dot-current');
		                }
		                slicebox.jump(i+1);
		                return false;
		              });
		            });
		          };
		          return { init : init };
		      })();
		      Page.init();
		});
                /*
                 * Adding a Caption effecct aroudd all images with lightBox effecct!
                 * see http://web.enavu.com/tutorials/making-image-captions-using-jquery/
                 */
                var copyright = {"url":"https://github.com/javaskater/wp-rsm_galleries", "desc":"Javaskater's Images for Wordpress"};
                function greet( event ) {
                    alert( "Hello " + event.data.url );
                }
                $( 'a[data-imagelightbox]' ).each(function(index,element){
                    var $a = $(element);
                    //console.log($a);
                    $a.find('img').each(function(index2,element2){
                        $image = $(element2);
                        ///console.log($image);
                        var description = $image.attr('alt');
                        var width = $image.attr('width');
                        var height = $image.attr('height')
                        if(description === null || description.length == 0){
                            description = $image.attr('title');
                        }
                        //console.log(description);
                        //appends the clone https://api.jquery.com/clone/
                        var $description = $("<div class='description'>").html("<div class='description-content' style='padding:0.5em'><h5>"+description+"</h5><h6 class='copyright'>Powered by: </h6></div>");
                        var $imagewithcaption = $("<div class='wrapper'>");
                        //for bottom attribute to work we have to define the height attribute of the wrapper div!!!
                        // see http://stackoverflow.com/questions/10733080/absolutebottom-does-not-work
                        $imagewithcaption.css('width',width);
                        $imagewithcaption.css('height',height);
                        $description.appendTo($imagewithcaption);
                        $image.clone().appendTo($imagewithcaption);
                        //and replace the original element http://api.jquery.com/replacewith/
                        $image.replaceWith( $imagewithcaption );
                        //console.log($image);
                    });
                });
                var $copyright = $('.copyright');
                var $a = $('<a>').attr({'target':'blank','href':copyright.url}).html(copyright.desc);
                $a.appendTo($copyright);
                $copyright.on('click',{'infos':copyright},function(event){
                    //console.log(event.target);
                    event.stopPropagation()
                });
		
	})(jQuery);