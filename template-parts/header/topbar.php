<?php
$topbar       = yanka_get_option('topbar', 0);
$topbar_text  = yanka_get_option('topbar-text', '');
$topbar_color = yanka_get_option('topbar-text-color', 'light');
$showLanguage = yanka_get_option('show-language-box', 0);
$showCurrency = yanka_get_option('show-currency-box', 0);
$header_design = yanka_get_option('header-layout', 1);

global $post;

// Get page options
$options = get_post_meta( get_the_ID(), '_custom_page_options', true );

if ( (isset( $options['disable-topbar'] ) && $options['disable-topbar'] == 1) || (isset( $options['page-header'] ) && $options['page-header'] == 5) ) $topbar = 0;
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
                <div class="topbar-position hidden-sm hidden-xs topbar-right">
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
                    <?php endif; ?>
                    <?php if ( $showLanguage == 1 ): ?>
                        <div class="header-block">
                            <?php echo yanka_language(); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ( yanka_woocommerce_activated() && class_exists('Jms_Currency') && $showCurrency == 1 ) : ?>
                        <div class="header-block">
                            <?php echo yanka_currency(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- top-bar -->
<?php endif; ?>
