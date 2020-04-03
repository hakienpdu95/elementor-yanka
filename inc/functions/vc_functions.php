<?php
if ( ! class_exists( 'VC_Manager' ) ) return;

$list = array(
    'page',
    'product',
    'portfolio',
    'html_block'
);
vc_set_default_editor_post_types( $list );

/**
 * ------------------------------------------------------------------------------------------------
 * Function to get HTML block content
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'yanka_get_html_block' ) ) {
    function yanka_get_html_block($id) {
        $content = get_post_field('post_content', $id);

        $content = do_shortcode($content);

        $shortcodes_custom_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
        if ( ! empty( $shortcodes_custom_css ) ) {
            $content .= '<style type="text/css" data-type="vc_shortcodes-custom-css">';
            $content .= $shortcodes_custom_css;
            $content .= '</style>';
        }

        return $content;
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * Function to get HTML block content
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'yanka_get_footer_layout' ) ) {
    function yanka_get_footer_layout($id) {
        $content = get_post_field('post_content', $id);

        $content = do_shortcode($content);

        $shortcodes_custom_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
        if ( ! empty( $shortcodes_custom_css ) ) {
            $content .= '<style type="text/css" data-type="vc_shortcodes-custom-css">';
            $content .= $shortcodes_custom_css;
            $content .= '</style>';
        }

        return $content;
    }
}

/**
 * Add icon stroke for vc
 *
 * @return array
 */

