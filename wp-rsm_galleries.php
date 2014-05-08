<?php
/**
 * Plugin Name: Reponsives Galleries And SlideShows for standard WORDPRESS Galleries
 * Plugin URI: https://github.com/javaskater/wp-rsm_galleries
 * Description: Responsive Galleries and Slideshows for http://rsmontreuil.fr, By Jean-Pierre MENA (the Webmaster of that Inline Skating Club).
 * Version: r1
 * Author: Jean-Pierre MENA (javaskater)
 * Author URI: https://github.com/javaskater
 * License: MIT
 */

function rsmg_enqueue() {
   wp_enqueue_style('imagelightbox', plugin_dir_url(__FILE__).'imagelightbox.css', false, 'r3');
   //wp_enqueue_script('imagelightbox', plugin_dir_url(__FILE__).'imagelightbox.min.js', array('jquery'), 'r3', true);
   wp_enqueue_script('imagelightbox', plugin_dir_url(__FILE__).'imagelightbox.js', array('jquery'), '1.0', true);
   wp_enqueue_script('gallery_lightbox', plugin_dir_url(__FILE__).'gallery.js', array('imagelightbox','jquery'), '0.1', true);
   //TODO add the Twitter BootStrap js Library and CSS if not preset by the template!!!
}


function rsmg_mod_tags ($content) {
   global $post;
   /*TODO si je fais un choix au niveau des boutons de l'éditeur (vois livre WP) alors ou on fait le remplacement 	
    * avec le bon type !!!
    */
   $type="f"; // the type of imagelightbox, f: combined

   $pattern = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
   //$replacement = '<a$1href=$2$3.$4$5$6 data-imagelightbox="'.$type.'">';
   //$content = preg_replace($pattern, $replacement, $content);
   $pattern = "/<a(.*?)href=('|\")(.*?)('|\")(.*?)>(<img(.*?)src=('|\")(.*?)('|\")(.*?)\/>)/i";
   /*We chage the image href from http://wprsm.1and1/?attachment_id=110 to
    * http://wprsm.1and1/wp-content/uploads/2014/04/web_DSC_0527.jpg when the image source (the thumb_url in my code)
    * itself is http://wprsm.1and1/wp-content/uploads/2014/04/web_DSC_0527-200x132.jpg
    */
   if(preg_match($pattern,$content,$matches)){
   	 $img_url = $matches[3];
   	 $thumb_url = $matches[9];
   	 $pattern_thumb_url="/^http:\/\/(.*?)\/([^\/]+)\-([0-9x\-]+)\.(bmp|gif|jpeg|jpg|png)$/i";
   	 if(preg_match($pattern_thumb_url,$thumb_url,$matches_thumb_url)){
   	 	$format_img_url="http://%s/%s.%s";
   	 	$img_url=sprintf($format_img_url,$matches_thumb_url[1],$matches_thumb_url[2],$matches_thumb_url[4]);
   	 }
   	 $format = "<a%shref='%s' %s><img%ssrc='%s'data-imagelightbox='%s'%s/>";
   	 $content = sprintf($format,$matches[1],$img_url,$matches[5],$matches[7],$thumb_url,$type,$matches[11]);
   }

   return $content;
}

