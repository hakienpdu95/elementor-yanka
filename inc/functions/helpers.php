<?php

if ( ! function_exists('yanka_favicon') ) {
    function yanka_favicon() {
        if ( ! ( function_exists( 'has_site_icon' ) && has_site_icon() ) ) {
            $favicon_url = yanka_get_option('favicon', '');

            if( isset($favicon_url['url']) && $favicon_url['url'] != '') : ?>
                <link rel="shortcut icon" href="<?php echo esc_url( $favicon_url['url'] ); ?>"/>
            <?php endif;
        }
    }
    add_action('wp_head', 'yanka_favicon');
}

/*---------------------------------
    Custom Login Logo
------------------------------------*/
if ( ! function_exists( 'yanka_login_logo' ) ) {
    function yanka_login_logo() {
        $login_logo = yanka_get_option('login-logo');

        if( !empty( $login_logo['url'] ) ) {
            $login_logo_url = $login_logo['url'];
        } else {
            $login_logo_url = YANKA_URL . '/assets/images/logo.png';
        }

        echo '<style type="text/css"> h1 a { background: url(' . esc_url($login_logo_url) . ') center no-repeat !important; width:302px !important; height:67px !important; } </style>';
    }
}
add_action('login_head', 'yanka_login_logo');

if ( ! function_exists( 'yanka_page_title' ) ) {
    function yanka_page_title() {
        global $wp_query, $post;

        // Remove page title for dokan store list page
        if( function_exists( 'dokan_is_store_page' )  && dokan_is_store_page() ) {
            return '';
        }

        $page_title     = true;
        $heading_class  = '';
        $page_for_posts = get_option( 'page_for_posts' );
        $breadcrumbs    = yanka_get_option( 'breadcrumbs', 1 );

        // Get default styles from Options Panel
        $title_design = yanka_get_option( 'page-title-design', 'centered' );
        $title_size   = yanka_get_option( 'page-title-size', 'default' );
        $title_color  = yanka_get_option( 'page-title-color', 'dark' );

        $options = get_post_meta( get_the_ID(), '_custom_page_options', true );

        if ( isset( $options['breadcrumb'] ) ) {
            $breadcrumbs = $options['breadcrumb'];
        }

        // Text color
        $heading_class .= ' title-align-' . $title_design;
        $heading_class .= ' title-size-' . $title_size;

        if( isset( $options['pagehead'] ) && $options['pagehead'] != 1 ) $page_title = false;

        if( $title_design == 'disable' ) $page_title = false;
        if( ! $page_title && ! $breadcrumbs ) return;


        // Heading for pages
        if( is_singular( 'page' ) && ( ! $page_for_posts || ! is_page( $page_for_posts ) ) ):
            $title = get_the_title();

            if ( isset( $options['page-title'] ) && $options['page-title'] != '' ) {
                $title = $options['page-title'];
            }

            ?>
                <?php if( $breadcrumbs ) : ?>
                    <div class="page-breadcrumb">
                        <?php if( yanka_woocommerce_activated() ) : ?>
                            <div class="container-fluid">
                        <?php else : ?>
                            <div class="container">
                        <?php endif; ?>
                            <?php echo yanka_breadcrumb(); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if( $page_title ): ?>
                <div class="page-heading<?php echo esc_attr($heading_class); ?>">
                        <?php if( yanka_woocommerce_activated() ) : ?>
                            <div class="container-fluid">
                        <?php else : ?>
                            <div class="container">
                        <?php endif; ?>
                        <header class="entry-header">
                            <?php if ( yanka_woocommerce_activated() && WC()->cart->get_cart_contents_count() == 0 ) : ?>
                                <h1 class="entry-title hide-heading"><?php echo esc_html( $title ); ?></h1>
                            <?php else : ?>
                                <h1 class="entry-title"><?php echo esc_html( $title ); ?></h1>
                            <?php endif; ?>
                        </header><!-- .entry-header -->
                    </div>
                </div>
                <?php endif; ?>
            <?php
            return;
        endif;


        // Heading for blog and archives
        if( is_singular( 'post' ) || is_home() || is_search() || is_tag() || is_category() || is_date() || is_author() ):
            $title = ( ! empty( $page_for_posts ) ) ? get_the_title( $page_for_posts ) : esc_html__( 'Blog', 'yanka' );

            if( is_tag() ) {
                $title = esc_html__( 'Tag Archives: ', 'yanka')  . single_tag_title( '', false ) ;
            }

            if( is_category() ) {
                $title = '<span>' . single_cat_title( '', false ) . '</span>';
            }

            if( is_date() ) {
                if ( is_day() ) :
                    $title = esc_html__( 'Daily Archives: ', 'yanka') . get_the_date();
                elseif ( is_month() ) :
                    $title = esc_html__( 'Monthly Archives: ', 'yanka') . get_the_date( _x( 'F Y', 'monthly archives date format', 'yanka' ) );
                elseif ( is_year() ) :
                    $title = esc_html__( 'Yearly Archives: ', 'yanka') . get_the_date( _x( 'Y', 'yearly archives date format', 'yanka' ) );
                else :
                    $title = esc_html__( 'Archives', 'yanka' );
                endif;
            }

            if ( is_author() ) {
                the_post();
                $title = esc_html__( 'Posts by ', 'yanka' ) . '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>';
                /*
                 * Since we called the_post() above, we need to
                 * rewind the loop back to the beginning that way
                 * we can run the loop properly, in full.
                 */
                rewind_posts();
            }

            if ( is_single() ) {
                $title = '';
            }

            if( is_search() ) {
                $title = esc_html__( 'Search results for: "', 'yanka' ) . get_search_query() . '"';
            }

            ?>
                <?php if( $breadcrumbs ) : ?>
                    <div class="page-breadcrumb">
                        <?php if( yanka_woocommerce_activated() ) : ?>
                            <div class="container-fluid">
                        <?php else : ?>
                            <div class="container">
                        <?php endif; ?>
                            <?php echo yanka_breadcrumb(); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if( $page_title ): ?>
                <div class="page-heading<?php echo esc_attr($heading_class); ?> title-blog title-other">
                        <?php if( yanka_woocommerce_activated() ) : ?>
                            <div class="container-fluid">
                        <?php else : ?>
                            <div class="container">
                        <?php endif; ?>
                        <header class="entry-header">
                            <h1 class="entry-title"><?php echo '' . wp_kses( $title , 'allowed-html'); ?></h1>
                        </header><!-- .entry-header -->
                    </div>
                </div>
                <?php endif; ?>
            <?php
            return;
        endif;


        // Heading for portfolio
        if( is_singular( 'portfolio' ) || is_post_type_archive( 'portfolio' ) || is_tax( 'portfolio-cat' ) ):
            $title = yanka_get_option('portfolio-title', 'Portfolio');

            if( is_tax( 'portfolio-cat' ) ) {
                $title = single_term_title( '', false );
            }

            if( is_singular( 'portfolio' ) ) {
                $title = get_the_title();
            }

            ?>
                <?php if( $breadcrumbs ) : ?>
                    <div class="page-breadcrumb">
                        <div class="container-fluid">
                            <?php echo yanka_breadcrumb(); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if( $page_title ): ?>
                <div class="page-heading<?php echo esc_attr( $heading_class ); ?> title-portfolio title-other">
                    <div class="container-fluid">
                        <header class="entry-header">
                            <h1 class="entry-title"><?php echo '' . wp_kses( $title , 'allowed-html'); ?></h1>
                        </header><!-- .entry-header -->
                    </div>
                </div>
                <?php endif; ?>
            <?php
            return;
        endif;


        // Page heading for shop page
        if( yanka_woocommerce_activated() && ( is_shop() || is_product_category() || is_product_tag() || is_singular( 'product' ) ) ) :
            if( is_product_category() ) {
                $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                if ( $term ) {
                    $term_options = get_term_meta( $term->term_id, '_custom_product_cat_options', true );
                }
            }

            if ( is_product() || is_single() ) {
                $terms = get_the_terms( $post->ID, 'product_cat' );

                foreach ($terms as $term) {
                    $title = esc_attr( $term->name );
                }
            }
            ?>
                <?php if ( apply_filters( 'woocommerce_show_page_title', true ) && ! is_singular( 'product' ) ) : ?>
                    <?php if( $breadcrumbs ) : ?>
                        <div class="page-breadcrumb">
                        <?php if( yanka_woocommerce_activated() ) : ?>
                            <div class="container-fluid">
                        <?php else : ?>
                            <div class="container">
                        <?php endif; ?>
                                <?php echo yanka_breadcrumb(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="page-heading<?php echo esc_attr( $heading_class ); ?> title-shop title-other">
                        <?php if( yanka_woocommerce_activated() ) : ?>
                            <div class="container-fluid">
                        <?php else : ?>
                            <div class="container">
                        <?php endif; ?>
                            <header class="entry-header">
                                <h1 class="entry-title"><?php woocommerce_page_title(); ?></h1>
                            </header><!-- .entry-header -->
                        </div>
                    </div>
                    
                <?php endif; ?>

                <?php if ( is_singular( 'product' ) ) : ?>
                <?php if( $breadcrumbs ) : ?>
                    <div class="page-breadcrumb">
                        <?php if( yanka_woocommerce_activated() ) : ?>
                            <div class="container-fluid">
                        <?php else : ?>
                            <div class="container">
                        <?php endif; ?>
                            <?php echo yanka_breadcrumb(); ?>
                        </div>
                    </div>
                <?php endif; ?>

                    <div class="page-heading<?php echo esc_attr( $heading_class ); ?>">
                        <?php if( yanka_woocommerce_activated() ) : ?>
                            <div class="container-fluid">
                        <?php else : ?>
                            <div class="container">
                        <?php endif; ?>
                            <header class="entry-header">
                                <h1 class="entry-title"><?php echo '' . wp_kses( $title , 'allowed-html'); ?></h1>
                            </header><!-- .entry-header -->
                        </div>
                    </div>
                <?php endif; ?>

            <?php

            return;
        endif;

    }
}

// **********************************************************************//
// Pre Loader
// **********************************************************************//
if ( !function_exists('yanka_preloader') ) {
    function yanka_preloader() {
        $loader          = yanka_get_option('site-loader', 0);
        $preloader_style = yanka_get_option('site-loader-style', 5);

        ?>
        <?php if ( isset($loader) && $loader == 1 ) : 
            if($preloader_style == 3) :
        ?>
                <div class="preloader main_loader<?php echo esc_attr( $preloader_style ); ?>">
                    <div class="loaderspinner<?php echo esc_attr( $preloader_style ); ?>"><?php esc_html__( 'Loading...', 'yanka' ); ?></div>
                </div>
            <?php else : ?>
                <div class="preloader">
                    <div class="spinner<?php echo esc_attr( $preloader_style ); ?>">
                        <div class="dot11"></div>
                        <div class="dot22"></div>
                        <div class="bounce11"></div>
                        <div class="bounce22"></div>
                        <div class="bounce33"></div>
                    </div>
                </div>
          <?php endif; ?>
        <?php endif; ?>
        <?php
    }
}

if( ! function_exists( 'yanka_get_static_blocks_array' ) ) {
    function yanka_get_static_blocks_array() {
        $args = array( 'posts_per_page' => 50, 'post_type' => 'cms_block' );
        $blocks_posts = get_posts( $args );
        $array = array();
        foreach ( $blocks_posts as $post ) :
            setup_postdata( $post );
            $array[$post->post_title] = $post->ID;
        endforeach;
        wp_reset_postdata();
        return $array;
    }
}

/**
 * Yanka top panel
 */

 if ( ! function_exists( 'yanka_top_panel' ) ) {
    function yanka_top_panel() {
        if( (is_front_page() && is_home()) || is_front_page() ) :
            $topbar_panel = yanka_get_option('box-top-panel', '');
                if ( isset($topbar_panel) && ! empty( $topbar_panel ) ) {
            ?>
                <div class="pt-top-panel">
                    <div class="container">
                        <div class="pt-row">
                            <div class="pt-description">
                                <?php
                                    $allowed_html = array(
                                        'a' => array(
                                            'href' => array(),
                                            'title' => array()
                                        ),
                                        'br' => array(),
                                        'em' => array(),
                                        'strong' => array(),
                                    );

                                    echo wp_kses($topbar_panel, $allowed_html);
                                ?>                            
                            </div>
                            <button class="pt-btn-close js-removeitem">
                                <svg fill="none">
                                    <use xlink:href="#icon-close"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            <?php
            }
        endif;
    }
}

 if ( ! function_exists( 'yanka_box_info_1' ) ) {
    function yanka_box_info_1() {
        $box_info = yanka_get_option('box-info-1', '');
        if(!empty($box_info) && isset($box_info)) :
        ?>
            <li class="slick-slide">
            <?php
                if ( isset($box_info) && ! empty( $box_info ) ) {
                    $allowed_html = array(
                        'a' => array(
                            'href' => array(),
                            'title' => array()
                        ),
                        'br' => array(),
                        'em' => array(),
                        'strong' => array(),
                    );

                    echo wp_kses($box_info, $allowed_html);
                }
            ?>   
            </li>                         
        <?php
        endif;
    }
}

if ( ! function_exists( 'yanka_box_info_2' ) ) {
    function yanka_box_info_2() {
        $box_info = yanka_get_option('box-info-2', '');
        if(!empty($box_info) && isset($box_info)) :
        ?>
            <li class="slick-slide">
            <?php
                if ( isset($box_info) && ! empty( $box_info ) ) {
                    $allowed_html = array(
                        'a' => array(
                            'href' => array(),
                            'title' => array()
                        ),
                        'br' => array(),
                        'em' => array(),
                        'strong' => array(),
                    );

                    echo wp_kses($box_info, $allowed_html);
                }
            ?>   
            </li>                         
        <?php
        endif;
    }
}

if ( ! function_exists( 'yanka_box_info_3' ) ) {
    function yanka_box_info_3() {
        $box_info = yanka_get_option('box-info-3', '');
        if(!empty($box_info) && isset($box_info)) :
        ?>
            <li class="slick-slide">
            <?php
                if ( isset($box_info) && ! empty( $box_info ) ) {
                    $allowed_html = array(
                        'a' => array(
                            'href' => array(),
                            'title' => array()
                        ),
                        'br' => array(),
                        'em' => array(),
                        'strong' => array(),
                    );

                    echo wp_kses($box_info, $allowed_html);
                }
            ?>   
            </li>                         
        <?php
        endif;
    }
}

 /**
 * Yanka promobar
 */
 if ( ! function_exists( 'yanka_promo_bar' ) ) {
    function yanka_promo_bar() {
       $promo_bar            = yanka_get_option('promo-bar', 0);
       $promo_bar_text       = yanka_get_option('promo-bar-text', '');

       if ( ! $promo_bar ) return;
       ?>

       <div class="yanka-promo-bar">
           <div class="container">
                <?php
                    if ( isset($promo_bar_text) && $promo_bar_text != '' ) {
                        $allowed_html = array(
                            'a' => array(
                                'href' => array(),
                                'title' => array()
                            ),
                            'br' => array(),
                            'em' => array(),
                            'strong' => array(),
                        );

                        echo wp_kses($promo_bar_text, $allowed_html);
                    }

                ?>
           </div>
       </div>
       <?php
    }
 }

/**
 * Social Dropdown
 */

if ( ! function_exists( 'yanka_social' )  ) {
    function yanka_social() { 
        $social_name_1  = yanka_get_option('social-name-1', 'Facebook');
        $social_name_2  = yanka_get_option('social-name-2', 'Twitter');
        $social_name_3  = yanka_get_option('social-name-3', 'Instagram');
        $social_link_1 = yanka_get_option( 'social-link-1', '#' );
        $social_link_2 = yanka_get_option( 'social-link-2', '#' );
        $social_link_3 = yanka_get_option( 'social-link-3', '#' );

        if ( $social_link_1 ||  $social_link_2 || $social_link_3 ) :
        ?>

            <div class="btn-group compact-hidden box-hover">
                <ul>
                    <?php if ( $social_link_1 ) : ?>
                        <li>
                            <a target="_blank" href="<?php echo esc_url( $social_link_1 ); ?>">
                                <span class="icon">
                                    <svg width="11" height="19" viewBox="0 0 11 19">
                                        <use xlink:href="#icon-social_icon_facebook"></use>
                                    </svg>
                                </span>                            
                                <span class="text"><?php echo esc_html( $social_name_1 ); ?></span> 
                            </a>
                        </li>
                    <?php endif; ?> 

                    <?php if ( $social_link_2 ) : ?>
                        <li>
                            <a target="_blank" href="<?php echo esc_url( $social_link_2 ); ?>">
                                <span class="icon">
                                    <svg width="18" height="18" viewBox="0 0 18 18">
                                        <use xlink:href="#icon-social_icon_1"></use>
                                    </svg>
                                </span>                            
                                <span class="text"><?php echo esc_html( $social_name_2 ); ?></span> 
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ( $social_link_3 ) : ?>
                        <li>
                            <a target="_blank" href="<?php echo esc_url( $social_link_3 ); ?>">
                                <span class="icon">
                                    <svg width="18" height="19" viewBox="0 0 18 19">
                                        <use xlink:href="#icon-social_icon_instagram"></use>
                                    </svg>
                                </span>                            
                                <span class="text"><?php echo esc_html( $social_name_3 ); ?></span> 
                            </a>
                        </li>
                    <?php endif; ?>                                                           
                </ul>
            </div>
        
        <?php endif;        
    }
}

/**
 * Language Dropdown
 */

if ( ! function_exists( 'yanka_language' )  ) {
    function yanka_language() { 
        if ( function_exists('icl_object_id') ) {
            dynamic_sidebar("language-sidebar");
        }else{
        ?>

            <div class="btn-group compact-hidden box-hover">
                <a href="javascript:void(0)" class="dropdown-toggle language-dropdown"><?php echo esc_html__( 'Eng', 'yanka' ); ?>
                    <span class="pt-icon">
                        <svg width="12" height="7" viewBox="0 0 12 7">
                            <use xlink:href="#icon-arrow_small_bottom"></use>
                        </svg>
                    </span>                    
                </a>
                <div class="dropdown-menu">
                    <ul>
                        <li><a href="javascript:void(0)"><?php echo esc_html__( 'Eng', 'yanka' ); ?></a></li>
                        <li><a href="javascript:void(0)"><?php echo esc_html__( 'Ger', 'yanka' ); ?></a></li>
                        <li><a href="javascript:void(0)"><?php echo esc_html__( 'Deutsch', 'yanka' ); ?></a></li>
                    </ul>
                </div>
            </div>
        <?php
        }
    }
}

/**
 * Language Dropdown
 */

if ( ! function_exists( 'yanka_language_mobile' )  ) {
    function yanka_language_mobile() { 
        if ( function_exists('icl_object_id') ) {
            dynamic_sidebar("language-sidebar");
        }else{
        ?>
            <div class="btn-group"><?php echo esc_html__( 'Languages :', 'yanka' ); ?></div>
            <ul>
                <li><a href="javascript:void(0)"><?php echo esc_html__( 'English', 'yanka' ); ?></a></li>
                        <li><a href="javascript:void(0)"><?php echo esc_html__( 'Italiano', 'yanka' ); ?></a></li>
                        <li><a href="javascript:void(0)"><?php echo esc_html__( 'French', 'yanka' ); ?></a></li>
            </ul>
        <?php
        }
    }
}

/*  Render Footer Social Icons
/* --------------------------------------------------------------------- */
if ( ! function_exists( 'yanka_social_icons' ) ) {
    function yanka_social_icons() {
        $facebook    = yanka_get_option( 'facebook' );
        $googleplus  = yanka_get_option( 'twitter' );
        $twitter     = yanka_get_option( 'google-plus' );
        $pinterest   = yanka_get_option( 'pinterest' );
        $instagram   = yanka_get_option( 'instagram' );
        $vimeo       = yanka_get_option( 'vimeo' );
        $youtube     = yanka_get_option( 'youtube' );
        $dribbble    = yanka_get_option( 'dribbble' );
        $tumblr      = yanka_get_option( 'tumblr' );
        $linkedin    = yanka_get_option( 'linkedin' );
        $flickr      = yanka_get_option( 'flickr' );
        $github      = yanka_get_option( 'github' );
        $lastfm      = yanka_get_option( 'lastfm' );
        $paypal      = yanka_get_option( 'paypal' );
        $wordpress   = yanka_get_option( 'wordpress' );
        $skype       = yanka_get_option( 'skype' );
        $yahoo       = yanka_get_option( 'yahoo' );
        $reddit      = yanka_get_option( 'reddit' );
        $deviantart  = yanka_get_option( 'deviantart' );
        $steam       = yanka_get_option( 'steam' );
        $foursquare  = yanka_get_option( 'foursquare' );
        $behance     = yanka_get_option( 'behance' );
        $blogger     = yanka_get_option( 'blogger' );
        $xing        = yanka_get_option( 'xing' );
        $stumbleupon = yanka_get_option( 'stumbleupon' );
        ?>
        <ul class="social-list-icons">
            <?php if ( ! empty($facebook) ) : ?>
                <li><a href="<?php echo esc_url($facebook); ?>"><i class="fa fa-facebook"></i></a></li>
            <?php endif; ?>

            <?php if ( ! empty($googleplus) ) : ?>
                <li><a href="<?php echo esc_url($googleplus); ?>"><i class="fa fa-google-plus"></i></a></li>
            <?php endif; ?>

            <?php if ( ! empty($twitter) ) : ?>
                <li><a href="<?php echo esc_url($twitter); ?>"><i class="fa fa-twitter"></i></a></li>
            <?php endif; ?>

            <?php if ( ! empty($pinterest) ) : ?>
                <li><a href="<?php echo esc_url($pinterest); ?>"><i class="fa fa-pinterest"></i></a></li>
            <?php endif; ?>

            <?php if ( ! empty($instagram) ) : ?>
                <li><a href="<?php echo esc_url($instagram); ?>"><i class="fa fa-instagram"></i></a></li>
            <?php endif; ?>

            <?php if ( ! empty($vimeo) ) : ?>
                <li><a href="<?php echo esc_url($vimeo); ?>"><i class="fa fa-vimeo"></i></a></li>
            <?php endif; ?>

            <?php if ( ! empty($youtube) ) : ?>
                <li><a href="<?php echo esc_url($youtube); ?>"><i class="fa fa-youtube"></i></a></li>
            <?php endif; ?>

            <?php if ( ! empty($dribbble) ) : ?>
                <li><a href="<?php echo esc_url($dribbble); ?>"><i class="fa fa-dribbble"></i></a></li>
            <?php endif; ?>

            <?php if ( ! empty($tumblr) ) : ?>
                <li><a href="<?php echo esc_url($tumblr); ?>"><i class="fa fa-tumblr"></i></a></li>
            <?php endif; ?>

            <?php if ( ! empty($linkedin) ) : ?>
                <li><a href="<?php echo esc_url($linkedin); ?>"><i class="fa fa-linkedin"></i></a></li>
            <?php endif; ?>

            <?php if ( ! empty($flickr) ) : ?>
                <li><a href="<?php echo esc_url($flickr); ?>"><i class="fa fa-flickr"></i></a></li>
            <?php endif; ?>

            <?php if ( ! empty($github) ) : ?>
                <li><a href="<?php echo esc_url($github); ?>"><i class="fa fa-github"></i></a></li>
            <?php endif; ?>

            <?php if ( ! empty($lastfm) ) : ?>
                <li><a href="<?php echo esc_url($lastfm); ?>"><i class="fa fa-lastfm"></i></a></li>
            <?php endif; ?>

            <?php if ( ! empty($paypal) ) : ?>
                <li><a href="<?php echo esc_url($paypal); ?>"><i class="fa fa-paypal"></i></a></li>
            <?php endif; ?>

            <?php if ( ! empty($wordpress) ) : ?>
                <li><a href="<?php echo esc_url($wordpress); ?>"><i class="fa fa-wordpress"></i></a></li>
            <?php endif; ?>

            <?php if ( ! empty($skype) ) : ?>
                <li><a href="<?php echo esc_url($skype); ?>"><i class="fa fa-skype"></i></a></li>
            <?php endif; ?>

            <?php if ( ! empty($yahoo) ) : ?>
                <li><a href="<?php echo esc_url($yahoo); ?>"><i class="fa fa-yahoo"></i></a></li>
            <?php endif; ?>

            <?php if ( ! empty($reddit) ) : ?>
                <li><a href="<?php echo esc_url($reddit); ?>"><i class="fa fa-reddit"></i></a></li>
            <?php endif; ?>

            <?php if ( ! empty($deviantart) ) : ?>
                <li><a href="<?php echo esc_url($deviantart); ?>"><i class="fa fa-deviantart"></i></a></li>
            <?php endif; ?>

            <?php if ( ! empty($steam) ) : ?>
                <li><a href="<?php echo esc_url($steam); ?>"><i class="fa fa-steam"></i></a></li>
            <?php endif; ?>

            <?php if ( ! empty($foursquare) ) : ?>
                <li><a href="<?php echo esc_url($foursquare); ?>"><i class="fa fa-foursquare"></i></a></li>
            <?php endif; ?>

            <?php if ( ! empty($behance) ) : ?>
                <li><a href="<?php echo esc_url($behance); ?>"><i class="fa fa-behance"></i></a></li>
            <?php endif; ?>

            <?php if ( ! empty($xing) ) : ?>
                <li><a href="<?php echo esc_url($xing); ?>"><i class="fa fa-xing"></i></a></li>
            <?php endif; ?>

            <?php if ( ! empty($stumbleupon) ) : ?>
                <li><a href="<?php echo esc_url($stumbleupon); ?>"><i class="fa fa-stumbleupon"></i></a></li>
            <?php endif; ?>

        </ul>
        <?php
    }
}

// -- Render Header Layout
if ( ! function_exists( 'yanka_header' ) ) {
    function yanka_header() {
        global $post;

        // Get page options
        $options = get_post_meta( get_the_ID(), '_custom_page_options', true );

        $stickyHeader      = yanka_get_option('sticky-header', 0);
        $positionHeader    = yanka_get_option('position-header', 0);
        $header_design     = yanka_get_option('header-layout', 1);
        $header_fullwidth  = yanka_get_option('header-fullwidth', 0);

        if ( isset( $options['page-header'] ) && $options['page-header'] != '' ) {
            $header_design = $options['page-header'];
        }

        if ( isset( $options['header-fullwidth'] ) && $options['header-fullwidth'] != '' ) {
            $header_fullwidth = $options['header-fullwidth'];
        }

        // HEADER CLASS ARRAY
        $header_class = array();

        if ( isset( $header_design ) && $header_design != '' ) {
            $header_classes[] = 'header-' . $header_design;
        }

        if ( isset($_GET['header-absolute']) && $_GET['header-absolute'] == 1 ) {
            $positionHeader = 1;
        }

        if ( isset( $positionHeader ) && $positionHeader == 1 ) {
            $header_classes[] = 'header-absolute';
        }

        if ( isset($header_fullwidth) && $header_fullwidth == 1 ) {
            $header_classes[] = 'header-fullwidth';
        }

        if ( isset($_GET['sticky']) && $_GET['sticky'] == 1 ) {
            $stickyHeader = 1;
        } elseif ( isset($_GET['sticky']) && $_GET['sticky'] == 0 ) {
            $stickyHeader = 0;
        }
        
        ?>


        <?php if ( isset($stickyHeader) && $stickyHeader == 1 ) get_template_part('template-parts/header/header', 'sticky'); ?>
        <header class="header-wrapper <?php echo implode(' ', $header_classes); ?>">
            <?php get_template_part( 'template-parts/header/header', $header_design ); ?>
        </header>
        <?php
    }
}


if ( ! function_exists( 'yanka_header_landingpage' ) ) {
    function yanka_header_landingpage() {
        ?>
        <header class="header-wrapper has-sticky-header-intro">
            <?php get_template_part( 'template-parts/header/header', 'landingpage' ); ?>
        </header>
        <?php        
    }   
}

// -- Render Header Layout
if ( ! function_exists( 'yanka_header_mobile' ) ) {
    function yanka_header_mobile() {
        global $post;

        // Get page options
        $options = get_post_meta( get_the_ID(), '_custom_page_options', true );

        $stickyHeader      = yanka_get_option('sticky-header', 0);
        $header_design     = yanka_get_option('header-layout', 1);

        if ( isset( $options['page-header'] ) && $options['page-header'] != '' ) {
            $header_design = $options['page-header'];
        }

        // HEADER CLASS ARRAY
        $header_class = array();

        if ( isset($_GET['sticky']) && $_GET['sticky'] == 1 ) {
            $stickyHeader = 1;
        } elseif ( isset($_GET['sticky']) && $_GET['sticky'] == 0 ) {
            $stickyHeader = 0;
        }

        if ( isset( $header_design ) && $header_design != '' ) {
            $header_classes[] = 'mobile-header-' . $header_design;
        }
        
        ?>

        <?php 
            if ( isset($stickyHeader) && $stickyHeader == 1)
                if ( !wp_is_mobile() ) {
                    get_template_part('template-parts/header/header', 'sticky');     
                } else {
                    get_template_part('template-parts/header/header', 'sticky-mobile');     
                }
                
        ?>
        <header class="header-wrapper header-mobile <?php echo implode(' ', $header_classes); ?>">
            <?php get_template_part( 'template-parts/header/header', 'mobile' ); ?>
        </header>
        <?php
    }
}

/*  Header Logo
/* --------------------------------------------------------------------- */
if ( ! function_exists( 'yanka_logo' ) ){
    function yanka_logo(){?>

        <?php 
        $header_logo = yanka_get_option('header-logo');

        $_id = get_the_ID();

        if( is_shop() ){
            $_id = wc_get_page_id('shop');
        }

        $options = get_post_meta( $_id, '_custom_page_options', true );

        if( isset( $header_logo['url'] ) && !empty( $header_logo['url'] ) ) {
            $header_url = $header_logo['url'];
        }

        if ( isset( $options['header-logo-page'] ) && $options['header-logo-page'] != '' ) {
            $attachment = wp_get_attachment_image_src( $options['header-logo-page'], 'full' );
            $image_id = $options['header-logo-page'];
            $header_logo_image = wp_get_attachment_image_src( $image_id, 'full' );

            if ( isset($header_logo_image) && $header_logo_image != '' ) {
                $header_url = esc_url($attachment[0]);
            }
        }
        ?>

        <?php if( isset( $header_url ) && !empty( $header_url ) ) : ?>
            <a class="logo_image" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                <img src="<?php echo esc_url( $header_url );?>" alt="<?php bloginfo( 'name' ); ?>">
            </a>
        <?php else: ?>
            <a class="logo_image" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                <img src="<?php echo YANKA_URL . '/assets/images/logo.png'; ?>" alt="<?php bloginfo( 'name' ); ?>">
            </a>
        <?php endif;
    }
}

/**
 * Create a breadcrumb menu.
 *
 * @return string
 */
if ( ! function_exists( 'yanka_breadcrumb' ) ) {
    function yanka_breadcrumb() {
        // Settings
        $sep   = '<span></span>';

        // Get the query & post information
        global $post, $wp_query;

        // Get post category
        $category = get_the_category();

        // Get product category
        $product_cat = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

        if ( $product_cat ) {
            $tax_title = $product_cat->name;
        }

        $output = '';

        // Build the breadcrums
        $output .= '<div class="breadcrumb">';

        // Do not display on the homepage
        if ( ! is_front_page() ) {

            if ( ( function_exists( 'is_shop' ) && is_shop() ) || ( function_exists( 'is_product' ) && is_product() ) || function_exists( 'is_product_category' ) && is_product_category() || function_exists( 'is_product_tag' ) && is_product_tag() ) {
                do_action('yanka_woocommerce_breadcrumb');
            } elseif ( is_home() ) {

                // Home page
                $output .= '<a href="' . esc_url( get_home_url() ) . '">' . esc_html__( 'Home', 'yanka' ) . '</a>';
                $output .= $sep;
                $output .= esc_html__( 'Blog', 'yanka' );
            } elseif ( is_post_type_archive() ) {
                $post_type = get_post_type_object( get_post_type() );
                $output .= '<a href="' . esc_url( get_home_url() ) . '">' . esc_html__( 'Home', 'yanka' ) . '</a>';
                $output .= ' ' . $sep . ' ';
                $output .= $post_type->labels->singular_name;
            } elseif ( is_tax() ) {
                $term = $GLOBALS['wp_query']->get_queried_object();
                $output .= '<a href="' . esc_url( get_home_url() ) . '">' . esc_html__( 'Home', 'yanka' ) . '</a>';
                $output .= ' ' . $sep . ' ';
                $output .= $term->name;
            } elseif ( is_single() ) {
                $output .= '<a href="' . esc_url( get_home_url() ) . '">' . esc_html__( 'Home', 'yanka' ) . '</a>';
                $output .= ' ' . $sep . ' ';
                // Single post (Only display the first category)
                if ( ! empty( $category ) ) {
                    $output .= '<a href="' . esc_url( get_category_link( $category[0]->term_id ) ) . '">' . esc_html( $category[0]->cat_name ). '</a>';
                    $output .= ' ' . $sep . ' ';
                }
                $output .= get_the_title();

            } elseif ( is_category() ) {
                $output .= '<a href="' . esc_url( get_home_url() ) . '">' . esc_html__( 'Home', 'yanka' ) . '</a>';
                $output .= ' ' . $sep . ' ';
                $thisCat = get_category( get_query_var( 'cat' ), false );
                if ( $thisCat->parent != 0 ) echo get_category_parents( $thisCat->parent, TRUE, ' ' );

                // Category page
                $output .= single_cat_title( '', false );

            } elseif ( is_page() ) {
                $output .= '<a href="' . esc_url( get_home_url() ) . '">' . esc_html__( 'Home', 'yanka' ) . '</a>';
                $output .= ' ' . $sep . ' ';

                // Standard page
                if ( $post->post_parent ) {

                    // If child page, get parents
                    $anc = get_post_ancestors( $post->ID );

                    // Get parents in the right order
                    $anc = array_reverse($anc);

                    // Parent page loop
                    foreach ( $anc as $ancestor ) {
                        $parents = '<a href="' . esc_url( get_permalink( $ancestor ) ) . '">' . get_the_title( $ancestor ) . '</a>';
                        $parents .= ' ' . $sep . ' ';
                    }

                    // Display parent pages
                    $output .= $parents;

                    // Current page
                    $output .= get_the_title();

                } else {

                    // Just display current page if not parents
                    $output .= get_the_title();

                }

            } elseif ( is_tag() ) {

                // Tag page

                // Get tag information
                $term_id  = get_query_var( 'tag_id' );
                $taxonomy = 'post_tag';
                $args     = 'include=' . $term_id;
                $terms    = get_terms( $taxonomy, $args );

                $output .= '<a href="' . esc_url( get_home_url() ) . '">' . esc_html__( 'Home', 'yanka' ) . '</a>';
                $output .= ' ' . $sep . ' ';
                // Display the tag name
                $output .= $terms[0]->name;

            } elseif ( is_day() ) {
                $output .= '<a href="' . esc_url( get_home_url() ) . '">' . esc_html__( 'Home', 'yanka' ) . '</a>';
                $output .= ' ' . $sep . ' ';
                // Day archive

                // Year link
                $output .= '<a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . get_the_time( 'Y' ) . esc_html__( ' Archives', 'yanka' ) . '</a>';
                $output .= ' ' . $sep . ' ';

                // Month link
                $output .= '<a href="' . esc_url( get_month_link( get_the_time('Y'), get_the_time( 'm' ) ) ) . '">' . get_the_time( 'M' ) . esc_html__( ' Archives', 'yanka' ) . '</a';
                $output .= ' ' . $sep . ' ';

                // Day display
                $output .= get_the_time('jS') . ' ' . get_the_time('M') . esc_html__( ' Archives', 'yanka' );

            } elseif ( is_month() ) {
                $output .= '<a href="' . esc_url( get_home_url() ) . '">' . esc_html__( 'Home', 'yanka' ) . '</a>';
                $output .= ' ' . $sep . ' ';
                // Month Archive

                // Year link
                $output .= '<a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . get_the_time( 'Y' ) . esc_html__( ' Archives', 'yanka' ) . '</a>';
                $output .= ' ' . $sep . ' ';

                // Month display
                $output .= get_the_time( 'M' ) . esc_html__( ' Archives', 'yanka' );

            } elseif ( is_year() ) {
                $output .= '<a href="' . esc_url( get_home_url() ) . '">' . esc_html__( 'Home', 'yanka' ) . '</a>';
                $output .= ' ' . $sep . ' ';
                // Display year archive
                $output .= get_the_time('Y') . esc_html__( 'Archives', 'yanka' );

            } elseif ( is_author() ) {
                $output .= '<a href="' . esc_url( get_home_url() ) . '">' . esc_html__( 'Home', 'yanka' ) . '</a>';
                $output .= ' ' . $sep . ' ';
                // Auhor archive

                // Get the author information
                global $author;
                $userdata = get_userdata( $author );

                // Display author name
                $output .= esc_html__( 'Author: ', 'yanka' ) . esc_html( $userdata->display_name );

            } elseif ( get_query_var('paged') ) {
                $output .= '<a href="' . esc_url( get_home_url() ) . '">' . esc_html__( 'Home', 'yanka' ) . '</a>';
                $output .= ' ' . $sep . ' ';
                // Paginated archives
                $output .= esc_html__( 'Page', 'yanka' ) . ' ' . get_query_var( 'paged' );

            } elseif ( is_search() ) {
                $output .= '<a href="' . esc_url( get_home_url() ) . '">' . esc_html__( 'Home', 'yanka' ) . '</a>';
                $output .= ' ' . $sep . ' ';
                // Search results page
                $output .= esc_html__( 'Search results for: ' . get_search_query(), 'yanka' );

            } elseif ( is_404() ) {

                // 404 page
                $output .= '<a href="' . esc_url( get_home_url() ) . '">' . esc_html__( 'Home', 'yanka' ) . '</a>';
                $output .= ' ' . $sep . ' ';
                $output .= esc_html__( 'Error 404', 'yanka' );
            }

        } else  {
            $output .= '<a href="' . esc_url( get_home_url() ) . '">' . esc_html__( 'Home', 'yanka' ) . '</a>';
            $output .= ' ' . $sep . ' ';
            $output .= esc_html__( 'Front Page', 'yanka' );
        }

        $output .= '</div>';

        return apply_filters( 'yanka_breadcrumb', $output );
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * Get post image
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'yanka_get_post_thumbnail' ) ) {
    function yanka_get_post_thumbnail( $size = 'medium', $attach_id = false ) {
        global $post, $yanka_loop;

        if ( has_post_thumbnail() ) {

            if( function_exists( 'wpb_getImageBySize' ) ) {
                if( ! $attach_id ) $attach_id = get_post_thumbnail_id();

                if( ! empty( $yanka_loop['img_size'] ) ) $size = $yanka_loop['img_size'];

                $img = wpb_getImageBySize( array( 'attach_id' => $attach_id, 'thumb_size' => $size, 'class' => 'attachment-large wp-post-image' ) );
                $img = $img['thumbnail'];

            } else {
                $img = get_the_post_thumbnail( $post->ID, $size );
            }

            return $img;
        }
    }
}


/**
 * Prints post date.
 *
 * @return string
 */
if( ! function_exists( 'yanka_post_date' ) ) {
    function yanka_post_date() {
        $has_title = get_the_title() != '';

        $attr = '';

        if( ! $has_title && ! is_single() ) {
            $attr = ' onclick="window.location=\''. get_the_permalink() .'\';"';
        }
        ?>
            <div class="post-date">
                <span class="post-date-day">
                    <?php echo get_the_time('d') ?>
                </span>
                <span class="post-date-month">
                    <?php echo get_the_time('M') ?>
                </span>
            </div>
        <?php
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * Display meta information for a specific post
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'yanka_post_meta' )) {
    function yanka_post_meta() {
        $show_date       = yanka_get_option('show-date', 0);
        $show_author     = yanka_get_option('show-author', 1);
        $show_comments   = yanka_get_option('show-comment', 1);
        $show_categories = yanka_get_option('show-category', 1);

        ?>
        <ul class="entry-meta-list">
            <?php if( get_post_type() === 'post' ): ?>

                <?php if( is_sticky() ): ?>
                    <li class="meta-featured-post"><?php esc_html_e( 'Featured', 'yanka' ) ?></li>
                <?php endif; ?>

                <?php // Author ?>
                <?php if ($show_author == 1): ?>
                    <li class="meta-author">
                        <?php esc_html_e('By', 'yanka'); ?>
                        <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php echo get_the_author(); ?></a>
                    </li>
                <?php endif ?>
                <?php // Date ?>
                <?php if( $show_date == 1): ?>
                    <li class="meta-date">
                        <a href="<?php echo esc_url( get_permalink() ); ?>" class="time updated"><?php echo get_the_date(); ?></a>
                    </li>
                <?php endif; ?>
                <?php // Comments ?>
                <?php if( $show_comments && comments_open() ): ?>
                    <li class="meta-comment">
                        <?php
                            $comment_link_template = '<span class="comments-count">%s %s</span>';
                         ?>
                        <?php comments_popup_link(
                            sprintf( $comment_link_template, '0', esc_html__( 'comments', 'yanka' ) ),
                            sprintf( $comment_link_template, '1', esc_html__( 'comment', 'yanka' ) ),
                            sprintf( $comment_link_template, '%', esc_html__( 'comments', 'yanka' ) )
                        ); ?>
                    </li>
                <?php endif; ?>
                <?php if ( get_the_category_list( ', ' ) && $show_categories ) : ?>
                    <li class="meta-categories"><?php echo get_the_category_list( ', ' ); ?></li>
                <?php endif ?>
            <?php endif; ?>
        </ul>
        <?php
    }
}

if( ! function_exists( 'yanka_post_meta_custom' )) {
    function yanka_post_meta_custom() {
        $show_date       = yanka_get_option('show-date', 0);
        $show_author     = yanka_get_option('show-author', 1);
        $show_comments   = yanka_get_option('show-comment', 1);
        $show_categories = yanka_get_option('show-category', 1);

        ?>
        <div class="pt-meta">
            <ul class="entry-meta-list custom">
                <?php if( get_post_type() === 'post' ): ?>

                    <?php if( is_sticky() ): ?>
                        <li class="meta-featured-post"><?php esc_html_e( 'Featured', 'yanka' ) ?></li>
                    <?php endif; ?>

                    <?php // Author ?>
                    <?php if ($show_author == 1): ?>
                        <li class="meta-author">
                            <?php esc_html_e('by', 'yanka'); ?>
                            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php echo get_the_author(); ?></a>
                        </li>
                    <?php endif ?>
                    <?php // Date ?>
                    <?php if( $show_date == 1): ?>
                        <li class="meta-date">
                            <?php esc_html_e( 'on', 'yanka' ) ?> <a href="<?php echo esc_url( get_permalink() ); ?>" class="time updated"><?php echo get_the_date(); ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if ( get_the_category_list( ', ' ) && $show_categories ) : ?>
                        <li class="meta-categories"><span class="meta_in"><?php esc_html_e( 'in', 'yanka' ) ?> </span><?php echo get_the_category_list( ', ' ); ?></li>
                    <?php endif ?>
                <?php endif; ?>
            </ul>

            <div class="pt-comments">
                <?php // Comments ?>
                <?php if( $show_comments && comments_open() ): ?>
                    <?php
                        $comment_link_template = '<span class="comments-count"><i class="pt-icon"></i> %s %s</span>';
                     ?>
                    <?php comments_popup_link(
                        sprintf( $comment_link_template, '0', esc_html__( 'comment(s)', 'yanka' ) ),
                        sprintf( $comment_link_template, '1', esc_html__( 'comment(s)', 'yanka' ) ),
                        sprintf( $comment_link_template, '%', esc_html__( 'comment(s)', 'yanka' ) )
                    ); ?>
                <?php endif; ?>                
            </div>            
        </div>
        <?php
    }
}

// **********************************************************************//
// ! Get exceprt from post content
// **********************************************************************//

if( ! function_exists( 'yanka_excerpt_from_content' ) ) {
    function yanka_excerpt_from_content($post_content, $limit, $shortcodes = '') {
        // Strip shortcodes and HTML tags
        if ( empty( $shortcodes )) {
            $post_content = preg_replace("/\[caption(.*)\[\/caption\]/i", '', $post_content);
            $post_content = preg_replace('`\[[^\]]*\]`','',$post_content);
        }

        $post_content = stripslashes( wp_filter_nohtml_kses( $post_content ) );

        if ( yanka_get_option( 'blog-words-or-letters' ) == 'letter' ) {
            $excerpt = mb_substr( $post_content, 0, $limit );
            if ( mb_strlen( $excerpt ) >= $limit ) {
                $excerpt .= '...';
            }
        } else{
            $limit++;
            $excerpt = explode(' ', $post_content, $limit);
            if ( count( $excerpt) >= $limit ) {
                array_pop( $excerpt );
                $excerpt = implode( " ", $excerpt ) . '...';
            } else {
                $excerpt = implode( " ", $excerpt );
            }
        }

        $excerpt = strip_tags( $excerpt );

        if ( trim( $excerpt ) == '...' ) {
            return '';
        }

        return $excerpt;
    }
}

/**
 * Get post content
 *
 * @since 1.0.0
 */
if( ! function_exists( 'yanka_get_content' ) ) {
    function yanka_get_content( $btn = true ) {
        global $post;

        if ( ! empty( $post->post_excerpt ) ) {
            the_excerpt();
        } else {
            $excerpt_length = apply_filters( 'yanka_get_excerpt_length', yanka_get_option( 'blog-excerpt-length' ) );
            echo yanka_excerpt_from_content( $post->post_content, $excerpt_length );
        }
        
        yanka_post_meta_custom();
        
        if( $btn ) {
            echo '<p class="read-more-section"><a class="btn-read-more more-link" href="' . get_permalink() . '">' . esc_html__('read more', 'yanka') . '</a></p>';
        }

    }
}

/**
 *
 * Limit Post Excerpt Length
 *
 */
if ( ! function_exists('yanka_post_excerpt') ) {
    function yanka_post_excerpt( $limit ) {
        $excerpt = explode(' ', get_the_excerpt(), $limit);

        if ( count($excerpt) >= $limit ) {
            array_pop( $excerpt );
            $excerpt = implode(" ",$excerpt).'...';
        } else {
            $excerpt = implode(" ",$excerpt);
        }

        $excerpt = preg_replace('`[[^]]*]`','',$excerpt);

        echo esc_html($excerpt);
    }
}

/**
 * Custom function to use to open and display each comment
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'yanka_comments_list' ) ) {
    function yanka_comments_list( $comment, $args, $depth ) {
    // Globalize comment object
        $GLOBALS['comment'] = $comment;

        switch ( $comment->comment_type ) :

            case 'pingback'  :
            case 'trackback' :
                ?>
                <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                    <p>
                        <?php
                            echo esc_html__( 'Pingback:', 'yanka' );
                            comment_author_link();
                            edit_comment_link( esc_html__( 'Edit', 'yanka' ), '<span class="edit-link">', '</span>' );
                        ?>
                    </p>
                <?php
            break;

            default :
                global $post;
                ?>
                <li <?php comment_class( 'mb_60' ); ?> id="li-comment-<?php comment_ID(); ?>">
                    <article id="comment-<?php comment_ID(); ?>" class="comment_container">
                        <?php echo get_avatar( $comment, 80 ); ?>

                        <div class="comment-text">
                            <?php if ( '0' == $comment->comment_approved ) : ?>
                                <p class="comment-awaiting-moderation"><?php echo esc_html__( 'Your comment is awaiting moderation.', 'yanka' ); ?></p>
                            <?php endif; ?>

                            <?php
                                printf(
                                '<h5 class="comment-author">By <span>%1$s</span> '.get_comment_date().'</h5>',
                                    get_comment_author_link(),
                                    ( $comment->user_id == $post->post_author ) ? '<span class="author-post">' . esc_html__( 'Post author', 'yanka' ) . '</span>' : ''
                                );
                            ?>
                            <div>
                                <?php comment_text(); ?>
                            </div>


                            <div class="flex">
                                <?php
                                    printf('<span class="grow pt-grow"></span>');
                                ?>
                                <?php
                                    edit_comment_link( wp_kses( '<span>' . esc_html__( 'Edit', 'yanka' ) . '</span>' , 'allowed-html') );
                                    comment_reply_link(
                                        array_merge(
                                            $args,
                                            array(
                                                'reply_text' => wp_kses( '<span class="ml__10">' . esc_html__( 'Reply', 'yanka' ) . '</span>', 'allowed-html' ),
                                                'depth'      => $depth,
                                                'max_depth'  => $args['max_depth'],
                                            )
                                        )
                                    );
                                ?>
                            </div><!-- .action-link -->
                        </div><!-- .comment-content -->
                    </article><!-- #comment- -->
                <?php
            break;

        endswitch;
    }
}

/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @return string
 */
if ( ! function_exists( 'yanka_post_pagination' ) ) {
    function yanka_post_pagination( $nav_query = false ) {

        global $wp_query, $wp_rewrite;

        // Don't print empty markup if there's only one page.
        if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
            return;
        }

        // Prepare variables
        $query        = $nav_query ? $nav_query : $wp_query;
        $max          = $query->max_num_pages;
        $current_page = max( 1, get_query_var( 'paged' ) );
        $big          = 999999;
        ?>
        <div class="yanka-pagination">
            <?php
                echo '' . paginate_links(
                    array(
                        'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format'    => '?paged=%#%',
                        'current'   => $current_page,
                        'total'     => $max,
                        'type'      => 'list',
                        'prev_text' => '<i class="fa fa-angle-left"></i>',
                        'next_text' => '<i class="fa fa-angle-right"></i>',
                    )
                ) . ' ';
            ?>
        </div><!-- .page-nav -->
        <?php
    }
}

