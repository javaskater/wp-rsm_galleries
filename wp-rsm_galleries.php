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
require_once 'socialnetworks_links.php';
require_once 'JQueryLightGallery.php';
require_once 'SocialNetworks.php';

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
			/*
			 * Pour la partie Image LightBox ....
			 */
			wp_enqueue_style ( 'imagelightbox', plugin_dir_url ( __FILE__ ) . 'css/imagelightbox.css', false, 'r3' );
			// wp_enqueue_script('imagelightbox', plugin_dir_url(__FILE__).'imagelightbox.min.js', array('jquery'), 'r3', true);
			wp_enqueue_script ( 'imagelightbox', plugin_dir_url ( __FILE__ ) . 'js/imagelightbox.js', array (
					'jquery' 
			), '1.0', true );
			
			/*
			 * Pour la partie Elsatiside Plugin https://github.com/codrops/Elastislide
			 
			wp_enqueue_style ( 'elastiside', plugin_dir_url ( __FILE__ ) . 'css/elastislide.css', false, 'r3' );
			wp_enqueue_style ( 'custom', plugin_dir_url ( __FILE__ ) . 'css/custom_elastislide.css', false, 'r3' );
			wp_enqueue_script ( 'jquerypp', plugin_dir_url ( __FILE__ ) . 'js/jquerypp.custom.js', array (
			'jquery'
					), '0.1', true );
			wp_enqueue_script ( 'modernizer', plugin_dir_url ( __FILE__ ) . 'js/modernizr.custom.17475.js', array (
			'jquery'
					), '0.1', true );
			wp_enqueue_script ( 'elastiside', plugin_dir_url ( __FILE__ ) . 'js/jquery.elastislide.js', array (
			'modernizer',
			'jquerypp',
			'jquery'
					), '1.0', true );
			*/
			/*
			 * Pour la partie SliceBox Plugin https://github.com/codrops/Slicebox
			*/
			//wp_enqueue_style ( 'sliceBox', plugin_dir_url ( __FILE__ ) . 'css/slicebox.css', false, 'r3' );
			//wp_enqueue_style ( 'custom', plugin_dir_url ( __FILE__ ) . 'css/custom_slicebox.css', false, 'r3' );
			//wp_enqueue_style ( 'demo', plugin_dir_url ( __FILE__ ) . 'css/demo_slicebox.css', false, 'r3' );
			/*
			 * see http://codex.wordpress.org/Function_Reference/wp_add_inline_style and
			 */
			/*$inline_sliceBox_css = "
			* { -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; };
      		.wrapper { position: relative; max-width: 840px; width: 100%; padding: 0 50px; margin: 0 auto; }
			}";
			wp_add_inline_style( 'inline-sliceBox-style', $inline_sliceBox_css );*/
			//wp_enqueue_script ( 'modernizer', plugin_dir_url ( __FILE__ ) . 'js/modernizr.custom.46884.js', array (
			//		'jquery'
			//), '0.1', true );
			//wp_enqueue_script ( 'slicebox', plugin_dir_url ( __FILE__ ) . 'js/jquery.slicebox.min.js', array (
			//		'modernizer',
			//		'jquery'
			//), '1.0', true );
			
			/*
			 * Pour les tests de Gridify !!!
			 * https://github.com/hongkhanh/gridify //problème il passe au dessus de toutes les div car absolu !!!
			 */
			//wp_enqueue_script ( 'gridify', plugin_dir_url ( __FILE__ ) . 'js/gridify.js', array ('jquery'), '0.1', true );
			//wp_enqueue_style ( 'gridify', plugin_dir_url ( __FILE__ ) . 'css/rsm_gridify.css', false, 'r3' );
                        
                        /*
			 * Pour les tests d'un autre Gridify !!!
			 * http://mattlayton.co.uk/gridify/
			 */
                        //wp_enqueue_script ( 'smartresize', plugin_dir_url ( __FILE__ ) . 'js/jquery.smartresize.js', array ('jquery'), '0.1', true );
                        //wp_enqueue_script ( 'gridify', plugin_dir_url ( __FILE__ ) . 'js/jquery.gridify.js', array ('smartresize','jquery'), '0.1', true );
                        
                        /*
			 * Pour les tests de Gridify !!!
			 * https://github.com/suprb/Grid-A-Licious 
                         * recommmandé par https://codegeekz.com/25-best-jquery-grid-plugins-developers/ il ne crée pas de div absolute ?
			 */
			//wp_enqueue_script ( 'gridify', plugin_dir_url ( __FILE__ ) . 'js/jquery.grid-a-licious.js', array ('jquery'), '0.1', true );
                        
                         /*
			 * Pour les tests de Gridify !!!
			 * https://github.com/suprb/nested/
                         * recommmandé par https://codegeekz.com/25-best-jquery-grid-plugins-developers/ il ne crée pas de div absolute ?
			 */
			//wp_enqueue_script ( 'gridify', plugin_dir_url ( __FILE__ ) . 'js/jquery.nested.js', array ('jquery'), '0.1', true );
                        
                        /*
			 * Pour les tests d'un autre système de Grille avec Mansonry !!!
			 * http://masonry.desandro.com/#download
			 */
                        wp_enqueue_script ( 'imagesloaded', plugin_dir_url ( __FILE__ ) . 'js/imagesloaded.pkgd.js', array ('jquery'), '0.1', true );
                        wp_enqueue_script ( 'jqmasonry', plugin_dir_url ( __FILE__ ) . 'js/masonry.pkgd.js', array ('jquery'), '0.1', true );
                        //wp_enqueue_script ( 'gridify', plugin_dir_url ( __FILE__ ) . 'js/masonry.pkgd.min.js', array ('jquery'), '0.1', true );
                        //wp_enqueue_script ( 'gridify', plugin_dir_url ( __FILE__ ) . 'js/jquery.masonry.min.js', array ('jquery'), '0.1', true );
			
			wp_enqueue_script ( 'gallery_lightbox', plugin_dir_url ( __FILE__ ) . 'js/gallery.js', array (
			'imagelightbox',
			//'elastiside',
			//'slicebox',
                        'imagesloaded',
			'jqmasonry'
					), '0.1', true );
			
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
                        
                        $picasa_links = new social_links("picasa",$type);
			$content = $picasa_links->contentimagestogallery($content);
                        
                        
                        
			return $content;
		}
		/*
		 * Private funcction to get the complemntary infos (image realpath, images sizes image author) for the image plugin
		 */
		private function get_complemtary_image_infos($post){
			$infos = array('author'=>null, 'image_datas'=>null);
			//https://codex.wordpress.org/Function_Reference/get_user_by
			if($user = get_user_by( 'id', $post->post_author )){
				$infos['author'] = 	$user;	
			}
			//https://codex.wordpress.org/Function_Reference/get_post_meta
			if($metas_image_serialized = get_post_meta( $post->ID, '_wp_attachment_metadata', true )){
				$infos['image_datas'] = maybe_unserialize($metas_image_serialized);
			}
			return $infos;
		}
		
		/*
		 * Create a slideshow based on existing galleries of the post if use of the SDS shortcode
		 * ToDo: an admin switch to decide wiche kind orf responsive gallery to Use
		 */
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
				/*$main_carousel = '<div id="carousel_post_x" class="carousel slide" data-ride="carousel">'; // Ajouter un indice éventuellement si plusieurs Carousels
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
				return $main_carousel;*/
				$main_slideshow = '<div class="wrapper sliceBoxWrapperDiv">';
				$main_slideshow .= '<ul class="sb-slider">';
				if ($the_ids == null) {
					foreach ( $image_posts as $image_post ) {
						$real_image_informations = $this->get_complemtary_image_infos($image_post);
						if($real_image_informations['image_datas']){
							$image_url = $this->site_url.'/wp-content/uploads/'.$real_image_informations['image_datas']['file'];
							$description = $image_post->post_content;
							if (strlen($description) == 0){
								$description = $image_post->post_excerpt;
								if (strlen($description) == 0){
									$description = $image_post->post_title;
								}
							}
							$author = 'Xxxxxxx';
							if($real_image_informations['author']){
								$author = $real_image_informations['author']->display_name;
							}
							$title_alt = $description."|".$author;
							$identifiant_slicebox = basename($atts['path']);
							$image_element = '<li><a href="#"><img src="'.$image_url.'" alt="'.$title_alt.'" title="'.$title_alt.'" /></a>';
							$image_element .= '<div class="sb-description"><h3>'.$description.'</h3><h4>'.$author.'</h4></div>';
							$image_element .= '</li>';
							$main_slideshow .= $image_element;
						}
					}
				} else {
					// We have to show the image in the order foreseen
					foreach ( $the_ids as $id ) {
						foreach ( $image_posts as $image_post ) {
							if ($image_post->ID == $id) {
								$real_image_informations = $this->get_complemtary_image_infos($image_post);
								if($real_image_informations['image_datas']){
									$image_url = $this->site_url.'/wp-content/uploads/'.$real_image_informations['image_datas']['file'];
									$description = $image_post->post_content;
									if (strlen($description) == 0){
										$description = $image_post->post_excerpt;
										if (strlen($description) == 0){
											$description = $image_post->post_title;
										}
									}
									$author = 'Xxxxxxx';
									if($real_image_informations['author']){
										$author = $real_image_informations['author']->display_name;
									}
									$title_alt = $description."|".$author;
									$identifiant_slicebox = basename($atts['path']);
									$image_element = '<li><a href="#"><img src="'.$image_url.'" alt="'.$title_alt.'" title="'.$title_alt.'" /></a>';
									$image_element .= '<div class="sb-description"><h3>'.$description.'</h3><h4>'.$author.'</h4></div>';
									$image_element .= '</li>';
								$main_slideshow .= $image_element;
								}
							}
						}
					}
				}
				$main_slideshow .= '</ul>';
				$main_slideshow .= '<div class="shadow"></div><div id="nav-arrows'.$identifiant_slicebox.'" class="nav-arrows"><a href="#">Next</a><a href="#">Previous</a></div>';
				$main_slideshow .= '<div class="nav-dots"><span class="nav-dot-current"></span><span></span><span></span><span></span><span></span><span></span><span></span></div>';
				$main_slideshow .= '</div>'; //.wrapper
				return $main_slideshow;
				
			}
			return "<h2>Mon SlideShow ici:" . $atts ['ids'] . "</h2>";
		}
		
		/*
		* Create a slideshow based on existing galleries of the post if use of the Joo Shortcode from the Joo Galleries
		* ToDo: an admin switch to decide wiche kind orf responsive gallery to Use
		* */
		function isimage($mediapath) { //http://stackoverflow.com/questions/15408125/php-check-if-file-is-an-image
			return getimagesize($mediapath) ? true : false;
		}
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
				 if(file_exists($labels_path) && is_readable ($labels_path) && $lp = fopen($labels_path,'r')){
				 	/*
				 	 * Cas où j'utilise Elastislide https://github.com/codrops/Elastislide
					$main_slideshow = '<ul class="elastislide-list">';
					while (($label = fgets($lp)) !== false){
						$label_array = explode("|",$label);
						if(sizeof($label_array) >= 3){
							$image_url = $images_url."/".$label_array[0];
							$description = $label_array[1];
							$author = $label_array[2];
							$title_alt = $label_array[1]."|".$label_array[2];
							$image_element = '<li><a href="#"><img src="'.$image_url.'" alt="'.$title_alt.'" title="'.$title_alt.'" /></a></li>';
							$main_slideshow .= $image_element;
						}
					}
					$main_slideshow .= '</ul>';
					return $main_slideshow;*/
				 	$main_slideshow = '<div class="wrapper sliceBoxWrapperDiv">';
				 	$main_slideshow .= '<ul class="sb-slider">';
				 	while (($label = fgets($lp)) !== false){
				 		$label_array = explode("|",$label);
				 		if(sizeof($label_array) >= 3 && $this->isimage($images_path.'/'.$label_array[0])){
				 			$image_url = $images_url."/".$label_array[0];
				 			$description = $label_array[1];
				 			$author = $label_array[2];
				 			$title_alt = $description."|".$author;
				 			$identifiant_slicebox = basename($atts['path']);
				 			$image_element = '<li><a href="#"><img src="'.$image_url.'" alt="'.$title_alt.'" title="'.$title_alt.'" /></a>';
				 			$image_element .= '<div class="sb-description"><h3>'.$description.'</h3><h4>'.$author.'</h4></div>';
				 			$image_element .= '</li>';
				 			$main_slideshow .= $image_element;
				 		}
				 	}
				 	$main_slideshow .= '</ul>';
				 	$main_slideshow .= '<div class="shadow"></div><div id="nav-arrows'.$identifiant_slicebox.'" class="nav-arrows"><a href="#">Next</a><a href="#">Previous</a></div>';
				 	$main_slideshow .= '<div class="nav-dots"><span class="nav-dot-current"></span><span></span><span></span><span></span><span></span><span></span><span></span></div>';
				 	$main_slideshow .= '</div>'; //.wrapper
				 	
				 	return $main_slideshow;
				}else{
					//return "<p>Galerie fichier de lables:".$labels_path." non trouvé</p>";
					if (file_exists($images_path) && is_dir($images_path) && $handle = opendir($images_path)){
						$main_slideshow = '<div class="wrapper sliceBoxWrapperDiv">';
						$main_slideshow .= '<ul class="sb-slider">';
						while (false !== ($entry = readdir($handle))) {
							if(basename($entry) != '.' && basename($entry) != '..' && $this->isimage($images_path.'/'.$entry)){
								$image_url = $images_url."/".basename($entry);
								$description = 'xxxxxxxxxxxx';
								$author = 'yyyyyyyyy';
								$title_alt = $description."|".$author;
								$identifiant_slicebox = basename($atts['path']);
								$image_element = '<li><a href="#"><img src="'.$image_url.'" alt="'.$title_alt.'" title="'.$title_alt.'" /></a>';
								$image_element .= '<div class="sb-description"><h3>'.$description.'</h3><h4>'.$author.'</h4></div>';
								$image_element .= '</li>';
								$main_slideshow .= $image_element;
							}
						}
						$main_slideshow .= '</ul>';
						$main_slideshow .= '<div class="shadow"></div><div id="nav-arrows'.$identifiant_slicebox.'" class="nav-arrows"><a href="#">Next</a><a href="#">Previous</a></div>';
						$main_slideshow .= '<div class="nav-dots"><span class="nav-dot-current"></span><span></span><span></span><span></span><span></span><span></span><span></span></div>';
						$main_slideshow .= '</div>'; //.wrapper
						return $main_slideshow;
					}else{
						return "<p>Galerie fichier de lables:".$labels_path." non trouvé et ".$images_path." n'est pas un répertoire valide!</p>";
					}
				}
			}
		}
		
		/*
		 * Create a slideshow based on existing galleries of the post if use of the Joo Shortcode from the Joo Galleries
		* Test of the Grify Plugin!!!!
		* */
		function rsmg_mod_JooGridifyGallery($atts) {
			$type = $this->type_lightbox; // the type of imagelightbox, f: combined
			extract ( shortcode_atts ( array (
			'path' => ''
					), $atts ) );
					$request = null;
					$the_ids = null;
					if ($atts['path'] == null) {
						return "<p>Attribut path oublié!!!</p>";
					} else {
						$identifiant_grid = "Joo".basename($atts['path']);
						$images_path = ABSPATH."wp-content/uploads/images/".$atts['path'];
						$images_url = $this->base_url."/wp-content/uploads/images/".$atts['path'];
						$labels_path = $images_path."/labels.txt";
						if($lp = fopen($labels_path,'r')){
							$main_slideshow = '<div class="wrapperGrid"><div class="grid" id="'.$identifiant_grid.'">';
							while (($label = fgets($lp)) !== false){
								$label_array = explode("|",$label);
								if(sizeof($label_array) >= 3){
									$image_url = $images_url."/".$label_array[0];
									$description = $label_array[1];
									$author = $label_array[2];
									$title_alt = $description."|".$author;
									$image_element = '<img src="'.$image_url.'" alt="'.$title_alt.'" title="'.$title_alt.'" />';
									$main_slideshow .= $image_element;
								}
							}
							$main_slideshow .= '</div></div>';
		
							return $main_slideshow;
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
				$my_jqlightbox = new jqlg("f");
				// registering styles and scripts
				add_action ( 'wp_enqueue_scripts', array($this,'rsmg_enqueue'));
				add_action ( 'wp_enqueue_scripts', array($my_jqlightbox,'rsmg_enqueue'));
				
				// adds the filter for single content images
				add_filter ( 'the_content', array($this,'rsmg_mod_tags'));
				
				// adds the filter for image galleries
				add_filter ( 'wp_get_attachment_link', array($this,'rsmg_mod_tags'));
				
				// add a shorcode to transform a gallery in a Bootstrap Carousel ...
				add_shortcode ( 'SDS', array($this,'rsmg_mod_slideshow'));
				
				// make also the default Gallery gallery in a Bootstrap Carousel ...
				///add_shortcode ( 'gallery', array($this,'rsmg_mod_slideshow'));
				
				// registering styles and scripts
				
				add_shortcode("gallery", array($my_jqlightbox,'rsmg_mod_jquerylightbox'));
				add_shortcode("jqlg", array($my_jqlightbox,'rsmg_mod_jquerylightbox'));
				
				// add a shorcode to transform a rsm -> Joomla gallery in a Bootstrap Carousel ...
				//add_shortcode ( 'JooGallery', array($this,'rsmg_mod_JooGallery') );
				// add a shorcode to transform a rsm -> Joomla gallery in a JQLG expression ...
				add_shortcode ( 'JooGallery', array($my_jqlightbox,'rsmg_mod_JooGallery') );
                                
                                //add shortcode for picasa libraries
                                add_shortcode ( 'picasa', array($my_jqlightbox,'rsmg_mod_PicasaGallery') );
				
				// add a shorcode to transform a rsm -> Joomla gallery in a Bootstrap Carousel ...
				add_shortcode ( 'JooGridGallery', array($this,'rsmg_mod_JooGridifyGallery') );
			}
		}
	}
}

$my_plugin = new wprsm_gals("f");
add_filter ( "template_redirect", array($my_plugin,"rsmg_mod_content"), 10, 1 );

$social_plugin = new socialNetworks();
$social_plugin->initFunctionalities();
add_shortcode("url", array($my_plugin,"rsmg_base_url"));
?>