if ( !function_exists('yanka_vc_icon_stroke') ) {
    function yanka_vc_icon_stroke( $icons ) {
        $stroke_icons = array(
            array( 'pe-7s-album' => 'Album' ),
            array( 'pe-7s-arc' => 'Arc' ),
            array( 'pe-7s-back-2' => 'Back-2' ),
            array( 'pe-7s-bandaid' => 'Bandaid' ),
            array( 'pe-7s-car' => 'Car' ),
            array( 'pe-7s-diamond' => 'Diamond' ),
            array( 'pe-7s-door-lock' => 'Door-lock' ),
            array( 'pe-7s-eyedropper' => 'Eyedropper' ),
            array( 'pe-7s-female' => 'Female' ),
            array( 'pe-7s-gym' => 'Gym' ),
            array( 'pe-7s-hammer' => 'Hammer' ),
            array( 'pe-7s-headphones' => 'Headphones' ),
            array( 'pe-7s-helm' => 'Helm' ),
            array( 'pe-7s-hourglass' => 'Hourglass' ),
            array( 'pe-7s-leaf' => 'Leaf' ),
            array( 'pe-7s-magic-wand' => 'Magic-wand' ),
            array( 'pe-7s-male' => 'Male' ),
            array( 'pe-7s-map-2' => 'Map-2' ),
            array( 'pe-7s-next-2' => 'Next-2' ),
            array( 'pe-7s-paint-bucket' => 'Paint-bucket' ),
            array( 'pe-7s-pendrive' => 'Pendrive' ),
            array( 'pe-7s-photo' => 'Photo' ),
            array( 'pe-7s-piggy' => 'Piggy' ),
            array( 'pe-7s-plugin' => 'Plugin' ),
            array( 'pe-7s-refresh-2' => 'Refresh-2' ),
            array( 'pe-7s-rocket' => 'Rocket' ),
            array( 'pe-7s-settings' => 'Settings' ),
            array( 'pe-7s-shield' => 'Shield' ),
            array( 'pe-7s-smile' => 'Smile' ),
            array( 'pe-7s-usb' => 'Usb' ),
            array( 'pe-7s-vector' => 'Vector' ),
            array( 'pe-7s-wine' => 'Wine' ),
            array( 'pe-7s-cloud-upload' => 'Cloud-upload' ),
            array( 'pe-7s-cash' => 'Cash' ),
            array( 'pe-7s-close' => 'Close' ),
            array( 'pe-7s-bluetooth' => 'Bluetooth' ),
            array( 'pe-7s-cloud-download' => 'Cloud-download' ),
            array( 'pe-7s-way' => 'Way' ),
            array( 'pe-7s-close-circle' => 'Close-circle' ),
            array( 'pe-7s-id' => 'Id' ),
            array( 'pe-7s-angle-up' => 'Angle-up' ),
            array( 'pe-7s-wristwatch' => 'Wristwatch' ),
            array( 'pe-7s-angle-up-circle' => 'Angle-up-circle' ),
            array( 'pe-7s-world' => 'World' ),
            array( 'pe-7s-angle-right' => 'Angle-right' ),
            array( 'pe-7s-volume' => 'Volume' ),
            array( 'pe-7s-angle-right-circle' => 'Angle-right-circle' ),
            array( 'pe-7s-users' => 'Users' ),
            array( 'pe-7s-angle-left' => 'Angle-left' ),
            array( 'pe-7s-user-female' => 'User-female' ),
            array( 'pe-7s-angle-left-circle' => 'Angle-left-circle' ),
            array( 'pe-7s-up-arrow' => 'Up-arrow' ),
            array( 'pe-7s-angle-down' => 'Angle-down' ),
            array( 'pe-7s-switch' => 'Switch' ),
            array( 'pe-7s-angle-down-circle' => 'Angle-down-circle' ),
            array( 'pe-7s-scissors' => 'Scissors' ),
            array( 'pe-7s-wallet' => 'Wallet' ),
            array( 'pe-7s-safe' => 'Safe' ),
            array( 'pe-7s-volume2' => 'Volume2' ),
            array( 'pe-7s-volume1' => 'Volume1' ),
            array( 'pe-7s-voicemail' => 'Voicemail' ),
            array( 'pe-7s-video' => 'Video' ),
            array( 'pe-7s-user' => 'User' ),
            array( 'pe-7s-upload' => 'Upload' ),
            array( 'pe-7s-unlock' => 'Unlock' ),
            array( 'pe-7s-umbrella' => 'Umbrella' ),
            array( 'pe-7s-trash' => 'Trash' ),
            array( 'pe-7s-tools' => 'Tools' ),
            array( 'pe-7s-timer' => 'Timer' ),
            array( 'pe-7s-ticket' => 'Ticket' ),
            array( 'pe-7s-target' => 'Target' ),
            array( 'pe-7s-sun' => 'Sun' ),
            array( 'pe-7s-study' => 'Study' ),
            array( 'pe-7s-stopwatch' => 'Stopwatch' ),
            array( 'pe-7s-star' => 'Star' ),
            array( 'pe-7s-speaker' => 'Speaker' ),
            array( 'pe-7s-signal' => 'Signal' ),
            array( 'pe-7s-shuffle' => 'Shuffle' ),
            array( 'pe-7s-shopbag' => 'Shopbag' ),
            array( 'pe-7s-share' => 'Share' ),
            array( 'pe-7s-server' => 'Server' ),
            array( 'pe-7s-search' => 'Search' ),
            array( 'pe-7s-film' => 'Film' ),
            array( 'pe-7s-science' => 'Science' ),
            array( 'pe-7s-disk' => 'Disk' ),
            array( 'pe-7s-ribbon' => 'Ribbon' ),
            array( 'pe-7s-repeat' => 'Repeat' ),
            array( 'pe-7s-refresh' => 'Refresh' ),
            array( 'pe-7s-add-user' => 'Add-user' ),
            array( 'pe-7s-refresh-cloud' => 'Refresh-cloud' ),
            array( 'pe-7s-paperclip' => 'Paperclip' ),
            array( 'pe-7s-radio' => 'Radio' ),
            array( 'pe-7s-note2' => 'Note2' ),
            array( 'pe-7s-print' => 'Print' ),
            array( 'pe-7s-network' => 'Network' ),
            array( 'pe-7s-prev' => 'Prev' ),
            array( 'pe-7s-mute' => 'Mute' ),
            array( 'pe-7s-power' => 'Power' ),
            array( 'pe-7s-medal' => 'Medal' ),
            array( 'pe-7s-portfolio' => 'Portfolio' ),
            array( 'pe-7s-like2' => 'Like2' ),
            array( 'pe-7s-plus' => 'Plus' ),
            array( 'pe-7s-left-arrow' => 'Left-arrow' ),
            array( 'pe-7s-play' => 'Play' ),
            array( 'pe-7s-key' => 'Key' ),
            array( 'pe-7s-plane' => 'Plane' ),
            array( 'pe-7s-joy' => 'Joy' ),
            array( 'pe-7s-photo-gallery' => 'Photo-gallery' ),
            array( 'pe-7s-pin' => 'Pin' ),
            array( 'pe-7s-phone' => 'Phone' ),
            array( 'pe-7s-plug' => 'Plug' ),
            array( 'pe-7s-pen' => 'Pen' ),
            array( 'pe-7s-right-arrow' => 'Right-arrow' ),
            array( 'pe-7s-paper-plane' => 'Paper-plane' ),
            array( 'pe-7s-delete-user' => 'Delete-user' ),
            array( 'pe-7s-paint' => 'Paint' ),
            array( 'pe-7s-bottom-arrow' => 'Bottom-arrow' ),
            array( 'pe-7s-notebook' => 'Notebook' ),
            array( 'pe-7s-note' => 'Note' ),
            array( 'pe-7s-next' => 'Next' ),
            array( 'pe-7s-news-paper' => 'News-paper' ),
            array( 'pe-7s-musiclist' => 'Musiclist' ),
            array( 'pe-7s-music' => 'Music' ),
            array( 'pe-7s-mouse' => 'Mouse' ),
            array( 'pe-7s-more' => 'More' ),
            array( 'pe-7s-moon' => 'Moon' ),
            array( 'pe-7s-monitor' => 'Monitor' ),
            array( 'pe-7s-micro' => 'Micro' ),
            array( 'pe-7s-menu' => 'Menu' ),
            array( 'pe-7s-map' => 'Map' ),
            array( 'pe-7s-map-marker' => 'Map-marker' ),
            array( 'pe-7s-mail' => 'Mail' ),
            array( 'pe-7s-mail-open' => 'Mail-open' ),
            array( 'pe-7s-mail-open-file' => 'Mail-open-file' ),
            array( 'pe-7s-magnet' => 'Magnet' ),
            array( 'pe-7s-loop' => 'Loop' ),
            array( 'pe-7s-look' => 'Look' ),
            array( 'pe-7s-lock' => 'Lock' ),
            array( 'pe-7s-lintern' => 'Lintern' ),
            array( 'pe-7s-link' => 'Link' ),
            array( 'pe-7s-like' => 'Like' ),
            array( 'pe-7s-light' => 'Light' ),
            array( 'pe-7s-less' => 'Less' ),
            array( 'pe-7s-keypad' => 'Keypad' ),
            array( 'pe-7s-junk' => 'Junk' ),
            array( 'pe-7s-info' => 'Info' ),
            array( 'pe-7s-home' => 'Home' ),
            array( 'pe-7s-help2' => 'Help2' ),
            array( 'pe-7s-help1' => 'Help1' ),
            array( 'pe-7s-graph3' => 'Graph3' ),
            array( 'pe-7s-graph2' => 'Graph2' ),
            array( 'pe-7s-graph1' => 'Graph1' ),
            array( 'pe-7s-graph' => 'Graph' ),
            array( 'pe-7s-global' => 'Global' ),
            array( 'pe-7s-gleam' => 'Gleam' ),
            array( 'pe-7s-glasses' => 'Glasses' ),
            array( 'pe-7s-gift' => 'Gift' ),
            array( 'pe-7s-folder' => 'Folder' ),
            array( 'pe-7s-flag' => 'Flag' ),
            array( 'pe-7s-filter' => 'Filter' ),
            array( 'pe-7s-file' => 'File' ),
            array( 'pe-7s-expand1' => 'Expand1' ),
            array( 'pe-7s-exapnd2' => 'Exapnd2' ),
            array( 'pe-7s-edit' => 'Edit' ),
            array( 'pe-7s-drop' => 'Drop' ),
            array( 'pe-7s-drawer' => 'Drawer' ),
            array( 'pe-7s-download' => 'Download' ),
            array( 'pe-7s-display2' => 'Display2' ),
            array( 'pe-7s-display1' => 'Display1' ),
            array( 'pe-7s-diskette' => 'Diskette' ),
            array( 'pe-7s-date' => 'Date' ),
            array( 'pe-7s-cup' => 'Cup' ),
            array( 'pe-7s-culture' => 'Culture' ),
            array( 'pe-7s-crop' => 'Crop' ),
            array( 'pe-7s-credit' => 'Credit' ),
            array( 'pe-7s-copy-file' => 'Copy-file' ),
            array( 'pe-7s-config' => 'Config' ),
            array( 'pe-7s-compass' => 'Compass' ),
            array( 'pe-7s-comment' => 'Comment' ),
            array( 'pe-7s-coffee' => 'Coffee' ),
            array( 'pe-7s-cloud' => 'Cloud' ),
            array( 'pe-7s-clock' => 'Clock' ),
            array( 'pe-7s-check' => 'Check' ),
            array( 'pe-7s-chat' => 'Chat' ),
            array( 'pe-7s-cart' => 'Cart' ),
            array( 'pe-7s-camera' => 'Camera' ),
            array( 'pe-7s-call' => 'Call' ),
            array( 'pe-7s-calculator' => 'Calculator' ),
            array( 'pe-7s-browser' => 'Browser' ),
            array( 'pe-7s-box2' => 'Box2' ),
            array( 'pe-7s-box1' => 'Box1' ),
            array( 'pe-7s-bookmarks' => 'Bookmarks' ),
            array( 'pe-7s-bicycle' => 'Bicycle' ),
            array( 'pe-7s-bell' => 'Bell' ),
            array( 'pe-7s-battery' => 'Battery' ),
            array( 'pe-7s-ball' => 'Ball' ),
            array( 'pe-7s-back' => 'Back' ),
            array( 'pe-7s-attention' => 'Attention' ),
            array( 'pe-7s-anchor' => 'Anchor' ),
            array( 'pe-7s-albums' => 'Albums' ),
            array( 'pe-7s-alarm' => 'Alarm' ),
            array( 'pe-7s-airplay' => 'Airplay' ),
        );

        return array_merge( $icons, $stroke_icons );
    }
    add_filter( 'vc_iconpicker-type-stroke', 'yanka_vc_icon_stroke' );
}