/**
 * Render post categories.
 */
if ( ! function_exists( 'yanka_post_categories' ) ) {
    function yanka_post_categories() {
        $categories_list = get_the_category_list( ' ' );
        if ( $categories_list ) {
            echo apply_filters( 'yanka_post_categories', '<div class="post-category mb_20">' . $categories_list . '</div>' );
        }
    }
}

// **********************************************************************//
// ! Get page ID by it's template name
// **********************************************************************//
if( ! function_exists( 'yanka_template_id' ) ) {
    function yanka_template_id( $tpl = '' ) {
        $pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => $tpl
        ));
        foreach($pages as $page){
            return $page->ID;
        }
    }
}


/**
 * Next and previous article
 */

if ( ! function_exists('yanka_post_navigation')) {
    function yanka_post_navigation() {

        $next_post = get_next_post();
        $prev_post = get_previous_post();

        $archive_url = '';

        if( get_post_type() == 'post' ) {
            $archive_url = get_post_type_archive_link( 'posts' );
        } else if( get_post_type() == 'portfolio' ) {
            $archive_url = get_post_type_archive_link( 'portfolio' );
        }
        ?>

        <div class="post-navigation flex between-xs middle-xs">
            <?php if (!empty($prev_post)) : ?>
                <div class="post-prev-post">
                    <div class="post-next-prev-content pr pl_40">
                        <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>">
                        <span class="db label-text"><?php esc_html_e('Older', 'yanka'); ?></span>
                        <div><?php echo get_the_title( $prev_post->ID ); ?></div>
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ( $archive_url && 'page' == get_option( 'show_on_front' ) ): ?>
                <div class="back-to-archive">
                    <a href="<?php echo esc_url( $archive_url ); ?>"></a>
                </div>
            <?php endif ?>

            <?php if (!empty($next_post)) : ?>
                <div class="post-next-post tr">
                    <div class="post-next-prev-content pr pr_40">
                        <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>">
                            <span class="db label-text"><?php esc_html_e('Newer', 'yanka'); ?></span>
                            <div><?php echo get_the_title( $next_post->ID ); ?></div>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}

/**
 * Render related post based on post tags.
 */
if ( ! function_exists( 'yanka_related_posts' ) ) {
    function yanka_related_posts() {
        global $post;

        // Get post's tags
        $taxs = wp_get_post_tags( get_the_ID() );

        if ( $taxs ) {
            // Get id for all tags
            $tag_ids = array();

            foreach( $taxs as $individual_tax ) $tax_ids[] = $individual_tax->term_id;

            // Build arguments to query for related posts
            $args = array(
                'tag__in'               => $tax_ids,
                'post__not_in'          => array( $post->ID ),
                'showposts'             => 6,
                'ignore_sticky_posts'   => 1
            );

            // Get related post
            $related = new wp_query( $args );
            ?>

            <div class="yanka-related-posts mt_50">
                <div class="addon-title">
                    <h3 class="title"><?php echo esc_html__('Related Posts', 'yanka'); ?></h3>
                </div>
                <div class="related-posts-carousel owl-carousel owl-theme">
                    <?php
                    while ( $related->have_posts() ) :
                        $related->the_post(); ?>

                        <div class="item">
                            <article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post-loop blog-design-slider blog-style-flat' ); ?>>
                                <div class="article-inner">
                                    <?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
                                        <header class="entry-header pr">
                                            <figure class="entry-thumbnail">
                                                <div class="post-img-wrap">
                                                    <a href="<?php echo esc_url( get_permalink() ); ?>">
                                                        <?php echo yanka_get_post_thumbnail( '500x400' );
                                                        ?>
                                                    </a>
                                                </div>
                                            </figure>
                                        </header><!-- .entry-header -->
                                    <?php endif; ?>

                                    <div class="article-body-container">
                                        <h3 class="blog-title entry-title">
                                            <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_title(); ?></a>
                                        </h3>
                                        <ul class="blog-meta entry-meta-list">
                                            <li class="meta-date"><a href="<?php echo esc_url( get_permalink() ); ?>" class="time updated"><?php echo get_the_date(); ?></a></li>
                                        </ul>
                                    </div>


                                </div>
                            </article><!-- #post-# -->

                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
            <?php
        } //endif $taxs
    }
}

/**
 * Render related post based on post tags.
 */
if ( ! function_exists( 'yanka_related_portfolio' ) ) {
    function yanka_related_portfolio() {
        global $post;

        $portfolio_style = yanka_get_option( 'portfolio-style', 'default' );

        // Portfolio style
        $classes = array( 'item pr' );
        if ( isset($portfolio_style) && $portfolio_style != '' ) {
            $classes[] = 'portfolio-' . $portfolio_style;
        }

        // Get the portfolio tags.
        $tags = get_the_terms( $post, 'portfolio-tag' );

        if ( $tags ) {
            $tag_ids = array();

            foreach ( $tags as $tag ) {
                $tag_ids[] = $tag->term_id;
            }

            $args = array(
                'post_type'      => 'portfolio',
                'post__not_in'   => array( $post->ID ),
                'posts_per_page' => -1,
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'portfolio-tag',
                        'field'    => 'id',
                        'terms'    => $tag_ids,
                    ),
                )
            );

            // Get portfolio category
            $categories = wp_get_post_terms( get_the_ID(), 'portfolio-cat' );

            $related = new WP_Query( $args );
            ?>
            <div class="yanka-related-portfolio mt_70">
                <div class="addon-title">
                    <h3 class="title"><?php esc_html_e('Related Portfolio', 'yanka'); ?></h3>
                </div>
                <div class="related-portfolio-carousel owl-carousel owl-theme" data-carousel='{"selector": ".related-portfolio-carousel", "itemDesktop": "3", "itemSmallDesktop": "3", "itemTablet": "2", "itemMobile": "1", "itemSmallMobile": "1", "margin": 40, "navigation": true, "pagination": false, "autoplay": false, "loop": false}'>
                    <?php while ( $related->have_posts() ) : $related->the_post(); ?>
                        <article id="portfolio-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
                            <div class="portfolio-item pr">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="portfolio-thumbnail pr oh">
                                        <a href="<?php echo esc_url( get_permalink() ); ?>">
                                            <?php the_post_thumbnail('yanka-portfolio-square'); ?>
                                        </a>
                                        <a href="<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id($post->ID) ) ); ?>" data-rel="mfp[gallery]" class="enlarge"><i class="sl icon-size-fullscreen"></i></a>
                                    </div>
                                <?php endif; ?>
                                <div class="portfolio-content">
                                    <?php $categories = wp_get_post_terms( get_the_ID(), 'portfolio-cat' ); ?>
                                    <?php if ( $categories ) : ?>
                                        <div class="portfolio-category"><?php echo get_the_term_list( $post->ID, 'portfolio-cat', '', ', ' ); ?></div>
                                    <?php endif; ?>
                                    <h4 class="portfolio-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
            <?php
        } //endif $tags
    }
}