//Create a slideshow based on existing galleries of the post if use of the SDS shortcode
function rsmg_mod_slideshow($atts){
	//uses global variable https://codex.wordpress.org/Class_Reference/wpdb
	global $post;
	global $wpdb;
	$type="f"; // the type of imagelightbox, f: combined
	extract( shortcode_atts( array('ids' => ''), $atts ) );
	$request = null;
	$the_ids = null;
	if($atts['ids'] == null){
		$request = $wpdb->prepare("SELECT $wpdb->posts.* FROM $wpdb->posts  where post_type = %s and post_parent = %d order by ID ASC", 'attachment', $post->ID);
	}else{
		$the_ids= explode(',',$atts['ids']);
		$request = $wpdb->prepare("SELECT $wpdb->posts.* FROM $wpdb->posts  where post_type = %s and ID IN (".implode(',',$the_ids).")",'attachment');
	}
	if ($request != null){
		$image_posts = $wpdb->get_results($request);
		$main_carousel = '<div id="carousel_post_x" class="carousel slide" data-ride="carousel">';//Ajouter un indice éventuellement si plusieurs Carousels
		$carousel_indicators = '<ol class="carousel-indicators">';
		$carousel_inner = '<div class="carousel-inner">';
		$indice = 0;
		if($the_ids == null){
			foreach ( $image_posts as $image_post )
			{
				if ($indice == 0){
					$carousel_indicators .=  '<li data-target="#carousel_post_x" data-slide-to="0" class="active"></li>';
					//$carousel_inner .= '<div class="item active"><a href="'.$image_post->guid.'"><img src="'.$image_post->guid.'" data-imagelightbox="'.$type.'" alt="..."></a><div class="carousel-caption"><p>Hello</p></div></div>';
					$carousel_inner .= '<div class="item active"><img class="carousel_image" src="'.$image_post->guid.'" alt="..."><div class="carousel-caption"><p>Hello</p></div></div>';
				}else{
					$carousel_indicators .=  '<li data-target="#carousel_post_x" data-slide-to="'.$indice.'"></li>';
					$carousel_inner .= '<div class="item"><img class="carousel_image" src="'.$image_post->guid.'" alt="..."><div class="carousel-caption"><p>Hello</p></div></div>';
				}
				$indice += 1;
			}
		}else{
			//We have to show the image in the order foreseen
			foreach ($the_ids as $id){
				foreach ( $image_posts as $image_post )
				{
					if ($image_post->ID == $id){
						if ($indice == 0){
							$carousel_indicators .=  '<li data-target="#carousel_post_x" data-slide-to="0" class="active"></li>';
							//$carousel_inner .= '<div class="item active"><a href="'.$image_post->guid.'"><img src="'.$image_post->guid.'" data-imagelightbox="'.$type.'" alt="..."></a><div class="carousel-caption"><p>Hello</p></div></div>';
							$carousel_inner .= '<div class="item active"><img class="carousel_image" src="'.$image_post->guid.'" alt="..."><div class="carousel-caption"><p>Hello</p></div></div>';
						}else{
							$carousel_indicators .=  '<li data-target="#carousel_post_x" data-slide-to="'.$indice.'"></li>';
							//$carousel_inner .= '<div class="item"><a href="'.$image_post->guid.'"><img src="'.$image_post->guid.'" data-imagelightbox="'.$type.'" alt="..."></a><div class="carousel-caption"><p>Hello</p></div></div>';
							$carousel_inner .= '<div class="item"><img class="carousel_image" src="'.$image_post->guid.'" alt="..."><div class="carousel-caption"><p>Hello</p></div></div>';
						}
						$indice += 1;
						break;
					}
				}
			}
		}
		$carousel_indicators .= '</ol>';
		$carousel_inner .= '</div>';
		$main_carousel .= $carousel_indicators;
		$main_carousel .= $carousel_inner;
		$main_carousel .= '<a class="left carousel-control" href="#carousel_post_x" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>';
		$main_carousel .= '<a class="right carousel-control" href="#carousel_post_x" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>';
		$main_carousel .= '</div>';
		return $main_carousel;
	}
	return "<h2>Mon SlideShow ici:".$atts['ids']."</h2>";
}

// run only on posts, pages, attachments(?) and galleries, no reason to run on the front page, yet...?
function rsmg_mod_content() {
   if (is_singular()) {
      
      // registering styles and scripts
      add_action( 'wp_enqueue_scripts', 'rsmg_enqueue' );

      // adds the filter for single content images
      add_filter('the_content', 'rsmg_mod_tags');

      // adds the filter for image galleries
      add_filter('wp_get_attachment_link','rsmg_mod_tags');
      
      //add a shorcode to use a slideshow as gallery
      add_shortcode('SDS', 'rsmg_mod_slideshow');
   }
}

add_filter("template_redirect", "rsmg_mod_content", 10, 1);

?>