/**
 * Enqueue stylesheets and scripts in admin.
 *
 * @return  void
 */

if ( ! function_exists('yanka_vc_enqueue_scripts') ) {
    function yanka_vc_enqueue_scripts() {
        if ( ! function_exists( 'vc_editor_post_types' ) ) {
            return;
        }

        // Get post type enabled for editing with Visual Composer.
        $types = vc_editor_post_types();

        // Check if current post type is enabled
        global $post;

        if ( isset( $post->post_type ) && in_array( $post->post_type, $types ) ) {
            wp_enqueue_style( 'font-stroke', get_template_directory_uri() . '/assets/3rd-party/font-stroke/css/pe-icon-7-stroke.css' );
        }

    }
    add_action( 'admin_enqueue_scripts', 'yanka_vc_enqueue_scripts' );
}

// Removing frontend editor
if(function_exists('vc_disable_frontend')){
    vc_disable_frontend();
}

/**
 * Enqueue stylesheets and scripts in admin.
 *
 * @return  void
 */

if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_yanka_google_map extends WPBakeryShortCodesContainer {

    }
}

if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_testimonials extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_testimonial extends WPBakeryShortCode {

    }
}

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if( class_exists( 'WPBakeryShortCodesContainer' ) ){
    class WPBakeryShortCode_pricing_tables extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if( class_exists( 'WPBakeryShortCode' ) ){
    class WPBakeryShortCode_pricing_plan extends WPBakeryShortCode {

    }
}


//Creat tab product

if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_jms_product_tabs extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_jms_product_tab extends WPBakeryShortCode {

    }
}