/**
 * Custom function to use to open and display each comment
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'yanka_comments_list' ) ) {
    function yanka_comments_list( $comment, $args, $depth ) {
    // Globalize comment object
        $GLOBALS['comment'] = $comment;

        switch ( $comment->comment_type ) :

            case 'pingback'  :
            case 'trackback' :
                ?>
                <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                    <p>
                        <?php
                            echo esc_html__( 'Pingback:', 'yanka' );
                            comment_author_link();
                            edit_comment_link( esc_html__( 'Edit', 'yanka' ), '<span class="edit-link">', '</span>' );
                        ?>
                    </p>
                <?php
            break;

            default :
                global $post;
                ?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                    <article id="comment-<?php comment_ID(); ?>" class="comment_container">
                        <?php echo get_avatar( $comment, 60 ); ?>

                        <div class="comment-text">
                            <?php if ( '0' == $comment->comment_approved ) : ?>
                                <p class="comment-awaiting-moderation"><?php echo esc_html__( 'Your comment is awaiting moderation.', 'yanka' ); ?></p>
                            <?php endif; ?>

                            <?php
                                printf(
                                '<h5 class="comment-author"><span>%1$s</span></h5>',
                                    get_comment_author_link(),
                                    ( $comment->user_id == $post->post_author ) ? '<span class="author-post">' . esc_html__( 'Post author', 'yanka' ) . '</span>' : ''
                                );
                            ?>
                            <div>
                                <?php comment_text(); ?>
                            </div>


                            <div class="flex">
                                <?php
                                    printf(
                                        '<time class="grow">%3$s</time>',
                                        esc_url( get_comment_link( $comment->comment_ID ) ),
                                        get_comment_time( 'c' ),
                                        sprintf( wp_kses( '%1$s at %2$s', 'allowed-html' ), get_comment_date(), get_comment_time() )
                                    );
                                ?>
                                <?php
                                    edit_comment_link( wp_kses( '<span><i class="icon-pencil mr_5"></i>' . esc_html__( 'Edit', 'yanka' ) . '</span>', 'allowed-html' ) );
                                    comment_reply_link(
                                        array_merge(
                                            $args,
                                            array(
                                                'reply_text' => wp_kses( '<span class="ml__10"><i class="icon-pencil mr_5"></i>' . esc_html__( 'Reply', 'yanka' ) . '</span>', 'allowed-html' ),
                                                'depth'      => $depth,
                                                'max_depth'  => $args['max_depth'],
                                            )
                                        )
                                    );
                                ?>
                            </div><!-- .action-link -->
                        </div><!-- .comment-content -->
                    </article><!-- #comment- -->
                <?php
            break;

        endswitch;
    }
}

 /*img alt*/
