<?php
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
    


    if ( isset($_GET['menu_align']) && $_GET['menu_align'] != '' ) {
        $header_menu_align = $_GET['menu_align'];
    }

    if ( isset($_GET['catalog-mode']) && $_GET['catalog-mode'] == 1 ) {
        $catalog_mode = 1;
    }

?>
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
        <div class="header-position header-center hidden-md hidden-xs hidden-sm">
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
        <!-- main-navigation -->
        <div class="header-position header-right text-right header-action block-action">
            
            <div class="header-block search-block desctop">
                <div id="header-search-12" class="yanka-box-dropdown header-search btn-group">
                    <a class="dropdown-hover search-button">
                        <svg class="sl icon-search" width="24" height="24" viewBox="0 0 24 24">
                            <use xlink:href="#icon-search"></use>
                        </svg>                        
                    </a>
                    <!-- pt-search -->
                    <div class="pt-desctop-parent-search pt-parent-box">
                        <div class="pt-search pt-dropdown-obj js-dropdown">
                            <div class="pt-dropdown-menu">
                                <div class="container">
                                    <div class="pt-info-text">
                                        <?php echo esc_html__('What are you Looking for?', 'yanka'); ?>
                                        <button class="pt-btn-close">
                                            <svg width="16" height="16" viewBox="0 0 16 16">
                                                <use xlink:href="#icon-close"></use>
                                            </svg>
                                        </button>                                        
                                    </div>
                                    <div class="search-box">
                                        <div class="search-box-content">
                                            <?php
                                            if ( class_exists('WooSearch_Widget') || class_exists('WooSearch_Front') ) {
                                                echo do_shortcode('[woocommerce_ajax_search]');
                                            } else {
                                                get_search_form();
                                            }
                                            ?>
                                            <div class="close-search-popup"></div>
                                        </div>
                                    </div>                
                                </div>
                            </div>      
                        </div>
                    </div>
                    <!-- /pt-search -->
                </div>
            </div>

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