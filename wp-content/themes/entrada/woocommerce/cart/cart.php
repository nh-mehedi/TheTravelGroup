<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<table class="shop_table shop_table_responsive cart">
	<thead>
		<tr>
			<th class="product-remove">&nbsp;</th>
			<th class="product-thumbnail">&nbsp;</th>
			<th class="product-name">
				<?php _e( 'Selected Tours', 'entrada' ); ?>
                <span class="sub-text"><?php _e( 'Confirmed Dates', 'entrada' ); ?></span>
            </th>
			<th class="product-price">
				<?php _e( 'Price', 'entrada' ); ?>
                <span class="sub-text"><?php _e( 'Updated Date', 'entrada' ); ?></span>
            </th>
			<th class="product-quantity">
				<?php _e( 'No. of People', 'entrada' ); ?>
                <span class="sub-text"><?php _e( 'Excluding Children', 'entrada' ); ?></span>
            </th>
			<th class="product-subtotal">
				<?php _e( 'Total Price', 'entrada' ); ?>
                 <span class="sub-text"><?php _e( 'Excluding Flights', 'entrada' ); ?></span>
            </th>
		</tr>
	</thead>
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
		
		
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			$variation_id = $cart_item['variation_id'];	
			$product_addons_arr = array();
			
			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

					<td class="product-remove">
						<?php
							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
								'<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
								esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
								__( 'Remove this item', 'entrada' ),
								esc_attr( $product_id ),
								esc_attr( $_product->get_sku() )
							), $cart_item_key );
						?>
					</td>

					<td class="product-thumbnail">
						<?php
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

							if ( ! $product_permalink ) {
								echo $thumbnail;
							} else {
								printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
							}
						?>
					</td>

					<td class="product-name" data-title="<?php _e( 'Product', 'entrada' ); ?>">
						<?php
							if ( ! $product_permalink ) {
								echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
							} else {
								echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_title() ), $cart_item, $cart_item_key );
							}

							// Meta data
							echo WC()->cart->get_item_data( $cart_item );

							// Backorder notification
							if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
								echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'entrada' ) . '</p>';
							}							
							
							if( $variation_id != 0 ) {
								$var_confirmed_date = get_post_meta( $variation_id, 'var_confirmed_date', true );	
								if( !empty( $var_confirmed_date ) ) {
									echo '<time class="time" datetime="2015-11-05">'.date( "jS M Y", strtotime( $var_confirmed_date ) ).'</time>';
								}
							} else {
								$entrada_product_type = get_post_meta( $product_id,'entrada_product_type', true );
								if( $entrada_product_type != 'shop_item' ) {
									$customer_start_date = array();
									$customer_start_date[0] = '';
									if ( array_key_exists( 'customer_start_date', $cart_item ) && $cart_item['customer_start_date'] != '') {
									 	
									 	if( isset( $cart_item['customer_start_date'][0] ) ) {
									 		$customer_start_date[0] = $cart_item['customer_start_date'][0];	
									 	}
									 	
									} 
									echo '<div class="time"><div id="tour_start_date" class="cart_start_date input-group date" data-date-format="yyyy-mm-dd"><input class="form-control"  name="customer_'. $cart_item_key.'_start_date[]"  type="text" value="'.$customer_start_date[0].'" placeholder="Select your date"  /><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div></div>';
								}
							}
						?>
					</td>

					<td class="product-price" data-title="<?php _e( 'Price', 'entrada' ); ?>">
						<input type="hidden" class="currency_symbol" name="currency_symbol" value="<?php echo get_woocommerce_currency_symbol(); ?>">
						<?php
							if($variation_id == 0){
								echo '<span class="price">'.apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ).' </span>';

							}
							else{
								$var_price_inc_flight = get_post_meta( $variation_id, 'var_price_inc_flight', true );
								$_price = get_post_meta( $variation_id, '_price', true );
								echo '<strong class="item_variation_price">'. apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ).' </strong>';
								if(!empty($var_price_inc_flight)) {
									$tour_with_flight = get_post_meta( $variation_id, 'tour_with_flight', true );
									$checked =  ($tour_with_flight) ?  'checked="checked"' : ''; ?>
									<div class="time">
										<input type="hidden" class="_price" name="_price[]" value="<?php echo $_price; ?>">
										<input type="hidden" class="var_price_inc_flight" name="var_price_inc_flight[]" value="<?php echo $var_price_inc_flight; ?>">
										<input type="checkbox" class="include_flight" name="include_flight" value="<?php echo $variation_id;  ?>" <?php echo $checked; ?>>
										<?php _e('Include flight.', 'entrada'); ?>
                                        
                                        
									</div>
							<?php 
								}
							}
							
							/* Entrada Product Addons */
							$product_addons_arr = array();
							$product_addons = get_post_meta($product_id,'product_addons', true);
							if(isset($product_addons) && !empty($product_addons)){		
								$product_addons_arr = maybe_unserialize($product_addons);
							}
							
							 ?>
					</td>

					<td class="product-quantity" data-title="<?php _e( 'Quantity', 'entrada' ); ?>">
					<?php
						if ( $_product->is_sold_individually() ) {
							$product_quantity = sprintf( '1 <input type="text"  class="qty_val input-count-field" name="cart[%s][qty]" value="1" />', $cart_item_key );
						}
						else {
							$product_quantity = '<input type="text" class="qty_val input-count-field" name="cart['.$cart_item_key.'][qty]" value="'.$cart_item['quantity'].'" />';	
						} ?>
						<div class="num-hold">
							<a href="javascript:void(null);" class="minus control"><span class="icon-minus-normal"></span></a>
							<a href="javascript:void(null);" class="plus control"><span class="icon-plus-normal"></span></a>
							<div class="input-count-hold">
                            	<?php echo $product_quantity; ?>
                            </div>
						</div>
					</td>

					<td class="product-subtotal" data-title="<?php _e( 'Total', 'entrada' ); ?>">
					<?php
						echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );

						if( count($product_addons_arr) > 0 ){
						?>
							<div><a id="btn_<?php echo $cart_item_key; ?>" onClick="cart_addons_options('<?php echo $cart_item_key; ?>');" class="btn btn-default more-option-opener"><?php _e( 'More Option', 'entrada' ); ?></a></div>
						<?php } ?>
					</td>
				</tr>
				<?php
			}
			
			/* Entrada Product Addons start here to display */
			if( count($product_addons_arr) > 0 ){
				
				foreach($product_addons_arr as $p_addons){

					$addons_qty = entrada_addons_selected_quantity($cart_item['addons_data'], $p_addons['addons_label']);
					
					$args = array();
					?>
                    <tr class="cart_item addons-row <?php echo $cart_item_key; ?>">
                     
	                    <td colspan="3" data-title="<?php _e( 'Product Addons', 'entrada' ); ?>">
							<?php echo $p_addons['addons_label']; ?> : 
	                        <input type="hidden" name="addons_<?php echo $cart_item_key; ?>_label[]" value="<?php echo $p_addons['addons_label']; ?>" >
	                    </td>
	                    <td data-title="<?php _e( 'Price', 'entrada' ); ?>">
	                        <strong><?php echo entrada_price( $p_addons['addons_price'], $args, 'footer_price' ); ?></strong> 
	                    </td>
	                    <td data-title="<?php _e( 'Quantity', 'entrada' ); ?>">
	                    	<input type="number" name="addons_<?php echo $cart_item_key; ?>_qty[]" value="<?php echo $addons_qty; ?>"  min="0" max="50">
	                    </td>
	                    <td data-title="<?php _e( 'Price', 'entrada' ); ?>">
	                        <strong><?php echo entrada_price( $p_addons['addons_price'] * $addons_qty, $args, 'footer_price' ); ?></strong>
	                    </td>
                   	
					</tr>
				<?php
					}
				
			}				
		}

		do_action( 'woocommerce_cart_contents' );
		?>
		<tr>
			<td colspan="6" class="actions">

				<?php if ( wc_coupons_enabled() ) { ?>
					<div class="coupon">

						<label for="coupon_code"><?php _e( 'Coupon', 'entrada' ); ?>:</label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'entrada' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'entrada' ); ?>" />

						<?php do_action( 'woocommerce_cart_coupon' ); ?>
					</div>
				<?php } ?>

				<input type="submit" class="button update_cart" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'entrada' ); ?>" />

				<?php do_action( 'woocommerce_cart_actions' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart' ); ?>
			</td>
		</tr>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</tbody>
</table>

<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>

<div class="cart-collaterals">

	<?php do_action( 'woocommerce_cart_collaterals' ); ?>

</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