if(!function_exists('yanka_img_alt')):
    function yanka_img_alt($id = null, $alt = '' ){
        $img_alt = (get_post_meta($id,'_wp_attachment_image_alt', true) != '') ? get_post_meta($id,'_wp_attachment_image_alt', true) : $alt;
        return $img_alt;
    }
endif;

/*Show attribute swatches list color*/
if(!function_exists( 'yanka_swatches_list_color' ) ) {
    function yanka_swatches_list_color($size = 'shop_catalog') {
        global $product;

        $pid = $product->get_id();

        if( empty( $pid ) || ! $product->is_type( 'variable' ) ) return;


        $default_attr = method_exists( $product, 'get_default_attributes' ) ? $product->get_default_attributes() : array();

        $vars = $product->get_available_variations();

        $attributes = $product->get_attributes();

        if(empty($attributes)) return;

        foreach($attributes as $key){
            $attr_name = $key['name'];/*swatches type*/
            $terms = wc_get_product_terms( $pid, $attr_name, array( 'fields' => 'all' ) );

            /*get type of product attribute by id*/
            $attr_type = wc_get_attribute( $key['id'] );

            if(empty($terms)) return;
            
            $id_slug = $name_slug = array();

            foreach($terms as $val){
                $id_slug[$val->term_id] = $val->slug;
                $id_name[$val->name] = $val->slug;
            }

            /*check atrribute*/
            $color = $img_id = '';
            $empty_arr = array();

            foreach($vars as $key){
                $slug = isset($key['attributes']['attribute_' . $attr_name]) ? $key['attributes']['attribute_' . $attr_name] : '';

                if( ! in_array( $slug, $empty_arr ) ){
                    array_push( $empty_arr, $slug );
                }else{
                    continue;
                }

                if( empty( $slug ) ) return;
                
                $_id = array_search( $slug, $id_slug );
                $name = array_search( $slug, $id_name );
                $src = wp_get_attachment_image_src( $key['image_id'], $size );
                $_class = ( isset( $default_attr[$attr_name] ) && $slug == $default_attr[$attr_name] ) ? 'active' : '';

                switch( $attr_type->type ){
                    case 'color':
                        $color = get_term_meta( $_id, 'color', true );
                        echo '<span class="p-attr-swatch p-attr-color '. esc_attr( $_class) .'" title="'. esc_attr( $name ) .'" data-src="'. esc_attr( $src[0] ) .'" style="background-color:'. esc_attr( $color ) .'"></span>';
                        break;
                }
            }
        }
    }
}

