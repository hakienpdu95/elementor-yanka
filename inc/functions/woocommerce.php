<?php
if ( !class_exists( 'WooCommerce' ) ) return;

/**
 * ------------------------------------------------------------------------------------------------
 * Unhook the WooCommerce wrappers
 * ------------------------------------------------------------------------------------------------
 */
 /**/

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

if( !function_exists( 'yanka_primary_navigation_wrapper' ) ) {
	/**
	 * The primary navigation wrapper
	 */
	function yanka_primary_navigation_wrapper() {
		$content_class = '';
		echo '<div class="page-content">';
	}
}

if( !function_exists( 'yanka_primary_navigation_wrapper_close' ) ) {
	/**
	 * The primary navigation wrapper close
	 */
	function yanka_primary_navigation_wrapper_close() {
		echo '</div>';
	}
}
add_action('woocommerce_before_main_content', 'yanka_primary_navigation_wrapper', 10);
add_action('woocommerce_after_main_content', 'yanka_primary_navigation_wrapper_close', 10);


// Wrapp cart totals
add_action( 'woocommerce_before_cart_totals', function() {
	echo '<div class="cart-totals-inner">';
}, 1);
add_action( 'woocommerce_after_cart_totals', function() {
	echo '</div><!--.cart-totals-inner-->';
}, 200);

remove_action( 'woocommerce_before_single_product', 'wc_print_notices', 10 );
remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );

if ( ! function_exists('yanka_add_to_cart_message') ) {
	function yanka_add_to_cart_message() {
		if( ! (isset( $_REQUEST['product_id'] ) && (int) $_REQUEST['product_id'] > 0 ) )
			return;

		$titles 	= array();
		$product_id = (int) $_REQUEST['product_id'];

		if ( is_array( $product_id ) ) {
			foreach ( $product_id as $id ) {
				$titles[] = get_the_title( $id );
			}
		} else {
			$titles[] = get_the_title( $product_id );
		}

		$titles     = array_filter( $titles );
		$added_text = sprintf( _n( '<div class="text-inner"><b>%s</b> has been added to your cart.</div>', '%s have been added to your cart.', sizeof( $titles ), 'yanka' ), '"' . wc_format_list_of_items( $titles ) . '"' );
		$message    = sprintf( '%s <a href="%s" class="wc-forward db">%s</a>', wp_kses( $added_text , 'allowed-html' ), esc_url( wc_get_page_permalink( 'cart' ) ), esc_html__( 'View Cart', 'yanka' ) );
		$data       =  array( 'message' => apply_filters( 'wc_add_to_cart_message', $message, $product_id ) );

		wp_send_json( $data );

		exit();
	}
	add_action( 'wp_ajax_add_to_cart_message', 'yanka_add_to_cart_message' );
	add_action( 'wp_ajax_nopriv_add_to_cart_message', 'yanka_add_to_cart_message' );
}

if ( !function_exists('yanka_product_get_sale_percent') ) {
	/*
	 *	Single product: Get sale percentage
	 */

	function yanka_product_get_sale_percent( $product ) {
		if ( $product->get_type() === 'variable' ) {
			// Get product variation prices (regular and sale)
			$product_variation_prices = $product->get_variation_prices();

			$highest_sale_percent = 0;

			foreach( $product_variation_prices['regular_price'] as $key => $regular_price ) {
				// Get sale price for current variation
				$sale_price = $product_variation_prices['sale_price'][$key];

				// Is product variation on sale?
				if ( $sale_price < $regular_price ) {
					$sale_percent = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );

					// Is current sale percent highest?
					if ( $sale_percent > $highest_sale_percent ) {
						$highest_sale_percent = $sale_percent;
					}
				}
			}

			// Return the highest product variation sale percent
			return $highest_sale_percent;
		} else {
			$regular_price = $product->get_regular_price();
			$sale_percent = 0;

			// Make sure the percentage value can be calculated
			if ( intval( $regular_price ) > 0 ) {
				$sale_percent = round( ( ( $regular_price - $product->get_sale_price() ) / $regular_price ) * 100 );
			}

			return $sale_percent;
		}
	}

}

/* New label in product
/* --------------------------------------------------------------------- */
if ( ! function_exists('yanka_add_new_label_product') ) {
	function yanka_add_new_label_product() {
		global $post;

		$options = get_post_meta( get_the_ID(), '_custom_single_product_options', true );

		$output = '';

		if ( is_array($options) && isset($options['wc-new-label']) && $options['wc-new-label'] !== '' ) : ?>
			<span class="badge new pa tc dib"><span class="new"><?php echo esc_html($options['wc-new-label']); ?></span></span>
		<?php endif;
	}
	add_action('woocommerce_before_shop_loop_item_title', 'yanka_add_new_label_product', 5);
}

if ( ! function_exists('yanka_add_new_label_single_product') ) {
	function yanka_add_new_label_single_product() {
		$options = get_post_meta( get_the_ID(), '_custom_single_product_options', true );
		$output = '';
		if ( is_array($options) && isset($options['wc-new-label']) && $options['wc-new-label'] !== '' ) : ?>
			<span class="badge new pa tc dib"><span class="new"><?php echo esc_html($options['wc-new-label']); ?></span></span>
		<?php endif;
	}
}

if ( !function_exists('yanka_wc_quickview') ) {
	/**
	 * Customize product quick view.
	 */
	function yanka_wc_quickview() {
		// Get product from request.
		if ( isset( $_POST['product'] ) && (int) $_POST['product'] ) {
			global $post, $product, $woocommerce;

			$id      = ( int ) $_POST['product'];
			$post    = get_post( $id );
			$product = get_product( $id );

			if ( $product ) {
				// Get quickview template.
				include YANKA_PATH . '/woocommerce/content-quickview-product.php';
			}
		}

		exit;
	}
	add_action( 'wp_ajax_yanka_quickview', 'yanka_wc_quickview' );
	add_action( 'wp_ajax_nopriv_yanka_quickview', 'yanka_wc_quickview' );
}

if ( ! function_exists('yanka_after_shop_loop_product') ) {
	function yanka_after_shop_loop_product() {
		echo '</div>';
	}
	add_action( 'woocommerce_after_shop_loop_item', 'yanka_after_shop_loop_product', 5 );
}

/**
 * Show the product title in the product loop.
 */
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
if ( ! function_exists( 'yanka_woocommerce_template_loop_product_title' ) ) {

	/**
	 * Show the product title in the product loop. By default this is an H2.
	 */
	function yanka_woocommerce_template_loop_product_title() {
		echo get_the_title();
	}
}

add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 5 );
add_action( 'woocommerce_shop_loop_item_title', 'yanka_woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 20 );

add_action( 'yanka_woocommerce_breadcrumb', 'woocommerce_breadcrumb', 10 );

// Product Shop
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
add_action( 'yanka_woocommerce_result_count', 'woocommerce_result_count', 5 );

if ( ! function_exists( 'yanka_woocommerce_catalog_ordering' ) ) {
	function yanka_woocommerce_catalog_ordering() {
		global $wp_query;

		if ( 1 === (int) $wp_query->found_posts || ! woocommerce_products_will_display() ) {
			return;
		}

		$orderby                 = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
		$show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
		$catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
			'menu_order' => esc_html__( 'Default', 'yanka' ),
			'popularity' => esc_html__( 'Popularity', 'yanka' ),
			'rating'     => esc_html__( 'Average rating', 'yanka' ),
			'date'       => esc_html__( 'Sort by newness', 'yanka' ),
			'price'      => esc_html__( 'Price low to high', 'yanka' ),
			'price-desc' => esc_html__( 'Price high to low', 'yanka' ),
		) );

		if ( ! $show_default_orderby ) {
			unset( $catalog_orderby_options['menu_order'] );
		}

		if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ) {
			unset( $catalog_orderby_options['rating'] );
		}

		wc_get_template( 'loop/orderby.php', array( 'catalog_orderby_options' => $catalog_orderby_options, 'orderby' => $orderby, 'show_default_orderby' => $show_default_orderby ) );
	}
}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

