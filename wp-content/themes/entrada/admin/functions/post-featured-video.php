<?php
/* Entrada Post Featured Video
.................................... */
add_action( 'admin_init', 'entrada_add_post_featured_video' );
add_action( 'save_post', 'entrada_update_post_featured_video', 10, 2 );
/**
 * Add custom Meta Box to Posts post type
 */
function entrada_add_post_featured_video(){
    add_meta_box(
        'post_featured_video',
        'Featured Video',
        'entrada_print_featured_video_option',
        'post',
        'side',
        'low'
    );
}
/**
 * Print the Meta Box content
 */
function entrada_print_featured_video_option(){
    global $post;
    $featured_video_url = get_post_meta( $post->ID, 'featured_video_url', true );
    /* Use nonce for verification */
	wp_nonce_field(basename(__FILE__), "noncename_so_144459045"); ?>
	<div id="dynamic_form">
		<div id="add_field_row">
			<input type="text" name="featured_video_url" size="32" value="<?php echo $featured_video_url; ?>" >
			<p class="howto">Add Youtube/vimeo URL.</p>
		</div>
	</div>
<?php
}
/**
 * Save post action, process fields
 */
function entrada_update_post_featured_video( $post_id, $post_object ){
    /* Doing revision, exit earlier **can be removed** */
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
	}
    /* Doing revision, exit earlier */
    if ( 'revision' == $post_object->post_type ){
        return;
	}
    /* Verify authenticity */
	if (!isset($_POST["noncename_so_144459045"]) || !wp_verify_nonce($_POST["noncename_so_144459045"], basename(__FILE__))) {
        return;
	}
    /* Correct post type */
    if ( 'post' != $_POST['post_type'] ){ /* here you can set post type name */
        return;
	}		
	if(isset( $_POST['featured_video_url'] ) ){
		update_post_meta($post_id, "featured_video_url", $_POST['featured_video_url']);
	}
    else{
		delete_post_meta($post_id, "featured_video_url", '');	
	}
} ?>