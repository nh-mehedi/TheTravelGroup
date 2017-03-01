<?php
/* PRODUCT TAB INFO.
 ............................ */
function entrada_add_product_custom_meta_box(){
    add_meta_box("entrada-product-meta-box", "Product Informations", "entrada_product_custom_meta_box", "product", "side", "low", null);
}
function entrada_product_custom_meta_box($object){
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");
	$trip_group_size_capacity = get_post_meta($object->ID, "trip_group_size_capacity", true);
	$trip_group_size = get_post_meta($object->ID, "trip_group_size", true);
	$trip_sub_heading = get_post_meta($object->ID, "trip_sub_heading", true); ?>
    <table width="100%" class="widefat fixed comments" style="padding-bottom:20px;">    
        <tr>
			<td><label for="meta-box-text"><?php _e('Sub-Title', 'entrada'); ?> </label> </td>
			<td><input name="trip_sub_heading" type="text" value="<?php echo $trip_sub_heading;  ?>"  style="width:100%;"> </td>
        </tr>
    	<tr>
			<td><label for="meta-box-text"><?php _e('Duration', 'entrada'); ?></label> </td>
			<td><input name="trip_duration" type="text" value="<?php echo get_post_meta($object->ID, "trip_duration", true); ?>" style="width:100%;"> </td>
        </tr>        
        <tr>
			<td><label for="meta-box-text"><?php _e('Group Size', 'entrada'); ?></label> </td>
			<td>
				<select name="trip_group_size" >
					<option value=""><?php _e('Group Size', 'entrada'); ?></option>
					<option value="Small Group" <?php if($trip_group_size == 'Small Group') { echo ' selected="selected"';} ?>> <?php _e('Small', 'entrada'); ?> </option>
					<option value="Medium Group"<?php if($trip_group_size == 'Medium Group') { echo ' selected="selected"';} ?>> <?php _e('Medium', 'entrada'); ?> </option>
					<option value="Large Group"<?php if($trip_group_size == 'Large Group') { echo ' selected="selected"';} ?>> <?php _e('Large', 'entrada'); ?> </option>
				 </select>
            </td>
        </tr>
		<tr>
			<td><label for="meta-box-text"><?php _e('Group Capacity', 'entrada'); ?> </label> </td>
			<td><input name="trip_group_size_capacity" type="text" value="<?php echo $trip_group_size_capacity;  ?>"  style="width:100%;"> </td>
        </tr>	
    </table>
<?php  
}
function entrada_save_product_custom_meta_box( $post_id, $post, $update ){
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__))){
        return $post_id;	
	}
    if(!current_user_can("edit_post", $post_id)){
        return $post_id;
	}
    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE){
        return $post_id;
	}
    if($post->post_type != 'product' ){
        return $post_id;
	}
    if(isset($_POST["trip_duration"])) {
      update_post_meta($post_id, "trip_duration", $_POST["trip_duration"]);
    }	
	if(isset($_POST["trip_group_size_capacity"])) {
      update_post_meta($post_id, "trip_group_size_capacity", $_POST["trip_group_size_capacity"]);
    }	
	if(isset($_POST["trip_group_size"])) {
      update_post_meta($post_id, "trip_group_size", $_POST["trip_group_size"]);
    }	
	if(isset($_POST["trip_sub_heading"])) {
      update_post_meta($post_id, "trip_sub_heading", $_POST["trip_sub_heading"]);
    }   
}
add_action("add_meta_boxes", "entrada_add_product_custom_meta_box");
add_action("save_post", "entrada_save_product_custom_meta_box", 10, 3);
	
/* PRODUCT TAB DETAIL INFO. 
 ............................ */