/**
 * ------------------------------------------------------------------------------------------------
 * My account remove logout link
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'yanka_remove_my_account_logout' ) ) {
	function yanka_remove_my_account_logout( $items ) {
		unset( $items['customer-logout'] );
		return $items;
	}
	add_filter( 'woocommerce_account_menu_items', 'yanka_remove_my_account_logout', 10 );
}

// -- MY ACCOUNT
if ( ! function_exists( 'yanka_my_account' ) ) {
	function yanka_my_account() {
		$user_registration_link = yanka_get_option( 'user-registration-link' );
		
		$wp_registration_url = '';
        if(isset($user_registration_link) && !empty($user_registration_link)) {
            $wp_registration_url = $user_registration_link;
        } else {
            $wp_registration_url = get_permalink( wc_get_page_id( 'myaccount' ) );
        }		
		?>
		<div class="header-account btn-group box-hover compact-hidden mt-svg">
			<a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>" class="dropdown-toggle">
				<span><?php echo esc_html__( 'My account', 'yanka' ); ?></span>
				<svg width="24" height="24" viewBox="0 0 24 24">
	                <use xlink:href="#icon-user"></use>
	            </svg>
			</a>
		    <div class="dropdown-menu">
                <ul>
					<?php if ( !is_user_logged_in() ) : ?>
						<li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--customer-login">
				        	<a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>"><?php echo esc_html__( 'Login', 'yanka' ); ?></a>
				        </li>

						<li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--customer-register">
				        	<a href="<?php echo esc_url( $wp_registration_url ); ?>"><?php echo esc_html__( 'Register', 'yanka' ); ?></a>
				        </li>
					<?php endif; ?>

					<?php if ( is_user_logged_in() ) : ?>
						<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
				            <li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
								<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><span><?php echo esc_html( $label ); ?></span></a>
							</li>
				        <?php endforeach; ?>

						<?php if ( class_exists( 'WeDevs_Dokan' ) ) : ?>
							<li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--dokan">
								<a href="<?php echo dokan_get_navigation_url(); ?>"><?php echo esc_html__( 'Vendor dashboard', 'yanka' ); ?></a>
							</li>
						<?php endif; ?>

						<li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--customer-logout">
				        	<a href="<?php echo wp_logout_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>"><?php echo esc_html__( 'Logout', 'yanka' ); ?></a>
				        </li>
					<?php endif; ?>
			    </ul>
		    </div>
		</div>
        <?php
	}
}

/**
 * Remove product in wishlist.
 */

if ( ! function_exists('yanka_remove_product_wishlist') ) {
	function yanka_remove_product_wishlist() {
		if ( ! ( isset ( $_POST['product_id'] ) && isset( $_POST['_nonce'] ) && wp_verify_nonce( $_POST['_nonce'], 'bb_yanka' ) ) ) {
			wp_send_json ( array(
				'status' => 'false',
				'notice' => esc_html__( 'Not validate.', 'yanka' )
			));
		}

		$product_id = intval( $_POST['product_id'] );

		$user_id = get_current_user_id();

		if( $user_id ) {
			global $wpdb;
			$sql = "DELETE FROM {$wpdb->yith_wcwl_items} WHERE user_id = %d AND prod_id = %d";
			$sql_args = array(
				$user_id,
				$product_id
			);
			$wpdb->query( $wpdb->prepare( $sql, $sql_args ) );
		} else {
			$wishlist = yith_getcookie( 'yith_wcwl_products' );
			foreach( $wishlist as $key => $item ){
				if( $item['prod_id'] == $product_id ){
					unset( $wishlist[ $key ] );
				}
			}
			yith_setcookie( 'yith_wcwl_products', $wishlist );
		}
		$data = array(
			'status' => 'true',
		);

		wp_send_json( $data );

		die();
	}
	// Delete product in wishlish
	add_action( 'wp_ajax_yanka_remove_product_wishlist', 'yanka_remove_product_wishlist' );
	add_action( 'wp_ajax_nopriv_yanka_remove_product_wishlist', 'yanka_remove_product_wishlist' );
}

if ( !function_exists('yanka_add_title_to_wishlist') ) {
	/**
	 * Add product title to wishlist notice.
	 */
	function yanka_add_title_to_wishlist() {
		$product_id = isset( $_POST['add_to_wishlist'] ) ? intval( $_POST['add_to_wishlist'] ) : 0;

		if( ! $product_id ) return;

		$product_title = get_the_title( $product_id );
		return '<span><b>' . esc_html( $product_title ) ."</b> ". esc_html__('has been added to your Wishlist', 'yanka') . '</span>';
	}
	add_filter( 'yith_wcwl_product_added_to_wishlist_message', 'yanka_add_title_to_wishlist' );
}

/**
 * Currency Dropdown
 */
if ( ! function_exists( 'yanka_currency' )  ) {
 	function yanka_currency() {
		if ( ! class_exists( 'Jms_Currency' ) ) return;
		$currencies = Jms_Currency::getCurrencies();

		if ( (!empty($currencies)) && (count( $currencies ) ) ) {
			$woocurrency = Jms_Currency::woo_currency();
			$woocode = $woocurrency['currency'];
			if ( ! isset( $currencies[$woocode] ) ) {
				$currencies[$woocode] = $woocurrency;
			}
			$default = Jms_Currency::woo_currency();
			$current = isset( $_COOKIE['jms_currency'] ) ? $_COOKIE['jms_currency'] : $default['currency'];

			?>

			<div class="btn-group compact-hidden box-hover">
				<a href="javascript:void(0)" class="dropdown-toggle currency-dropdown">
					<span class="current"><?php echo esc_html( $current ) ?></span>
					<span class="pt-icon">
						<svg width="12" height="7" viewBox="0 0 12 7">
							<use xlink:href="#icon-arrow_small_bottom"></use>
						</svg>
					</span>
				</a>
				<div class="dropdown-menu currency-box">
					<ul>
						<?php foreach( $currencies as $code => $val ) : ?>
							<li>
								<a class="currency-item" href="javascript:void(0);" data-currency="<?php echo esc_attr( $code ); ?>"><?php echo esc_html( $code ); ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>

			<?php

		}
 	}
}

/* 	Yanka Wishlist
/* --------------------------------------------------------------------- */
if ( ! function_exists( 'yanka_wishlist' ) ){
	function yanka_wishlist(){
			$wishlist_url = YITH_WCWL()->get_wishlist_url(); ?>
			<div class="header-wishlist btn-group mt-svg">
	            <a href="<?php echo esc_url($wishlist_url);?>" class="dropdown-toggle">
	                <svg width="24" height="24" viewBox="0 0 24 24">
		                <use xlink:href="#icon-wishlist"></use>
		            </svg>	
					<?php 
					if(YITH_WCWL()->count_products() == 0 && YITH_WCWL()->count_products() === 0) :
						echo '<span class="wishlist_count_products no"></span>';
					else :
						echo '<span class="wishlist_count_products yes">'.YITH_WCWL()->count_products().'</span>';
					endif;
					?>
	            </a>
	        </div>
		<?php
	}
}


