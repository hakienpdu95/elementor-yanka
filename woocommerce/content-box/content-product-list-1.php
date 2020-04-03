<?php
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 4);
?>

<div class="product-box">
	<div class="product-thumb product-thumb-list pr oh">
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
		image_list_product();
		?>
	</div>

	<div class="product-list-info-box">
		<div class="product-list-info-top">
			<?php do_action( 'woocommerce_shop_loop_item_title' ); ?>
			<?php yanka_product_categories(); ?>
			<?php yanka_product_rating(); ?>


			<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook.
			 *
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
			?>

		</div>

		<?php
		$catalog_mode = yanka_get_option( 'catalog-mode', 0 );

		if ( isset($_GET['catalog-mode']) && $_GET['catalog-mode'] == 1 ) {
	        $catalog_mode = 1;
	    }

		if ( !$catalog_mode ) : ?>
			<div class="addtocart"><?php woocommerce_template_loop_add_to_cart(); ?></div>
		<?php endif; ?>

	</div>

</div>
