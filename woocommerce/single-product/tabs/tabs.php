<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

$tabs_layout = $position_accordion = '';
// Get page options
$options = get_post_meta( get_the_ID(), '_custom_single_product_options', true );

$tabs_layout = yanka_get_option('product-tab-layout', 'tabs');
$position_accordion = yanka_get_option('position-accordion', 'right');


if ( isset( $_GET['woo-tab'] ) && $_GET['woo-tab'] != '' ) {
	$tabs_layout = $_GET['woo-tab'];
}

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

if ( ! empty( $tabs ) ) : ?>

	<div class="woocommerce-tabs wc-tabs-wrapper clearfix tabs-layout-<?php echo esc_attr( $tabs_layout ); ?>">
		<?php if( $tabs_layout == 'tabs' ) : ?>
			<div class="wc-header-tabs">
				<div class="container">
					<ul class="tabs wc-tabs" role="tablist">
						<?php foreach ( $tabs as $key => $tab ) : ?>
							<li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
								<a href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<div class="wc-body-tabs">
				<div class="container">
					<div class="tab-content">
						<?php foreach ( $tabs as $key => $tab ) : ?>
							<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
								<?php call_user_func( $tab['callback'], $key, $tab ); ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>


		<?php if( $tabs_layout == 'accordion' ) : ?>
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<div class="yanka-tab-wrapper <?php echo $key === 'reviews' ? 'tab-reviews' : ''; ?>">
					<?php if( isset($position_accordion) && $position_accordion == 'bottom' ) : ?>
						<div class="container">
					<?php endif; ?>
						<a href="#tab-<?php echo esc_attr( $key ); ?>" <?php echo $key === 'description' ? 'aria-expanded="true"' : ''; ?> data-toggle="collapse" class="yanka-accordion-title"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
						<div class="collapse <?php echo $key === 'description' ? 'in' : ''; ?>" id="tab-<?php echo esc_attr( $key ); ?>">
							<?php call_user_func( $tab['callback'], $key, $tab ); ?>
						</div>
					<?php if( isset($position_accordion) && $position_accordion == 'bottom' ) : ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>

	</div>

<?php endif; ?>
