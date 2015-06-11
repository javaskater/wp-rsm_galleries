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
		
		function __construct(){
			$this->base_url = get_site_url();
			$this->thumb_size = 150;
		}
		
		function rsmg_enqueue() {
			
			/*
			 * Pour les tests de Jquery Light Plugin !!!
			 * https://github.com/sachinchoolur/lightGallery
			 */
			wp_enqueue_style ( 'jqlg', plugin_dir_url ( __FILE__ ) . 'css/lightGallery.css', false, 'r3' );
			wp_enqueue_style ( 'jqlgcustoms', plugin_dir_url ( __FILE__ ) . 'css/customjplg.css', false, 'r3' );
			wp_enqueue_script ( 'jqlightbox', plugin_dir_url ( __FILE__ ) . 'js/lightGallery.js', array ('jquery'
			), '1.0', true );
			wp_enqueue_script ( 'myjqlightbox', plugin_dir_url ( __FILE__ ) . 'js/galleryjqlg.js', array ('jqlightbox'
			), '0.1', true );
			
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
		 * Create a slideshow based on existing galleries of the post 
		 * use of the https://github.com/sachinchoolur/lightGallery for responsive animation 
		 */
		private function image_for_jquery_lightbox($real_image_informations,$index_image){
			$image_elements_array = array();
			if($real_image_informations['image_datas']){
				$original_file = $real_image_informations['image_datas']['file'];
				$original_file_name = basename($original_file);
				$image_local_dir = dirname($original_file);
				$large_file_name = $original_file_name;
				if($real_image_informations['image_datas']['sizes']['slide-large-thumb']['file']){
					$large_file_name = $real_image_informations['image_datas']['sizes']['slide-large-thumb']['file'];
				} elseif ($real_image_informations['image_datas']['sizes']['large']['file']){
					$large_file_name = $real_image_informations['image_datas']['sizes']['large']['file'];
				}
				$large_image_url = $this->base_url.'/wp-content/uploads/'.$image_local_dir.'/'.$large_file_name;
				
				$medium_file_name = $original_file_name;
				if($real_image_informations['image_datas']['sizes']['slide-medium-thumb']['file']){
					$medium_file_name = $real_image_informations['image_datas']['sizes']['slide-medium-thumb']['file'];
				} elseif ($real_image_informations['image_datas']['sizes']['medium']['file']){
					$medium_file_name = $real_image_informations['image_datas']['sizes']['medium']['file'];
				}
				$medium_image_url = $this->base_url.'/wp-content/uploads/'.$image_local_dir.'/'.$medium_file_name;
				
				$thumb_file_name = $original_file_name;
				if($real_image_informations['image_datas']['sizes']['slide-small-thumb']['file']){
					$thumb_file_name = $real_image_informations['image_datas']['sizes']['slide-small-thumb']['file'];
				} elseif ($real_image_informations['image_datas']['sizes']['small']['file']){
					$thumb_file_name = $real_image_informations['image_datas']['sizes']['small']['file'];
				}
				$thumb_url = $this->base_url.'/wp-content/uploads/'.$image_local_dir.'/'.$thumb_file_name;
				
				$image_jqueryhtmlegend = '<div id="html'.$index_image.'" style="display:none"><div class="custom-html">';
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
				$image_jqueryhtmlegend .='</div></div>';
				$image_elements_array['html_legend'] = $image_jqueryhtmlegend;
				$image_element = '<li data-src="'.$large_image_url.'" data-responsive-src="'.$medium_image_url.'" data-sub-html="#html'.$index_image.'"><a href="#">';
				$image_element .= '<img src="'.$thumb_url.'"></img>';
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
				$main_jqueryullist = '<ul class="light-gallery-serie gallery list-unstyled">';
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
				$main_jqueryullist .= '</ul>';
				return "<div class='jqlg-container'>".$main_jqueryullist.$main_jqueryhtmlegend."</div>";
		
			}
			return "<h2>Ma JQueryLightBox ici:" . $atts ['ids'] . "</h2>";
		}
		
		/*
		 * Create a jqlg gallery based on imported Joomla Galleries !!!!
		 * use of the https://github.com/sachinchoolur/lightGallery for responsive animation
		 */
		/*
		 * Create a slideshow based on existing galleries of the post if use of the Joo Shortcode from the Joo Galleries
		 * ToDo: an admin switch to decide wiche kind orf responsive gallery to Use
		 * */
		private function isimage($mediapath) { //http://stackoverflow.com/questions/15408125/php-check-if-file-is-an-image
			if (file_exists($mediapath)){
				return getimagesize($mediapath) ? true : false;
			}else{
				return false;
			}
		}
		private function jooimage_for_jquery_lightbox($image_infos,$thumb_size,$index_image){
			$label_array = $image_infos['labels'];
			$images_dir = $image_infos['dir'];
			$images_base_url = $image_infos['base_url'];
			if(sizeof($label_array) >= 3){
				$real_image_name = $label_array[0];
				$real_image_full_path = $images_dir."/".$real_image_name;
				if ($this->isimage($real_image_full_path)){
					$description = $label_array[1];
					$author = $label_array[2];
					$title_alt = $description."|".$author;
					$real_image_url = $images_base_url."/".$real_image_name;
					$image_elements_array = array();
					//TODO si le thumb  n'existe pas redimmensionner en PHP cf. l'import de Joomla vers Wordpress !!!!
					$large_file_name = $real_image_name;
					$large_image_url = $real_image_url;
					$medium_file_name = $large_file_name;
					$medium_image_url = $large_image_url;
					$real_image_path_parts = pathinfo($real_image_full_path);//http://php.net/manual/fr/function.pathinfo.php
					$thumb_image_extension = strtolower($real_image_path_parts['extension']);
					$thumb_file_name = $real_image_path_parts['filename']."-".$thumb_size."x".$thumb_size.".".$thumb_image_extension;
					$thumb_dir = $real_image_path_parts['dirname'];
					$thumb_full_path = $thumb_dir."/".$thumb_file_name;
					if(!file_exists($thumb_full_path)){
						//https://codex.wordpress.org/Class_Reference/WP_Image_Editor for resizing Image
						$image = wp_get_image_editor( $real_image_full_path ); // Return an implementation that extends <tt>WP_Image_Editor</tt>
						if ( ! is_wp_error( $image ) ) {
							//$image->rotate( 90 ); only for the example
							$image->resize( $thumb_size, true );
							$image->save( $thumb_full_path );
						}
					}
					$thumb_url = $images_base_url.'/'.$thumb_file_name;
			
					$image_jqueryhtmlegend = '<div id="html'.$index_image.'" style="display:none"><div class="custom-html">';
					$image_jqueryhtmlegend .= '<h4>'.$description.'</h4>';
					$image_jqueryhtmlegend .= '<h5>'.$author.'</h5>';
					$image_jqueryhtmlegend .='</div></div>';
					$image_elements_array['html_legend'] = $image_jqueryhtmlegend;
					$image_element = '<li data-src="'.$large_image_url.'" data-responsive-src="'.$medium_image_url.'" data-sub-html="#html'.$index_image.'"><a href="#">';
					$image_element .= '<img src="'.$thumb_url.'"></img>';
					$image_element .= '</a></li>';
					$image_elements_array['html_image'] = $image_element;
					return $image_elements_array;
				}
			}
			return null;
		}
		function rsmg_mod_JooGallery($atts) {
			extract ( shortcode_atts ( array (
					'path' => '',
			), $atts ) );
			$request = null;
			$the_ids = null;
			if ($atts['path'] == null) {
				return "<p>Attribut path oublié!!!</p>";
			} else {
				$images_path = ABSPATH."wp-content/uploads/images/".$atts['path'];
				$images_url = $this->base_url."/wp-content/uploads/images/".$atts['path'];
				$images_infos = array('dir' => ABSPATH."wp-content/uploads/images/".$atts['path'],
						'base_url' => $this->base_url."/wp-content/uploads/images/".$atts['path']
				);
				$labels_path = $images_path."/labels.txt";
				/*
				 * La fonction finale ...
				 */
				$main_jqueryullist = '<ul class="light-gallery-serie gallery list-unstyled">';
				$main_jqueryhtmlegend = '';
				$index = 0;
				if(file_exists($labels_path) && is_readable ($labels_path) && $lp = fopen($labels_path,'r')){
					while (($label = fgets($lp)) !== false){
						$label_array = explode("|",$label);
						$images_infos['labels'] = $label_array;
						$image_gal_datas = $this->jooimage_for_jquery_lightbox($images_infos,$this->thumb_size,$index);
						if($image_gal_datas != null){
							$main_jqueryullist .= $image_gal_datas['html_image'];
							$main_jqueryhtmlegend .= $image_gal_datas['html_legend'];
						}
					}
					$main_jqueryullist .= '</ul>';
					return "<div class='jqlg-container'>".$main_jqueryullist.$main_jqueryhtmlegend."</div>";
				}else{
					//return "<p>Galerie fichier de lables:".$labels_path." non trouvé</p>";
					if (file_exists($images_path) && is_dir($images_path) && $handle = opendir($images_path)){
						while (false !== ($entry = readdir($handle))) {
							if(basename($entry) != '.' && basename($entry) != '..' && $this->isimage($images_path.'/'.$entry)){
								$label_array = array($entry,'xxxxxxxxxxxx','yyyyyyyyy');
								$images_infos['labels'] = $label_array;
								$image_gal_datas = $this->jooimage_for_jquery_lightbox($images_infos,$this->thumb_size,$index);
								if($image_gal_datas != null){
									$main_jqueryullist .= $image_gal_datas['html_image'];
									$main_jqueryhtmlegend .= $image_gal_datas['html_legend'];
								}
							}
						}
						return "<div class='jqlg-container'>".$main_jqueryullist.$main_jqueryhtmlegend."</div>";
					}else{
						return "<p>Galerie fichier de lables:".$labels_path." non trouvé et ".$images_path." n'est pas un répertoire valide!</p>";
					}
				}
			}
			
		}
	}
}