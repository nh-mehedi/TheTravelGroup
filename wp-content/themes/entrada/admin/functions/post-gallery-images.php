<?php
/* Entrada Post Gallery Images 
.................................... */
add_action( 'admin_init', 'entrada_add_post_gallery_so_14445904' );
add_action( 'save_post', 'entrada_update_post_gallery_so_14445904', 10, 2 );
/**
 * Add custom Meta Box to Posts post type
 */
function entrada_add_post_gallery_so_14445904(){
    add_meta_box(
        'post_gallery',
        'Post Gallery Images',
        'entrada_post_gallery_options_so_14445904',
        'post',
        'normal',
        'core'
    );
}
/**
 * Print the Meta Box content
 */
function entrada_post_gallery_options_so_14445904(){
    global $post;
	$entrada_img_gal_arr = array();	
    $entrada_img_gal = get_post_meta( $post->ID, 'entrada_img_gal', true );
	if( isset( $entrada_img_gal ) && !empty( $entrada_img_gal ) ){
		$entrada_img_gal_arr = $entrada_img_gal;
	} 

    /* Use nonce for verification */
	wp_nonce_field(basename(__FILE__), "noncename_so_14445904"); ?>
	<div id="dynamic_form">
		<ul class="post-gallery-list entrada_thumb" id="entrada_image_galleries">
		<?php
		
			if(count($entrada_img_gal_arr) > 0 ) {
				$cnt = 0;
				foreach($entrada_img_gal_arr as $attach_id){
					$cnt++;
				
					$entrada_img_gal = wp_get_attachment_url( $attach_id );
					$image = matthewruddy_image_resize( $entrada_img_gal, 150, 150, true, false);
					
					if (array_key_exists('url', $image) && $image['url'] != '') {
						echo '<li><div class="holder"><input type="hidden" name="entrada_img_gal[]" value="'.$attach_id.'"> <img src="'.$image['url'].'"> <a class="delete" href="javascript:void(null);"><img src="'.get_template_directory_uri().'/admin/img/delete.png"></a></div></li>';
					}
				}
			} ?>
		</ul>
		<div id="add_field_row">
			<input class="button" type="button" id="add_post_gallery_images" value="<?php _e('Add post gallery images', 'entrada'); ?>"  />
		</div>
	</div>
<?php
}
/**
 * Save post action, process fields
 */
function entrada_update_post_gallery_so_14445904( $post_id, $post_object ) {
    /* Doing revision, exit earlier **can be removed** */
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )  {
        return;
	}
    /* Doing revision, exit earlier */
    if ( 'revision' == $post_object->post_type ){
        return;
	}
    /* Verify authenticity */
	if ( !isset( $_POST["noncename_so_14445904"] ) || !wp_verify_nonce( $_POST["noncename_so_14445904"], basename(__FILE__) ) ){
        return;
	}
    /* Correct post type */
    if ( 'post' != $_POST['post_type'] ){ /* here you can set post type name */
        return;
	}
	if(isset( $_POST['entrada_img_gal'] ) && count( $_POST['entrada_img_gal'] ) > 0){
		update_post_meta($post_id, "entrada_img_gal",  $_POST['entrada_img_gal'] );
	}
	else{
		delete_post_meta($post_id, "entrada_img_gal", '');	
	}
} ?>