/* Second product thumbnail
/* --------------------------------------------------------------------- */
if ( ! function_exists('yanka_second_product_thumbnail') ) {
    function yanka_second_product_thumbnail( $size = 'woocommerce_thumbnail', $attach_id = false ) {
        $product_thumb_hover  = yanka_get_option('wc-product-image-hover', 1);

        global $product, $woocommerce;

        $attachment_ids = $product->get_gallery_image_ids();
        if ( isset($product_thumb_hover) && $product_thumb_hover == 1 || $product->is_type( 'variable' ) ){
            if ( count($attachment_ids) > 0 ) {
                $secondary_image_id = $attachment_ids['0'];
                echo wp_get_attachment_image( $secondary_image_id, 'shop_catalog', '', $attr = array( 'class' => 'hover-image attachment-shop-catalog' ) );
            }
        }
    }
}

/*MODIFY woocommerce_before_shop_loop_item_title content-product.php*/
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'goto_modify_shop_item_title' );
function goto_modify_shop_item_title() {
    global $product, $woocommerce;

    /*product id*/
    $pid = $product->get_id();

    /*image*/
    $img_id  = get_post_thumbnail_id($pid);
    $img_src = wp_get_attachment_image_src($img_id, 'shop_catalog');
    $origin_src = $img_src;
    $img_alt = yanka_img_alt($img_id, esc_html__( 'Product image', 'yanka' ));


    /*get hover img src*/
    $gallery_ids = $product->get_gallery_image_ids();
    $hover_src = ''; ?>
    <a href="<?php echo get_permalink( $pid ); ?>" class="p-image" aria-label="<?php esc_attr_e( 'Product image', 'yanka' ); ?>" data-ori_src="<?php echo esc_attr( $origin_src[0] ); ?>">
            <img src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>">
        <?php 
            echo yanka_second_product_thumbnail();
        ?>
    </a>
<?php
}

