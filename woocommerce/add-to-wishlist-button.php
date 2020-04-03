<?php
/**
 * Add to wishlist button template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.8
 */

if ( ! defined( 'YITH_WCWL' ) ) {
    exit;
} // Exit if accessed directly

global $product;
?>

<a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product_id ) )?>" rel="nofollow" data-product-id="<?php echo esc_attr($product_id); ?>" data-product-type="<?php echo esc_attr($product_type); ?>" class="<?php echo esc_attr($link_classes); ?>" >
        <svg width="24" height="24" viewBox="0 0 25.4 22" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M6.9 2.6c1.4 0 2.7.6 3.8 1.6l.2.2L12 5.6l1.1-1.1.2-.2c1-1 2.3-1.6 3.8-1.6s2.8.6 3.8 1.6c2.1 2.1 2.1 5.6 0 7.7L12 20.7l-8.9-8.9C1 9.7 1 6.2 3.1 4.1c1.1-.9 2.4-1.5 3.8-1.5zm0-1.6C5.1 1 3.3 1.7 2 3.1-.7 5.8-.7 10.3 2 13l10 10 10-9.9c2.7-2.8 2.7-7.3 0-10-1.4-1.4-3.1-2-4.9-2-1.8 0-3.6.7-4.9 2l-.2.2-.2-.2C10.4 1.7 8.7 1 6.9 1z"></path></svg>
        <span class="txt_wishlist"><?php echo esc_html__('Add to wishlist', 'yanka'); ?></span>
</a>
<img src="<?php echo esc_url( YITH_WCWL_URL . 'assets/images/wpspin_light.gif' ) ?>" class="ajax-loading wpspin-light" alt="loading" width="16" height="16" />
