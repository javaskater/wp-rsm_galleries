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
		//test of Gridify !!!!
		$(".grid[id^='Joo']").each(function( index ) {
			var options =
            {
                srcNode: 'img',             // grid items (class, node)
                margin: '5px',             // margin in pixel, default: 0px
                width: '400px',             // grid item width in pixel, default: 220px
                max_width: '100%',              // dynamic gird item width if specified, (pixel)
                max_height: ' ',
                resizable: true,            // re-layout if window resize
                transition: 'all 0.5s ease' // support transition for CSS3, default: all 0.5s ease
            }
			$(this).gridify(options);
		});
	})(jQuery);