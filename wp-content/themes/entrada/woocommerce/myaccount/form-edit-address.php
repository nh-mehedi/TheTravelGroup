<?php
/**
 * Edit address form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-address.php.
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
 * @version 2.6.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$page_title = ( $load_address === 'billing' ) ? __( 'Billing Address', 'entrada' ) : __( 'Shipping Address', 'entrada' );
do_action( 'woocommerce_before_edit_account_address_form' );
?>

<div class="booking-form account-form">
    <div class="top-box">
        <strong class="holder height">
            <span class="left"><?php echo $page_title; ?> </span>
            <span class="arrow"></span>
        </strong>
    </div>
	<?php
		wc_print_notices();
		if ( ! $load_address ) :
			wc_get_template( 'myaccount/my-address.php' );
		else : ?>
			<form method="post" class="form-holder">
				<?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>
                
				<?php foreach ( $address as $key => $field ) : ?>
					<?php woocommerce_form_field( $key, $field, ! empty( $_POST[ $key ] ) ? wc_clean( $_POST[ $key ] ) : $field['value'] ); ?>
				<?php endforeach; ?>
				<?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>
                
				<p>
					<div class="btn-holder">
		            	<input type="submit" class="btn btn-default" name="save_address" value="<?php esc_attr_e( 'Save Address', 'entrada' ); ?>" />
						<?php wp_nonce_field( 'woocommerce-edit_address' ); ?>
						<input type="hidden" name="action" value="edit_address" />
		            </div>
				</p>
			</form>
	<?php endif; ?>
</div>

<?php do_action( 'woocommerce_after_edit_account_address_form' ); ?>