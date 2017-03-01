<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>
<h3><?php _e( 'Customer Details', 'entrada' ); ?></h3>
<div class="form-holder form-holder-details">
	<div class="table-responsive">
		<table class="table no-border customer-detail-table">
			<?php if ( $order->customer_note ) : ?>
				<tr>
					<th><?php _e( 'Note:', 'entrada' ); ?></th>
					<td><?php echo wptexturize( $order->customer_note ); ?></td>
				</tr>
			<?php endif; ?>
			<?php if ( $order->billing_email ) : ?>
				<tr>
					<th><?php _e( 'Email:', 'entrada' ); ?></th>
					<td><?php echo esc_html( $order->billing_email ); ?></td>
				</tr>
			<?php endif; ?>
			<?php if ( $order->billing_phone ) : ?>
				<tr>
					<th><?php _e( 'Telephone:', 'entrada' ); ?></th>
					<td><?php echo esc_html( $order->billing_phone ); ?></td>
				</tr>
			<?php endif; ?>
			<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>
		</table>
	</div>
</div>
<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() ) : ?>
<div class="col2-set addresses">
	<div class="col-1">
<?php endif; ?>
	<h3><?php _e( 'Billing Address', 'entrada' ); ?></h3>
	<address><?php echo ( $address = $order->get_formatted_billing_address() ) ? $address : __( 'N/A', 'entrada' ); ?></address>
<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() ) : ?>
	</div><!-- /.col-1 -->
	<div class="col-2">
		<header class="title"><h2 class="small-size"><?php _e( 'Shipping Address', 'entrada' ); ?></h2></header>
		<address><?php echo ( $address = $order->get_formatted_shipping_address() ) ? $address : __( 'N/A', 'entrada' ); ?></address>
	</div><!-- /.col-2 -->
</div><!-- /.col2-set -->
<?php endif; ?>