//For param: ID default value filter
add_filter( 'vc_form_fields_render_field_yanka_products_id_param_value', 'productIdDefaultValue', 10, 4 );

/**
 * Suggester for autocomplete by id/name/title/sku
 * @since 4.4
 *
 * @param $query
 *
 * @return array - id's from products with title/sku.
 */

if ( !function_exists('productIdAutocompleteSuggester') ) {
    function productIdAutocompleteSuggester( $query ) {
        global $wpdb;
        $product_id = (int) $query;
        $post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.ID AS id, a.post_title AS title, b.meta_value AS sku
                    FROM {$wpdb->posts} AS a
                    LEFT JOIN ( SELECT meta_value, post_id  FROM {$wpdb->postmeta} WHERE `meta_key` = '_sku' ) AS b ON b.post_id = a.ID
                    WHERE a.post_type = 'product' AND ( a.ID = '%d' OR b.meta_value LIKE '%%%s%%' OR a.post_title LIKE '%%%s%%' )", $product_id > 0 ? $product_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

        $results = array();
        if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
            foreach ( $post_meta_infos as $value ) {
                $data = array();
                $data['value'] = $value['id'];
                $data['label'] = esc_html__( 'Id', 'yanka' ) . ': ' . $value['id'] . ( ( strlen( $value['title'] ) > 0 ) ? ' - ' . esc_html__( 'Title', 'yanka' ) . ': ' . $value['title'] : '' ) . ( ( strlen( $value['sku'] ) > 0 ) ? ' - ' . esc_html__( 'Sku', 'yanka' ) . ': ' . $value['sku'] : '' );
                $results[] = $data;
            }
        }

        return $results;
    }
    add_filter( 'vc_autocomplete_yanka_products_id_callback', 'productIdAutocompleteSuggester', 10, 1 );
}

