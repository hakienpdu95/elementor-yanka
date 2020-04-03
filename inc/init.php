<?php
/*
* [ Theme Functions. ] - - - - - - - - - - - - - - - - - - - -
*/
require YANKA_PATH . '/inc/functions/theme.php';
require YANKA_PATH . '/inc/functions/helpers.php';
if ( class_exists( 'VC_Manager' ) ) require YANKA_PATH . '/inc/functions/vc_functions.php';

/*
* [ WooCommerce Customizer. ] - - - - - - - - - - - - - - - - - - - -
*/
if ( yanka_woocommerce_activated() ) require YANKA_PATH . '/inc/functions/woocommerce.php';

/*
* [ Theme Options. ] - - - - - - - - - - - - - - - - - - - -
*/
if ( class_exists ( 'ReduxFramework' ) ) {
    require YANKA_PATH . '/inc/admin/theme-options.php';
}
require YANKA_PATH . '/inc/admin/tgm-functions.php';
require YANKA_PATH . '/inc/selectors.php';
