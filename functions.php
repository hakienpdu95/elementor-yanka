<?php
/**
 * Theme constants definition and functions.
*/

// Constants definition
define( 'YANKA_PATH', get_template_directory()     );
define( 'YANKA_URL',  get_template_directory_uri() );
define( 'YANKA_DUMMY',  YANKA_PATH . '/inc/admin/data' );
define( 'YANKA_VERSION', '1.0.0' );


/**
 * ------------------------------------------------------------------------------------------------
 * Enqueue styles
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'yanka_enqueue_styles' ) ) {
    function yanka_enqueue_styles() {
        wp_dequeue_style( 'yith-wcwl-font-awesome' );
        // Add custom fonts, used in the main stylesheet.
        wp_enqueue_style( 'yanka-fonts', yanka_enqueue_google_fonts(), array(), null );
        wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/3rd-party/bootstrap/css/bootstrap.min.css', array(), '3.3.7');
        wp_enqueue_script( 'waypoint', get_template_directory_uri() . '/assets/3rd-party/jquery.waypoints.min.js', array(), '4.0.1', true);
        wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/3rd-party/font-awesome/css/font-awesome.min.css', array(), '4.7.0' );
        wp_enqueue_style( 'simple-line-icons', get_template_directory_uri() . '/assets/3rd-party/simple-line-icons/simple-line-icons.css', array(), '' );
        wp_enqueue_style( 'font-stroke', get_template_directory_uri() . '/assets/3rd-party/font-stroke/css/pe-icon-7-stroke.css' );
        wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/assets/3rd-party/owl-carousel/owl.carousel.min.css', array(), '2.0.0' );
        wp_enqueue_style( 'owl-carousel-theme', get_template_directory_uri() . '/assets/3rd-party/owl-carousel/owl.theme.default.min.css' );
        wp_enqueue_style( 'slick', get_template_directory_uri() . '/assets/3rd-party/slick/slick.css' );
        wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/assets/3rd-party/magnific-popup/magnific-popup.css' );
        wp_enqueue_style( 'magnific-popup-effect', get_template_directory_uri() . '/assets/3rd-party/magnific-popup/magnific-popup-effect.css' );

        $page_transition = yanka_get_option('page-transition', '');
        if ( isset($page_transition) && $page_transition != '' ) {
            wp_enqueue_style( 'animsition', get_template_directory_uri() . '/assets/3rd-party/animsition/css/animsition.css' );
        }


        // Main stylesheet
        wp_enqueue_style( 'yanka-style', get_template_directory_uri() . '/style.css');
        
        if( isset( $_GET['rtl'] ) && (int) $_GET['rtl'] == 1 ) {
            wp_enqueue_style( 'yanka-rtl-style', get_template_directory_uri() . '/style-rtl.css');
        }        
    }
    add_action( 'wp_enqueue_scripts', 'yanka_enqueue_styles', 15 );
}

if( ! function_exists( 'yanka_inline_enqueue_scripts' ) ) {
    function yanka_inline_enqueue_scripts() {
        wp_register_style( 'css-inline', false );
        wp_enqueue_style( 'css-inline' );
        
        global $post;

        $options = get_post_meta( get_the_ID(), '_custom_page_options', true );

        //add css for footer, header templates
        $jscomposer_templates_args = array(
            'orderby'          => 'title',
            'order'            => 'ASC',
            'post_type'        => 'footerlayout',
            'post_status'      => 'publish',
            'posts_per_page'   => 30,
        );
        $jscomposer_templates = get_posts( $jscomposer_templates_args );
        $footer_layout = yanka_get_option('footer-layout');
        if ( isset( $options['page-footer'] ) && $options['page-footer'] != '' ) {
            $footer_layout = $options['page-footer'];
        }

        if (count($jscomposer_templates) > 0) {
            foreach($jscomposer_templates as $jscomposer_template){
                if( $jscomposer_template->post_title == $footer_layout){
                    $jscomposer_template_css = get_post_meta ( $jscomposer_template->ID, '_wpb_shortcodes_custom_css', false );
                    if ( ! empty( $jscomposer_template_css ) ) {
                        wp_add_inline_style( 'css-inline', $jscomposer_template_css[0] );
                    }
                }
            }
        }

        // background color

        if ( isset( $options['body-bg-color'] ) && $options['body-bg-color'] != '' && ($options['background-body'] == true) ) {
            $custom_css = "
                    body {
                        background-color: {$options['body-bg-color']} !important;
                    }";
            wp_add_inline_style( 'css-inline', $custom_css );
        }

        if ( isset( $options['pagehead-bg-color'] ) && $options['pagehead-bg-color'] != '' ) {
            $custom_css = "
                    .page-heading {
                        background-color: {$options['pagehead-bg-color']} !important;
                    }";
            wp_add_inline_style( 'css-inline', $custom_css );
        }


        //Background Image
        if ( isset( $options['body-bg'] ) && $options['body-bg'] != '' && ($options['background-body'] == true) ) {
            $image_id = $options['body-bg'];
            $bg_image = wp_get_attachment_image_src( $image_id, 'full' );
            if ( isset($bg_image) && $bg_image != '' ) {
                $custom_css = "
                        body {
                            background-image: url({$bg_image[0]}) !important;
                        }";
                wp_add_inline_style( 'css-inline', $custom_css );
            }
        }

        if ( isset( $options['pagehead-bg'] ) && $options['pagehead-bg'] != '' ) {
            $image_id = $options['pagehead-bg'];
            $bg_image = wp_get_attachment_image_src( $image_id, 'full' );

            if ( isset($bg_image) && $bg_image != '' ) {
                $custom_css = "
                        .page-heading {
                            background-image: url({$bg_image[0]}) !important;
                        }";
                wp_add_inline_style( 'css-inline', $custom_css );
            }
        }

        if( yanka_woocommerce_activated() && is_product_category() ) {
            $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            if ( isset($term->term_id) && $term->term_id != '' ) {
                $term_options = get_term_meta( $term->term_id, '_custom_product_cat_options', true );
            }

            if ( isset( $term_options ) && $term_options && $term_options['product-cat-bg']['color'] != '' ) {
                $custom_css = "
                    .page-heading {
                        background-color: {$term_options['product-cat-bg']['color']};
                    }";
                wp_add_inline_style( 'css-inline', $custom_css );
            }

            if ( isset( $term_options ) && $term_options && $term_options['product-cat-bg']['image'] != '' ) {
                $custom_css = "
                    .page-heading {
                        background-image: url({$term_options['product-cat-bg']['image']}) !important;
                    }";
                wp_add_inline_style( 'css-inline', $custom_css );
            }
        }
        wp_add_inline_style( 'css-inline', yanka_custom_inline_css() );
    }
    add_action( 'wp_enqueue_scripts', 'yanka_inline_enqueue_scripts', 25 );
}

if( ! function_exists( 'yanka_enqueue_scripts' ) ) {
    function yanka_enqueue_scripts() {
        global $post;
        $elementor_page = get_post_meta( $post->ID, '_elementor_edit_mode', true );
        // Load required scripts.
        wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/3rd-party/bootstrap/js/bootstrap.min.js', array(), '3.3.7', true);
        wp_enqueue_script( 'isotope-pkgd' , get_template_directory_uri() . '/assets/3rd-party/isotope/isotope.pkgd.min.js', array(), false, true  );
        wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/3rd-party/slick/slick.js', array(), '1.6.0', true );
        wp_enqueue_script( 'theia-sticky-sidebar', get_template_directory_uri() . '/assets/3rd-party/theia-sticky-sidebar/theia-sticky-sidebar.js', array(), false, true );
        wp_enqueue_script( 'magnific-popup' , get_template_directory_uri() . '/assets/3rd-party/magnific-popup/jquery.magnific-popup.min.js', array(), false, true  );
        wp_enqueue_script( 'jquery-tweenmax', get_template_directory_uri() . '/assets/3rd-party/panr/TweenMax.js', array(), '', true );
        wp_enqueue_script( 'jquery-panr', get_template_directory_uri() . '/assets/3rd-party/panr/jquery.panr.js', array(), '', true );
        if (( !!$elementor_page && ( $post && preg_match( '/countdown="yes"/', $post->post_content ) )  ) || ( !!$elementor_page && ( $post && preg_match( '/yanka_countdown/', $post->post_content ) )  ) || ( is_singular( 'product' ) ) ) {
            wp_enqueue_script( 'countdown' , get_template_directory_uri() . '/assets/3rd-party/jquery.countdown.min.js', array(), false, true  );
            wp_enqueue_script( 'moment', get_template_directory_uri() . '/assets/3rd-party/moment.min.js', array( 'jquery' ), '', true );
            wp_enqueue_script( 'moment-timezone', get_template_directory_uri() . '/assets/3rd-party/moment-timezone-with-data.min.js', array( 'jquery' ), '', true );
        }
        wp_enqueue_script( 'parallax', get_template_directory_uri() . '/assets/3rd-party/parallax.js', array( 'jquery' ), '', true );
        wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/assets/3rd-party/owl-carousel/owl.carousel.min.js', array(), '2.2.0', true );
        wp_enqueue_script( 'equal-height', get_template_directory_uri() . '/assets/3rd-party/jquery.equal-height.js', array(), '1.0', true );
        wp_enqueue_script( 'resize-sensor', get_template_directory_uri() . '/assets/3rd-party/ResizeSensor.js', array(), false, true );
        wp_enqueue_script( 'sticky-sidebar', get_template_directory_uri() . '/assets/3rd-party/sticky-sidebar.js', array(), false, true );
        
        wp_dequeue_script( 'default-js' );

        if ( yanka_woocommerce_activated() ) {
            wp_enqueue_script( 'wc-add-to-cart-variation' );
            wp_enqueue_script( 'jquery-ui-autocomplete' );
            if ( is_shop() ){
                wp_enqueue_script( 'yanka-shop-filter', get_template_directory_uri() . '/assets/js/shop-filter.js', array(), false, true );
            }

            // Zoom image
            if ( is_singular( 'product' ) ) {
                wp_enqueue_script( 'zoom' );
                wp_register_script( 'threesixty', get_template_directory_uri() . '/assets/3rd-party/threesixty/threesixty.min.js', array(), '', true );
            }

            if( is_product() || is_singular( 'product' ) ) {
                wp_enqueue_script( 'sticky-addcart', get_template_directory_uri() . '/assets/3rd-party/theia-sticky-addtocart.js', array(), false, true );  
            }
        }

        $page_transition = yanka_get_option('page-transition', '');
        if ( isset($page_transition) && $page_transition != '' ) {
            wp_enqueue_script( 'animsition', get_template_directory_uri() . '/assets/3rd-party/animsition/js/animsition.min.js', array(), false, true );
        }

        // Load theme js
        wp_enqueue_script('yanka-theme', get_template_directory_uri() . '/assets/js/theme.js', array( 'jquery', 'imagesloaded' ), false, true);
        wp_add_inline_script('yanka-theme', yanka_settings_js(), 'after' );

        // Custom localize script
        wp_localize_script( 'yanka-theme', 'yanka_settings',
            array(
                'ajaxurl'          => esc_url(admin_url('admin-ajax.php')),
                'ajax_add_to_cart' => apply_filters( 'yanka_ajax_add_to_cart', true ),
                '_nonce_yanka'     => wp_create_nonce('bb_yanka'),
                'JmsSiteURL'       => esc_url(get_option('siteurl')),
                'added_to_cart'    => esc_html__( 'Product was successfully added to your cart.', 'yanka' ),
                'View Wishlist'    => esc_html__( 'View Wishlist', 'yanka' ),
                'viewall_wishlist' => esc_html__( 'View all', 'yanka' ),
                'removed_notice'   => esc_html__( '%s has been removed from your cart.', 'yanka' ),
                'load_more'        => esc_html__( 'Load more', 'yanka' ),
                'loading'          => esc_html__( 'Loading...', 'yanka' ),
                'no_more_item'     => esc_html__( 'All items loaded', 'yanka' ),
                'days'             => esc_html__( 'Day', 'yanka' ),
                'hours'            => esc_html__( 'Hrs', 'yanka' ),
                'mins'             => esc_html__( 'Min', 'yanka' ),
                'secs'             => esc_html__( 'Sec', 'yanka' ),
                'permalink'        => ( get_option( 'permalink_structure' ) == '' ) ? 'plain' : '',
            )
        );

        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }
    add_action( 'wp_enqueue_scripts', 'yanka_enqueue_scripts', 10000 );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Enqueue google fonts
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'yanka_enqueue_google_fonts' ) ) {
    function yanka_enqueue_google_fonts() {
        $fonts_url = '';

        $primary_font = _x( 'on', 'Libre Franklin: on or off', 'yanka' );

        if ( 'off' !== $primary_font ) {
            $font_families = array();
            $font_families[] = 'Libre Franklin:300,400,400i,500,600,700';

            $query_args = array(
                'family' => urlencode( implode( '|', $font_families ) ),
                'subset' => urlencode( 'latin,latin-ext' ),
            );

            $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

        }  

        return esc_url_raw( $fonts_url );
    }
}

remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );

// Initialize core file
require YANKA_PATH . '/inc/init.php';

if( ! function_exists('yanka_script_admin') ) {
    function yanka_script_admin() {
        wp_enqueue_style( 'yanka-custom-wp-admin', get_template_directory_uri() . '/assets/css/admin-style.css', false, '1.0.0' );
    }
    add_action('admin_enqueue_scripts', 'yanka_script_admin');
}



// Require ReduxFramework
function yanka_addons_custom_css_redux() {
    wp_register_style(
        'redux-custom-css',
        YANKA_URL . '/assets/css/redux-framework.css',
        array( 'redux-admin-css' ),
        time(),
        'all'
    );
    wp_enqueue_style('redux-custom-css');
}
add_action( 'redux/page/yanka_option/enqueue', 'yanka_addons_custom_css_redux' );

// load admin dashboard
require_once get_template_directory() . '/inc/admin/admin.php';

add_filter('shoppable_images_capability', function($capability) {
   if(current_user_can('manage_options'))
      return 'manage_options'; // To allow admins to also edit the hours.
   return 'manage_shoppable_images';
});
 
remove_role('manage_shoppable_images');
add_role('manage_shoppable_images','Shoppable Images Manager', array(
   'read' => true,
   'edit_posts' => true,
   'manage_shoppable_images' => true,
));
 
add_filter('option_page_capability_mabel-shoppable-images','set_si_options_capability');
function set_si_options_capability($capa){
    if(current_user_can('manage_options'))
        return $capa;
    return 'manage_shoppable_images';
}

// Load RTL
function enqueue_theme_files() { 
    wp_enqueue_style( 'yanka-rtl-style', get_stylesheet_uri() ); 
    wp_style_add_data( 'yanka-rtl-style', 'rtl', 'replace' ); 
} 
add_action( 'wp_enqueue_scripts', 'enqueue_theme_files' , 16);


if( ! function_exists( 'yanka_filter_language_attributes' ) ) {
   function yanka_filter_language_attributes( $output, $doctype ) { 
        if( isset( $_GET['rtl'] ) && (int) $_GET['rtl'] == 1 ) {
            $output .=  ' dir="rtl"'; 
        }
        return $output; 
    }; 
    add_filter( 'language_attributes', 'yanka_filter_language_attributes', 10, 2 ); 
}


if( ! function_exists( 'yanka_body_dir_class' ) ) {
    function yanka_body_dir_class( $classes ) {
        if( isset( $_GET['rtl'] ) && (int) $_GET['rtl'] == 1 ) {
            $classes[] = 'rtl';
        }
        return $classes;
    }  
    add_filter( 'body_class', 'yanka_body_dir_class' );    
}
