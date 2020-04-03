<?php
    $topbar             = yanka_get_option('show-topbar', 0);
    $showAccount        = yanka_get_option('show-account-box', 1);
    $showSearchForm     = yanka_get_option('show-search-form', 1);
    $showWishlistButton = yanka_get_option('show-wishlist-button', 1);
    $showCartButton     = yanka_get_option('show-cart-button', 1);
    $catalog_mode       = yanka_get_option('catalog-mode', 0);
    $header_menu_align  = yanka_get_option('header-menu-align', 'left');
    $topbar_text  = yanka_get_option('topbar-text', '');
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
    <div class="container">
        <div class="wrap-topbar">
            <div class="topbar-position topbar-left">
                <?php if ( ! empty($topbar_text) ) : ?>
                    <div class="header-block">
                        <?php echo apply_filters( 'yanka_post_meta', '<p>' . $topbar_text . '</p>' ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="wrap-slider">
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
    </div>
</div>
<!-- top-bar -->
<?php endif; ?>

<div class="container">
    <div class="wrap-header">
        <div class="header-position menu-toggle">
            <div class="header-block">
                <div class="menu-button">
                    <svg width="24" height="24" viewBox="0 0 24 24">
                        <use xlink:href="#icon-mobile-menu-toggle"></use>
                    </svg>
                </div>
            </div>
        </div>
        <!-- menu-toggle -->
        <div class="header-position header-left header-logo">
            <div class="header-block">
                <?php yanka_logo(); ?>
            </div>
        </div>
        <!-- main-navigation -->
        <div class="header-position header-right header-action">
            <div class="header-block search-block">
                <div id="header-search" class="yanka-box-dropdown header-search btn-group">
                    <a class="dropdown-hover search-button">
                        <svg class="sl icon-search" width="24" height="24" viewBox="0 0 24 24">
                            <use xlink:href="#icon-search"></use>
                        </svg>                        
                    </a>
                    <!-- pt-search -->
                    <div class="pt-mobile-parent-search pt-parent-box">
                        <div class="pt-search pt-dropdown-obj js-dropdown">
                            <div class="pt-dropdown-menu">
                                <div class="container">
                                    <div class="search-box">
                                        <div class="search-box-content woo-search-mobile">
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
                                    <div class="pt-info-text">
                                        <button class="pt-btn-close">
                                            <svg width="16" height="16" viewBox="0 0 16 16">
                                                <use xlink:href="#icon-close"></use>
                                            </svg>
                                        </button>                                        
                                    </div>                                                   
                                </div>
                            </div>      
                        </div>
                    </div>
                    <!-- /pt-search -->
                </div>
            </div>            
            <?php if ( yanka_woocommerce_activated() && $showCartButton && !$catalog_mode ) : ?>
                <div class="header-block">
                    <?php yanka_header_cart(); ?>
                </div>
            <?php endif; ?>
        </div>
        <!-- header-action -->
    </div>
</div>
