<?php
/**
 * ------------------------------------------------------------------------------------------------
 * Prepare CSS selectors for theme settions (colors, borders, typography etc.)
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'yanka_custom_inline_css' ) ) {
    function yanka_custom_inline_css( $css = array() ) {
        if ( !class_exists ( 'ReduxFramework' ) ) return;

        // Color scheme
        $primary_color = yanka_get_option('primary-color', '#F86B73');


        if ( isset($_GET['color']) && $_GET['color'] != '' ) {
            $primary_color = '#' . $_GET['color'];
        }

        if ( isset($primary_color) && $primary_color != '' ) {
            $css[] = '
                .color-primary-color-ipt, .wpb-js-composer .sizing_guide.vc_tta-color-white.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title > a, .wpb-js-composer .faq.vc_tta-color-white.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title > a, .type-title-4 p:hover, .button-color-primary a, .button-color-hover-primary a:hover, .portfolio-title a:hover {
                    color: ' . esc_attr( $primary_color ) . '!important;
                }
            ';

            $css[] = '
              .color-primary-color, a:hover, a:focus, a:active, p a, .color, .menu-11 .widget ul li:last-child a, .menu-11 .widget ul li:last-child a:hover, .pt-lookbook-02 .pt-description .pt-price, .pt-insta-title a, .wpb-js-composer .shipping-returns.vc_general.vc_tta-style-classic .vc_tta-tab.vc_active > a, .wpb-js-composer .shipping-returns.vc_general.vc_tta-style-classic .vc_tta-tab > a:hover, .wpb-js-composer .faq.vc_tta-color-white.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-title > a:hover, div.mb-siwc-popup div.mb-siwc-popup-inner h2, .woocommerce .yith-woo-ajax-reset-navigation .yith-wcan .pt-filter-list:hover, .xoo-cp-modal .xoo-cp-pdetails td.xoo-cp-pprice span.amount, .xoo-cp-modal .xoo-cp-ptotal, .search-box .woo-ajaxsearchform-container .ui.search > .results > .action:hover, .search-box .woo-ajaxsearchform-container .ui.search > .results .result:hover .content .title, .header-action .header-block:hover i, .wrap-header .btn-group .dropdown-menu a:hover, .result-wrapper .content-price ins, .header-account .dropdown-menu ul li a:hover, .header-wrapper .yanka-menu.primary-menu .current-menu-item > a, .header-wrapper .yanka-menu.primary-menu .current-menu-item.menu-item-has-children > a, .header-wrapper .yanka-menu.primary-menu .current-menu-ancestor.menu-item-has-children > a, .header-wrapper .single-button > a, .topbar .topbar-menu a:hover, .topbar.color-scheme-dark .topbar-menu li a:hover, .topbar.color-scheme-dark .topbar-menu li a:focus, .topbar.color-scheme-dark .dropdown-toggle:hover, .topbar .topbar-social a:hover, .topbar a:hover, .language-dropdown:hover, .currency-dropdown:hover, header .pt-box-info ul li a, header .pt-box-info ul li a.pt-link-underline, .yanka-menu.primary-menu > li > a:hover, .yanka-menu.category-menu > li:hover > a, .yanka-menu.category-menu-1 > li:hover > a, .menu-popup .close-menu-popup:hover:before, .popup-menu > li:hover > a, .popup-menu ul li:hover > a, .yanka-menu .dropdown-menu .column-heading:hover, .yanka-menu li a:hover, .yanka-menu li.current-menu-item > a, .yanka-menu li ul:not(.mega-nav) a:hover, #footer-wrapper a:hover, #footer-wrapper p a, #footer-wrapper .footer-top .widget_nav_menu li:hover a, #footer-wrapper .footer-bottom .copyright a, #footer-wrapper .copyright_footer a, .custom-banner h3 span, .custom-banner .btn-transparent-color, .header-7 .header-menu .yanka-menu.primary-menu > li > a:hover, .header-8 .header-menu .yanka-menu.primary-menu > li > a:hover, .error-404 .sub-title a, .pt-link, .pt-link:focus, .pt-link:hover, .pt-link:focus:hover, .not-found .entry-header:before, .icon-close:hover, .page-heading a:hover, .blog-post-loop.blog-design-default .entry-title:hover, .read-more-section a:hover, .comments-area #cancel-comment-reply-link, .comments-area .reply a, .widget .widgettitle:hover, .widget .widget-title:hover, .widget a:hover, .widget_ranged_price_filter .ranged-price-filter li.current, .widget_order_by_filter li.current, .widget_ranged_price_filter .ranged-price-filter li.current a, .widget_order_by_filter li.current a, .widget_categories ul li.current_page_item > a, .widget_pages ul li.current_page_item > a, .widget_archive ul li.current_page_item > a, .widget_nav_menu ul li.current_page_item > a, .widget_product_categories ul li.current_page_item > a, .cart_list li .desc .product_name:hover, .cart_list li .desc .amount, .product_list_widget > li .woocommerce-Price-amount, .archive .widget .widgettitle:hover, .archive .widget .widget-title:hover, .category .widget .widgettitle:hover, .category .widget .widget-title:hover, .single .widget .widgettitle:hover, .single .widget .widget-title:hover, .blog .widget .widgettitle:hover, .blog .widget .widget-title:hover, .archive .widget.widget_recent_entries ul li a:hover, .category .widget.widget_recent_entries ul li a:hover, .single .widget.widget_recent_entries ul li a:hover, .blog .widget.widget_recent_entries ul li a:hover, .notice-cart .text-notice a, .special-filter .product-categories > li > a:hover, .special-filter .product-categories > li > a:focus, .special-filter .product-categories > li .count, .special-filter .product-categories > li.active > a, .product-box .price, .product-box .btn-wishlist .yith-wcwl-add-to-wishlist:hover a:before, .product-box .btn-wishlist .yith-wcwl-add-to-wishlist:focus a:before, .product-box .btn-wishlist .yith-wcwl-add-to-wishlist:hover .yith-wcwl-wishlistaddedbrowse.show a:before, .product-box .btn-wishlist .yith-wcwl-add-to-wishlist:focus .yith-wcwl-wishlistaddedbrowse.show a:before, .product-box .btn-wishlist .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse.show a:before, .product-box .btn-wishlist .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse.show a:before, .product-box .btn-wishlist .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse.show a:hover:before, .product-box .btn-wishlist .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse.show a:hover:before, .product-btn li .button:hover:before, .product-btn li .button:focus:before, .btn-wishlist .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse.show a, .addtocart .button-cart, .addtocart .button-cart:hover, .addtocart .button-cart:focus, .pt-row-hover .price, .pt-row-hover .price ins, .list-product .product-info .price, .product-style-list-box .addtocart .button-cart:hover, .product-style-list-box.product-style-list-1 .product-list-info-top a.woocommerce-LoopProduct-link:hover, .list-view .product-list-info .pt-description .pt-col .quickview .btn-quickview:hover, .woocommerce-product-rating .woocommerce-review-link, .woocommerce-product-rating .woocommerce-review-link:hover, .product_meta li:before, .product_meta a:hover, .entry-summary .pt-wrapper.pt-quickview-view-info > a, .entry-summary .price, .entry-summary .compare.button:hover, .quantity .qty a:hover svg, .woocommerce table.wishlist_table tbody td.product-stock-status span.wishlist-in-stock, .woocommerce.yith-wcwl-form .wishlist_table.responsive.mobile li .remove_from_wishlist, .shop_table .woocommerce-Price-amount, .shop_table .woocommerce-Price-amount ins, .cart-actions .action-1 .btn_cont_shop:hover span, .cart-actions .action-2 .btn_clear-cart:hover span, .cart-actions .action-2 .btn_update-cart:hover span, .cart-totals-inner table .shipping .shipping-calculator-button:hover, body.woocommerce-checkout .woocommerce > .woocommerce-info a, .cartSidebarWrap .cart-sidebar-header .close-cart i:hover:before, .title-color-primary .title, .title-color-primary .subtitle, .yanka-button-wrapper a:hover, .yanka-button-wrapper a:focus, .portfolio-filter > a.selected, .portfolio-category .pt-btn-zoom a:hover, .image-carousel-box .title-image a:hover, .product-filter a.active, .jmsproduct-tab .nav-tabs > li.active > a, .jmsproduct-tab.design-tab-2 .nav-tabs > li.active > a, .team-member .member-social .yanka-social-icon a:hover, .yanka-social-icons.icon-color-default .yanka-social-icon a:hover, .yanka-social-icons.icon-color-black .yanka-social-icon a:hover, .yanka-social-icons.icon-color-white .yanka-social-icon a:hover, .yanka-social-icons.icon-color-primary .yanka-social-icon a, .yanka-price-table.price-style-alt .yanka-price-currency, .yanka-price-table.price-style-alt .yanka-price-value, .jms-tabs-title ul li.active, .jms-tabs-title ul li:hover, .loaderspinner3 {
                    color: ' . esc_attr( $primary_color ) . ';
                }
            ';

            $css[] = '
                .border-primary-color-ipt, .image-box:hover a.button-banner, .border-color-primary a, .border-color-hover-primary a:hover {
                    border-color: ' . esc_attr( $primary_color ) . '!important;
                }
            ';

            $css[] = '
                .border-primary-color, .btn-transparent:hover, .yanka-menu.primary-menu > li:hover > a, .newsletter-form input[type="email"]:focus, #newsletter-bottom .newsletter-form input[type="email"]:focus, .custom-banner .btn-transparent-color, .yanka-single-bottom .tags-list a:hover, .yanka-single-bottom .tags-list a:focus, .notice-cart .text-notice a, .product-list-info .product-btn li .button:hover, .product-list-info .product-btn .button-cart, .product-list-info .product-btn .yith-wcwl-add-to-wishlist:hover, .product-list-info-box .addtocart .button-cart:hover, .entry-summary .attribute-wrap .imageswatch-variation.selected, .tabs-layout-tabs .wc-tabs > li:hover a, .tabs-layout-tabs .wc-tabs > li.active a, .variation-attr .variation-attr_color .p-attr-color.active, .variation-attr .variation-attr_image .p-attr-image.active, .testimonial-box .testimonial-avatar img, .testimonials-style-primary.jmstestimonial-box .pt-reviewsbox .pt-reviewsbox-author, .yanka .tp-bullet.selected, .yanka .tp-bullet:hover{
                    border-color: ' . esc_attr( $primary_color ) . ';
                }
            ';
            
            $css[] = '
                .background-primary-color-ipt, .image-box:hover a.button-banner, .background-color-primary a, .background-color-hover-primary a:hover{
                    background-color: ' . esc_attr( $primary_color ) . '!important;
                }
            ';

            $css[] = '
               .background-primary-color, .btn.btn-color-primary, .button.btn-color-primary, button.btn-color-primary, .added_to_cart.btn-color-primary, input.btn-color-primary[type="submit"], input.btn-color-primary[type="button"], input.btn-color-primary[type="reset"], .btn-transparent:hover, .checkout-button, .coupon .button, .checkout_coupon .button, .actions .update-cart, #place_order, #customer_login .button, .btn, #backtop:hover, .login-page .woocommerce input[type="submit"], .pt-menu-categories .pt-dropdown-toggle, .menu-11 .widget ul li:last-child a:before, .wc-ask-about .btn:hover, .pt-insta-title a:before, .ctu_form .wpcf7-form input[type="submit"]:hover, span.mb-siwc-tag:after, .btn-buy-it-now:hover, .xoo-cp-modal .xoo-cp-btns a.xoo-cp-btn-ch, .xoo-cp-modal .xoo-cp-btns a.xoo-cp-close:hover, .yithpopup_wrapper.yith-popup #yith-popup-right input[type="submit"], #catapult-cookie-bar a:before, .js-header-slider .slick-slide a:before, .header-wrapper .single-button > a span:before, header .pt-box-info ul li a.pt-link-underline:before, .yanka-menu.primary-menu > li > a span:before, .yanka-mobile-menu .menu-title, .yanka-popup-menu .menu-title, .header-7 .menu-popup-button:hover .icon-menu, .header-7 .menu-popup-button:hover .icon-menu:before, .header-7 .menu-popup-button:hover .icon-menu:after, .header-13 .menu-header-13 .yanka-menu.primary-menu > li > a:hover, .header-wrapper.header-13 .yanka-menu.primary-menu .current-menu-item > a, .header-wrapper.header-13 .yanka-menu.primary-menu .current-menu-item.menu-item-has-children > a, .header-wrapper.header-13 .yanka-menu.primary-menu .current-menu-ancestor.menu-item-has-children > a, .pt-link:before, .pt-link:focus:before, .contact-form-default .wpcf7-submit, .yanka-single-bottom .tags-list a:hover:after, .yanka-single-bottom .tags-list a:focus:after, .post-password-form input[type="submit"], .comment-form .submit:hover, .page-links > span:not(.page-links-title), .yanka-entry-content .page-links > a, .yanka-entry-content .page-links > span:not(.page-links-title), .widget_calendar #wp-calendar tbody a, .widget_shopping_cart_content .cart-bottom-box .buttons .button.checkout, .widget_price_filter .price_slider_amount .button, .widget_price_filter .ui-slider .ui-slider-handle, .notice-cart .icon-notice, .pt-row-hover > .button-cart, .product-list-info .product-btn li .button:hover, .product-list-info .product-btn .button-cart, .product-list-info-box .addtocart .button-cart:hover, .list-view .product-list-info .pt-description .pt-col .addtocart > a, nav.woocommerce-pagination ul li a:focus, nav.woocommerce-pagination ul li a:hover, nav.woocommerce-pagination ul li span.current, .wc-single-video a:before, .woocommerce-product-rating .woocommerce-review-link:before, .entry-summary .pt-wrapper.pt-quickview-view-info .pt-text:before, .cart .single_add_to_cart_button, .single_add_to_cart_button, .woocommerce table.wishlist_table a.button, .woocommerce.yith-wcwl-form .wishlist_table.responsive.mobile li .additional-info-wrapper .product-add-to-cart a.button, .woocommerce-MyAccount-content .button.view, .cart-content-wrapper .cart-totals-section .cart_totals .pt-shopcart-box button[type="submit"]:hover, .wc-proceed-to-checkout .checkout-button, .cart_totals .cart-totals-inner .shop_table tr.woocommerce-shipping-totals.shipping td form .button[type="submit"], .cart_totals .cart-totals-inner .shop_table tr.woocommerce-shipping-totals td form .button[type="submit"], input.dokan-btn[type="submit"], a.dokan-btn, .dokan-btn, input.dokan-btn[type="submit"]:hover, input.dokan-btn[type="submit"]:focus, a.dokan-btn:hover, a.dokan-btn:focus, .dokan-btn:hover, .dokan-btn:focus, .reset_variations:hover, .addon-title.line-bottom-big h3:before, .addon-title.line-bottom-small h3:before, .addon-title.line-bottom-right h3:before, .title-color-primary .title.style-background, .title-color-primary .subtitle.style-background, .button-type-buton a, .button-type-border a, .button-banner, .yanka-button-wrapper a:hover, .yanka-button-wrapper a:focus, .jmsproduct-tab .nav-tabs > li > a:after, .jmsproduct-tab.design-tab-2 .nav-tabs > li.active > a:after, .testimonials-style-primary.jmstestimonial-box .pt-reviewsbox .pt-reviewsbox-description, .megamenu-widget-wrapper h3:before, .countdown-style-primary .yanka-countdown > span, .yanka-price-table .yanka-plan-footer > a, .spinner1 .bounce11, .spinner1 .bounce22, .spinner4 .bounce11, .spinner4 .bounce22, .spinner4 .bounce33, .spinner5, .spinner6 .dot11, .spinner6 .dot22 {
                    background-color: ' . esc_attr( $primary_color ) .';
                }
            ';
        }

        $text_color = yanka_get_option('text-font');
        if ( isset($text_color) && $text_color != '' ) {
            $css[] = '
                .color-body-color, .entry-meta-list li, .entry-meta-list li a, .product-box .product-cat a, .product-box .product-cat a:hover, .pt-row-hover .price del, .product-style-1 .product-box .yanka-countdown_box .yanka-countdown > span span, .image-carousel-box .pt-description p {
                    color: '.esc_attr( $text_color['color'] ).';
                }
            ';
        }

        $box_layout_width = yanka_get_option('box_layout_width', '1480');
        if ( isset($box_layout_width) && $box_layout_width != '' ) {
            $css[] = '
                @media screen and (min-width: ' . esc_attr( $box_layout_width ) . 'px){.wrapper-boxed .site{width: ' . esc_attr( $box_layout_width ) . 'px;}.container{width: calc(' . esc_attr( $box_layout_width ) . 'px - 120px);max-width: 1250px;}.wrapper-boxed .header-wrapper.header-fullwidth {padding: 0;margin: 0 !important;}.wrapper-boxed .header-wrapper.header-fullwidth .container {width: 100%;}.wrapper-boxed .site {margin: 0 auto;overflow: hidden;-webkit-box-shadow: 0px 1px 51px 0px #d9d6d9;-moz-box-shadow: 0px 1px 51px 0px #d9d6d9;-o-box-shadow: 0px 1px 51px 0px #d9d6d9;box-shadow: 0px 1px 51px 0px #d9d6d9;}.wrapper-boxed .vc_row[data-vc-full-width] {padding-left: 60px !important;padding-right: 60px !important;width: 100% !important;margin: 0;position: static !important;}.wrapper-boxed .vc_row[data-vc-full-width].vc_row-no-padding {padding-left: 0 !important;padding-right: 0 !important;}.header-fullwidth .container {width: 94%;}}
            ';
        }

        $primary_font = yanka_get_option('text-font');
        if ( isset($primary_font['font-family']) && $primary_font['font-family'] != '' ) {
            $css[] = '
                .primary-font, .yanka-button-wrapper.font-primary, .addon-title.subtitle .title {
                    font-family: '.esc_attr( $primary_font['font-family'] ).';
                }
            ';
        }

        $height_logo = yanka_get_option('height-logo');
        if ( isset($height_logo) && $height_logo != '' ) {
            $css[] = '
                .logo_image img{
                    max-height: '.esc_attr( $height_logo).'px;
                }
            ';
        }

        $header_color = yanka_get_option('header-text-color','#333');
        if ( isset($_GET['header-color']) && $_GET['header-color'] != '' ) {
            $header_color = '#' . $_GET['header-color'];
        }

        
        if ( isset($header_color) && $header_color != '' ) {
            $css[] = '
                .header-action i{
                    color: '.esc_attr( $header_color).';
                }
            ';
        }

        $menu_font = yanka_get_option('menu-font','#666');
        if ( isset($_GET['menu-color']) && $_GET['menu-color'] != '' ) {
            $menu_font = '#' . $_GET['menu-color'];
        }
        if ( isset($menu_font) && $menu_font != '' ) {
            $css[] = '
                .yanka-menu.primary-menu > li > a{
                    color: '.esc_attr( $menu_font).';
                }
            ';
        }


        return preg_replace( '/\n|\t/i', '', implode( '', $css ) );
    }
}