/*Image thumb product list*/
if ( ! function_exists('image_list_product') ) {
    function image_list_product() {
        global $product, $woocommerce;

        /*product id*/
        $pid = $product->get_id();

        /*image*/
        $img_id  = get_post_thumbnail_id($pid);
        $img_src = wp_get_attachment_image_src($img_id, 'medium');
        $origin_src = $img_src;
        $img_alt = yanka_img_alt($img_id, esc_html__( 'Product image', 'yanka' ));


        /*get hover img src*/
        $gallery_ids = $product->get_gallery_image_ids();
        $hover_src = ''; ?>
        <a href="<?php echo get_permalink( $pid ); ?>" class="p-image" aria-label="<?php esc_attr_e( 'Product image', 'yanka' ); ?>" data-ori_src="<?php echo esc_attr( $origin_src[0] ); ?>">
                <img src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>">
        </a>
    <?php
    }
}

function yanka_move_comment_field_to_bottom( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
} 
add_filter( 'comment_form_fields', 'yanka_move_comment_field_to_bottom' );

if ( ! function_exists( 'yanka_remove_attributes_scripts_and_styles' ) ) {
    add_action('wp_loaded', 'prefix_output_buffer_start');
    function prefix_output_buffer_start() { 
        ob_start("prefix_output_callback"); 
    }

    add_action('shutdown', 'prefix_output_buffer_end');
    function prefix_output_buffer_end() { 
        if (ob_get_length()) {
            ob_end_flush();
        } 
    }

    function prefix_output_callback($buffer) {
        return preg_replace( "%[ ]type=[\'\"]text\/(javascript|css)[\'\"]%", '', $buffer );
    }
}

