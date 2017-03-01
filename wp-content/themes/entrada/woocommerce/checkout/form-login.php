<?php
/**
 * Checkout login form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) {
	return;
} ?>
<div class="top-box">
	<a href="#" class="showlogin holder height">
		<span class="left hidden-xs"><?php _e('Are you returning customer?', 'entrada'); ?> </span>
		<span class="right"><?php _e('Login Here', 'entrada'); ?></span>
		<span class="arrow"></span>
	</a>
</div>
<?php
	woocommerce_login_form(
		array(
			'message'  => _e( '<div class="checkout-note">If you have shopped with us before, please enter your details in the boxes below. If you are a new customer please proceed to the Billing &amp; Shipping section.</div>', 'entrada' ),
			'redirect' => wc_get_page_permalink( 'checkout' ),
			'hidden'   => true
		)
	); ?>