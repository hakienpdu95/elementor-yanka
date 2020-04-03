<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;
?>

<div class="pt-row-hover">
	<?php
		$product_style       = yanka_get_option('wc-product-style', 2);
		if ( ( $product_style == '2' && $product_style === '2') || ( isset( $woocommerce_loop['style_product'] ) && ( $woocommerce_loop['style_product'] == '2' ) ) ) {
			if ( isset($woocommerce_loop['varition_woocommerce']) && $woocommerce_loop['varition_woocommerce'] == 'yes' ) {
			    yanka_product_varition();
			}
		}
		
		$catalog_mode = yanka_get_option( 'catalog-mode', 0 );

		if ( isset($_GET['catalog-mode']) && $_GET['catalog-mode'] == 1 ) {
	        $catalog_mode = 1;
	    }

	if ( !$catalog_mode ) : ?>
		<?php woocommerce_template_loop_add_to_cart(); ?>
	<?php endif;

	?>
    <span class="price">
		<?php if ( $price_html = $product->get_price_html() ) :
			echo ''. $price_html;
		endif; ?>
	</span>
</div>