/* 	Header cart
/* --------------------------------------------------------------------- */
if ( ! function_exists( 'yanka_header_cart' ) ) {
	function yanka_header_cart(){
		global $woocommerce;
		$cart_style  = yanka_get_option('wc-add-to-cart-style', 'alert');

		if( isset($_GET['cart_design']) && $_GET['cart_design'] != '' ) {
			$cart_style = $_GET['cart_design'];
		}

    	?>
        <div class="header-cart btn-group box-hover <?php echo esc_attr($cart_style); ?> mt-svg">
            <a href="#" class="dropdown-toggle cart-contents">
            	<svg width="24" height="24" viewBox="0 0 24 24">
                    <use xlink:href="#icon-cart_1"></use>
                </svg>
                <samp class="cart-count pa"><?php echo esc_html($woocommerce->cart->cart_contents_count);?></samp>
            </a>
			<?php if ( isset($cart_style) && $cart_style != 'toggle-sidebar' ) : ?>
				<div class="widget_shopping_cart_content"></div>
			<?php endif; ?>
        </div>
	<?php
	}
}

/* 	Header single button
/* --------------------------------------------------------------------- */
if ( ! function_exists( 'yanka_header_single_button' ) ) {
	function yanka_header_single_button() {
		$text  = yanka_get_option('single-button-text', '');
		$url  = yanka_get_option('single-button-url', '');
	?>
		<div class="single-button">
			<a href="<?php echo esc_url($url); ?>" class="pt-btn-custom inner-l-r">
				<span class="pt-text"><?php echo esc_html($text); ?></span>
			</a>
		</div>
	<?php	
	}
}

if ( ! function_exists( 'yanka_header_single_button_intro' ) ) {
	function yanka_header_single_button_intro() {
		$url  = yanka_get_option('single-button-url', '');
	?>
		<div class="single-button-intro">
			<a href="<?php echo esc_url($url); ?>" class="pt-btn-custom inner-l-r">
				<span class="pt-text"><?php echo esc_html__('PURCHASE', 'yanka'); ?></span>
			</a>
		</div>
	<?php	
	}
}
/**
 * Ensure cart contents update when products are added to the cart via AJAX.
 */

if ( !function_exists('yanka_header_cart_fragment') ) {
	function yanka_header_cart_fragment( $fragments ) {
		global $woocommerce;

		ob_start();
		?>
	    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="dropdown-toggle cart-contents" data-toggle="dropdown">
        	<svg width="24" height="24" viewBox="0 0 24 24">
                <use xlink:href="#icon-cart_1"></use>
            </svg>
	        <samp class="cart-count pa"><?php echo esc_html($woocommerce->cart->cart_contents_count);?></samp>
	    </a>
		<?php
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;

	}
	add_filter('woocommerce_add_to_cart_fragments', 'yanka_header_cart_fragment');
}

/**
 * Load mini cart on header.
 */

if ( !function_exists('yanka_load_mini_cart') ) {
	function yanka_load_mini_cart() {
	 	$output = '';

	 	ob_start();
	 		$args['list_class'] = '';
	 		wc_get_template( 'cart/mini-cart.php' );

	 	$output = ob_get_clean();

	 	$result = array(
	 		'message'    => WC()->session->get( 'wc_notices' ),
	 		'cart_total' => WC()->cart->cart_contents_count,
	 		'cart_html'  => $output
	 	);
	 	echo json_encode( $result );
	 	exit;
	}
	add_action( 'wp_ajax_load_mini_cart', 'yanka_load_mini_cart' );
	add_action( 'wp_ajax_nopriv_load_mini_cart', 'yanka_load_mini_cart' );
}

if ( ! function_exists( 'yanka_shop_action_switch' ) ) {
	function yanka_shop_action_switch() {
		$product_view             = yanka_get_option( 'wc-product-view', 'grid' );
		$current_per_row          = yanka_get_option( 'wc-product-column', '4' );

		if ( isset($_GET['per_row']) && $_GET['per_row'] != '' ) {
			$current_per_row = $_GET['per_row'];
		}

		if ( isset( $_GET['product_view'] ) && $_GET['product_view'] != '' ) {
			$product_view = $_GET['product_view'];
		}
		
		?>
		<div class="wc-switch flex">
			<?php if ($current_per_row !== '') { ?>
				<a href="#" class="<?php echo ( 'list' != $product_view ) ? 'active ' : ''; ?> <?php echo 'per-row-'.esc_attr( $current_per_row ) ?> grid">
					<span class="icon-listing-three">
						<span></span>
						<span></span>
						<span></span>
					</span>
				</a>
			<?php } ?>
			<a href="#" class="<?php echo ( 'list' == $product_view ) ? 'active ' : ''; ?>per-row-1 list">
				<span></span>
				<span></span>
			</a>
		</div>
		<?php
	}
}


if ( ! function_exists( 'yanka_woocommerce_shop_action' ) ) {
	function yanka_woocommerce_shop_action() {
		$shop_ordering        = yanka_get_option( 'wc-shop-ordering', 1 );
		$products_per_page	  = yanka_get_option( 'wc-products-per-page', 1 );

		?>
		<div class="shop-action">
			<div class="shop-action-inner flex right-xs">
				<div class="action-right flex middle-xs">
					<?php if( $shop_ordering ) yanka_woocommerce_catalog_ordering(); ?>
					<?php if( $products_per_page ) yanka_product_show_pager(); ?>
				</div>
				<?php yanka_shop_action_switch(); ?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'yanka_taxonomy_archive_description' ) ) {
	function yanka_taxonomy_archive_description() {
		if ( is_product_taxonomy() && 0 === absint( get_query_var( 'paged' ) ) ) {
			$description = wc_format_content( term_description() );
			if ( $description ) {
				echo '<div class="term-description">' .$description. '</div>';
			}
		}
	}
	add_action( 'woocommerce_archive_description', 'yanka_taxonomy_archive_description', 10 );
}
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );


if ( ! function_exists('yanka_cart_remove_item') ) {
	function yanka_cart_remove_item() {
	    $item_key = $_POST['item_key'];

        $removed = WC()->cart->remove_cart_item( $item_key ); // Note: WP 2.3 >

        if ( $removed ) {
           $data['status'] = '1';
           $data['cart_count'] = WC()->cart->get_cart_contents_count();
           $data['cart_subtotal'] = WC()->cart->get_cart_subtotal();
        } else {
            $data['status'] = '0';
        }

        echo json_encode( $data );

        exit;
	}
	add_action( 'wp_ajax_cart_remove_item', 'yanka_cart_remove_item' );
	add_action( 'wp_ajax_nopriv_cart_remove_item', 'yanka_cart_remove_item' );
}