/**
 * Find product by id
 * @since 4.4
 *
 * @param $query
 *
 * @return bool|array
 */

if ( ! function_exists('productIdAutocompleteRender') ) {
    function productIdAutocompleteRender( $query ) {
        $query = trim( $query['value'] ); // get value from requested
        if ( ! empty( $query ) ) {
            // get product
            $product_object = wc_get_product( (int) $query );
            if ( is_object( $product_object ) ) {
                $product_sku = $product_object->get_sku();
                $product_title = $product_object->get_title();
                $product_id = $product_object->get_id();

                $product_sku_display = '';
                if ( ! empty( $product_sku ) ) {
                    $product_sku_display = ' - ' . esc_html__( 'Sku', 'yanka' ) . ': ' . esc_html( $product_sku );
                }

                $product_title_display = '';
                if ( ! empty( $product_title ) ) {
                    $product_title_display = ' - ' . esc_html__( 'Title', 'yanka' ) . ': ' . esc_html( $product_title );
                }

                $product_id_display = esc_html__( 'Id', 'yanka' ) . ': ' . esc_html( $product_id );

                $data = array();
                $data['value'] = $product_id;
                $data['label'] = $product_id_display . $product_title_display . $product_sku_display;

                return ! empty( $data ) ? $data : false;
            }

            return false;
        }

        return false;
    }
    add_filter( 'vc_autocomplete_yanka_products_id_render', 'productIdAutocompleteRender', 10, 1 );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Add options to columns
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'yanka_update_vc_column' ) ) {
    function yanka_update_vc_column() {
        if( !function_exists('vc_map') ) return;
        vc_add_param( 'vc_column', array(
            'type'        => 'checkbox',
            'group'       => esc_html__( 'Yanka Extras', 'yanka' ),
            'heading'     => esc_html__( 'Enable sticky column', 'yanka' ),
            'description' => esc_html__( 'Also enable equal columns height for the parent row to make it work', 'yanka' ),
            'param_name'  => 'yanka_sticky_column'
        ) );
    }
    add_action( 'init', 'yanka_update_vc_column');
}


if( ! function_exists( 'yanka_vc_extra_classes' ) ) {

    if( defined( 'VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG' ) ) {
        add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'yanka_vc_extra_classes', 30, 3 );
    }

    function yanka_vc_extra_classes( $class, $base, $atts ) {
        if( ! empty( $atts['yanka_sticky_column'] ) ) {
            $class .= ' yanka-sticky-column';
        }

        return $class;
    }

}

/**
 * Custom row for visual composer.
 */

if ( ! function_exists('yanka_vc_add_params_to_row') ) {
    function yanka_vc_add_params_to_row() {
        vc_add_params(
            'vc_row',
            array(
                array(
                    'heading'     => esc_html__( 'Row stretch', 'yanka' ),
                    'description' => esc_html__( 'If checked row will be set to full width.', 'yanka' ),
                    'type'        => 'dropdown',
                    'param_name'  => 'full_width',
                    'value'       => array(
                        esc_html__( 'Default', 'yanka' )                                => '',
                        esc_html__( 'Stretch row', 'yanka' )                            => 'stretch_row',
                        esc_html__( 'Stretch row and content (no paddings)', 'yanka' )  => 'stretch_row_content_no_spaces',
                        esc_html__( 'Stretch wide', 'yanka' )                           => 'stretch_row_wide',
                        esc_html__( 'Stretch wide container', 'yanka' )                 => 'stretch_row_wide_container',
                    ),
                ),
            )
        );
    }
    add_action( 'vc_after_init', 'yanka_vc_add_params_to_row' );
}