<?php
/*
Plugin Name: Entrada VC Addons
Plugin URI: http://waituk.com/
Description: Declares a plugin that will extend Visual Composer Elements and Shortcodes.
Version: 2.0.0
Author: WAITUK
Author URI: http://waituk.com/
License: GPLv2
*/


if ( in_array( 'js_composer/js_composer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	require_once 'vc-extended-shortcode.php';

	require_once 'vc-extended-elements.php';	  


}
else {


	add_action( 'admin_notices', 'admin_notice_evc_activation');	


}

function entrada_product_cat_url($term_id, $mode = 'default'){
	$url = '';
	switch ($mode) {
		case 'custom':
			$url = '#';
			$term_meta = get_option( "taxonomy_$term_id" );
			if(array_key_exists('prod_cat_dig_more_link', $term_meta) && $term_meta['prod_cat_dig_more_link'] != '' ){
				$url = $term_meta['prod_cat_dig_more_link'];
			}
			
			break;

		case 'search':
			$term = get_term_by('id', $term_id, 'product_cat');
			$url = esc_url( home_url( '/' ). 'find/tours/?product_cat='.$term->slug );
			break;	 
		
		default:
			$url = esc_url( get_term_link( $term_id ) );
			break;
	}

	return $url;
}
	


function admin_notice_evc_activation(){


	echo '<div class="error"><p>' . __('The <strong>Entrada VC Addons</strong> plugin requires <strong>Visual Composer</strong> installed and activated.' , 'entrada' ) . '</p></div>';


} ?>