/* 	Product show per page
/* --------------------------------------------------------------------- */
if( ! function_exists( 'yanka_product_show_pager' ) ) {
	function yanka_product_show_pager() {
		$numbers = array(6, 8, 10, 12, 15, 16, 18, 20, 24, 27, 28, 30, 32, 33, 36, 40, 48, 60, 72 );

		$options   = array();
		$showproducts = get_query_var( 'posts_per_page' );
		if( ! $showproducts ) {
			$showproducts = yanka_get_option('products-show-per-page','12');
		}
		foreach ( $numbers as $number ):
			$options[] = sprintf(
				'<option value="%s" %s>%s %s</option>',
				esc_attr( $number ),
				selected( $number, $showproducts, false ),
				$number,'','');
		endforeach;
		?>
		<form class="show-products-number hidden-xs" method="get">
			<span><?php esc_html_e( 'Show:', 'yanka' ) ?></span>
			<select name="showproducts">
				<?php echo implode( '', $options ); ?>
			</select>
			<?php
			foreach( $_GET as $name => $value ) {
				if ( 'showproducts' != $name ) {
					printf( '<input type="hidden" name="%s" value="%s">', esc_attr( $name ), esc_attr( $value ) );
				}
			}
			?>
		</form>
		<?php
	}
}

/**
 * Change number of products to be displayed
 */

if ( !function_exists('yanka_change_product_per_page') ) {
	function yanka_change_product_per_page() {
		if ( isset( $_GET['showproducts'] ) ) {
			$number = absint( $_GET['showproducts'] );
		} else {
			$number = yanka_get_option( 'wc-number-per-page', '12' );
		}
		return $number;
	}
	add_filter( 'loop_shop_per_page', 'yanka_change_product_per_page' );
}


/* Product deal countdown
/* --------------------------------------------------------------------- */
if( ! function_exists( 'yanka_product_countdown_timer' ) ) {
	function yanka_product_countdown_timer() {
		global $post;
        $sale_date = get_post_meta( $post->ID, '_sale_price_dates_to', true );
        
        $countdown_title   = yanka_get_option('countdown_title', 'Offer Will End Through');

		if( ! $sale_date ) return;

        $timezone = 'GMT';

        if ( apply_filters( 'yanka_wp_timezone', false ) ) $timezone = wc_timezone_string();

		echo '<div class="yanka-countdown_box"><div class="yanka-countdown_inner"><div class="yanka-countdow-title">'.esc_attr( $countdown_title ).'</div><div class="yanka-product-countdown yanka-countdown" data-end-date="' . esc_attr( date( 'Y-m-d H:i:s', $sale_date ) ) . '" data-timezone="' . $timezone . '"></div></div></div>';
	}
	add_action( 'woocommerce_single_product_summary', 'yanka_product_countdown_timer', 1 );
}

/**
 * Add extra link after single cart.
 */

if ( !function_exists('yanka_add_extra_link_after_cart') ) {
	function yanka_add_extra_link_after_cart() {
		$shipping   = yanka_get_option('wc-single-shipping-return', '');
		if ( ! empty( $shipping ) ) {
			echo '<div class="extra-link mt_30 mb_30">';
					echo '<a data-type="shipping-return" class="yanka-wc-help" href="#">' . esc_html__( 'Delivery & Return', 'yanka' ) . '</a>';
			echo '</div>';
		}
	}
	add_action( 'woocommerce_single_product_summary', 'yanka_add_extra_link_after_cart', 35 );
}

if ( !function_exists('yanka_shipping_return') ) {
	/**
	 * Customize shipping & return content.
	 */

	function yanka_shipping_return() {
		// Get help content
		$shipping   = yanka_get_option('wc-single-shipping-return', '');
		if ( ! $shipping ) return;

		$output = '<div class="wc-shipping-return pr">' .$shipping. '</div>';

		echo wp_kses( $output, 'editor' );
		exit;
	}
	add_action( 'wp_ajax_yanka_shipping_return', 'yanka_shipping_return' );
	add_action( 'wp_ajax_nopriv_yanka_shipping_return', 'yanka_shipping_return' );
}

if ( !function_exists('yanka_size_guide') ) {
	function yanka_size_guide() {
		$size_guide   = yanka_get_option('wc-single-size-guide', '');
		if ( ! $size_guide ) return;

		$output = '<div class="wc-size-guide pr">' .$size_guide. '</div>';

		echo wp_kses( $output, 'editor' );
	}
}

if ( !function_exists('yanka_shipping') ) {
	function yanka_shipping() {
		$shipping   = yanka_get_option('wc-single-shipping', '');
		if ( ! $shipping ) return;

		$output = '<div class="wc-shipping pr">' .$shipping. '</div>';

		echo wp_kses( $output, 'editor' );
	}
}

if ( !function_exists('yanka_ask_about_product') ) {
	function yanka_ask_about_product() {
		$ask_about   = yanka_get_option('wc-single-ask-about-product', '');
		if ( ! $ask_about ) return;

		$output = '<div class="wc-ask-about pr">' .$ask_about. '</div>';

		echo apply_filters( 'the_content', wp_kses( $output, 'editor' ) );
	}
}


if ( !function_exists('yanka_product_information_buttons_html') ) {	
	function yanka_product_information_buttons_html() {
		global $product;

		$size_guide   = yanka_get_option('wc-single-size-guide', '');
		$shipping   = yanka_get_option('wc-single-shipping', '');
		$ask_about   = yanka_get_option('wc-single-ask-about-product', '');


		$txt_size = esc_html__('Size guide', 'yanka');
		$txt_shipping = esc_html__('Shipping', 'yanka');
		$txt_ask = esc_html__('Ask about this product', 'yanka');

		$html = '';
		if( !empty($size_guide) || !empty($shipping) || !empty($ask_about) ) {
			$html .= '<div class="pt-wrapper">';
			$html .= '<div class="product-information-buttons">';
			if( !empty($size_guide) ) {
				$html .= '<a data-toggle="modal" data-target="#modalProductInfo" href="#">';
				$html .= '<span class="pt-icon"><img src="'.YANKA_URL .'/assets/images/icons/ic-size-guide.png" /></span>';
				$html .= '<span class="pt-text">'.$txt_size.'</span>';
				$html .= '</a>';			
			}

			if( !empty($shipping) ) {
				$html .= '<a data-toggle="modal" data-target="#modalProductInfo-02" href="#">';
				$html .= '<span class="pt-icon"><img src="'.YANKA_URL .'/assets/images/icons/ic-shipping.png" /></span>';
				$html .= '<span class="pt-text">'.$txt_shipping.'</span>';
				$html .= '</a>';			
			}
			
			if( !empty($ask_about) ) {
				$html .= '<a data-toggle="modal" data-target="#modalProductInfo-03" href="#">';
				$html .= '<span class="pt-icon"><img src="'.YANKA_URL .'/assets/images/icons/ic-ask.png" /></span>';
				$html .= '<span class="pt-text">'.$txt_ask.'</span>';
				$html .= '</a>';			
			}
			$html .= '</div>';
			$html .= '</div>';			
		}
		return $html;
	}
}


add_action( 'woocommerce_single_product_summary', 'yanka_product_information_buttons', 28);
if ( !function_exists('yanka_product_information_buttons') ) {	
	function yanka_product_information_buttons() {
		global $product;

		$html = yanka_product_information_buttons_html();
		if ( $product->is_type( 'simple' ) || $product->is_type( 'grouped' ) || $product->is_type( 'external' ) ) {
			echo wp_kses($html, 'allowed-html');
		}	
	}
}

