<?php 
global $post, $woocommerce, $product;

$tabs_layout = $position_accordion = $hide_sticky_addtocart = $share_toolbox = '';

// Get page options
$options = get_post_meta( get_the_ID(), '_custom_single_product_options', true );

$tabs_layout = yanka_get_option('product-tab-layout', 'tabs');
$position_accordion = yanka_get_option('position-accordion', 'right');

$sticky_addtocart = yanka_get_option('wc-product-sticky-addtocart', 0);
if ( isset($sticky_addtocart) && $sticky_addtocart == 0 ) {
	$hide_sticky_addtocart = 'hide-sticky-addtocart-bottom';
}

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

if( ( isset($position_accordion) && $position_accordion == 'bottom' ) || ( isset($tabs_layout) && $tabs_layout == 'tabs' ) ){
	$share_toolbox = 'custom-share-toolbox';
}


?>
<div id="jms-column-left" class="col-lg-6 col-md-6 col-sm-6 col-xs-12 column-left">
	<?php
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
		/**
		 * woocommerce_before_single_product_summary hook.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 column-right">
	<div class="summary entry-summary info-summary">
		<?php yanka_add_new_label_single_product(); ?>
		<?php
			
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 15);
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 6);
			add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 3);

			/**
			 * woocommerce_single_product_summary hook.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_meta - 15
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_price - 25
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
			do_action( 'woocommerce_single_product_summary' );
		?>

		<div class="pt-wrapper list-btn">
			<ul class="pt-list-btn">
				<?php if (class_exists( 'YITH_WCWL' ) ) { ?>
					<li>
						<?php yanka_product_wishlist(); ?>
					</li>
				<?php }	?>
				<?php yanka_product_compare(); ?>
			</ul>
		</div>

		<div class="pt-wrapper">
			<?php 
				if(!$product->is_type( 'grouped' )) {
					yanka_term_conditions_checkbox();
					yanka_btn_buy_it_now();					
				}
			?>			
		</div>

		<div class="pt-wrapper">
			<div class="pt-promo-brand">
				<img src="<?php echo YANKA_URL . '/assets/images/trust_badge_desk.png'; ?>">
			</div>	
		</div>

		<!-- tabs -->
		<?php if($tabs_layout == 'accordion' && isset($position_accordion) && $position_accordion == 'right') : ?>
			<div class="product-detail-information tabs-<?php echo esc_attr( $tabs_layout ); ?>">
				<div class="container">
					<?php
					remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
					woocommerce_output_product_data_tabs();
					?>
				</div>
			</div>
		
		<?php endif;?>

        <!-- Go to www.addthis.com/dashboard to customize your tools --> 
        <div class="addthis_inline_share_toolbox <?php echo esc_attr( $share_toolbox ); ?>"></div>
            
        <?php if( $product->is_in_stock() ) : ?>
			<div class="pt-fixed-product-wrapper <?php echo esc_attr( $hide_sticky_addtocart ); ?>">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-one">
							<div class="pt-fixed-product">
								<div class="pt-img">
									<?php 
										if (has_post_thumbnail($product->get_id())) {
											$thumb = get_the_post_thumbnail_url();
										    
										    if ( ! empty( $thumb ) ) {
									            echo '<img src="'. esc_url( $thumb ) .'">';
									        }
										}
									?>
								</div>
								<div class="pt-description">
									<h3 class="pt-title"><?php echo esc_html($product->get_title()); ?></h3>
									<div class="pt-price"><?php woocommerce_template_single_price(); ?></div>
								</div>
							</div>
						</div>
						<div class="col-two">
							<?php woocommerce_template_single_add_to_cart(); ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif;?>


	</div><!-- .summary -->
</div>
