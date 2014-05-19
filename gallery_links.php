<?php
/**
 * JPMEna Gallery links manipulation
 * Module to manipulate Gallery Links
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists('wprsm_links', false) ) {
	class wprsm_links {
		//the array of wp links found in the POST!!!
		private $wp_links_array;
		private $wprsmimg_link_count;
		private $type;
		
		public function __construct($type) {
			$this->wp_links_array = array();
			$this->wprsmimg_link_count = 0;
			$this->type = $type; //the gallery.js type to apply
		}
		
		public function remove_wp_link($found_image_link){
			if (sizeof($found_image_link) > 11){
				$img_url = $found_image_link[3];
				$thumb_url = $found_image_link[9];
				$format = "<a%shref='%s' %s><img%ssrc='%s' data-imagelightbox='%s' %s /></a>";
				$new_img_wp_code = sprintf($format,$found_image_link[1],$img_url,$found_image_link[5],$found_image_link[7],$thumb_url,$this->type,$found_image_link[11]);
				$this->wp_links_array[] = array('img_url'=>$img_url,
						'thumb_url'=>$thumb_url,
						'new_img_wp_code'=>$new_img_wp_code);
				return '__rsmwp_link_' . $this->wprsmimg_link_count++ . '__';
			}else{
				return $found_image_link[0]; //we do nothing in that case 
			}
			
		}
		
		public function restore_wp_link($replacment_text_matches){
			$wp_rsm_image = $this->wp_links_array[$replacment_text_matches[1]];
			$new_link = array_key_exists('new_img_wp_code', $wp_rsm_image)? $wp_rsm_image['new_img_wp_code'] : $replacment_text_matches[0];
			return $new_link;
		}
	}
}