if ( !function_exists('yanka_product_information_buttons_for_variable') ) {	
	function yanka_product_information_buttons_for_variable() {

		$html = yanka_product_information_buttons_html();
		echo wp_kses($html, 'allowed-html');
	}
}

if ( !function_exists('yanka_product_categories') ) {
	function yanka_product_categories() {
		global $product;
		global $post;
		
		$id_product_cat = yanka_get_option( 'product-category-label');
		$show_category_name  = yanka_get_option('wc-category-name', 1);

		$product_label = array();
		$product_slug = array();
		//echo wc_get_product_category_list( $product->get_id(), ', ', '<div class="product-cat"> ', '</div>' );
		
		if(!empty($id_product_cat)) {
			$brands_id = get_term_by('id', $id_product_cat , 'product_cat');
			$terms = get_the_terms($post->ID, 'product_cat',array('fields' => 'ids'));

			foreach ($terms as $term) {		    
			    if($term->parent == $brands_id->term_id) {
			        $product_label[] = $term->name;
			        $product_slug[] = $term->term_id;
			        break;
			    } 
			}
		}

		if( count($product_label) == 1 && !empty($product_label) ) {
			echo '<div class="product-cat"><a href="' . get_term_link( (int) $product_slug[0], 'product_cat' ) . '">'.$product_label[0].'</a></div>';
		} elseif ( empty($product_label) ) {
			echo wc_get_product_category_list( $product->get_id(), ', ', '<div class="product-cat"> ', '</div>' );
		} else {
			echo '<div class="product-cat">N/A</div>';
		}
	}
}

if ( !function_exists('yanka_product_quickview') ) {
	function yanka_product_quickview() {
		global $post;

		$show_quickview = yanka_get_option('wc-quick-view', 1);

		if ( $show_quickview ) : ?>
			<li class="quickview hidden-xs"><a href="javascript:void(0)" data-original-title="Quick View" class="button btn-quickview" data-product="<?php echo esc_attr( $post->ID ); ?>"><?php echo esc_html__('Quick View', 'yanka'); ?></a></li>
		<?php endif;
	}
}

if ( !function_exists('yanka_block_product_quickview') ) {
	function yanka_block_product_quickview() {
		global $post;

		$show_quickview = yanka_get_option('wc-quick-view', 1);

		if ( $show_quickview ) : ?>
			<div class="quickview hidden-xs"><a href="javascript:void(0)" data-original-title="Quick View" data-toggle="tooltip" data-placement="left" class="button btn-quickview" data-product="<?php echo esc_attr( $post->ID ); ?>">
				<svg width="24" height="24" fill="none" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"><path d="M15 11H7m4-4v8" stroke="currentColor" stroke-width="1.6"></path><circle cx="11" cy="11" r="10.2" stroke="currentColor" stroke-width="1.6"></circle><path d="M23 23l-5-5" stroke="currentColor" stroke-width="1.6"></path></svg>
			</a></div>
		<?php endif;
	}
}

if ( !function_exists('yanka_list_view_product_quickview') ) {
	function yanka_list_view_product_quickview() {
		global $post;

		$show_quickview = yanka_get_option('wc-quick-view', 1);

		if ( $show_quickview ) : ?>
			<div class="quickview hidden-xs"><a href="javascript:void(0)" data-original-title="Quick View" data-toggle="tooltip" data-placement="left" class="button btn-quickview" data-product="<?php echo esc_attr( $post->ID ); ?>">
				<svg width="24" height="24" fill="none" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"><path d="M15 11H7m4-4v8" stroke="currentColor" stroke-width="1.6"></path><circle cx="11" cy="11" r="10.2" stroke="currentColor" stroke-width="1.6"></circle><path d="M23 23l-5-5" stroke="currentColor" stroke-width="1.6"></path></svg>
				<span class="txt_qv"><?php echo esc_html__('Zoom', 'yanka'); ?></span></a></div>
		<?php endif;
	}
}

if ( !function_exists('yanka_product_wishlist') ) {
	function yanka_product_wishlist() {
		echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
	}
}

if ( !function_exists('yanka_product_varition') ) {
	function yanka_product_varition() {
		$show_varition = yanka_get_option('wc-attribute-variation', 1);

		if(class_exists('TA_WC_Variation_Swatches' ) && $show_varition) { ?>
			<div class="variation-attr">
				<div class="variation-attr_color">
	            	<?php yanka_swatches_list_color();/*swatches color*/ ?>
	        	</div>
	        </div>
	    <?php }
	}
}

//Compare

if ( !function_exists('yanka_product_rating') ) {
	function yanka_product_rating() {
		$show_rating = yanka_get_option('wc-rating', 0);

		if ( isset($_GET['show-rating']) && $_GET['show-rating'] != '' ) {
			$show_rating = $_GET['show-rating'];
		}

		if ( $show_rating ) {
			woocommerce_template_loop_rating();
		}
	}
}

if( ! function_exists( 'yanka_shop_page_link' ) ) {
	/**
	 * ------------------------------------------------------------------------------------------------
	 * Get base shop page link
	 * ------------------------------------------------------------------------------------------------
	 */
	function yanka_shop_page_link( $keep_query = false, $taxonomy = '' ) {
		// Base Link decided by current page
		if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
			$link = home_url();
		} elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id('shop') ) ) {
			$link = get_post_type_archive_link( 'product' );
		} elseif( is_product_category() ) {
			$link = get_term_link( get_query_var('product_cat'), 'product_cat' );
		} elseif( is_product_tag() ) {
			$link = get_term_link( get_query_var('product_tag'), 'product_tag' );
		} else {
			$link = get_term_link( get_query_var('term'), get_query_var('taxonomy') );
		}

		return $link;
	}
}


if( ! function_exists( 'yanka_get_shop_view' ) ) {
	function yanka_get_shop_view() {
		if( ! class_exists('WC_Session_Handler') ) return;
		$s = WC()->session;
		if ( is_null( $s ) ) return yanka_get_option('wc-product-view', 'grid');

		if ( isset( $_REQUEST['product_view'] ) ) {
			return $_REQUEST['product_view'];
		}elseif ( $s->__isset( 'product_view' ) ) {
			return $s->__get( 'product_view' );
		} else {
			$product_view = yanka_get_option('wc-product-view', 'grid');
			if ( $product_view == 'grid' ) {
				return 'grid';
			} elseif( $product_view == 'list'){
				return 'list';
			}
		}
	}
}

if( ! function_exists( 'yanka_shop_view_action' ) ) {
	function yanka_shop_view_action() {
		if( ! class_exists('WC_Session_Handler')) return;
		$s = WC()->session;
		if ( is_null( $s ) ) return;

		if ( isset( $_REQUEST['product_view'] ) ) {
			$s->set( 'product_view', $_REQUEST['product_view'] );
		}
		if ( isset( $_REQUEST['per_row'] ) ) {
			$s->set( 'shop_per_row', $_REQUEST['per_row'] );
		}
	}
}