if ( ! function_exists( 'yanka_prefix_kses_allowed_html' ) ) {
    function yanka_prefix_kses_allowed_html($tags, $context) {
        switch($context) {
            case 'editor':
                $tags = array(
                    'a'          => array('href' => array('href' => true,),'class' => true,'style' => true,'id' => true,'data-*' => true),
                    'i'          => array(),
                    'code'       => array(),
                    'del'        => array('datetime' => true),
                    'blockquote' => array('cite' => true),
                    'b'          => array(),
                    'br'         => array(),
                    'div'        => array('class' => true,'style' => true,'id' => true),
                    'em'         => array(),
                    'h1'         => array('align' => true,'class' => true,'style' => true,'id' => true),
                    'h2'         => array('align' => true,'class' => true,'style' => true,'id' => true),
                    'h3'         => array('align' => true,'class' => true,'style' => true,'id' => true),
                    'h4'         => array('align' => true,'class' => true,'style' => true,'id' => true),
                    'h5'         => array('align' => true,'class' => true,'style' => true,'id' => true),
                    'h6'         => array('align' => true,'class' => true,'style' => true,'id' => true),
                    'hr'         => array('align' => true,'noshade' => true,'size' => true,'width' => true),
                    'li'         => array('align' => true,'value' => true),
                    'p'          => array('class' => true,'style' => true,'id' => true),
                    'strong'     => array(),
                    'small'      => array(),
                    'textarea'   => array(),                    
                    'table'      => array('class' => true,'style' => true,'id' => true),
                    'tbody'      => array('class' => true,'style' => true,'id' => true),
                    'td'         => array('class' => true,'style' => true,'id' => true),
                    'th'         => array('class' => true,'style' => true,'id' => true),
                    'thead'      => array('class' => true,'style' => true,'id' => true),
                    'tr'         => array('class' => true,'style' => true,'id' => true),
                    'ul'         => array('class' => true,'style' => true,'id' => true),
                    'ol'         => array('start' => true,'type' => true,'reversed' => true),
                    'img'        => array('alt' => true,'src' => true,'align' => true,'height' => true,'width' => true,'class' => true,'style' => true,'id' => true),
                );
            return $tags;

            case 'allowed-html':
                $tags = array(
                    'a'          => array('href' => array('href' => true,),'class' => true,'style' => true,'id' => true,'data-*' => true),
                    'b'          => array(),
                    'div'        => array('class' => true,'style' => true,'id' => true,'data-*' => true),
                    'p'          => array('class' => true,'style' => true,'id' => true),
                    'span'       => array('class' => true,'style' => true,'id' => true),
                    'img'        => array('alt' => true,'src' => true,'align' => true,'height' => true,'width' => true,'class' => true,'style' => true,'id' => true),
                );
            return $tags;

            default:
            return $tags;
        }
    }
    add_filter( 'wp_kses_allowed_html', 'yanka_prefix_kses_allowed_html', 10, 2);  
}
