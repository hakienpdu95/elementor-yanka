<?php
global $product, $woocommerce_loop;


$product_hover_preset = yanka_get_option('wc-product-hover-presets', '2e2e2e');
$show_wishlist = yanka_get_option('wc-wishlist', 1);
if ( isset($_GET['hover_preset']) && $_GET['hover_preset'] != '' ) {
	$product_hover_preset = $_GET['hover_preset'];
}

?>

<div class="product-box<?php echo ' product-preset-' . esc_attr( $product_hover_preset ); ?>">
	<div class="product-thumb pr oh">
		<?php
		/**
		 * woocommerce_before_shop_loop_item_title hook.
		 *
		 * @hooked woocommerce_template_loop_product_link_open - 5
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 15
		 * @hooked yanka_second_product_thumbnail - 15
		 * @hooked woocommerce_template_loop_product_link_close - 20
		 */
		do_action( 'woocommerce_before_shop_loop_item_title' );

		?>

		<ul class="product-btn in-thumb flex">

			<?php
				$catalog_mode = yanka_get_option( 'catalog-mode', 0 );

				if ( isset($_GET['catalog-mode']) && $_GET['catalog-mode'] == 1 ) {
			        $catalog_mode = 1;
			    }

			if ( !$catalog_mode ) : ?>
				<li class="addtocart-thumb"><?php woocommerce_template_loop_add_to_cart(); ?></li>
			<?php endif;
				yanka_product_compare();
				yanka_product_quickview();
			?>
		</ul>
		<?php yanka_product_varition(); ?>
		<?php if ( $show_wishlist && class_exists( 'YITH_WCWL' ) ) { ?>
			<div class="btn-wishlist">
				<?php yanka_product_wishlist(); ?>
			</div>
		<?php } ?>

	    <?php
		if ( isset($woocommerce_loop['countdown']) && $woocommerce_loop['countdown'] == 'yes' ) {
		    yanka_product_countdown_timer();
		}
		?>
	</div>

	<div class="product-info">

		<?php 
		do_action( 'woocommerce_shop_loop_item_title' ); 
		yanka_product_categories();
		?>

		<?php
		/**
		 * woocommerce_after_shop_loop_item_title hook.
		 *
		 * @hooked woocommerce_template_loop_price - 10
		 */
		yanka_product_rating();
		do_action( 'woocommerce_after_shop_loop_item_title' );
		?>
	</div>
	<?php if (is_shop() || is_archive()){  yanka_product_list_info(); } ?>
</div>