if ( ! function_exists( 'yanka_is_woo_ajax' ) ) {
	/**
	 * ------------------------------------------------------------------------------------------------
	 * is ajax request
	 * ------------------------------------------------------------------------------------------------
	 */
	function yanka_is_woo_ajax() {
		$request_headers = getallheaders();

		if( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return 'wp-ajax';
		}
		if( isset( $request_headers['x-pjax'] ) || isset( $request_headers['X-PJAX'] ) || isset( $request_headers['X-Pjax'] ) ) {
			return 'full-page';
		}
		if( isset( $_REQUEST['woo_ajax'] ) ) {
			return 'fragments';
		}
		if( isset( $_REQUEST['_pjax'] ) ) {
			return 'full-page';
		}

		if( isset( $_REQUEST['_pjax'] ) ) {
			return true;
		}
		return false;
	}
}

if( ! function_exists( 'yanka_my_account_wrapper_start' ) ) {
	/**
	 * ------------------
	 * My account wrapper
	 * ------------------
	 */
	function yanka_my_account_wrapper_start(){
		echo '<div class="woocommerce-my-account-wrapper">';
	}
	add_action( 'woocommerce_account_navigation', 'yanka_my_account_wrapper_start', 1 );
}

if( ! function_exists( 'yanka_my_account_wrapper_end' ) ) {
	function yanka_my_account_wrapper_end(){
		echo '</div><!-- .woocommerce-my-account-wrapper -->';
	}
	add_action( 'woocommerce_account_content', 'yanka_my_account_wrapper_end', 10000 );
}

if ( !function_exists('yanka_catalog_mode_init') ) {
	function yanka_catalog_mode_init() {
		/**
		 * WooCommerce catalog mode functions
		 */
		$catalog_mode = yanka_get_option( 'catalog-mode', 0 );

		if ( isset($_GET['catalog-mode']) && $_GET['catalog-mode'] == 1 ) {
	        $catalog_mode = 1;
	    }

		if( ! $catalog_mode  ) return false;

		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	}
	add_action( 'wp', 'yanka_catalog_mode_init' );
}

if ( !function_exists('yanka_pages_redirect') ) {
	function yanka_pages_redirect() {
		$catalog_mode = yanka_get_option( 'catalog-mode', 0 );

		if( ! $catalog_mode  ) return false;

		$cart     = is_page( wc_get_page_id( 'cart' ) );
		$checkout = is_page( wc_get_page_id( 'checkout' ) );

		wp_reset_postdata();

		if ( $cart || $checkout ) {
			wp_redirect( home_url() );
			exit;
		}
	}
	add_action( 'wp', 'yanka_pages_redirect' );
}

if ( !function_exists('yanka_js_sticky_content_product_layout_1_2') ) {
	function yanka_js_sticky_content_product_layout_1_2() {
		ob_start();
		?>
		jQuery(document).ready(function($) {
			var stickySidebar = new StickySidebar('#jms-column-left', {
				containerSelector: '.jms-container',
				innerWrapperSelector: '.product-thumbnail__inner',
				topSpacing: 15,
				bottomSpacing: 30
			});					
		});
		<?php
		return ob_get_clean();
	}
}

if ( !function_exists('yanka_js_sticky_content_product_layout_3') ) {
	function yanka_js_sticky_content_product_layout_3() {
		ob_start();
		?>
		jQuery(document).ready(function($) {
			var one = new StickySidebar('#jms-column-one', {
				containerSelector: '.jms-container',
				innerWrapperSelector: '.summary-one',
				topSpacing: 100,
				bottomSpacing: 30
			});
		});
		<?php
		return ob_get_clean();
	}
}

if ( !function_exists('yanka_js_sticky_content_product_layout_4') ) {
	function yanka_js_sticky_content_product_layout_4() {
		ob_start();
		?>
		jQuery(document).ready(function($) {
			var one = new StickySidebar('#jms-column-one', {
				containerSelector: '.jms-container',
				innerWrapperSelector: '.summary-one',
				topSpacing: 100,
				bottomSpacing: 30
			});
			
			var two = new StickySidebar('#jms-column-two', {
				containerSelector: '.jms-container',
				innerWrapperSelector: '.summary-two',
				topSpacing: 100,
				bottomSpacing: 30
			});
		});
		<?php
		return ob_get_clean();
	}
}

if ( !function_exists('yanka_fixed_product_wrapper_layout') ) {
	function yanka_fixed_product_wrapper_layout() {
		global $product;
		$hide_sticky_addtocart = '';

		$sticky_addtocart = yanka_get_option('wc-product-sticky-addtocart', 0);
		if ( isset($sticky_addtocart) && $sticky_addtocart == 0 ) {
			$hide_sticky_addtocart = 'hide-sticky-addtocart-bottom';
		}		

		if( $product->is_in_stock() ) :
		?>	
			<div class="summary entry-summary info-summary">
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
			</div>
		<?php
		endif;
	}
}

if ( !function_exists('yanka_related_product_carousel_js') ) {
	function yanka_related_product_carousel_js() {
		ob_start();
		?>
		jQuery(document).ready(function($) {
			var owl_product = $('.product-related-carousel');
			var rtl = false;
			if ($('body').hasClass('rtl')) rtl = true;

			owl_product.on('initialized.owl.carousel', function(event) {
			    $(this).trigger('refresh.owl.carousel');
			});

			owl_product.owlCarousel({
				responsive : {
					320 : {
						items: 2,
					},
					560 : {
						items: 2,
					},
					767 : {
						items: 2,
					},
					991 : {
						items: 3,
					},
					1199 : {
						items: 4,
					}
				},
				lazyLoad : true,
				rtl: rtl,
				margin: 30,
				dots: false,
				nav: true,
				autoplay: false,
				loop: false,
				autoplayTimeout: 5000,
				smartSpeed: 250,
				autoHeight:true,
				navText: ['<?php esc_html_e('Prev', 'yanka'); ?>','<?php esc_html_e('Next', 'yanka'); ?>']
			});


		});
		<?php
		return ob_get_clean();
	}
}

if ( !function_exists('yanka_cross_sell_product_carousel_js') ) {
	function yanka_cross_sell_product_carousel_js() {
		ob_start();
		?>
		jQuery(document).ready(function($) {
			var owl_product = $('.cross-sell-carousel');
			var rtl = false;
			if ($('body').hasClass('rtl')) rtl = true;

			owl_product.on('initialized.owl.carousel', function(event) {
			    $(this).trigger('refresh.owl.carousel');
			});

			owl_product.owlCarousel({
				responsive : {
					320 : {
						items: 2,
					},
					560 : {
						items: 2,
					},
					767 : {
						items: 2,
					},
					991 : {
						items: 3,
					},
					1199 : {
						items: 4,
					}
				},
				lazyLoad : true,
				rtl: rtl,
				margin: 30,
				dots: true,
				nav: true,
				autoplay: false,
				loop: false,
				autoplayTimeout: 5000,
				smartSpeed: 250,
				autoHeight:true,
				navText: ['<?php esc_html_e('Prev', 'yanka'); ?>','<?php esc_html_e('Next', 'yanka'); ?>']
			});
		});
		<?php
		return ob_get_clean();
	}
}

