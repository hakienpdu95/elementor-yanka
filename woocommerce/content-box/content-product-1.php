<?php

global $product, $woocommerce_loop;

$product_view        = yanka_get_option('wc-product-view', 'grid');
$product_hover_preset = yanka_get_option('wc-product-hover-presets', '2e2e2e');
$show_wishlist = yanka_get_option('wc-wishlist', 1);
if ( isset($_GET['hover_preset']) && $_GET['hover_preset'] != '' ) {
	$product_hover_preset = $_GET['hover_preset'];
}
if ( isset( $_GET['product_view'] ) && $_GET['product_view'] != '' ) {
	$product_view = $_GET['product_view'];
}
?>

<div class="product-box<?php echo ' product-preset-' . esc_attr( $product_hover_preset ); ?>" <?php if('list' != $product_view) {echo 'data-eqh-product-box'; } ?> >
	<?php 
		echo '<ul class="list-view-compare">';
		yanka_product_compare();
		echo '</ul>';
	?>
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

		<div class="pt-app-btn product-btn in-thumb flex">
			<?php 
				if ( $show_wishlist && class_exists( 'YITH_WCWL' ) ) { 
			?>
				<div class="btn-wishlist">
					<?php yanka_product_wishlist();  ?>
				</div>
			<?php }
				yanka_block_product_compare();
				yanka_block_product_quickview();
			?>
		</div>

	    <?php
		if ( isset($woocommerce_loop['countdown']) && $woocommerce_loop['countdown'] == 'yes' ) {
		    yanka_product_countdown_timer();
		}
		?>
	</div>

	<div class="product-info">

		<?php 
		yanka_product_rating();
		yanka_product_categories();
		do_action( 'woocommerce_shop_loop_item_title' ); 
		?>

		<?php
		/**
		 * woocommerce_after_shop_loop_item_title hook.
		 *
		 * @hooked woocommerce_template_loop_price - 10
		 */
		?>
		<?php 
		if ( isset($woocommerce_loop['varition_woocommerce']) && $woocommerce_loop['varition_woocommerce'] == 'yes' ) {
		    yanka_product_varition();
		}
		?>
		<?php 
		do_action( 'woocommerce_after_shop_loop_item_title' );
		?>
		
	</div>
	<?php if (is_shop() || is_archive()){  yanka_product_list_info(); } ?>
</div>
