<?php $showAccount = yanka_get_option('show-account-box', 1); ?>
<?php $showLanguage = yanka_get_option('show-language-box', 1); ?>
<?php $showCurrency = yanka_get_option('show-currency-box', 1); ?>
<div class="yanka-mobile-menu">
    <div class="menu-title flex between-xs"><?php esc_html_e( 'MENU', 'yanka' ) ?><div class="close-menu-mobile"><span></span></div></div>
    <?php
    if ( has_nav_menu('primary-menu') ) {
        $args = array(
            'theme_location'  => 'primary-menu',
            'container_class' => 'mobile-menu-wrapper',
            'menu_class'      => 'mobile-menu',
        );
        wp_nav_menu( $args );
    }
    ?>

    <?php if ( $showLanguage == 1 ): ?>
        <div class="language-mobile">
            <?php echo yanka_language_mobile(); ?>
        </div>
    <?php endif; ?>

</div>