if ( !function_exists('yanka_upsell_product_carousel_js') ) {
	function yanka_upsell_product_carousel_js() {
		ob_start();
		?>
		jQuery(document).ready(function($) {
			var owl_product = $('.upsell-product-carousel');
			var rtl = false;
			if ($('body').hasClass('rtl')) rtl = true;

			owl_product.on('initialized.owl.carousel', function(event) {
			    $(this).trigger('refresh.owl.carousel');
			});
			
			owl_product.owlCarousel({
				responsive : {
					320 : {
						items: 2,
					},
					560 : {
						items: 2,
					},
					767 : {
						items: 2,
					},
					991 : {
						items: 3,
					},
					1199 : {
						items: 4,
					}
				},
				lazyLoad : true,
				rtl: rtl,
				margin: 30,
				dots: true,
				nav: true,
				autoplay: false,
				loop: false,
				autoplayTimeout: 5000,
				smartSpeed: 250,
				autoHeight:true,
				navText: ['<?php esc_html_e('Prev', 'yanka'); ?>','<?php esc_html_e('Next', 'yanka'); ?>']
			});
		});
		<?php
		return ob_get_clean();
	}
}


remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 4);

/*
 * Add to cart ajax
 */
if( ! function_exists( 'yanka_ajax_add_to_cart' ) ) {
	function yanka_ajax_add_to_cart() {

		// Get messages
		ob_start();

		wc_print_notices();

		$notices = ob_get_clean();


		// Get mini cart
		ob_start();

		woocommerce_mini_cart();

		$mini_cart = ob_get_clean();

		// Fragments and mini cart are returned
		$data = array(
			'notices' => $notices,
			'fragments' => apply_filters( 'woocommerce_add_to_cart_fragments', array(
					'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
				)
			),
			'cart_hash' => apply_filters( 'woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', WC()->cart->get_cart_for_session() )
		);

		wp_send_json( $data );

		die();
	}
	add_action( 'wp_ajax_yanka_ajax_add_to_cart', 'yanka_ajax_add_to_cart' );
	add_action( 'wp_ajax_nopriv_yanka_ajax_add_to_cart', 'yanka_ajax_add_to_cart' );
}


/* 	Yanka Compare
/* --------------------------------------------------------------------- */
if ( ! function_exists( 'yanka_compare' ) ){
	function yanka_compare(){
			$compare_url = home_url() . '/?action=yith-woocompare-view-table&iframe=yes'; ?>
			<div class="header-compare btn-group compare-button product">
	            <a href="<?php echo esc_url($compare_url);?>" class="compare added">
	                <svg width="24" height="24" viewBox="0 0 24 24">
						<use xlink:href="#icon-compare"></use>
					</svg>	
					<!-- <span></span> -->
	            </a>
	        </div>
		<?php
	}
}

/* Compare button
/* --------------------------------------------------------------------- */

if ( !function_exists('yanka_product_compare') ) {
	function yanka_product_compare() {
		$show_compare = yanka_get_option('wc-compare', 1);
		if( ! class_exists( 'YITH_Woocompare' ) ) return;

		echo '<li class="compare-button">';
            global $product;
            $product_id = $product->get_id();

            // return if product doesn't exist
            if ( empty( $product_id ) || apply_filters( 'yith_woocompare_remove_compare_link_by_cat', false, $product_id ) )
	            return;

            $is_button = ! isset( $button_or_link ) || ! $button_or_link ? get_option( 'yith_woocompare_is_button' ) : $button_or_link;

            if ( ! isset( $button_text ) || $button_text == 'default' ) {
                $button_text = get_option( 'yith_woocompare_button_text', esc_html__( 'Compare', 'yanka' ) );
            }

            printf( '<a href="%s" class="%s" data-product_id="%d" rel="nofollow"><svg><use xlink:href="#icon-compare"></use></svg><svg><use xlink:href="#icon-compare-add"></use></svg><span>%s</span></a>', yanka_compare_add_product_url( $product_id ), 'compare' . ( $is_button == 'button' ? ' button' : '' ), $product_id, $button_text );

		echo '</li>';
	}
}

if ( !function_exists('yanka_block_product_compare') ) {
	function yanka_block_product_compare() {
		$show_compare = yanka_get_option('wc-compare', 1);
		if( ! class_exists( 'YITH_Woocompare' ) ) return;

		echo '<div class="compare-button">';
            global $product;
            $product_id = $product->get_id();

            // return if product doesn't exist
            if ( empty( $product_id ) || apply_filters( 'yith_woocompare_remove_compare_link_by_cat', false, $product_id ) )
	            return;

            $is_button = ! isset( $button_or_link ) || ! $button_or_link ? get_option( 'yith_woocompare_is_button' ) : $button_or_link;

            if ( ! isset( $button_text ) || $button_text == 'default' ) {
                $button_text = get_option( 'yith_woocompare_button_text', esc_html__( 'Compare', 'yanka' ) );
            }

            printf( '<a href="%s" class="%s" data-product_id="%d" data-original-title="Add to Compare" data-toggle="tooltip" data-placement="left" rel="nofollow"><svg><use xlink:href="#icon-compare"></use></svg></a>', yanka_compare_add_product_url( $product_id ), 'compare' . ( $is_button == 'button' ? ' button' : '' ), $product_id, $button_text );

		echo '</div>';
	}
}

/* yanka_compare_add_product_url
/* --------------------------------------------------------------------- */
if( ! function_exists( 'yanka_compare_add_product_url' ) ) {
    function yanka_compare_add_product_url( $product_id ) {
    	$action_add = 'yith-woocompare-add-product';
        $url_args = array(
            'action' => 'asd',
            'id' => $product_id
        );
        return apply_filters( 'yith_woocompare_add_product_url', esc_url_raw( add_query_arg( $url_args ) ), $action_add );
    }
}


if( ! function_exists( 'yanka_product_list_info' ) ) {
    function yanka_product_list_info() {
    	global $product, $woocommerce_loop;
		$show_wishlist = yanka_get_option('wc-wishlist', 1);
    	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 4); ?>

		<div class="product-list-info">
			<div class="pt-description">
				<div class="pt-col">
					<?php yanka_product_rating(); ?>	
					<?php yanka_product_categories(); ?>
					<div class="product-list-info-top">				
						<?php do_action( 'woocommerce_shop_loop_item_title' ); ?>
						<?php 
						    yanka_product_varition();
						?>				
					</div>		
					<?php woocommerce_template_single_excerpt(); ?>			
				</div>
				<div class="pt-col">
					<?php
					/**
					 * woocommerce_after_shop_loop_item_title hook.
					 *
					 * @hooked woocommerce_template_loop_price - 10
					 */
					do_action( 'woocommerce_after_shop_loop_item_title' );
					?>					
					<?php
					$catalog_mode = yanka_get_option( 'catalog-mode', 0 );

					if ( isset($_GET['catalog-mode']) && $_GET['catalog-mode'] == 1 ) {
				        $catalog_mode = 1;
				    }

					if ( !$catalog_mode ) : ?>
						<div class="addtocart"><?php woocommerce_template_loop_add_to_cart(); ?></div>
					<?php endif; ?>

					<ul class="product-btn flex">

						<?php
							if ( $show_wishlist && class_exists( 'YITH_WCWL' ) ) { ?>
								<li class="btn-wishlist">
									<?php yanka_product_wishlist(); ?>
								</li>
							<?php } ?>
					</ul>	
					<?php yanka_list_view_product_quickview(); ?>				
				</div>
			</div>
		</div>
		<?php
    }
}


