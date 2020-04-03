<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * woocommerce_before_single_product hook.
 *
 * @hooked wc_print_notices - 10
 */

do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
 	echo get_the_password_form();
 	return;
}


/* Prev/next product buttons */
$thumbnail = $single_background = $style = '';

$tabs_layout = $position_accordion = $has_accordion_full = '';

// Get page options
$options = get_post_meta( get_the_ID(), '_custom_single_product_options', true );

$product_navigation = yanka_get_option('wc-single-nagivation', 1);
$single_sidebar  = yanka_get_option( 'single-product-sidebar', 'no' );

if ( isset($_GET['sidebar']) && $_GET['sidebar'] != '' ) {
	$single_sidebar = $_GET['sidebar'];
}


if ( isset($product_navigation) && $product_navigation == 1 ) {
	$prevPost = get_previous_post();
	if($prevPost) {
		$thumbnail = get_the_post_thumbnail($prevPost->ID , 'shop_thumbnail');
	}

	echo '<span id="next-product" class="hidden-sm hidden-xs">';
		previous_post_link( '%link', '<span></span>'. $thumbnail );
	echo '</span>';

	$nextPost = get_next_post();
	if($nextPost) {
		$thumbnail = get_the_post_thumbnail($nextPost->ID , 'shop_thumbnail');
	}

	echo '<span id="prev-product" class="hidden-sm hidden-xs">';
	next_post_link( '%link', '<span></span>' . $thumbnail );
	echo '</span>';
}


$tabs_layout = yanka_get_option('product-tab-layout', 'tabs');
$position_accordion = yanka_get_option('position-accordion', 'right');


if ( isset( $_GET['woo-tab'] ) && $_GET['woo-tab'] != '' ) {
	$tabs_layout = $_GET['woo-tab'];
}


// Get product single style
$style             = ( is_array( $options ) && $options['wc-single-product-style'] ) ? $options['wc-single-product-style'] : '1';
$single_background = ( is_array( $options ) && $options['wc-enable-background'] ) ? 'product-detail-bg pt_100 pb_100' : '';

if( isset($options['wc-tabs-settings']) && !empty($options['wc-tabs-settings']) ) {
	if ( is_array( $options ) && $options['wc-tabs-settings'] ) {
		$tabs_layout = $options['wc-tabs-settings'];
	}
}

if( isset($options['wc-tabs-settings']) && !empty($options['wc-tabs-settings']) ) {
	if( isset($options['wc-position-accordion']) && !empty($options['wc-position-accordion']) ) {
		if ( is_array( $options ) && $options['wc-position-accordion'] ) {
			$position_accordion = $options['wc-position-accordion'];
		} else {
			$position_accordion = $position_accordion;
		}
	} else {
		$position_accordion = $position_accordion;
	}	
}

if( $tabs_layout == 'accordion' && isset($position_accordion) && $position_accordion == 'bottom' ) {
	$has_accordion_full = 'has-accordion-full';
}

?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class(); ?>>

	<div class="jms-product-single-extra">
		<div id="wc-single-product" class="wc-single-product-<?php echo esc_attr( $style ); ?> wc-single-product <?php echo esc_attr($single_background); ?> <?php echo esc_attr( $has_accordion_full ); ?>">
			<div class="container">
				<?php if( is_array( $options ) && $options['wc-enable-background'] == 1 ) : ?>
					<div class="container">
				<?php endif; ?>
					<div class="row jms-container">
						<?php wc_get_template( 'extras/single/layout-' . esc_attr( $style ) . '.php' ); ?>
					</div>
				<?php if( is_array( $options ) && $options['wc-enable-background'] == 1 ) : ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<?php if ( $single_sidebar != 'no' && is_active_sidebar( 'woocommerce-single-product-sidebar' ) ) : ?>
			<!-- tabs -->
			<?php if( ($tabs_layout == 'tabs') || ($tabs_layout == 'accordion' && isset($position_accordion) && $position_accordion == 'bottom') ) : ?>
				<div class="tabs-sidebar">
					<?php echo $tabs_layout == 'accordion' ? '<div class="product-detail-information tabs-accordion-fullwidth tabs-bottom">' : ''; ?>
						<?php echo $tabs_layout == 'accordion' ? '<div class="container-accordion-fullwidth">' : ''; ?>
							<?php
							remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
							woocommerce_output_product_data_tabs();
							?>
						<?php echo $tabs_layout == 'accordion' ? '</div>' : ''; ?>
					<?php echo $tabs_layout == 'accordion' ? '</div>' : ''; ?>
				</div>
			
			<?php endif;?>
		<?php endif; ?>
		
		<?php 

			if( isset($style) && ($style == 1 || $style == 2) ) : 
				wp_add_inline_script( 'yanka-theme', yanka_js_sticky_content_product_layout_1_2(), 'after' );
			elseif( isset($style) && $style == 3 ) :
				yanka_fixed_product_wrapper_layout();
				wp_add_inline_script( 'yanka-theme', yanka_js_sticky_content_product_layout_3(), 'after' );
			elseif( isset($style) && $style == 4 ) :
				yanka_fixed_product_wrapper_layout();
				wp_add_inline_script( 'yanka-theme', yanka_js_sticky_content_product_layout_4(), 'after' );
			else :

			endif;

		?>

	</div>

</div>
