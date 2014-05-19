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
require_once 'gallery_links.php';

// Exit if accessed directly
if (! defined ( 'ABSPATH' ))
	exit ();

if (! class_exists ( 'wprsm_gals', false )) {
	class wprsm_gals {
		
		private $type_lightbox = "f";
		private $base_url;
		
		function __construct($type_lightbox){
			$this->type_lightbox = $type_lightbox;
			$this->base_url = get_site_url();
		}
		
		function rsmg_enqueue() {
			wp_enqueue_style ( 'imagelightbox', plugin_dir_url ( __FILE__ ) . 'imagelightbox.css', false, 'r3' );
			// wp_enqueue_script('imagelightbox', plugin_dir_url(__FILE__).'imagelightbox.min.js', array('jquery'), 'r3', true);
			wp_enqueue_script ( 'imagelightbox', plugin_dir_url ( __FILE__ ) . 'imagelightbox.js', array (
					'jquery' 
			), '1.0', true );
			wp_enqueue_script ( 'gallery_lightbox', plugin_dir_url ( __FILE__ ) . 'gallery.js', array (
					'imagelightbox',
					'jquery' 
			), '0.1', true );
			// TODO add the Twitter BootStrap js Library and CSS if not preset by the template!!!
		}
		function rsmg_mod_tags($content) {
			/*
			 * TODO si je fais un choix au niveau des boutons de l'éditeur (vois livre WP) alors ou on fait le remplacement avec le bon type !!!
			 */
			$type = $this->type_lightbox; // the type of imagelightbox, f: combined
			$wp_links = new wprsm_links($type);
			
			$pattern = "/<a(.*?)href=('|\")(.*?)('|\")(.*?)>(<img(.*?)src=('|\")(.*?)('|\")(.*?)\/>)<\/a>/i";
			/*
			 * We chage the image href from http://wprsm.1and1/?attachment_id=110 to http://wprsm.1and1/wp-content/uploads/2014/04/web_DSC_0527.jpg when the image source (the thumb_url in my code) itself is http://wprsm.1and1/wp-content/uploads/2014/04/web_DSC_0527-200x132.jpg use of http://www.php.net/manual/en/function.preg-match-all.php
			 */
			$content = preg_replace_callback ( $pattern, array (
					$wp_links,
					'remove_wp_link' 
			), $content );
			$content = preg_replace_callback ( "/__rsmwp_link_(\d+)__/i", array (
					$wp_links,
					'restore_wp_link' 
			), $content );
			
			return $content;
		}
		
		// Create a slideshow based on existing galleries of the post if use of the SDS shortcode
		function rsmg_mod_slideshow($atts) {
			// uses global variable https://codex.wordpress.org/Class_Reference/wpdb
			global $post;
			global $wpdb;
			$type = $this->type_lightbox; // the type of imagelightbox, f: combined TODO fournir cette variable au code JavaScript !!!!
			extract ( shortcode_atts ( array (
					'ids' => '' 
			), $atts ) );
			$request = null;
			$the_ids = null;
			if ($atts ['ids'] == null) {
				$request = $wpdb->prepare ( "SELECT $wpdb->posts.* FROM $wpdb->posts  where post_type = %s and post_parent = %d order by ID ASC", 'attachment', $post->ID );
			} else {
				$the_ids = explode ( ',', $atts ['ids'] );
				$request = $wpdb->prepare ( "SELECT $wpdb->posts.* FROM $wpdb->posts  where post_type = %s and ID IN (" . implode ( ',', $the_ids ) . ")", 'attachment' );
			}
			if ($request != null) {
				$image_posts = $wpdb->get_results ( $request );
				$main_carousel = '<div id="carousel_post_x" class="carousel slide" data-ride="carousel">'; // Ajouter un indice éventuellement si plusieurs Carousels
				$carousel_indicators = '<ol class="carousel-indicators">';
				$carousel_inner = '<div class="carousel-inner">';
				$indice = 0;
				if ($the_ids == null) {
					foreach ( $image_posts as $image_post ) {
						if ($indice == 0) {
							$carousel_indicators .= '<li data-target="#carousel_post_x" data-slide-to="0" class="active"></li>';
							// $carousel_inner .= '<div class="item active"><a href="'.$image_post->guid.'"><img src="'.$image_post->guid.'" data-imagelightbox="'.$type.'" alt="..."></a><div class="carousel-caption"><p>Hello</p></div></div>';
							$carousel_inner .= '<div class="item active"><img class="carousel_image" src="' . $image_post->guid . '" alt="..."><div class="carousel-caption"><p>Hello</p></div></div>';
						} else {
							$carousel_indicators .= '<li data-target="#carousel_post_x" data-slide-to="' . $indice . '"></li>';
							$carousel_inner .= '<div class="item"><img class="carousel_image" src="' . $image_post->guid . '" alt="..."><div class="carousel-caption"><p>Hello</p></div></div>';
						}
						$indice += 1;
					}
				} else {
					// We have to show the image in the order foreseen
					foreach ( $the_ids as $id ) {
						foreach ( $image_posts as $image_post ) {
							if ($image_post->ID == $id) {
								if ($indice == 0) {
									$carousel_indicators .= '<li data-target="#carousel_post_x" data-slide-to="0" class="active"></li>';
									// $carousel_inner .= '<div class="item active"><a href="'.$image_post->guid.'"><img src="'.$image_post->guid.'" data-imagelightbox="'.$type.'" alt="..."></a><div class="carousel-caption"><p>Hello</p></div></div>';
									$carousel_inner .= '<div class="item active"><img class="carousel_image" src="' . $image_post->guid . '" alt="..."><div class="carousel-caption"><p>Hello</p></div></div>';
								} else {
									$carousel_indicators .= '<li data-target="#carousel_post_x" data-slide-to="' . $indice . '"></li>';
									// $carousel_inner .= '<div class="item"><a href="'.$image_post->guid.'"><img src="'.$image_post->guid.'" data-imagelightbox="'.$type.'" alt="..."></a><div class="carousel-caption"><p>Hello</p></div></div>';
									$carousel_inner .= '<div class="item"><img class="carousel_image" src="' . $image_post->guid . '" alt="..."><div class="carousel-caption"><p>Hello</p></div></div>';
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
			return "<h2>Mon SlideShow ici:" . $atts ['ids'] . "</h2>";
		}
		
		// Create a slideshow based on existing galleries of the post if use of the SDS shortcode
		function rsmg_mod_JooGallery($atts) {
			$type = $this->type_lightbox; // the type of imagelightbox, f: combined
			extract ( shortcode_atts ( array (
					'path' => '' 
			), $atts ) );
			$request = null;
			$the_ids = null;
			if ($atts['path'] == null) {
				return "<p>Attribut path oublié!!!</p>";
			} else {
				$images_path = ABSPATH."wp-content/uploads/images/".$atts['path'];
				$images_url = $this->base_url."/wp-content/uploads/images/".$atts['path'];
				$labels_path = $images_path."/labels.txt";
				if($lp = fopen($labels_path,'r')){
					$main_carousel = '<div id="carousel_post_x" class="carousel slide" data-ride="carousel">'; // Ajouter un indice éventuellement si plusieurs Carousels
					$carousel_indicators = '<ol class="carousel-indicators">';
					$carousel_inner = '<div class="carousel-inner">';
					$indice = 0;
					while (($label = fgets($lp)) !== false){
						$label_array = explode("|",$label);
						if(sizeof($label_array) >= 3){
							$image_url = $images_url."/".$label_array[0]; //to show an image don't use the image path but the image url !!!
							$description = $label_array[1];
							$author = $label_array[2];
							if ($indice == 0) {
								$carousel_indicators .= '<li data-target="#carousel_post_x" data-slide-to="0" class="active"></li>';
								// $carousel_inner .= '<div class="item active"><a href="'.$image_post->guid.'"><img src="'.$image_post->guid.'" data-imagelightbox="'.$type.'" alt="..."></a><div class="carousel-caption"><p>Hello</p></div></div>';
								$carousel_inner .= '<div class="item active"><img class="carousel_image" src="' . $image_url . '" alt="'.$description.'"><div class="carousel-caption"<h3>.'.$description.'</h3><p>'.$author.'</p></div></div>';
							} else {
								$carousel_indicators .= '<li data-target="#carousel_post_x" data-slide-to="' . $indice . '"></li>';
								// $carousel_inner .= '<div class="item"><a href="'.$image_post->guid.'"><img src="'.$image_post->guid.'" data-imagelightbox="'.$type.'" alt="..."></a><div class="carousel-caption"><p>Hello</p></div></div>';
								$carousel_inner .= '<div class="item"><img class="carousel_image" src="' . $image_url . '" alt="'.$description.'"><div class="carousel-caption"><h3>.'.$description.'</h3><p>'.$author.'</p></div></div>';
							}
							$indice += 1;
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
				}else{
					return "<p>Galerie fichier de lables:".$labels_path." non trouvé</p>";
				}
			}
		}
		
		public function rsmg_base_url(){
			return $this->base_url;
		}
		
		// run only on posts, pages, attachments(?) and galleries, no reason to run on the front page, yet...?
		function rsmg_mod_content() {
			if (is_singular ()) {
				
				// registering styles and scripts
				add_action ( 'wp_enqueue_scripts', array($this,'rsmg_enqueue'));
				
				// adds the filter for single content images
				add_filter ( 'the_content', array($this,'rsmg_mod_tags'));
				
				// adds the filter for image galleries
				add_filter ( 'wp_get_attachment_link', array($this,'rsmg_mod_tags'));
				
				// add a shorcode to transform a gallery in a Bootstrap Carousel ...
				add_shortcode ( 'SDS', array($this,'rsmg_mod_slideshow'));
				
				// add a shorcode to transform a rsm -> Joomla gallery in a Bootstrap Carousel ...
				add_shortcode ( 'JooGallery', array($this,'rsmg_mod_JooGallery') );
			}
		}
	}
}

$my_plugin = new wprsm_gals("f");

add_filter ( "template_redirect", array($my_plugin,"rsmg_mod_content"), 10, 1 );
add_shortcode("url", array($my_plugin,"rsmg_base_url"));

?>
