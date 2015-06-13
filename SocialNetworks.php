<?php
/**
 * Inspired by
* http://sachinchoolur.github.io/lightGallery/
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists('socialNetworks', false) ) {
	class socialNetworks {
		public function addGoogleButton(){
			$context .= '<a href="#vpml_popup" id="vpml-btn" class="button add_media" title="Picasa"><span class="wp-media-buttons-icon"></span> Picasa</a><input type="hidden" id="vpml_featured_url" name="vpml_featured_url" value="" />';
			return $context;
		}
		
	}
}