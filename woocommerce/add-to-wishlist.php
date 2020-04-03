<?php
/**
 * Add to wishlist template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly

global $product;
?>

<div class="yith-wcwl-add-to-wishlist add-to-wishlist-<?php echo esc_attr($product_id); ?>">
	<?php if( ! ( $disable_wishlist && ! is_user_logged_in() ) ): ?>
	    <div class="yith-wcwl-add-button <?php if( $exists && ! $available_multi_wishlist ){ echo esc_attr('hide', 'yanka'); }else{ echo esc_attr('show', 'yanka'); } ?>" >

	        <?php yith_wcwl_get_template( 'add-to-wishlist-' . $template_part . '.php', $var ); ?>
	        
	    </div>

	    <div class="yith-wcwl-wishlistaddedbrowse hide">
	        
	        <a href="<?php echo esc_url( $wishlist_url )?>" rel="nofollow">
				<svg width="24" height="24" viewBox="0 0 25.4 22"  xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M6.9 2.6c1.4 0 2.7.6 3.8 1.6l.2.2L12 5.6l1.1-1.1.2-.2c1-1 2.3-1.6 3.8-1.6s2.8.6 3.8 1.6c2.1 2.1 2.1 5.6 0 7.7L12 20.7l-8.9-8.9C1 9.7 1 6.2 3.1 4.1c1.1-.9 2.4-1.5 3.8-1.5zm0-1.6C5.1 1 3.3 1.7 2 3.1-.7 5.8-.7 10.3 2 13l10 10 10-9.9c2.7-2.8 2.7-7.3 0-10-1.4-1.4-3.1-2-4.9-2-1.8 0-3.6.7-4.9 2l-.2.2-.2-.2C10.4 1.7 8.7 1 6.9 1z"></path></svg>
				<span class="feedback txt_wishlist"><?php echo esc_html($product_added_text); ?></span>
	        </a>
	    </div>

	    <div class="yith-wcwl-wishlistexistsbrowse <?php if( $exists && ! $available_multi_wishlist ){ echo esc_attr('show', 'yanka'); }else{ echo esc_attr('hide', 'yanka'); } ?>" >
	        
	        <a href="<?php echo esc_url( $wishlist_url ) ?>" rel="nofollow">
            	<svg width="24" height="24" viewBox="0 0 25.4 22"  xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M6.9 2.6c1.4 0 2.7.6 3.8 1.6l.2.2L12 5.6l1.1-1.1.2-.2c1-1 2.3-1.6 3.8-1.6s2.8.6 3.8 1.6c2.1 2.1 2.1 5.6 0 7.7L12 20.7l-8.9-8.9C1 9.7 1 6.2 3.1 4.1c1.1-.9 2.4-1.5 3.8-1.5zm0-1.6C5.1 1 3.3 1.7 2 3.1-.7 5.8-.7 10.3 2 13l10 10 10-9.9c2.7-2.8 2.7-7.3 0-10-1.4-1.4-3.1-2-4.9-2-1.8 0-3.6.7-4.9 2l-.2.2-.2-.2C10.4 1.7 8.7 1 6.9 1z"></path></svg>
            	<span class="feedback txt_wishlist"><?php echo esc_html($already_in_wishslist_text); ?></span>
	        </a>
	    </div>

	    <div class="cb-wishlist"></div>
	    <div class="yith-wcwl-wishlistaddresponse"></div>
	<?php else: ?>
		<a href="<?php echo esc_url( add_query_arg( array( 'wishlist_notice' => 'true', 'add_to_wishlist' => $product_id ), get_permalink( wc_get_page_id( 'myaccount' ) ) ) )?>" rel="nofollow" class="<?php echo str_replace( 'add_to_wishlist', '', $link_classes ) ?>" >
			<?php echo esc_attr($icon) ?>
			<?php echo esc_attr($label); ?>
		</a>
	<?php endif; ?>

</div>

<div class="clear"></div>
