<?php
    $topbar             = yanka_get_option('show-topbar', 0);
    $showAccount        = yanka_get_option('show-account-box', 1);
    $showSearchForm     = yanka_get_option('show-search-form', 1);
    $showWishlistButton = yanka_get_option('show-wishlist-button', 1);
    $showCompareButton = yanka_get_option('show-compare-button', 1);
    $showCartButton     = yanka_get_option('show-cart-button', 1);
    $catalog_mode       = yanka_get_option('catalog-mode', 0);
    $header_menu_align  = yanka_get_option('header-menu-align', 'left');
    $topbar_text  = yanka_get_option('topbar-text', '');
    $contact_text  = yanka_get_option('contact-text', '');
    $topbar_color = yanka_get_option('topbar-text-color', 'light');
    $showLanguage = yanka_get_option('show-language-box', 0);
    $showCurrency = yanka_get_option('show-currency-box', 0);
    $header_design = yanka_get_option('header-layout', 1);
    $box_info = yanka_get_option('show-box-info', 0);
    
    if ( isset($_GET['menu_align']) && $_GET['menu_align'] != '' ) {
        $header_menu_align = $_GET['menu_align'];
    }

    if ( isset($_GET['catalog-mode']) && $_GET['catalog-mode'] == 1 ) {
        $catalog_mode = 1;
    }

?>

<?php if ( isset($topbar) && $topbar == 1 ) : ?>
<div class="topbar <?php echo 'color-scheme-' . esc_attr( $topbar_color ); ?>">
    <div class="container-fluid">
        <div class="pt-header-row pt-top-row no-gutters">
            <div class="pt-col-left col-lg-3 col-md-12 col-sm-12 col-xs-12 topbar-left">
                <?php if ( ! empty($topbar_text) ) : ?>
                    <div class="header-block">
                        <?php echo apply_filters( 'yanka_post_meta', '<p>' . $topbar_text . '</p>' ); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="pt-col-center col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <?php if($box_info == 1) : ?>
                    <div class="pt-box-info">
                        <ul class="js-header-slider pt-slider-smoothhiding">
                            <?php yanka_box_info_1(); ?>
                            <?php yanka_box_info_2(); ?>
                            <?php yanka_box_info_3(); ?>                     
                        </ul>                        
                    </div>
                    <?php endif; ?>
            </div>
            <div class="pt-col-right col-lg-3 ml-auto topbar-right topbar-social hidden-md hidden-xs hidden-sm">                
                <div class="header-block">
                    <?php yanka_social(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- top-bar -->
<?php endif; ?>

<div class="container-fluid">
    <div class="wrap-header">
        <div class="header-position hidden-lg menu-toggle">
            <div class="header-block">
                <div class="menu-button">
                    <svg width="24" height="24" viewBox="0 0 24 24">
                        <use xlink:href="#icon-mobile-menu-toggle"></use>
                    </svg>
                </div>
            </div>
        </div>
        <!-- menu-toggle -->
        <div class="header-position header-left block-logo">
            <div class="header-block">
                <?php yanka_logo(); ?>
            </div>
        </div>
        <div class="header-position header-center hidden-md hidden-xs hidden-sm box-search">
            <div class="header-block">
                <div id="header-search-7" class="header-search btn-group mt-svg woo-search">
                    <?php
                    if ( class_exists('WooSearch_Widget') || class_exists('WooSearch_Front') ) {
                        echo do_shortcode('[woocommerce_ajax_search]');
                    } else {
                        get_search_form();
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- main-navigation -->
        <div class="header-position header-right text-right header-action block-action">
            <?php if ( yanka_woocommerce_activated() && $showAccount == 1 ) : ?>
                <div class="header-block account-icon hidden-md hidden-sm hidden-xs">
                    <?php echo yanka_my_account(); ?>
                </div>
            <?php endif; ?>

            <?php if( $showCompareButton && yanka_woocommerce_activated() && class_exists('YITH_Woocompare') ) :?>
                <div class="header-block hidden-md hidden-sm hidden-xs">
                    <?php yanka_compare(); ?>
                </div>
            <?php endif; ?>

            <?php if ( $showWishlistButton && yanka_woocommerce_activated() && class_exists( 'YITH_WCWL' ) ) : ?>
                <div class="header-block hidden-md hidden-sm hidden-xs">
                    <?php yanka_wishlist(); ?>
                </div>
            <?php endif; ?>            

            <?php if ( yanka_woocommerce_activated() && $showCartButton && !$catalog_mode ) : ?>
                <div class="header-block">
                    <?php yanka_header_cart(); ?>
                </div>
            <?php endif; ?>
            <?php if ( $showLanguage == 1 ): ?>
                <div class="header-block hidden-md hidden-sm hidden-xs">
                    <?php echo yanka_language(); ?>
                </div>
            <?php endif; ?> 
            <?php if ( yanka_woocommerce_activated() && class_exists('Jms_Currency') && $showCurrency == 1 ) : ?>
                <div class="header-block hidden-md hidden-sm hidden-xs">
                    <?php echo yanka_currency(); ?>
                </div>
            <?php endif; ?>                       
        </div>
        <!-- header-action -->
    </div>
</div>

<div class="header-menu hidden-md hidden-xs hidden-sm">
    <div class="container-fluid">
        <div class="wrap-header menu-header-7">
            <div class="header-position header-left">
                <div class="header-block">
                    <?php if ( has_nav_menu('primary-menu') ) : ?>
                        <?php
                            if ( class_exists('Yanka_Megamenu_Walker') ) {
                                $menu = array(
                                    'theme_location'  => 'primary-menu',
                                    'container_class' => 'primary-menu-wrapper',
                                    'menu_class'      => 'yanka-menu primary-menu menu-center',
                                    'walker'          => new Yanka_Megamenu_Walker,
                                );
                            } else {
                                $menu = array(
                                    'theme_location'  => 'primary-menu',
                                    'container_class' => 'primary-menu-wrapper',
                                    'menu_class'      => 'yanka-menu primary-menu menu-center',
                                );
                            }

                            wp_nav_menu( $menu );
                        ?>
                    <?php else : ?>
                        <div class="primary-menu-wrapper">
                            <ul class="yanka-menu primary-menu menu-<?php echo esc_attr($header_menu_align); ?>">
                                <li><a href="<?php echo esc_url(home_url( '/' )) . 'wp-admin/nav-menus.php?action=locations'; ?>"><?php esc_html_e( 'Select or create a menu', 'yanka' ) ?></a></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>                
            </div>

            <div class="header-position header-right header-action">
                <div class="header-block">
                    <?php yanka_header_single_button(); ?>
                </div>
            </div>
        </div>

    </div>
</div>