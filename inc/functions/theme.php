<?php

if ( ! function_exists( 'yanka_setup' ) ) {
    function yanka_setup() {
	    load_theme_textdomain( 'yanka', get_template_directory() . '/languages' );

	    // Add default posts and comments RSS feed links to head.
	    add_theme_support( 'automatic-feed-links' );
	    add_theme_support( 'title-tag' );
	    add_theme_support( 'post-thumbnails' );
	    add_theme_support( 'woocommerce' );
        add_theme_support( 'custom-background' );
        add_theme_support( 'custom-header' );
        add_theme_support( 'custom-background' );
        // Add theme support for selective refresh for widgets.
        add_theme_support( 'customize-selective-refresh-widgets' );

        add_theme_support( 'woocommerce', array(
            'gallery_thumbnail_image_width' => '600',
        ) );

	    // This theme uses wp_nav_menu() in one location.
	    register_nav_menus( array(
		    'primary-menu'  => esc_html__('Primary Menu', 'yanka'),
            'category-menu' => esc_html__('Vertical Category Menu', 'yanka'),
            'category-menu-1' => esc_html__('Vertical Category Menu Icon - For Header 18', 'yanka'),
            'landing-menu'   => esc_html__('Landing Menu', 'yanka'),
	    ) );

	    /*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	    add_theme_support( 'html5', array(
		   'search-form',
		   'comment-form',
		   'comment-list',
		   'gallery',
		   'caption',
	    ) );

        add_image_size( 'yanka-portfolio-square', 450, 450, 1 );

        add_editor_style(); // add the default style

        if ( ! isset( $content_width ) ) $content_width = 900;
   }
}
add_action( 'after_setup_theme', 'yanka_setup' );

/*
* [ Remove all style woocommerce. ] - - - - - - - - - - - - - - - - - - - -
*/
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/*
* [ Check variable Theme option ] - - - - - - - - - - - - - - - - - - - -
*/
if ( ! function_exists( 'yanka_get_option' ) ) {
	function yanka_get_option($name, $default = '') {
		global $yanka_option;
		if ( isset($yanka_option[$name]) ) {
			return $yanka_option[$name];
		}
		return $default;
	}
}

/* get page config for install sample
/* --------------------------------------------------------------------- */
if( ! function_exists( 'yanka_get_config' ) ) {
    function yanka_get_config() {
        $path = YANKA_PATH . '/inc/admin/configs/pages.php';
        if( file_exists( $path ) ) {
            return include $path;
        } else {
            return array();
        }
    }
}

/* 	Check WooCommerce is activated
/* --------------------------------------------------------------------- */
if ( ! function_exists( 'yanka_woocommerce_activated' ) ) {
	function yanka_woocommerce_activated() {
		return class_exists( 'woocommerce' ) ? true : false;
	}
}

/*
* [ Register Widget Area. ] - - - - - - - - - - - - - - - - - - - -
*/
if ( ! function_exists( 'yanka_register_sidebars' ) ) {
	function yanka_register_sidebars() {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Primary Sidebar', 'yanka' ),
				'id'            => 'primary-sidebar',
				'description'   => esc_html__( 'The Primary Sidebar', 'yanka' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widgettitle">',
				'after_title'   => '</h3>',
			)
		);

        if ( yanka_woocommerce_activated() ) {
            register_sidebar( array(
        		'name'          => esc_html__( 'WooCommerce Sidebar', 'yanka' ),
        		'id'            => 'shop-page',
        		'description'   => esc_html__( 'Add widgets here to appear in shop page sidebar.', 'yanka' ),
        		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        		'after_widget'  => '</aside>',
        		'before_title'  => '<h3 class="widgettitle">',
        		'after_title'   => '<span class="pt-icon"><svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 0.992188L6 5.98947L11 0.992187" stroke="#D0D0D0" stroke-width="1.1"></path></svg></span></h3>',
        	) );

            register_sidebar( array(
        		'name'          => esc_html__( 'WooCommerce Single Product Sidebar', 'yanka' ),
        		'id'            => 'woocommerce-single-product-sidebar',
        		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        		'after_widget'  => '</aside>',
        		'before_title'  => '<h3 class="widgettitle">',
        		'after_title'   => '</h3>',
        	) );
        }

        if ( function_exists('icl_object_id') ) {
            register_sidebar( array(
                'name'          => esc_html__( 'Language', 'yanka' ),
                'id'            => 'language-sidebar',
                'description'   => esc_html__( 'Add widgets wpml to appear languages table.', 'yanka' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h3 class="widgettitle">',
                'after_title'   => '</h3>',
            ) );
        }
        
	}
}
add_action( 'widgets_init', 'yanka_register_sidebars' );

// **********************************************************************//
// ! Text to one-line string
// **********************************************************************//
if( ! function_exists( 'yanka_format_css')) {
	function yanka_format_css( $str ) {
		return trim(preg_replace("/('|\"|\r?\n)/", '', $str));
	}
}

/*
* [ Add a pingback url auto-discovery header for singularly identifiable articles. ] - - - - - - - - - - - - - - - - - - - -
*/
function yanka_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'yanka_pingback_header' );

/*
* [ Adds custom classes to the array of body classes. ] - - - - - - - - - - - - - - - - - - - -
*/

if ( !function_exists('yanka_body_class') ) {
    function yanka_body_class( $classes ) {
        global $post;

        // Get page options
        $options = get_post_meta( get_the_ID(), '_custom_page_options', true );

    	// Adds a class of group-blog to blogs with more than 1 published author.
    	if ( is_multi_author() ) {
    		$classes[] = 'group-blog';
    	}

    	// Adds a class of hfeed to non-singular pages.
    	if ( ! is_singular() ) {
    		$classes[] = 'hfeed';
    	}

        $stickyHeader = yanka_get_option('sticky-header', 0);
        if ( isset($stickyHeader) && $stickyHeader == 1 ) {
    		$classes[] = 'has-sticky-header';
    	}

        $cart_style = yanka_get_option('wc-add-to-cart-style', 'alert');

        if( isset($_GET['cart_design']) && $_GET['cart_design'] != '' ) {
            $cart_style = $_GET['cart_design'];
        }

        if ( isset($cart_style) && $cart_style != 'alert' ) {
    		$classes[] = 'add-to-cart-style-sidebar';
    	} else {
            $classes[] = 'add-to-cart-style-alert';
        }

        $layout = yanka_get_option( 'header-layout', 1 );

        if ( isset( $options['page-header'] ) && $options['page-header'] != '' ) {
            $layout = $options['page-header'];
        }

        if ( isset( $layout ) && $layout == '8' ) {
            $classes[] = 'menu-fix-left';
        }

        $site_width = yanka_get_option('site-width', 'fullwidth');


        if ( isset( $options['page-width'] ) && $options['page-width'] != 'inherit' ){
            $site_width = $options['page-width'];
        }

        if ( $layout !== '8' ) {
            $classes[] = 'wrapper-' . $site_width;
        }

        // Check if under construction page is enabled
        $maintenance_mode = yanka_get_option('maintenance-mode', 0);

        if ( isset($_GET['maintenance']) && $_GET['maintenance'] != '' ) {
            $maintenance_mode = $_GET['maintenance'];
        }

        if ( isset($maintenance_mode) && $maintenance_mode == 1 ) {
            if ( ! is_user_logged_in() ) {
                $classes[] = 'offline';
            }
    	}

    	return $classes;
    }
    add_filter( 'body_class', 'yanka_body_class' );
}


/**
 * Redirect to under construction page
 */
if ( ! function_exists( 'yanka_offline' ) ) {
	function yanka_offline() {
		$maintenance_mode = yanka_get_option('maintenance-mode', 0);

        if ( isset($_GET['maintenance']) && $_GET['maintenance'] != '' ) {
            $maintenance_mode = $_GET['maintenance'];
        }
        
		// Check if under construction page is enabled
		if ( $maintenance_mode) {
			if ( ! is_feed() ) {
				// Check if user is not logged in
				if ( ! is_user_logged_in() ) {
					// Load under construction page
					include get_template_directory() . '/maintenance.php';
					exit;
				}
			}

			// Check if user is logged in
			if ( is_user_logged_in() ) {
				global $current_user;

				// Get user role
				wp_get_current_user();

				$loggedInUserID = $current_user->ID;
				$userData = get_userdata( $loggedInUserID );

				// If user role is not 'administrator' then redirect to under construction page
				if ( 'administrator' != $userData->roles[0] ) {
					if ( ! is_feed() ) {
						include get_template_directory() . '/maintenance.php';
						exit;
					}
				}
			}
		}
	}
}
add_action( 'template_redirect', 'yanka_offline' );

if ( !function_exists('yanka_customize_register') ) {
    function yanka_customize_register() {
        global $wp_customize;
        $wp_customize->remove_section( 'header_image' );  //Modify this line as needed
    }
    add_action( 'customize_register', 'yanka_customize_register', 11 );
}

/*  Custom Javascript
/* --------------------------------------------------------------------- */
if ( ! function_exists('yanka_settings_js') ) {
	function yanka_settings_js() {
        $custom_js       = yanka_get_option( 'custom_js', '' );
        $js_ready        = yanka_get_option( 'js_ready', '' );

		ob_start();

        return ob_get_clean();
	}
}

if ( ! function_exists('yanka_plugin_active') ) {
    function yanka_plugin_active( $plg_class = '', $plg_func = '' ) {
        if($plg_class) return class_exists($plg_class);
        if($plg_func) return function_exists($plg_func);
        return false;
    }
}
