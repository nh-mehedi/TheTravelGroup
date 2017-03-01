<?php
/**
 * Thankyou page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( $order ) : ?>
	<?php if ( $order->has_status( 'failed' ) ) : ?>
		<p><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction.', 'entrada' ); ?></p>
		<p><?php
			if ( is_user_logged_in() ){
				_e( 'Please attempt your purchase again or go to your account page.', 'entrada' );
			}
			else{
				_e( 'Please attempt your purchase again.', 'entrada' );
			} ?>
		</p>
		<p>
			<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'entrada' ) ?></a>
			<?php if ( is_user_logged_in() ) : ?>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My Account', 'entrada' ); ?></a>
			<?php endif; ?>
		</p>
	<?php else : ?>
		<p  class="alert alert-success"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', _e( 'Thank you. Your order has been received.', 'entrada' ), $order ); ?></p>
		<ul class="order_details">
			<li class="order">
				<?php esc_html__( 'Order Number:', 'entrada' ); ?>
				<strong><?php echo $order->get_order_number(); ?></strong>
			</li>
			<li class="date">
				<?php esc_html__( 'Date:', 'entrada' ); ?>
				<strong><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></strong>
			</li>
			<li class="total">
				<?php esc_html__( 'Total:', 'entrada' ); ?>
				<strong><?php echo $order->get_formatted_order_total(); ?></strong>
			</li>
			<?php if ( $order->payment_method_title ) : ?>
			<li class="method">
				<?php esc_html__( 'Payment Method:', 'entrada' ); ?>
				<strong><?php echo $order->payment_method_title; ?></strong>
			</li>
			<?php endif; ?>
		</ul>
		<div class="clear"></div>
	<?php endif; ?>
	<?php do_action( 'woocommerce_thankyou_' . $order->payment_method, $order->id ); ?>
	<?php do_action( 'woocommerce_thankyou', $order->id ); ?>
<?php else : ?>
	<p class="alert alert-success"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', _e( 'Thank you. Your order has been received.', 'entrada' ), null ); ?></p>
<?php endif; ?>
