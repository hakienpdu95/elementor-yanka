<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */
do_action( 'woocommerce_cart_is_empty' );

if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
	<div class="wc_cart_empty">
		<div class="pt-empty-layout">
		    <span class="pt-icon">
		        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24;" xml:space="preserve">
					<g>
						<path fill="currentColor" d="M22.1,5H6.9C6.6,5,6.4,5.1,6.2,5.1L5.1,0.2H0v1.6h3.9L5,7.3c0,0,0,0.1,0,0.1l2,9C7.2,17.4,8,18,8.9,18h11.3
							c0.9,0,1.6-0.6,1.8-1.6l2-9C24.2,6.2,23.3,5,22.1,5z M20.4,16.1c0,0.2-0.2,0.3-0.3,0.3H8.9c-0.1,0-0.2-0.1-0.3-0.3L6.8,7.8l0,0
							L6.6,7.1c0-0.2,0-0.3,0.1-0.3c0.1-0.1,0.1-0.1,0.2-0.1h15.2c0.1,0,0.1,0,0.2,0.1c0,0.1,0.1,0.2,0.1,0.4L20.4,16.1z"></path>
						<path fill="currentColor" d="M9.5,19C8.1,19,7,20.1,7,21.5S8.1,24,9.5,24s2.5-1.1,2.5-2.5S10.9,19,9.5,19z M9.5,22.4
							c-0.5,0-0.9-0.4-0.9-0.9s0.4-0.9,0.9-0.9s0.9,0.4,0.9,0.9S10,22.4,9.5,22.4z"></path>
						<path fill="currentColor" d="M19.5,19c-1.4,0-2.5,1.1-2.5,2.5s1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5S20.9,19,19.5,19z M19.5,22.4
							c-0.5,0-0.9-0.4-0.9-0.9s0.4-0.9,0.9-0.9s0.9,0.4,0.9,0.9S20,22.4,19.5,22.4z"></path>
					</g>
				</svg>
			</span>
		    <h1 class="pt-title"><?php esc_html_e( 'Shopping cart is empty', 'yanka' ); ?></h1>
		    <p class="desc-cart"><?php esc_html_e( 'You have no items in your shopping cart.', 'yanka' ); ?></p>
		    <div class="row-btn">
		        <a href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>" class="btn btn-border"><?php esc_html_e( 'Continue Shopping', 'yanka' ); ?></a>
		    </div>
		</div>
	</div>
<?php endif; ?>
