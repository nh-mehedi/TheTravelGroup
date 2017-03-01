<?php
/**
 * Checkout coupon form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! WC()->cart->coupons_enabled() ) {
	return;
} ?>
<div class="top-box">
        <a href="#" class="showcoupon holder height">
            <span class="left"><?php _e('Have a Promotional Coupon?', 'entrada'); ?></span>
            <span class="right"><?php _e('Enter Coupon Code', 'entrada'); ?></span>
            <span class="arrow"></span>
        </a>
    </div>
<form class="checkout_coupon booking-form" method="post" style="display:none">
    <div class="form-holder checkout-form-slide">
        <p><?php _e('Enter your Coupon Code', 'entrada'); ?></p>
    	<div class="row"> 
            <div class="col-md-6">
        		<div class="hold">
                <input type="text" name="coupon_code" class="form-control" placeholder="<?php esc_attr_e( 'Coupon code', 'entrada' ); ?>" id="coupon_code" value="" />
                </div>
            </div>
            <div class="col-md-6">
        		<div class="hold">
                <input type="submit" class="btn btn-default" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'entrada' ); ?>" />
                </div>
            </div>    
        </div>
    	<div class="clear"></div> 
    </div>
</form>