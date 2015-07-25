<?php
/**
 * JPMEna Gallery links manipulation
 * Module to manipulate Gallery Links
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists('social_links', false) ) {
	class social_links {
		//the array of wp links found in the POST!!!
		private $sn_links_array;
		private $snrsmimg_link_count;
		private $type;
                private $image_domains = array('picasa'=>'lh3.googleusercontent.com');
		
		public function __construct($reseau,$type) {
			$this->sn_links_array = array();
			$this->snrsmimg_link_count = 0;
                        $this->type = $type;
			$this->reseau = $reseau; //the gallery.js type to apply
                        
		}
		
		protected function remove_picasa_link($found_image_link){
			if (sizeof($found_image_link) == 6){
				$img_url = $found_image_link[3];
                                $thumb_url = $img_url;
                                $pos = strpos($img_url,$this->image_domains[$this->reseau]);
                                if($pos > 0){
                                    $format = "<a href='%s'><img%ssrc='%s' data-imagelightbox='%s' %s /></a>";
                                    $new_img_wp_code = sprintf($format,$img_url,$found_image_link[1],$thumb_url,$this->type,$found_image_link[5]);
                                    $this->sn_links_array[] = array('img_url'=>$img_url,
                                                                    'thumb_url'=>$thumb_url,
                                                                    'new_img_picasa_code'=>$new_img_wp_code);
                                    return '__rsmpicasa_link_' . $this->snrsmimg_link_count++ . '__';
                                } else {
                                    return $found_image_link[0]; //we do nothing in that case
                                }
			}else{
				return $found_image_link[0]; //we do nothing in that case 
			}
			
		}
		
		protected function restore_picasa_link($replacment_text_matches){
			$wp_rsm_image = $this->sn_links_array[$replacment_text_matches[1]];
			$new_link = array_key_exists('new_img_picasa_code', $wp_rsm_image)? $wp_rsm_image['new_img_picasa_code'] : $replacment_text_matches[0];
			return $new_link;
		}
                public function contentimagestogallery($content){
                    if ($this->reseau == "picasa"){
                        $pattern = "/<img(.*?)src=('|\")(.*?)('|\")(.*?)\/>/i";
			/*
			 * We chage the image href from http://wprsm.1and1/?attachment_id=110 to http://wprsm.1and1/wp-content/uploads/2014/04/web_DSC_0527.jpg when the image source (the thumb_url in my code) itself is http://wprsm.1and1/wp-content/uploads/2014/04/web_DSC_0527-200x132.jpg use of http://www.php.net/manual/en/function.preg-match-all.php
			 */
			$content = preg_replace_callback ( $pattern, array (
					$this,
					'remove_picasa_link' 
			), $content );
			$content = preg_replace_callback ( "/__rsmpicasa_link_(\d+)__/i", array (
					$this,
					'restore_picasa_link' 
			), $content );
                    }
                    return $content;
                }
            }
}