    <div class="clearfix"></div>
    <?php

        global $post;
        $hide_atdshowedfooter = '';
        $footer_class = '';
        $options = get_post_meta( get_the_ID(), '_custom_page_options', true );
        if ( isset( $options['disable-footer'] ) && $options['disable-footer'] == 1 ) {
            $show_footer = 0;
        }else{
            $show_footer = 1;
        }

        $sticky_addtocart = yanka_get_option('wc-product-sticky-addtocart', 0);

        if ( isset($sticky_addtocart) && $sticky_addtocart == 0 ) {
            $hide_atdshowedfooter = 'hide-atdshowedfooter';
        }

        $footer_copyright = 'Copyright 2020. All rights reserved. Design by <a href="#">JoomMasters.com</a>.';
        $footer_layout = yanka_get_option( 'footer-layout');
        if ( isset( $options['page-footer'] ) && $options['page-footer'] != '' ) {
            $footer_layout = $options['page-footer'];
        }

        if ( class_exists( 'WooCommerce' ) ) {
            if( is_post_type_archive( 'product' ) || is_shop() ) {
                $footer_layout = yanka_get_option( 'footer-layout-archive-product');
            }            
        }

        
        
        if(isset($footer_layout) && $footer_layout !=''){
            $footer_class = str_replace(' ', '-', strtolower($footer_layout));
        } else {
            $footer_class = '';
        }
    ?>
<?php if ($show_footer) { ?>
    <footer id="footer-wrapper" class="footer <?php echo esc_html($footer_class);?> <?php echo esc_html($hide_atdshowedfooter);?>">
        <?php
            if ( isset($footer_layout) && $footer_layout !='' ) {
                $jscomposer_templates_args = array(
                    'orderby'          => 'title',
                    'order'            => 'ASC',
                    'post_type'        => 'footerlayout',
                    'post_status'      => 'publish',
                    'posts_per_page'   => 30,
                );
                $jscomposer_templates = get_posts( $jscomposer_templates_args );

                if(count($jscomposer_templates) > 0) {
                    foreach($jscomposer_templates as $jscomposer_template){
                        if($jscomposer_template->post_title == $footer_layout){
                            //echo $jscomposer_template->post_title;

                            // echo '<pre>';
                            // echo print_r($jscomposer_template);
                            // echo '</pre>';

                            //echo do_shortcode($jscomposer_template->post_content);
                            $content = '';
                            $content .= \Elementor\Plugin::$instance->frontend->get_builder_content( $jscomposer_template->ID, true );
                            echo do_shortcode($content);
                        }
                    }
                }
            } else { ?>
                <div class="footer-block tc copyright_footer pb_60">
                    <?php
                        echo wp_kses( $footer_copyright , array(
                            'a' => array(
                                'href' => array(),
                                'title' => array()
                            )
                        ) );
                    ?>
                </div>

            <?php } ?>
    </footer>
<?php } ?>

    <?php
    $cart_style = yanka_get_option('wc-add-to-cart-style', 'alert');

    if( isset($_GET['cart_design']) && $_GET['cart_design'] != '' ) {
        $cart_style = $_GET['cart_design'];
    }

    if ( class_exists( 'WooCommerce' ) && isset($cart_style) && $cart_style != '' ) : ?>
        <div class="cartSidebarWrap">
            <div class="cart_wrap_content">
                <div class="cart-sidebar-header flex between-xs">
                    <div class="cart-sidebar-title">
                        <?php esc_html_e( 'Shopping cart', 'yanka' ); ?>
                    </div>
                    <div class="close-cart"><i class="sl icon-close"></i></div>
                </div>
                <div class="widget_shopping_cart_content"></div>
            </div>
        </div>
    <?php endif; ?>

</div><!-- #page -->
<!-- modal "Size Guid" -->
<div class="modal fade" id="modalProductInfo" tabindex="-1" role="dialog" aria-label="myModalLabel" aria-hidden="true">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog modal-lg vertical-align-center">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon icon-clear"></span></button>
                </div>
                <div class="modal-body noindent">
                    <?php
                        if (function_exists('yanka_size_guide')) { yanka_size_guide(); }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal "Shipping" -->
<div class="modal fade" id="modalProductInfo-02" tabindex="-1" role="dialog" aria-label="myModalLabel" aria-hidden="true">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog modal-lg vertical-align-center">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon icon-clear"></span></button>
                </div>
                <div class="modal-body">
                    <?php 
                        if (function_exists('yanka_shipping')) { yanka_shipping(); }
                    ?>
                </div>
            </div>
        </div>        
    </div>
</div>
<!-- modal "Question" -->
<div class="modal fade" id="modalProductInfo-03" tabindex="-1" role="dialog" aria-label="myModalLabel" aria-hidden="true">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog modal-lg vertical-align-center">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon icon-clear"></span></button>
                </div>
                <div class="modal-body">
                        <?php 
                            if (function_exists('yanka_ask_about_product')) { yanka_ask_about_product(); }
                        ?>
                </div>
            </div>
        </div>
    </div>
</div>
<a id="backtop">
    <span class="pt-icon">
        <svg version="1.1" x="0px" y="0px" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24;" xml:space="preserve"><g><polygon fill="currentColor" points="20.9,17.1 12.5,8.6 4.1,17.1 2.9,15.9 12.5,6.4 22.1,15.9"></polygon></g></svg>
    </span>
    <span class="pt-text"><?php esc_html_e( 'BACK TO TOP', 'yanka' ); ?></span>
</a>
<?php locate_template('template-parts/support-svg/icons.php', true);?>
<!-- W3TC-include-css -->
<?php wp_footer(); ?>
<!-- W3TC-include-js-head -->
</body>
</html>