function entrada_add_product_custom_detailtab_meta_box(){
    add_meta_box("entrada-product-detailtab-meta-box", "Product Details", "entrada_product_detailtab_custom_meta_box", "product", "normal", "high", null);
}
function entrada_product_detailtab_custom_meta_box( $post ){
	global $wpdb;
	global $post;	
	$post_id = $post->ID;
	
	$customized_settings = array(
							'quicktags' 	=> array('buttons' => 'em,strong,link'),
							'quicktags' 	=> true,
							'tinymce' 		=> true,
							'textarea_rows'	=> 10,
						);
	wp_nonce_field(basename(__FILE__), "prodtab-box-nonce");
	$product_overview_detail = get_post_meta($post_id,'product_overview_detail', true);
	$product_overview_included_feature = get_post_meta($post_id,'product_overview_included_feature', true);
	$product_overview_not_included_feature = get_post_meta($post_id,'product_overview_not_included_feature', true);
	/* Itinerary ......... */
	$product_itinerary_arr = array();
	$product_itinerary = get_post_meta($post_id, 'product_itinerary', true);	
	if(isset($product_itinerary) && !empty($product_itinerary)){
		$product_itinerary_arr = maybe_unserialize($product_itinerary);
	}	
	/* Product Itinerary Gallery  ......... */	
	$itinerary_gallery_img_arr = array();	
	$itinerary_gallery_img = get_post_meta($post_id, 'itinerary_gallery_img', true);	
	if(isset($itinerary_gallery_img) && !empty($itinerary_gallery_img)){
		$itinerary_gallery_img_arr = maybe_unserialize($itinerary_gallery_img);
	}
   	/* Product Gallery  ......... */	
   	$product_gallery_img_arr = array();		
   	$product_gallery_img = get_post_meta($post_id, 'product_gallery_img', true); 
   	if(isset($product_gallery_img) && !empty($product_gallery_img) ){
		$product_gallery_img_arr = maybe_unserialize($product_gallery_img);
	}
	/* Product Accommodation  ......... */	
	$hotel_name = get_post_meta($post_id,'hotel_name', true);
	$product_accommodation = get_post_meta($post_id,'product_accommodation', true);	
	$included_title = get_post_meta($post_id,'included_title', true);
	$included_sub_title = get_post_meta($post_id,'included_sub_title', true);
	$product_shared_room_included_feature = get_post_meta($post_id,'product_shared_room_included_feature', true);
	$excluded_title = get_post_meta($post_id,'excluded_title', true);
	$excluded_sub_title = get_post_meta($post_id,'excluded_sub_title', true);
	$product_individual_room_not_included_feature = get_post_meta($post_id,'product_individual_room_not_included_feature', true);	
	
	/* FAQ  ......... */	
	$product_faq_arr = array();
	$product_faq = get_post_meta($post_id,'product_faq', true);
	if(isset($product_faq) && !empty($product_faq)){		
		$product_faq_arr = maybe_unserialize($product_faq);
	}
	
	/* Product Addons  ......... */	
	$product_addons_arr = array();
	$product_addons = get_post_meta($post_id,'product_addons', true);
	if(isset($product_addons) && !empty($product_addons)){		
		$product_addons_arr = maybe_unserialize($product_addons);
	}
	
	$entrada_product_type = get_post_meta($post_id,'entrada_product_type', true);
	$entrada_product_type_arr = array(
									'tour' => 'Tours',
									'shop_item' => 'Shop Item',
								);
	 ?>
     <table width="100%" class="widefat fixed comments" style="padding-bottom:20px;">    
        <tr>
			<td width="30%"><label for="meta-box-text"><?php _e('Product Type', 'entrada'); ?> </label> </td>
			<td  width="70%"><select name="entrada_product_type" id="entrada_product_type">
            	<?php
                	foreach($entrada_product_type_arr as $key => $value ) {
						$selected = '';
						if(isset($entrada_product_type) && $entrada_product_type == $key ){
							$selected = ' selected = "selected"';
							}
						echo '<option value="'.$key.'" '.$selected.'> '.$value.'</option>';		
					}
					
				?>
             </select></td>
        </tr>
        
       </table> 
	<div class ="product_tab_attributes">
		<div id="prod_custom_tabs">
			<ul>
				<li><a href="#overview"> <span class="img"><img src="<?php echo get_template_directory_uri();?>/admin/img/icon-overview.png"></span> <span class="text"><?php _e('Overview', 'entrada'); ?></span></a> </li>
				<li> <a href="#itinerary"><span class="img"><img src="<?php echo get_template_directory_uri();?>/admin/img/icon-itinerary.png"></span> <span class="text"><?php _e('Itinerary', 'entrada'); ?></span></a> </li>
				<li><a href="#accommodation"><span class="img"><img src="<?php echo get_template_directory_uri();?>/admin/img/icon-accommodation.png"></span><span class="text"><?php _e('Accommodation', 'entrada'); ?></span></a></li>
				<li><a href="#faq_reviews"><span class="img"><img src="<?php echo get_template_directory_uri();?>/admin/img/icon-faq.png"></span><span class="text"><?php _e('FAQs', 'entrada'); ?></span></a></li>
				<li> <a href="#gallery"><span class="img"><img src="<?php echo get_template_directory_uri();?>/admin/img/icon-gallery.png"></span><span class="text"><?php _e('Gallery', 'entrada'); ?></span></a> </li>
                <li> <a href="#addons"><span class="img"><img src="<?php echo get_template_directory_uri();?>/admin/img/product_addons.png"></span><span class="text"><?php _e('Add-ons', 'entrada'); ?></span></a> </li>
			</ul>
			<div id="overview">
			<h4>Overview</h4>
			<table cellpadding="0" class="widefat fixed comments" cellspacing="6" border="0" width="100%">
				<tbody>
					<tr><td><?php  wp_editor( $product_overview_detail, 'product_overview_detail', $customized_settings ); ?></td></tr>
					<tr><td><h4><?php _e('Whats included in this tour?', 'entrada'); ?></h4></td></tr>
					<tr><td><?php  wp_editor( $product_overview_included_feature, 'product_overview_included_feature', $customized_settings ); ?></td></tr>
					<tr><td><h4><?php _e('Whats not included in this tour?', 'entrada'); ?></h4></td></tr>
					<tr><td><?php  wp_editor( $product_overview_not_included_feature, 'product_overview_not_included_feature', $customized_settings ); ?></td></tr>
				</tbody>
			</table>					
			</div>
			<div id="itinerary">
				<h4><?php _e('Itinerary', 'entrada'); ?> </h4>
				<table cellpadding="0" id="itinerary_table" class="widefat fixed comments entrada_table" cellspacing="6" border="0" width="100%">
					<thead>
						<tr>
							<th width="12%"><?php _e('#', 'entrada'); ?></th>
							<th width="30%"><?php _e('Title', 'entrada'); ?> </th>
							<th width="45%"><?php _e('Description', 'entrada'); ?></th>
							<th width="13%"><?php _e('Action', 'entrada'); ?></th>
						</tr>
					</thead>
					<tbody>
				<?php
					if( $product_itinerary_arr ) {
						$cnt = 0;
						foreach($product_itinerary_arr as $itinerary){ 
							$cnt++;

							if (array_key_exists("itinerary_txt",$itinerary) && $itinerary['itinerary_txt'] != ''){
								$itinerary_txt = stripslashes( $itinerary['itinerary_txt'] ); 
							} else{
								$itinerary_txt = __('Day', 'entrada') .$cnt;
							}

							 ?>
							<tr id="row_<?php echo $cnt; ?>">
								<td class="itinerary_counter" title="<?php echo $cnt; ?>"><input type="text" name="itinerary_txt[]" value="<?php echo $itinerary_txt; ?>"> </td>
								<td >
									<input type="text" name="itinerary_title[]" value="<?php echo stripslashes( $itinerary['itinerary_title'] ); ?>"> 
								</td>
								<td  align="left">
									<textarea style="width:100%; height:60px;"  name="itinerary_desc[]"><?php echo stripslashes( $itinerary['itinerary_desc'] ); ?></textarea>
								</td>
								<td >
								<?php if($cnt == 1) { ?>
									<a href="javascript:void(null);" id="add_itinerary_row" class="button button-primary button-small" > <?php _e('Add New', 'entrada'); ?> </a> 
								<?php }
								else { ?>
									<a href="javascript:void(null);" class="button button-small" onClick="remove_itinery(<?php echo $cnt; ?>);" > <?php _e('Remove', 'entrada'); ?> </a> 
								<?php } ?>
								</td>
							</tr>	  
					<?php
						}
					}
					else { ?>	
						<tr>
							<td class="itinerary_counter" title="1"><input style="width:100%;" type="text" name="itinerary_txt[]" value=""></td>
							<td><input style="width:100%;" type="text" name="itinerary_title[]" value=""></td>
							<td  align="left"><textarea style="width:100%; height:60px;"  name="itinerary_desc[]"></textarea></td>
							<td><a href="javascript:void(null);" id="add_itinerary_row" class="button button-primary button-small" > <?php _e('Add New', 'entrada'); ?> </a></td>
						</tr>
				<?php } ?>
					</tbody>
				</table>
				  
				<div class="product-tab-gallery-block">
					<div class="pro-heading">
						<div class="btn-holder">
							<input class="button" type="button" id="add_itinerary_gallery_images" value="<?php _e('Add Images', 'entrada'); ?>"  />
						</div>
						<h4><?php _e('Itinerary Gallery', 'entrada'); ?></h4>
					</div>
					<div id="itinerary_gallery_pane" class="pro-content">
						<ul id="itinerary_gallery" class="entrada_thumb">
						<?php 
							if(count($itinerary_gallery_img_arr) > 0 ) {
								$cnt = 0;
								foreach($itinerary_gallery_img_arr as $attach_id){
									$cnt++;
									$entrada_iti_img_gal = wp_get_attachment_url( $attach_id );
									$image = matthewruddy_image_resize( $entrada_iti_img_gal, 150, 150, true, false);
									if (array_key_exists('url', $image) && $image['url'] != '') {
										echo '<li><div class="holder"><input type="hidden" name="itinerary_gallery_img[]" value="'.$attach_id.'"> <img src="'.$image['url'].'" height="150" width="150"> <a class="delete" href="javascript:void(null);"><img src="'.get_template_directory_uri().'/admin/img/delete.png"></a></div></li>';
									}
								}
							} ?>
						</ul>
					</div>
				</div>
			</div>
			<div id="accommodation">
				<h4><?php _e('Title', 'entrada'); ?> </h4>
				<table cellpadding="0" class="widefat fixed comments" cellspacing="6" border="0" width="100%">
				  <tbody>
					<tr>
					  <td><input type="text" style="width:100%;" name="hotel_name" id="hotel_name" value="<?php echo $hotel_name; ?>" /></td>
					</tr>
					<tr>
					  <td><?php  wp_editor( $product_accommodation, 'product_accommodation', $customized_settings ); ?></td>
					</tr>					
				  </tbody>
				</table>
				<br>
				<h4><?php _e('The tour package inclusions', 'entrada'); ?> </h4>
				<table cellpadding="0" class="widefat fixed comments" cellspacing="6" border="0" width="100%">
				  <tbody>					
					<tr>
					  <td><input type="text" style="width:100%;" name="included_title" id="included_title" value="<?php echo $included_title; ?>" placeholder="Title" /></td>
					</tr>
					<tr>
					  <td><input type="text" style="width:100%;" name="included_sub_title" id="included_sub_title" value="<?php echo $included_sub_title; ?>" placeholder="Sub Title" /></td>
					</tr>
					<tr>
					  <td><?php  wp_editor( $product_shared_room_included_feature, 'product_shared_room_included_feature', $customized_settings ); ?></td>
					</tr>					
				  </tbody>
				</table>
				<br>
				<h4><?php _e('The tour package exclusions', 'entrada'); ?> </h4>
				<table cellpadding="0" class="widefat fixed comments" cellspacing="6" border="0" width="100%">
				  <tbody>					
					<tr>
					  <td><input type="text" style="width:100%;" name="excluded_title" id="excluded_title" value="<?php echo $excluded_title; ?>" placeholder="Title" /></td>
					</tr>
					<tr>
					  <td><input type="text" style="width:100%;" name="excluded_sub_title" id="excluded_sub_title" value="<?php echo $excluded_sub_title; ?>" placeholder="Sub Title" /></td>
					</tr>
					<tr>
					  <td><?php  wp_editor( $product_individual_room_not_included_feature, 'product_individual_room_not_included_feature', $customized_settings ); ?></td>
					</tr>
				  </tbody>
				</table>
			</div>
			<div id="faq_reviews">
				<div class="pro-heading">
					<div class="btn-holder">
						<a href="javascript:void(null);" id="add_product_faq" class="button button-primary button-large"><?php _e('Add New', 'entrada'); ?></a>
					</div>
					<h4><?php _e('FAQs', 'entrada'); ?></h4>
				</div>
				<div id="faq_content">
				<?php 
					if(count( $product_faq_arr ) > 0) {
						$faq_cnt = 0;
						$faq_editor_setting = array(
												'quicktags' 	=> array('buttons' => 'em,strong,link',),
												'quicktags' 	=> true,
												'tinymce' 		=> true,
												'textarea_rows'	=> 10,
												'textarea_name'	=> 'faq_answer[]'
											);
						foreach($product_faq_arr as $faq){
							
							$faq_cnt++; ?>
							<table id="<?php echo 'faq_block_'.$faq_cnt;?>" cellpadding="0" class="entrada_faq_table widefat fixed comments" cellspacing="6" border="0" width="100%">	
								<tr><td width="20%"> <?php _e('Question', 'entrada'); ?> :</td><td> <input type="text" name="faq_question[]" value="<?php echo stripslashes( $faq['faq_question'] );?>" style="width:80%;" > <span style="float:right;"><a href="javascript:void(null);" onClick="remove_block('<?php echo 'faq_block_'.$faq_cnt;?>');"  class="button button-small"><?php _e('Remove', 'entrada'); ?></a> </span> </td></tr>
								<tr><td  width="20%"> <?php _e('Answer', 'entrada'); ?> :</td><td>
								<?php  wp_editor( stripslashes( $faq['faq_answer'] ), 'faq_answer'.$faq_cnt, $faq_editor_setting ); ?> </td></tr>
							</table>
				<?php
						}						
					} ?>
				</div>
			 
			</div>
			<div id="gallery">				
				<ul class="post-gallery-list entrada_thumb" id="entrada_image_galleries">
				<?php 
					if(count($product_gallery_img_arr) > 0 ) {
						$cnt = 0;
						foreach($product_gallery_img_arr as $attach_id){
							$cnt++;
							$entrada_img_gal = wp_get_attachment_url( $attach_id );
							$image = matthewruddy_image_resize( $entrada_img_gal, 150, 150, true, false);
							if (array_key_exists('url', $image) && $image['url'] != '') {
								echo '<li><div class="holder"><input type="hidden" name="entrada_img_gal[]" value="'.$attach_id.'"> <img src="'.$image['url'].'" height="150" width="150"> <a class="delete" href="javascript:void(null);"><img src="'.get_template_directory_uri().'/admin/img/delete.png"></a></div></li>';
							}
						}					
					} ?>
				</ul>
				<div id="add_field_row">
				  <input class="button" type="button" id="add_post_gallery_images" value="<?php _e('Add Post Gallery Images', 'entrada'); ?>"  />
				</div>
			</div>
            <div id="addons">
				<div class="pro-heading">
					<div class="btn-holder">
						<a href="javascript:void(null);" id="add_product_addons" class="button button-primary button-large"><?php _e('Add New', 'entrada'); ?></a>
					</div>
					<h4><?php _e('Add-ons', 'entrada'); ?></h4>
				</div>
				<div id="addons_content">
                
                <table cellpadding="0" id="product_addons_table" class="widefat fixed comments entrada_table" cellspacing="6" border="0" width="100%">
					<thead>
						<tr>
							<th width="60%"><?php _e('Option Label', 'entrada'); ?> </th>
							<th width="30%"><?php _e('Option Price', 'entrada'); ?> </th>
							<th width="10%"><?php _e('Action', 'entrada'); ?></th>
						</tr>
					</thead>
					<tbody>
                    <?php if(count($product_addons_arr) > 0) {
						
					
						foreach($product_addons_arr as $product_addons) {
						?>
                    	<tr>
                        <td> <input type="text" name="addons_label[]" value="<?php echo $product_addons['addons_label']?>" > </td>
                        <td> <input type="text" name="addons_price[]" value="<?php echo $product_addons['addons_price']?>" > </td>
                        <td> <a href="javascript:void(null);" class="button"><?php _e('X', 'entrada'); ?></a> </td>
                        </tr>
                       <?php
							}
					    } ?> 
                    </tbody>
                    </table> 
				
				</div>
			 
			</div>
		</div>
	</div>
	<script>
	/* Product FAQ
	 ....................................................  */
	jQuery('#add_product_faq').click(function() {
		var rand = get_entrada_random_integer();
		var editor_block = 'faq_answer'+rand;
		var faq_content = '<table id="'+rand+'" cellpadding="0" class="entrada_faq_table widefat fixed comments" cellspacing="6" border="0" width="100%">';
		faq_content  = faq_content + '<tr><td width="20%"> Question :</td><td> <input type="text" name="faq_question[]" value="" style="width:80%;" > <span style="float:right;"><a href="javascript:void(null);" onClick="remove_block('+rand+');"   class="button button-small">Remove</a> </span> </td></tr>';
		faq_content  = faq_content + '<tr><td  width="20%"> Answer :</td><td> <textarea name="faq_answer[]" id="'+editor_block+'" > </textarea> </td></tr>';
		faq_content = faq_content + '</table>';
		jQuery('#faq_content').append(faq_content);
		tinymce.execCommand('mceAddEditor', true, editor_block);
		return false;
	});	 
	function remove_block(id){
		jQuery('#'+id).remove();
	}
	function remove_gallery(rand){	
		jQuery('#'+rand).parent().remove();
		return false;
	}
	function remove_itinery(icounter) {
		jQuery('#row_'+icounter).remove();
		manageDayCount(1);
	}
	function manageDayCount(icounter){
		jQuery('#itinerary_table .itinerary_counter').each(function(){
			jQuery(this).attr('title', icounter);
			icounter =  parseInt(icounter) + 1;
		});
		
	}		
	function get_entrada_random_integer(){
		var rand_string = Math.random();
		rand_string = rand_string.toString();
		var rand = rand_string.replace("0.", "");
		rand = parseInt(rand);	
		return rand;
	}
	</script>
<?php
	global $post;
	$post->ID=$post_id;	
}
function entrada_save_product_custom_detailtab_meta_box( $post_id ){
	global $wpdb;
	$exists=0;
	if ( $the_post = wp_is_post_revision( $post_id ) ){
		$post_id = $the_post;		
	}
	/* checking verification */
	if (!isset($_POST["prodtab-box-nonce"]) || !wp_verify_nonce($_POST["prodtab-box-nonce"], basename(__FILE__))) {
		return $post_id;
	}
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
		return $post_id;
	}
	if ( $_POST['post_type'] != 'product' ){
		return $post_id;
	}
	if ( !current_user_can( 'edit_post', $post_id ) ){
		return $post_id;
	}
	$product_itinerary = array();	
	if(isset($_POST["itinerary_title"]) && $_POST["itinerary_title"] != ''){
		for($i= 0; $i< count($_POST["itinerary_title"]); $i++){
			$product_itinerary[$i]['itinerary_txt'] = $_POST["itinerary_txt"][$i];
			$product_itinerary[$i]['itinerary_title'] = $_POST["itinerary_title"][$i];
			$product_itinerary[$i]['itinerary_desc'] = $_POST["itinerary_desc"][$i];
		}
	}	
	$p_itinerary = maybe_serialize( $product_itinerary );
	if(count( $product_itinerary ) > 0){
		update_post_meta($post_id, "product_itinerary", wp_slash( $p_itinerary ));
	}
	else{
		delete_post_meta($post_id, "product_itinerary", '');	
	}
	if( isset( $_POST['product_overview_detail'] ) && $_POST['product_overview_detail'] != '' ){
		update_post_meta($post_id, 'product_overview_detail', $_POST['product_overview_detail']);
	}
	else{
		delete_post_meta($post_id, 'product_overview_detail', '');	
	}
	if( isset( $_POST['product_overview_included_feature'] ) && $_POST['product_overview_included_feature'] != '' ){
		update_post_meta($post_id, 'product_overview_included_feature', $_POST['product_overview_included_feature']);
	}
	else{
		delete_post_meta($post_id, 'product_overview_included_feature', '');	
	}
	if( isset( $_POST['product_overview_not_included_feature'] ) && $_POST['product_overview_not_included_feature'] != '' ){
		update_post_meta($post_id, 'product_overview_not_included_feature', $_POST['product_overview_not_included_feature']);
	}
	else{
		delete_post_meta($post_id, 'product_overview_not_included_feature', '');	
	}	
	if(isset($_POST['itinerary_gallery_img']) && count( $_POST['itinerary_gallery_img'] ) > 0){				
		update_post_meta($post_id, "itinerary_gallery_img", $_POST['itinerary_gallery_img'] );
	}
	else{
		delete_post_meta($post_id, "itinerary_gallery_img", '');	
	}
	if( isset($_POST['entrada_img_gal']) && count( $_POST['entrada_img_gal'] ) > 0){
		update_post_meta($post_id, "product_gallery_img", $_POST['entrada_img_gal']);
	}
	else{
		delete_post_meta($post_id, "product_gallery_img", '');	
	}
	if( isset( $_POST['product_accommodation'] ) && $_POST['product_accommodation'] != '' ){
		update_post_meta($post_id, 'product_accommodation', $_POST['product_accommodation']);
	}
	else{
		delete_post_meta($post_id, 'product_accommodation', '');	
	}
	if( isset( $_POST['product_shared_room_included_feature'] ) && $_POST['product_shared_room_included_feature'] != '' ){
		update_post_meta($post_id, 'product_shared_room_included_feature', $_POST['product_shared_room_included_feature']);
	}
	else{
		delete_post_meta($post_id, 'product_shared_room_included_feature', '');	
	}
	if( isset( $_POST['product_individual_room_not_included_feature'] )
		 && $_POST['product_individual_room_not_included_feature'] != '' ){
		update_post_meta($post_id, 'product_individual_room_not_included_feature',
		 $_POST['product_individual_room_not_included_feature']);
	}
	else{
		delete_post_meta($post_id, 'product_individual_room_not_included_feature', '');	
	}
	if( isset( $_POST['hotel_name'] ) && $_POST['hotel_name'] != '' ){
		update_post_meta($post_id, 'hotel_name', $_POST['hotel_name']);
	}
	else{
		delete_post_meta($post_id, 'hotel_name', '');
	}
	if( isset( $_POST['included_title'] ) && $_POST['included_title'] != '' ){
		update_post_meta($post_id, 'included_title', $_POST['included_title']);
	}
	else{
		delete_post_meta($post_id, 'included_title', '');
	}
	if( isset( $_POST['included_sub_title'] ) && $_POST['included_sub_title'] != '' ){
		update_post_meta($post_id, 'included_sub_title', $_POST['included_sub_title']);
	}
	else{
		delete_post_meta($post_id, 'included_sub_title', '');
	}
	if( isset( $_POST['excluded_title'] ) && $_POST['excluded_title'] != '' ){
		update_post_meta($post_id, 'excluded_title', $_POST['excluded_title']);
	}
	else{
		delete_post_meta($post_id, 'excluded_title', '');
	}
	if( isset( $_POST['excluded_sub_title'] ) && $_POST['excluded_sub_title'] != '' ){
		update_post_meta($post_id, 'excluded_sub_title', $_POST['excluded_sub_title']);
	}
	else{
		delete_post_meta($post_id, 'excluded_sub_title', '');
	}
	
	/* FAQ ..................*/
	$product_faq = array();
	
	if(isset($_POST["faq_question"]) && $_POST["faq_question"] != ''){
		for($i= 0; $i< count($_POST["faq_question"]); $i++){
			$product_faq[$i]['faq_question'] = $_POST["faq_question"][$i];
			$product_faq[$i]['faq_answer'] = $_POST["faq_answer"][$i];
		}
	}
	$p_faq = maybe_serialize( $product_faq );
	if(count( $product_faq ) > 0){
		update_post_meta( $post_id, "product_faq", wp_slash( $p_faq ) );
	}
	else{
		delete_post_meta( $post_id, "product_faq", '' );	
	}
	
	/* Product AddOns  ..................*/ 
	$product_addons = array();
	
	if(isset($_POST["addons_label"]) && $_POST["addons_label"] != ''){
		for($i= 0; $i< count($_POST["addons_label"]); $i++){
			$product_addons[$i]['addons_label'] = $_POST["addons_label"][$i];
			$product_addons[$i]['addons_price'] = $_POST["addons_price"][$i];
		}
	}
	$p_addons = maybe_serialize( $product_addons );
	if(count( $product_addons ) > 0){
		update_post_meta( $post_id, "product_addons", wp_slash( $p_addons ) );
	}
	else{
		delete_post_meta( $post_id, "product_addons", '' );	
	}
	
	if( isset( $_POST['entrada_product_type'] ) && $_POST['entrada_product_type'] != '' ){
		update_post_meta($post_id, 'entrada_product_type', $_POST['entrada_product_type']);
	}
	else{
		delete_post_meta($post_id, 'entrada_product_type', '');	
	}
	
	
}
add_action("add_meta_boxes", "entrada_add_product_custom_detailtab_meta_box");
add_action("save_post", "entrada_save_product_custom_detailtab_meta_box", 10, 3);