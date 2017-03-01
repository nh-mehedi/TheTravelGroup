<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
wc_print_notices();
do_action( 'woocommerce_before_checkout_form', $checkout );
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', esc_html__( 'You must be logged in to checkout.', 'entrada' ) );
	return;
}
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>
<div class="row same-height">
	<div class="col-md-6">                             
<?php
	if ( !is_user_logged_in()  ) {
		 wc_get_template( 'checkout/form-login.php', array( 'checkout' => WC()->checkout() ) );
	} ?>
	</div>
	<div class="col-md-6">
<?php
	if (  WC()->cart->coupons_enabled() ) {
		wc_get_template( 'checkout/form-coupon.php', array( 'checkout' => WC()->checkout() ) );   
	} ?>              
	</div>
</div>
<form name="checkout" method="post" class="booking-form checkout woocommerce-checkout" action="<?php echo esc_url( $get_checkout_url ); ?>" enctype="multipart/form-data">
	<div class="row">
		<div class="col-md-6">	    
		  	<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
		    <?php do_action( 'woocommerce_checkout_billing' ); ?>
			<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>	
		</div>
		<div class="col-md-6">
		    <div class="form-holder">
		    	<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			    <div class="order-block">
				    <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
				    <?php do_action( 'woocommerce_checkout_order_review' ); ?>
				    <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
			    </div>
		    </div>			
		</div>
	</div>
</form>
<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>