//  Custom metabox content in admin product pages
if ( ! function_exists( 'yanka_add_additional_information_meta_box' ) ) {
    function yanka_add_additional_information_meta_box( $post ) {
        $prefix = '_wcai_'; // global $prefix;

        $additional_information = get_post_meta($post->ID, $prefix.'addinfo_wysiwyg', true) ? get_post_meta($post->ID, $prefix.'addinfo_wysiwyg', true) : '';
        $args['textarea_rows'] = 10;

        wp_editor( $additional_information, 'addinfo_wysiwyg', $args );

        echo '<input type="hidden" name="custom_product_field_nonce" value="' . wp_create_nonce() . '">';
    }
}

//Save the data of the Meta field
add_action( 'save_post', 'yanka_save_additional_information_meta_box', 10, 1 );
if ( ! function_exists( 'yanka_save_additional_information_meta_box' ) ) {

    function yanka_save_additional_information_meta_box( $post_id ) {
        $prefix = '_wcai_'; // global $prefix;

        // We need to verify this with the proper authorization (security stuff).

        // Check if our nonce is set.
        if ( ! isset( $_POST[ 'custom_product_field_nonce' ] ) ) {
            return $post_id;
        }
        $nonce = $_REQUEST[ 'custom_product_field_nonce' ];

        //Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce ) ) {
            return $post_id;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        // Check the user's permissions.
        if ( 'product' == $_POST[ 'post_type' ] ){
            if ( ! current_user_can( 'edit_product', $post_id ) )
                return $post_id;
        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) )
                return $post_id;
        }

        // Sanitize user input and update the meta field in the database.
        update_post_meta( $post_id, $prefix.'addinfo_wysiwyg', wp_kses( $_POST[ 'addinfo_wysiwyg' ], 'editor' ) );
    }
}

if ( ! function_exists( 'yanka_woo_additional_information_tab_content' ) ) {

    function yanka_woo_additional_information_tab_content() {
	    global $post;

	    $additional_information = get_post_meta( $post->ID, '_wcai_addinfo_wysiwyg', true );

	    if ( ! empty( $additional_information ) ) {

	        // Updated to apply the_content filter to WYSIWYG content
	        echo apply_filters( 'the_content', $additional_information );
	    }    	
    }
}


add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['additional_information'] );   // Remove the additional information tab
    return $tabs;
}

add_filter( 'woocommerce_product_tabs', 'yanka_woo_additional_information_tab' );
function yanka_woo_additional_information_tab( $tabs ) {
	// Adds the new tab
    $tabs['additional_information_custom'] = array(
        'title'     => esc_html__( 'Additional Information', 'yanka' ),
        'priority'  => 10,
        'callback'  => 'yanka_woo_additional_information_tab_content'
    );

     return $tabs;
}

// check for empty-cart get param to clear the cart
add_action( 'init', 'yanka_wc_clear_cart_url' );
if ( ! function_exists( 'yanka_wc_clear_cart_url' ) ) {
	function yanka_wc_clear_cart_url() {
	  global $woocommerce;
		
		if ( isset( $_GET['empty-cart'] ) ) {
			$woocommerce->cart->empty_cart(); 
		}
	}
}

// hide coupon field on the cart page
add_filter( 'woocommerce_coupons_enabled', 'yanka_disable_coupon_field_on_cart' );
if ( ! function_exists( 'yanka_disable_coupon_field_on_cart' ) ) {
	function yanka_disable_coupon_field_on_cart( $enabled ) {
		if ( is_cart() ) {
			$enabled = false;
		}
		return $enabled;
	}
}

//Custom Variation product in cart template
add_filter( 'woocommerce_product_variation_title_include_attributes', '__return_false' );
add_filter( 'woocommerce_is_attribute_in_product_name', '__return_false' );

if ( ! function_exists( 'yanka_customizing_variable_short_description_products' ) ) {
	function yanka_customizing_variable_short_description_products() {
		global $product;
		if( ! $product->is_type( 'variable' ) ) return;
		echo '<div class="woocommerce-variable__short-description">';
			echo wpautop($product->get_short_description());
		echo '</div>';
	}
}


if ( !function_exists('yanka_product_quickview_view_full_info') ) {
	function yanka_product_quickview_view_full_info() {
		global $post, $product;

		$product_id = $product->get_id();

		$url = get_permalink( $product_id ) ;

		$html = '<div class="pt-wrapper pt-quickview-view-info">';
		$html .= '<a href="'.esc_url($url).'" class=""><span class="pt-text">'.esc_html__( 'View full info', 'yanka' ).'</span></a>';
		$html .= '</div>';
		echo wp_kses( $html, 'allowed-html' );
	}
	add_action('woocommerce_single_product_summary', 'yanka_product_quickview_view_full_info', 31);
}


if ( !function_exists('yanka_term_conditions_checkbox') ) {
	function yanka_term_conditions_checkbox() {
		global $woocommerce, $product;
		$html = '<div class="pt-checkbox-group">';
		$html .= '<div class="checkbox-group term-conditions-checkbox-js">';
		$html .= '<input type="checkbox" id="checkBox01" name="checkbox" >';
		$html .= '<label for="checkBox01">';
		$html .= '<span class="check"></span>';
		$html .= '<span class="box"></span>';
		$html .= ''.esc_html__( 'I agree with the terms and conditions', 'yanka' ).'';
		$html .= '</label>';
		$html .= '</div>';
		$html .= '</div>';
		echo html_entity_decode($html);
	}
}

if ( !function_exists('yanka_btn_buy_it_now') ) {
	function yanka_btn_buy_it_now(){
		global $woocommerce, $product;

		$product_id = $product->get_id();

		if( $product->is_in_stock() ) :
			$html = '<form action="'.wc_get_checkout_url().'" method="get">'; 
			$html .= '<button type="submit" class="btn-buy-it-now" id="btn-buy-it-now" disabled>'.esc_html__( 'Buy it now!', 'yanka' ).'</button>'; 
			$html .= '<input type="hidden" name="add-to-cart" value="'.esc_attr( $product_id ).'">'; 
			$html .= '<input type="hidden" name="quantity" class="get_quantity_number" value="1">'; 

			if($product->is_type( 'simple' )) {

			} elseif ($product->is_type( 'variable' )) {
			    $variation_attributes = $product->get_variation_attributes();
			    $html .= '<input type="hidden" name="variation_id" class="get_variation_id" value="0">';
			    if(count($variation_attributes) > 0 && !empty($variation_attributes)) {
			    	foreach ($variation_attributes as $key => $value) {
			    		$key = strtolower($key);
			    		
			    		if(!empty($value[0])) {
			    			$html .= '<input type="hidden" name="attribute_'.esc_attr( $key ).'" class="get_attribute_'.esc_attr( $key ).'" value="'.esc_attr($value[0]).'">';	
			    		} else {
			    			$html .= '<input type="hidden" name="attribute_'.esc_attr( $key ).'" class="get_attribute_'.esc_attr( $key ).'" value="">';	
			    		}
			    		
			    	}
			    }	    
			}

			$html .= '</form>'; 
		    echo html_entity_decode($html);
		endif;
	}	
}

if ( !function_exists('yanka_change_cross_sells_columns') ) {
	add_filter( 'woocommerce_cross_sells_columns', 'yanka_change_cross_sells_columns' ); 
	function yanka_change_cross_sells_columns( $columns ) {
		return 4;
	}
}

if ( !function_exists('yanka_change_cross_sells_product_no') ) {
	add_filter( 'woocommerce_cross_sells_total', 'yanka_change_cross_sells_product_no' );  
	function yanka_change_cross_sells_product_no( $columns ) {
		return 10;
	}
}