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
    $box_info = yanka_get_option('show-box-info', 0);


    if ( isset($_GET['menu_align']) && $_GET['menu_align'] != '' ) {
        $header_menu_align = $_GET['menu_align'];
    }

    if ( isset($_GET['catalog-mode']) && $_GET['catalog-mode'] == 1 ) {
        $catalog_mode = 1;
    }

?>
<div class="container">
    <div class="wrap-header">

        <div class="header-position header-left block-logo">
            <div class="header-block">
                <?php yanka_logo(); ?>
            </div>
        </div>
        <div class="header-position header-center hidden-xs hidden-sm">
        	

            <div class="header-block">
                <?php if ( has_nav_menu('landing-menu') ) : ?>
                    <div class="header-block">
                        <?php
                            $landingmenu = array(
                                'theme_location'  => 'landing-menu',
                                'container_class' => 'landing-menu-wrapper',
                                'menu_class'      => 'landing-menu',
                                'depth'           => 1
                            );
                            wp_nav_menu( $landingmenu );
                        ?>
                    </div>
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
        <div class="header-position header-right text-right header-action button-intro">
			<div class="header-block">
                <?php yanka_header_single_button_intro(); ?>
            </div>			                      
        </div>
        <!-- header-action -->

        <div class="header-position hidden-lg hidden-md menu-toggle">
            <div class="header-block">
                <div class="menu-button">
                    <svg width="24" height="24" viewBox="0 0 24 24">
                        <use xlink:href="#icon-mobile-menu-toggle"></use>
                    </svg>
                </div>
            </div>
        </div>
        <!-- menu-toggle -->
                
    </div>
</div>