<?php
/**
 * Another Gallery
 * http://sachinchoolur.github.io/lightGallery/
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists('jqlg', false) ) {
	class jqlg {
		private $base_url;
		private $type_lightbox;
		
		function __construct($type_lightbox){
			$this->type_lightbox = $type_lightbox;
			$this->base_url = get_site_url();
		}
		
		function rsmg_enqueue() {
			
			/*
			 * Pour les tests de Jquery Light Plugin !!!
			 * https://github.com/sachinchoolur/lightGallery
			 */
			wp_enqueue_style ( 'jqlg', plugin_dir_url ( __FILE__ ) . 'css/lightGallery.css', false, 'r3' );
			wp_enqueue_style ( 'jqlg', plugin_dir_url ( __FILE__ ) . 'css/customjplg.css', false, 'r3' );
			wp_enqueue_script ( 'jqlightbox', plugin_dir_url ( __FILE__ ) . 'js/lightGallery.js', array ('jquery'
			), '1.0', true );
			wp_enqueue_script ( 'myjqlb', plugin_dir_url ( __FILE__ ) . 'js/galleryjqlg.js', array ('jqlightbox'
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
			$infos['post'] = $post;
			return $infos;
		}
		
		/*
		* Create a slideshow based on existing galleries of the post if use of the Joo Shortcode from the Joo Galleries
		* ToDo: an admin switch to decide wiche kind orf responsive gallery to Use
		* */
		function isimage($mediapath) { //http://stackoverflow.com/questions/15408125/php-check-if-file-is-an-image
			return getimagesize($mediapath) ? true : false;
		}
		/*
		 * Create a slideshow based on existing galleries of the post 
		 * use of the https://github.com/sachinchoolur/lightGallery for responsive animation 
		 */
		private function image_for_jquery_lightbox($real_image_informations,$index_image){
			$image_elements_array = array();
			if($real_image_informations['image_datas']){
				$original_file = $real_image_informations['image_datas']['file'];
				$image_local_dir = dirname($original_file);
				$large_image_url = $this->base_url.'/wp-content/uploads/'.$image_local_dir.'/'.$real_image_informations['image_datas']['sizes']['large']['file'];
				$medium_image_url = $this->base_url.'/wp-content/uploads/'.$image_local_dir.'/'.$real_image_informations['image_datas']['sizes']['medium']['file'];
				$thumb_url = $this->base_url.'/wp-content/uploads/'.$image_local_dir.'/'.$real_image_informations['image_datas']['sizes']['thumbnail']['file'];
				$image_jqueryhtmlegend = '<div id="html'.$index_image.'" style="display:none">';
				$image_post = $real_image_informations['post'];
				if (strlen($image_post->post_title) > 0){
					$image_jqueryhtmlegend .= '<h4>'.$image_post->post_title.'</h4>';
				}
				if (strlen($image_post->post_excerpt) > 0){
					$image_jqueryhtmlegend .= '<h5>'.$image_post->post_excerpt.'</h5>';
				}
				if (strlen($image_post->post_content) > 0){
					$image_jqueryhtmlegend .= '<p>'.$image_post->post_content.'</p>';
				}
				if($real_image_informations['author']){
					$author_name = $real_image_informations['author']->display_name;
					$image_jqueryhtmlegend .= '<p><i>'.$author_name.'</i></p>';
				}
				$image_jqueryhtmlegend .='</div>';
				$image_elements_array['html_legend'] = $image_jqueryhtmlegend;
				$image_element = '<li data-src="'.$large_image_url.'" data-responsive-src="'.$medium_image_url.'" data-sub-html="#html'.$index_image.'"><a href="#">';
				$image_element .= '<img src="'.$thumb_url.'"';
				$image_element .= '</a></li>';
				$image_elements_array['html_image'] = $image_element;
			}
			return $image_elements_array;
		}
		function rsmg_mod_jquerylightbox($atts) {
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
				$main_jqueryullist = '<di><ul class="light-gallery-serie gallery list-unstyled home">';
				$main_jqueryhtmlegend = '';
				$index = 0;
				if ($the_ids == null) {
					foreach ( $image_posts as $image_post ) {
						$index++;
						$real_image_informations = $this->get_complemtary_image_infos($image_post);
						$image_elements_array = $this->image_for_jquery_lightbox($real_image_informations,$index);
						if($image_elements_array['html_image']){
							$main_jqueryullist .= $image_elements_array['html_image'];
							if($image_elements_array['html_legend']){
								$main_jqueryhtmlegend .= $image_elements_array['html_legend'];
							}
						}
					}
				} else {
					// We have to show the image in the order foreseen
					foreach ( $the_ids as $id ) {
						foreach ( $image_posts as $image_post ) {
							if ($image_post->ID == $id) {
								$index++;
								$real_image_informations = $this->get_complemtary_image_infos($image_post);
								$image_elements_array = $this->image_for_jquery_lightbox($real_image_informations,$index);
								if($image_elements_array['html_image']){
									$main_jqueryullist .= $image_elements_array['html_image'];
									if($image_elements_array['html_legend']){
										$main_jqueryhtmlegend .= $image_elements_array['html_legend'];
									}
								}
							}
						}
					}
				}
				$main_jqueryullist .= '</ul></div>';
				return $main_jqueryullist.$main_jqueryhtmlegend;
		
			}
			return "<h2>Ma JQueryLightBox ici:" . $atts ['ids'] . "</h2>";
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
		
		public function rsmg_base_url(){
			return $this->base_url;
		}
		// run only on posts, pages, attachments(?) and galleries, no reason to run on the front page, yet...?
		function rsmg_mod_content() {
			if (is_singular ()) {
				
				// registering styles and scripts
				add_action ( 'wp_enqueue_scripts', array($this,'rsmg_enqueue'));
				
				// make also the default Gallery gallery in a Bootstrap Carousel ...
				add_shortcode ( 'gallery', array($this,'rsmg_mod_jquerylightbox'));
				
			}
		}
	}
}