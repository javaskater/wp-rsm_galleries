=== Plugin Name ===
Contributors: javaskater
Donate link: 
Tags: imagelightbox.js, bootstrap.js
Requires at least: 3.0.1
Tested up to: 3.9
Stable tag: trunk
License: MIT
License URI: http://opensource.org/licenses/MIT

Responsive and touch-friendly lightbox for Wordpress. Uses ImageLightbox.js by Osvaldas Valutis

== Description ==

Responsive and touch-friendly lightbox for Wordpress.

Has no options. It will run on posts/pages/attachments. It will NOT run on categories, archives, front page etc. 

This plugin uses the excellent [ImageLightbox.js by Osvaldas Valutis](http://osvaldas.info/image-lightbox-responsive-touch-friendly).


== Installation ==

1. Upload wp-imagelightbox to `/wp-content/plugins`
2. Activate plugin from admin interface


== Frequently Asked Questions ==

= Where are the options? =

There aren't any at the moment!

= How to change the imagelightbox type? =

At the moment there is no way to change the type unless you edit the code of the plugin. Inside wp-imagelightbox.php you can edit the line containing `$type="f"`. Change the letter "f" to different types that you can see on Osvaldas Valutis' demo page.


== Screenshots ==

== Changelog ==

= r1 =
* Integration of lightbox.js with the standard WordPRess Gallery
* Add a shortcode to enable the integration of the BootStrap/Carousel + lightbox effect on the slide displayed 

= r2 (TODO)=
* adding the possibility to change the lightbox type by admin menu (no lightBox possible)
* add a shortcode to add lightBox Effect independently of the lightBox chosen by the admin Menu
* add the Bootstrap.js and the Bootstrap.css if not already done by the Template
