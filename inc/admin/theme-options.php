<?php
/**
 * ReduxFramework Barebones Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

if ( ! class_exists( 'Redux' ) ) {
    return;
}

/**
 * ------------------------------------------------------------------------------------------------
 * Prepare CSS selectors for theme settions (colors, borders, typography etc.)
 * ------------------------------------------------------------------------------------------------
 */
//include YANKA_PATH . '/inc/selectors.php';

// This is your option name where all the Redux data is stored.
$opt_name = "yanka_option";

/**
 * ---> SET ARGUMENTS
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
 * */

$theme = wp_get_theme(); // For use with some settings. Not necessary.

$args = array(
    // TYPICAL -> Change these values as you need/desire
    'opt_name'             => $opt_name,
    // This is where your data is stored in the database and also becomes your global variable name.
    'display_name'         => $theme->get( 'Name' ),
    // Name that appears at the top of your panel
    'display_version'      => $theme->get( 'Version' ),
    // Version that appears at the top of your panel
    'menu_type'            => 'menu',
    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu'       => false,
    // Show the sections below the admin menu item or not
    'menu_title'           => esc_html__( 'Theme Options', 'yanka' ),
    'page_title'           => esc_html__( 'Theme Options', 'yanka' ),
    // You will need to generate a Google API key to use this feature.
    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_api_key'       => 'AIzaSyCF5_SS7dQ37SiwEHOcNMA5kvCpFurExk4',
    // Set it you want google fonts to update weekly. A google_api_key value is required.
    'google_update_weekly' => false,
    // Must be defined to add google fonts to the typography module
    'async_typography'     => true,
    // Use a asynchronous font on the front end or font string
    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
    'admin_bar'            => false,
    // Show the panel pages on the admin bar
    'admin_bar_icon'       => 'dashicons-portfolio',
    // Choose an icon for the admin bar menu
    'admin_bar_priority'   => 50,
    // Choose an priority for the admin bar menu
    'global_variable'      => '',
    // Set a different name for your global variable other than the opt_name
    'dev_mode'             => false,
    // Show the time the page took to load, etc
    'update_notice'        => true,
    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer'           => true,

    // OPTIONAL -> Give you extra features
    'page_priority'        => null,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent'          => 'themes.php',

    'page_permissions'     => 'administrator',
    // Permissions needed to access the options panel.
    'menu_icon'            => 'dashicons-palmtree',
    // Specify a custom URL to an icon
    'last_tab'             => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon'            => 'icon-themes',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug'            => '_options',
    // Page slug used to denote the panel
    'save_defaults'        => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show'         => false,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark'         => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export'   => true,
    // Shows the Import/Export panel when not used as a field.

    // CAREFUL -> These options are for advanced use only
    'transient_time'       => 60 * MINUTE_IN_SECONDS,
    'output'               => true,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag'           => true,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head

    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database'             => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!

    'use_cdn'              => true,
    // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.


    // HINTS
    'hints'                => array(
        'icon'          => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color'    => 'lightgray',
        'icon_size'     => 'normal',
        'tip_style'     => array(
            'color'   => 'light',
            'shadow'  => true,
            'rounded' => false,
            'style'   => '',
        ),
        'tip_position'  => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect'    => array(
            'show' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'mouseover',
            ),
            'hide' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'click mouseleave',
            ),
        ),
    )
);


// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
$args['share_icons'][] = array(
    'url'   => 'https://facebook.com/joommasters2015',
    'title' => 'Like us on Facebook',
    'icon'  => 'el el-facebook'
);
$args['share_icons'][] = array(
    'url'   => 'https://twitter.com/joommasters',
    'title' => 'Follow us on Twitter',
    'icon'  => 'el el-twitter'
);
$args['share_icons'][] = array(
    'url'   => 'https://www.linkedin.com/company/joommasters',
    'title' => 'Find us on LinkedIn',
    'icon'  => 'el el-linkedin'
);


Redux::setArgs( $opt_name, $args );

/*
 * ---> END ARGUMENTS
 */

/*
 * ---> START HELP TABS
 */

$tabs = array(
    array(
        'id'      => 'redux-help-tab-1',
        'title'   => esc_html__( 'Theme Information 1', 'yanka' ),
        'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'yanka' )
    ),
    array(
        'id'      => 'redux-help-tab-2',
        'title'   => esc_html__( 'Theme Information 2', 'yanka' ),
        'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'yanka' )
    )
);
Redux::setHelpTab( $opt_name, $tabs );

// Set the help sidebar
$content = esc_html__( '<p>This is the sidebar content, HTML is allowed.</p>', 'yanka' );
Redux::setHelpSidebar( $opt_name, $content );


/*
 * <--- END HELP TABS
 */

Redux::setSection( $opt_name, array(
    'title' => esc_html__( 'General', 'yanka' ),
    'id'     => 'general',
    'icon'   => 'el el-dashboard',
    'fields' => array(
        array(
            'id'       => 'site-width',
            'type'     => 'select',
            'title'    => esc_html__('Site width', 'yanka'),
            'subtitle' => esc_html__('You can make your content wrapper boxed or full width', 'yanka'),
            'options'  => array(
               'fullwidth' => esc_html__('Fullwidth', 'yanka'),
               'boxed'   => esc_html__('Boxed', 'yanka'),
            ),
            'default' => 'fullwidth',
        ),
        array(
            'id'        => 'box_layout_width',
            'type'      => 'slider',
            'title'     => esc_html__('Box layout width', 'yanka'),
            'desc'      => esc_html__('Box layout width in pixels, default value: 1370', 'yanka'),
            "default"   => 1480,
            "min"       => 1200,
            "step"      => 10,
            "max"       => 1920,
            'display_value' => 'text',
            'required' => array( 'site-width', '=', 'boxed' )
        ),
        array(
            'id'                    => 'body-background',
            'type'                  => 'background',
            'title'                 => esc_html__('Body background', 'yanka'),
            'subtitle' => esc_html__('Set background image or color for page.', 'yanka'),
            'desc'     => esc_html__('You can also specify other image for particular page', 'yanka'),
            'output'   => array('body'),
        ),
        array(
            'id'      => 'site-loader',
            'type'    => 'switch',
            'title'   => esc_html__('Site Loader', 'yanka'),
            'on'      => esc_html__('On','yanka'),
            'off'     => esc_html__('Off','yanka'),
            'default' => false,
        ),
        array(
            'id'       => 'site-loader-style',
            'type'     => 'select',
            'title'    => esc_html__( 'Site Loader Style', 'yanka' ),
            'options'  => array(
                '1' => esc_html__( 'Style 1', 'yanka' ),
                '2' => esc_html__( 'Style 2', 'yanka' ),
                '3' => esc_html__( 'Style 3', 'yanka' ),
                '4' => esc_html__( 'Style 4', 'yanka' ),
                '5' => esc_html__( 'Style 5', 'yanka' ),
                '6' => esc_html__( 'Style 6', 'yanka' ),
            ),
            'default'  => '5',
            'required' => array( 'site-loader', '=', 3 )
        ),
        array(
            'id'      => 'smart-sidebar',
            'type'    => 'switch',
            'title'   => esc_html__('Smart sidebar', 'yanka'),
            'subtitle' => esc_html__('The smart sidebar is an affix (sticky) sidebar that has auto resize and it scrolls with the content.', 'yanka'),
            'on'      => esc_html__('On','yanka'),
            'off'     => esc_html__('Off','yanka'),
            'default' => false,
        ),
        array(
            'id'       => 'login-logo',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__('Login Logo', 'yanka'),
            'subtitle' => esc_html__('Max width: 302px - Max height: 67px','yanka'),
            'default'  => array(
                'url'  => YANKA_URL . '/assets/images/logo.png'
            ),            
        ),
        array(
            'id'       => 'favicon',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__('Favicon', 'yanka'),
            'subtitle' => esc_html__('Max width: 32px - Max height: 32px','yanka'),
            'default'  => array(
                'url'  => YANKA_URL . '/assets/images/fav_icon.png'
            ),            
        ),
        array(
            'id'       => 'back-to-top',
            'type'     => 'switch',
            'title'    => esc_html__( 'Show Back To Top Button', 'yanka' ),
            'desc'     => esc_html__( 'Show back to top button.', 'yanka' ),
            'on'       => esc_html__( 'On', 'yanka' ),
            'off'      => esc_html__( 'Off', 'yanka' ),
            'default'  => 1,
        ),
        array(
            'id'          => 'user-registration-link',
            'type'        => 'text',
            'title'       => esc_html__('User Registration URL', 'yanka'),
            'default'     => '',
        ),          
        array(
            'id'       => 'google_map_api_key',
            'type'     => 'text',
            'title'    => esc_html__('Google map API key', 'yanka'),
            'subtitle' => wp_kses( esc_html__('Obtain API key <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">here</a> to use our Google Map VC element.', 'yanka'),
            array(
                'a' => array(
                    'href' => array(),
                    'target' => array()
                )
            ) ),
            'default'  => '',
        ),
    )
) );

// START Typography
Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Typography', 'yanka' ),
    'id'     => 'theme-typography',
    'subsection' => true,
    'fields' => array(
        array(
            'id'              => 'primary-color',
            'type'            => 'color',
            'title'           => esc_html__('Primary Color', 'yanka'),
            'default'         => '#48CAB2'
        ),
        array(
            'id'          => 'text-font',
            'type'        => 'typography',
            'title'       => esc_html__('Text font', 'yanka'),
            'all_styles'  => true,
            'google'      => true,
            'font-backup' => true,
            'text-align'  => false,
            'subsets'  => false,
            'letter-spacing' => true,
            'output'      => 'body',
            'units'       =>'px',
            'subtitle'    => esc_html__('Set you typography options for body, paragraphs.', 'yanka'),
            'default'     => array(
                'font-family'    => '',
                'font-weight'    => 400,
                'line-height'    => '25px',
                'font-size'      => '18px',
                'google'         => true,
                'color'          => '#777777',
                'font-backup'    => 'Arial, Helvetica, sans-serif'
            ),
        ),
        array(
            'id'          => 'second-font',
            'type'        => 'typography',
            'title'       => esc_html__('Font Family', 'yanka'),
            'google'      => true,
            'color'       => false,
            'text-align'  => false,
            'font-weight' => false,
            'font-size'   => false,
            'line-height' => false,
            'font-style'  => false,
            'subsets'     => false,
            'all_styles'  => true,
            'subtitle'    => esc_html__('Set you typography options for text with second font. Example: title, description.', 'yanka'),
        ),
        array(
            'id'             => 'heading-font',
            'type'           => 'color',
            'title'          => esc_html__('Heading font', 'yanka'),
            'default'        => '#333333',
            'subtitle'       => esc_html__('Set you typography options for heading.', 'yanka'),
            'output'   => array('h1,h2,h3,h4,h5,h6'),
        ),
        array(
            'id'             => 'menu-font',
            'type'           => 'color',
            'title'          => esc_html__('Main menu font', 'yanka'),
            'subtitle'       => esc_html__('Set you typography options for main menu.', 'yanka'),
            'default'        => '#333333',

        ),
    )
) );

Redux::setSection( $opt_name, array(
    'title' => esc_html__('Page heading', 'yanka'),
    'id' => 'page_titles',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'page-title-design',
            'type'     => 'button_set',
            'title'    => esc_html__('Page title design', 'yanka'),
            'options'  => array(
                'left'     => esc_html__('Left', 'yanka'),
                'centered' => esc_html__('Centered', 'yanka'),
                'right'    => esc_html__('Right', 'yanka'),
                'vertical'    => esc_html__('Line', 'yanka'),
                'disable'  => esc_html__('Disable', 'yanka'),
            ),
            'default' => 'centered',
        ),
        array(
            'id'       => 'page-title-size',
            'type'     => 'button_set',
            'title'    => esc_html__('Page title size', 'yanka'),
            'options'  => array(
                'default' => esc_html__('Default', 'yanka'),
                'small'  => esc_html__('Small', 'yanka'),
                'medium' => esc_html__('Medium', 'yanka'),
                'large'  => esc_html__('Large', 'yanka'),
            ),
            'default' => 'default',
        ),
        array(
            'id'       => 'breadcrumbs',
            'type'     => 'switch',
            'title'    => esc_html__('Show breadcrumbs', 'yanka'),
            'subtitle' => esc_html__('Displays a full chain of links to the current page.', 'yanka'),
            'default' => true
        ),
        array(
            'id'       => 'title-background',
            'type'     => 'background',
            'title'    => esc_html__('Page title background', 'yanka'),
            'subtitle' => esc_html__('Set background image or color, that will be used as a default for all page titles, shop page and blog.', 'yanka'),
            'desc'     => esc_html__('You can also specify other image for particular page', 'yanka'),
            'output'   => array('.page-heading:not(.title-other)'),
            'default'  => array(
                'background-position' => 'center center',
                'background-size'     => 'cover'
            ),
        ),
        array(
            'id'             => 'page-title-color',
            'type'           => 'color',
            'title'          => esc_html__('Page Heading color', 'yanka'),
            'default'        => '#333',
            'output'           => array('.page-heading:not(.title-other) .entry-title'),
            'subtitle'       => esc_html__('Set your color options for heading.', 'yanka'),
        ),
    ),
) );

Redux::setSection( $opt_name, array(
    'title' => esc_html__('Promo Bar', 'yanka'),
    'id' => 'promo_bar',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'box-top-panel',
            'type'     => 'textarea',
            'title'    => esc_html__('Title Top Panel', 'yanka'),
            'subtitle' => esc_html__('HTML is allowed.', 'yanka'),
            'validate' => 'html',
            'rows'     => 2,
            'default'  => '<strong>ENJOY AN EXTRA 40%</strong> off select sales styles <a href="#">More details</a>',
            'placeholder' => '<strong>ENJOY AN EXTRA 40%</strong> off select sales styles <a href="#">More details</a>',
        ),         
        array(
            'id'          => 'show-box-info',
            'type'        => 'switch',
            'title'       => esc_html__('Show Box Info', 'yanka'),
            'default'     => true,
        ),        
        array(
            'id'       => 'box-info-1',
            'type'     => 'textarea',
            'title'    => esc_html__('Box Info - 1', 'yanka'),
            'subtitle' => esc_html__('HTML is allowed.', 'yanka'),
            'validate' => 'html',
            'rows'     => 2,
            'default'  => '<strong>FREE 2-DAYS</strong> standard shipping on orders $255+ <a href="/" target="_blank" class="pt-link-underline" tabindex="-1">More details</a>',
            'placeholder' => '<strong>FREE 2-DAYS</strong> standard shipping on orders $255+ <a href="/" target="_blank" class="pt-link-underline" tabindex="-1">More details</a>',
            'required'    => array( 'show-box-info', '=', 1 )
        ), 
        array(
            'id'       => 'box-info-2',
            'type'     => 'textarea',
            'title'    => esc_html__('Box Info - 2', 'yanka'),
            'subtitle' => esc_html__('HTML is allowed.', 'yanka'),
            'validate' => 'html',
            'rows'     => 2,
            'default'  => '<strong>TAKE 30% OFF</strong> when you spend $99 or more with code: “Yanka” <a href="/" target="_blank" class="pt-link-underline" tabindex="-1">More details</a>',
            'placeholder' => '<strong>TAKE 30% OFF</strong> when you spend $99 or more with code: “Yanka” <a href="/" target="_blank" class="pt-link-underline" tabindex="-1">More details</a>',
            'required'    => array( 'show-box-info', '=', 1 )
        ),   
        array(
            'id'       => 'box-info-3',
            'type'     => 'textarea',
            'title'    => esc_html__('Box Info - 3', 'yanka'),
            'subtitle' => esc_html__('HTML is allowed.', 'yanka'),
            'validate' => 'html',
            'rows'     => 2,
            'default'  => '<strong>50% OFF</strong> all new collection! <a href="/" target="_blank" class="pt-link-underline" tabindex="-1">More details</a>',
            'placeholder' => '<strong>50% OFF</strong> all new collection! <a href="/" target="_blank" class="pt-link-underline" tabindex="-1">More details</a>',
            'required'    => array( 'show-box-info', '=', 1 )
        ),                    
    ),
) );

// Header
Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Header', 'yanka' ),
    'id'     => 'header',
    'icon'   => 'el el-circle-arrow-up',
    'fields'     => array(
        array(
            'id'       => 'header-layout',
            'type'     => 'select',
            'title'    => esc_html__( 'Header Layout', 'yanka' ),
            'subtitle' => esc_html__( 'Set the header layout', 'yanka' ),
            'options'  => array(
                '1'    => esc_html__( 'Header 1', 'yanka' ),
                '2'    => esc_html__( 'Header 2', 'yanka' ),
                '3'    => esc_html__( 'Header 3', 'yanka' ),
                '4'    => esc_html__( 'Header 4', 'yanka' ),
                '5'    => esc_html__( 'Header 5', 'yanka' ),
                '6'    => esc_html__( 'Header 6', 'yanka' ),
                '7'    => esc_html__( 'Header 7', 'yanka' ),
                '8'    => esc_html__( 'Header 8', 'yanka' ),
                '9'    => esc_html__( 'Header 9', 'yanka' ),
                '10'   => esc_html__( 'Header 10', 'yanka' ),
                '11'   => esc_html__( 'Header 11', 'yanka' ),
                '12'   => esc_html__( 'Header 12', 'yanka' ),
                '13'   => esc_html__( 'Header 13', 'yanka' ),
                '15'   => esc_html__( 'Header 15', 'yanka' ),
                '18'   => esc_html__( 'Header 18', 'yanka' ),
            ),
            'default'  => '1',
        ),
        array(
            'id'       => 'header-fullwidth',
            'type'     => 'switch',
            'title'    => esc_html__('Header fullwidth', 'yanka'),
            'subtitle' => esc_html__('Make header full width', 'yanka'),
            'default'  => false,
        ),
        array(
            'id'       => 'header-logo',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__('Logo', 'yanka'),
            'default'  => array(
                'url'  => YANKA_URL . '/assets/images/logo.png'
            ),            
        ),

        array(
            'id'       => 'height-logo',
            'type'     => 'text',
            'title'    => esc_html__('Logo Max Height', 'yanka'),
            'default'  => '50'
        ),
        array(
            'id'          => 'position-header',
            'type'        => 'switch',
            'title'       => esc_html__('Header Position', 'yanka'),
            'subtitle'    => esc_html__('Make header position absolute (only home page)', 'yanka'),
            'default'     => false,
        ),
        array(
            'id'          => 'sticky-header',
            'type'        => 'switch',
            'title'       => esc_html__('Sticky Header', 'yanka'),
            'subtitle'    => esc_html__('How to display the header menu on scroll.', 'yanka'),
            'default'     => false,
        ),
        array(
            'id'                    => 'header-background-color',
            'type'                  => 'background',
            'title'                 => esc_html__('Header background', 'yanka'),
            'subtitle' => esc_html__('Set background image or color for header.', 'yanka'),
            'desc'     => esc_html__('You can also specify other image for particular page', 'yanka'),
            'output'   => array('.header-wrapper'),
            'default'  => array(
                'background-position' => 'center center',
                'background-size'     => 'cover'
            ),
        ),
        array(
            'id'          => 'show-topbar',
            'type'        => 'switch',
            'title'       => esc_html__('Show topbar', 'yanka'),
            'default'     => false,
        ),        
        array(
            'id'       => 'header-text-color',
            'type'     => 'color',
            'title'    => esc_html__('Header text color', 'yanka'),
            'default'        => '#333',
        ),
        array(
            'id'       => 'topbar-text',
            'type'     => 'textarea',
            'title'    => esc_html__('Phone Text', 'yanka'),
            'subtitle' => esc_html__('HTML is allowed.', 'yanka'),
            'validate' => 'html',
            'rows'     => 3,
            'default'  => 'Call Us: <strong>1–234–5678901</strong>',
        ),
        array(
            'id'          => 'show-social-box',
            'type'        => 'switch',
            'title'       => esc_html__('Show Social', 'yanka'),
            'default'     => true,
        ),
        array(
            'id'          => 'social-name-1',
            'type'        => 'text',
            'title'       => esc_html__('1st Social Name', 'yanka'),
            'default'     => 'Facebook',
            'required'    => array( 'show-social-box', '=', 1 )
        ), 
        array(
            'id'          => 'social-link-1',
            'type'        => 'text',
            'title'       => esc_html__('1st Social URL', 'yanka'),
            'default'     => '#',
            'required'    => array( 'show-social-box', '=', 1 )
        ), 
        array(
            'id'          => 'social-name-2',
            'type'        => 'text',
            'title'       => esc_html__('2st Social Name', 'yanka'),
            'default'     => 'Twitter',
            'required'    => array( 'show-social-box', '=', 1 )
        ), 
        array(
            'id'          => 'social-link-2',
            'type'        => 'text',
            'title'       => esc_html__('2st Social URL', 'yanka'),
            'default'     => '#',
            'required'    => array( 'show-social-box', '=', 1 )
        ),  
        array(
            'id'          => 'social-name-3',
            'type'        => 'text',
            'title'       => esc_html__('3st Social Name', 'yanka'),
            'default'     => 'Instagram',
            'required'    => array( 'show-social-box', '=', 1 )
        ), 
        array(
            'id'          => 'social-link-3',
            'type'        => 'text',
            'title'       => esc_html__('3st Social URL', 'yanka'),
            'default'     => '#',
            'required'    => array( 'show-social-box', '=', 1 )
        ),                                    
        array(
            'id'          => 'show-language-box',
            'type'        => 'switch',
            'title'       => esc_html__('Show Language', 'yanka'),
            'default'     => true,
        ),
        array(
            'id'          => 'language-name-1',
            'type'        => 'text',
            'title'       => esc_html__('1st Language Name', 'yanka'),
            'default'     => 'English',
            'required'    => array( 'show-language-box', '=', 1 )
        ),
        array(
            'id'          => 'language-link-1',
            'type'        => 'text',
            'title'       => esc_html__('1st Language URL', 'yanka'),
            'default'     => '#',
            'required'    => array( 'show-language-box', '=', 1 )
        ),
        array(
            'id'          => 'language-name-2',
            'type'        => 'text',
            'title'       => esc_html__('2nd Language Name', 'yanka'),
            'default'     => 'Italiano',
            'required'    => array( 'show-language-box', '=', 1 )
        ),
        array(
            'id'          => 'language-link-2',
            'type'        => 'text',
            'title'       => esc_html__('2nd Language URL', 'yanka'),
            'default'     => '#',
            'required'    => array( 'show-language-box', '=', 1 )
        ),
        array(
            'id'          => 'language-name-3',
            'type'        => 'text',
            'title'       => esc_html__('3rd Language Name', 'yanka'),
            'default'     => '',
            'required'    => array( 'show-language-box', '=', 1 )
        ),
        array(
            'id'          => 'language-link-3',
            'type'        => 'text',
            'title'       => esc_html__('3rd Language URL', 'yanka'),
            'default'     => '',
            'required'    => array( 'show-language-box', '=', 1 )
        ),
        array(
            'id'          => 'show-currency-box',
            'type'        => 'switch',
            'title'       => esc_html__('Show Currency', 'yanka'),
            'default'     => true,
        ),
        array(
            'id'          => 'show-search-form',
            'type'        => 'switch',
            'title'       => esc_html__('Show Search Form', 'yanka'),
            'default'     => true
        ),
        array(
            'id'          => 'show-cart-button',
            'type'        => 'switch',
            'title'       => esc_html__('Show Cart Button', 'yanka'),
            'default'     => true
        ),
        array(
            'id'       => 'wc-add-to-cart-style',
            'type'     => 'button_set',
            'title'    => esc_html__( 'Add To Cart Design', 'yanka' ),
            'options'  => array(
                'alert'          => esc_html__('Default', 'yanka'),
                'toggle-sidebar' => esc_html__('Toggle Sidebar', 'yanka'),
            ),
            'default'  => 'alert'
        ),
        array(
            'id'          => 'show-wishlist-button',
            'type'        => 'switch',
            'title'       => esc_html__('Show Wishlist Button', 'yanka'),
            'default'     => true
        ),
        array(
            'id'          => 'show-compare-button',
            'type'        => 'switch',
            'title'       => esc_html__('Show Compare Button', 'yanka'),
            'default'     => true
        ),
        array(
            'id'          => 'single-button-text',
            'type'        => 'text',
            'title'       => esc_html__('Single Button Text', 'yanka'),
            'default'     => 'BUY THEME!',
        ),
        array(
            'id'          => 'single-button-url',
            'type'        => 'text',
            'title'       => esc_html__('Single Button URL', 'yanka'),
            'default'     => '#',
        ),                     
        array(
            'id'       => 'header-menu-align',
            'type'     => 'button_set',
            'title'    => esc_html__('Menu Align', 'yanka'),
            'options'  => array(
                'left'   => esc_html__('Left', 'yanka'),
                'center' => esc_html__('Center', 'yanka'),
                'right'  => esc_html__('Right', 'yanka'),
            ),
            'default' => 'center',
        ),
    ),
) );


// -> START Footer Fields

$footer_layouts = array();
$footer_default = '';

$jscomposer_templates_args = array(
    'orderby'          => 'title',
    'order'            => 'ASC',
    'post_type'        => 'footer_layout',
    'post_status'      => 'publish',
    'posts_per_page'   => 30,
);
$jscomposer_templates = get_posts( $jscomposer_templates_args );

if(count($jscomposer_templates) > 0) {
    foreach($jscomposer_templates as $jscomposer_template){
        $footer_layouts[$jscomposer_template->post_title] = $jscomposer_template->post_title;
    }
    $footer_default = $jscomposer_templates[0]->post_title;
}

Redux::setSection( $opt_name, array(
    'title'  => esc_html__('Footer', 'yanka' ),
    'id'     => 'footer',
    'icon'   => 'el el-circle-arrow-down',
    'fields' => array(
        array(
            'id'       => 'footer-layout',
            'type'     => 'select',
            'title'    => esc_html__('Footer Layout', 'yanka' ),
            'subtitle' => esc_html__('Choose footer you want to show - All Page', 'yanka' ),
            'desc'      => esc_html__('Go to Footer Layout (admin table) to create/edit layout', 'yanka'),
            'options'   => $footer_layouts,
            'default'   => $footer_default
        ),
        array(
            'id'       => 'footer-layout-archive-product',
            'type'     => 'select',
            'title'    => esc_html__('Footer Layout Archive Shop Page', 'yanka' ),
            'subtitle' => esc_html__('Choose footer you want to show - Page Shop / Product', 'yanka' ),
            'desc'      => esc_html__('Go to Footer Layout (admin table) to create/edit layout', 'yanka'),
            'options'   => $footer_layouts,
            'default'   => $footer_default
        ),        
        array(
            'id'       => 'footer-copyright',
            'type'     => 'textarea',
            'title'    => esc_html__('Copyright', 'yanka'),
            'subtitle' => esc_html__('HTML is allowed.', 'yanka'),
            'validate' => 'html',
            'default'  => 'Copyright 2020. All rights reserved. Design by <a href="#">JoomMasters.com</a>.',
        ),
    )
) );

/*
 * <--- END FOOTER
 */

// BLOG
Redux::setSection( $opt_name, array(
    'title' => esc_html__( 'Blog', 'yanka' ),
    'id'     => 'blog',
    'icon'   => 'el el-pencil',
    'fields' => array(
        array(
            'id'             => 'Blog-title-color',
            'type'           => 'color',
            'title'          => esc_html__('Blog heading color', 'yanka'),
            'default'        => '#000',
            'output'           => array('.title-blog.page-heading .entry-title'),
            'subtitle'       => esc_html__('Set your color options for heading.', 'yanka'),
        ),
        array(
            'id'       => 'blog-title-background',
            'type'     => 'background',
            'title'    => esc_html__('Blog heading background', 'yanka'),
            'subtitle' => esc_html__('Set background image or color for blog.', 'yanka'),
            'desc'     => esc_html__('You can also specify other image for particular page', 'yanka'),
            'output'   => array('.title-blog.page-heading'),
            'default'  => array(
                'background-color'    => '',
                'background-position' => 'center center',
                'background-size'     => 'cover'
            ),
        ),
        array(
            'id'       => 'blog-fullwidth',
            'type'     => 'switch',
            'title'    => esc_html__('Full Width', 'yanka'),
            'subtitle' => esc_html__('Makes container 100% width of the page', 'yanka'),
            'on'       => esc_html__('On', 'yanka'),
			'off'      => esc_html__('Off', 'yanka'),
			'default'  => 0,
        ),
        array(
            'id'       => 'blog-design',
            'type'     => 'select',
            'title'    => esc_html__( 'Blog Design', 'yanka' ),
            'subtitle' => esc_html__( 'You can use different design for your blog styled for the theme.', 'yanka' ),
            'options'  => array(
                'default'      => esc_html__('Default', 'yanka'),
                'small-images' => esc_html__('Small images', 'yanka'),
                'chess'        => esc_html__('Chess', 'yanka'),
                'masonry'      => esc_html__('Masonry grid', 'yanka')
            ),
            'default' => 'default'
        ),
        array(
            'id'       => 'blog-style',
            'type'     => 'button_set',
            'title'    => esc_html__('Blog Style', 'yanka'),
            'options'  => array(
                'flat'   => esc_html__('Flat', 'yanka'),
                'shadow' => esc_html__('With Shadow', 'yanka')
            ),
            'default' => 'flat'
        ),
        array(
            'id'       => 'blog-columns',
            'type'     => 'button_set',
            'title'    => esc_html__('Blog items columns', 'yanka'),
            'subtitle' => esc_html__('For masonry grid design', 'yanka'),
            'options'  => array(
                2 => '2',
                3 => '3',
                4 => '4',
            ),
            'default' => 3,
            'required' => array(
                array('blog-design','equals','masonry'),
            )
        ),
        array(
            'id'       => 'blog-image-size',
            'type'     => 'text',
            'title'    => esc_html__( 'Blog image size', 'yanka' ),
            'desc'     => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 500x300 (Width x Height). Leave empty to use "1540x1082" size.', 'yanka' ),
            'default'  => '1540x1082'
        ),
        array(
            'id'       => 'show-date-image',
            'type'     => 'switch',
            'title'    => esc_html__('Show date in images', 'yanka'),
            'on'       => esc_html__('Show', 'yanka'),
			'off'      => esc_html__('Hide', 'yanka'),
			'default'  => 1,
        ),
        array(
            'id'       => 'show-date',
            'type'     => 'switch',
            'title'    => esc_html__('Show date', 'yanka'),
            'on'       => esc_html__('Show', 'yanka'),
			'off'      => esc_html__('Hide', 'yanka'),
			'default'  => 1,
        ),
        array(
            'id'       => 'show-author',
            'type'     => 'switch',
            'title'    => esc_html__('Show author', 'yanka'),
            'on'       => esc_html__('Show', 'yanka'),
			'off'      => esc_html__('Hide', 'yanka'),
			'default'  => 1,
        ),
        array(
            'id'       => 'show-category',
            'type'     => 'switch',
            'title'    => esc_html__('Show category', 'yanka'),
            'on'       => esc_html__('Show', 'yanka'),
			'off'      => esc_html__('Hide', 'yanka'),
			'default'  => 1,
        ),
        array(
            'id'       => 'show-comment',
            'type'     => 'switch',
            'title'    => esc_html__('Show comment', 'yanka'),
            'on'       => esc_html__('Show', 'yanka'),
			'off'      => esc_html__('Hide', 'yanka'),
			'default'  => 1,
        ),
        array(
            'id'       => 'blog-words-or-letters',
            'type'     => 'button_set',
            'title'    => esc_html__('Excerpt length by words or letters', 'yanka'),
            'options'  => array(
                'word'   => esc_html__('Words', 'yanka'),
                'letter' => esc_html__('Letters', 'yanka'),
            ),
            'default' => 'letter',
        ),
        array(
            'id'       => 'blog-excerpt-length',
            'type'     => 'text',
            'title'    => esc_html__('Excerpt length', 'yanka'),
            'subtitle' => esc_html__('Number of words or letters that will be displayed for each post if you use "Excerpt" mode and don\'t set custom excerpt for each post.', 'yanka'),
            'default' => 125,
        ),
        array(
            'id'       => 'blog-pagination-type',
            'type'     => 'button_set',
            'title'    => esc_html__('Blog Pagination', 'yanka'),
            'options'  => array(
                'number'   => esc_html__('Pagination links', 'yanka'),
                'loadmore' => esc_html__('Load more button', 'yanka'),
                'infinite' => esc_html__('Infinit scrolling', 'yanka'),
            ),
            'default' => 'number'
        ),
        array(
            'id'       => 'blog-layout',
            'type'     => 'image_select',
            'title'    => esc_html__( 'Blog Layout', 'yanka' ),
            'subtitle' => esc_html__( 'Select blog layout with sidebar postion.', 'yanka' ),
            'options'  => array(
                'left' => array(
                    'alt' => esc_html__('Left Sidebar', 'yanka'),
                    'img' => YANKA_URL . '/assets/images/layout/left-sidebar.jpg'
                ),
                'no' => array(
                    'alt' => esc_html__('No Sidebar', 'yanka'),
                    'img' => YANKA_URL . '/assets/images/layout/no-sidebar.jpg'
                ),
                'right' => array(
                    'alt' => esc_html__('Right Sidebar', 'yanka'),
                    'img' => YANKA_URL . '/assets/images/layout/right-sidebar.jpg'
                ),
            ),
            'default'  => 'left'
        ),
    )
) );

// Blog single
Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Blog Single', 'yanka' ),
    'id'         => 'blog-single',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'show-feature-image',
            'type'     => 'switch',
            'title'    => esc_html__('Featured Image', 'yanka'),
            'on'       => esc_html__('Show', 'yanka'),
			'off'      => esc_html__('Hide', 'yanka'),
			'default'  => 1,
        ),
        array(
            'id'       => 'show-author-bio',
            'type'     => 'switch',
            'title'    => esc_html__('Author bio', 'yanka'),
            'subtitle' => esc_html__('Display information about the post author', 'yanka'),
            'default' => true
        ),
        array(
            'id'       => 'show-related-posts',
            'type'     => 'switch',
            'title'    => esc_html__('Show Related Posts', 'yanka'),
            'on'       => esc_html__('Show', 'yanka'),
			'off'      => esc_html__('Hide', 'yanka'),
			'default'  => 1,
        ),
        array(
            'id'       => 'show-post-navigation',
            'type'     => 'switch',
            'title'    => esc_html__('Show Post Navigation', 'yanka'),
            'on'       => esc_html__('Show', 'yanka'),
			'off'      => esc_html__('Hide', 'yanka'),
			'default'  => 1,
        ),
        array(
            'id'       => 'blog-single-layout',
            'type'     => 'image_select',
            'title'    => esc_html__( 'Blog Single Layout', 'yanka' ),
            'subtitle' => esc_html__( 'Select blog single layout with sidebar postion.', 'yanka' ),
            'options'  => array(
                'left' => array(
                    'alt' => esc_html__('Left Sidebar', 'yanka'),
                    'img' => YANKA_URL . '/assets/images/layout/left-sidebar.jpg'
                ),
                'no' => array(
                    'alt' => esc_html__('No Sidebar', 'yanka'),
                    'img' => YANKA_URL . '/assets/images/layout/no-sidebar.jpg'
                ),
                'right' => array(
                    'alt' => esc_html__('Right Sidebar', 'yanka'),
                    'img' => YANKA_URL . '/assets/images/layout/right-sidebar.jpg'
                ),
            ),
            'default'  => 'left'
        ),
    )
) );



// Woocommerce
Redux::setSection( $opt_name, array(
    'title' => esc_html__( 'Shop', 'yanka' ),
    'id'     => 'shop',
    'icon'   => 'el el-shopping-cart',
    'fields' => array(
        array(
            'id'       => 'wc-shop-fullwidth',
            'type'     => 'switch',
            'title'    => esc_html__('Enable Fullwidth', 'yanka'),
            'on'       => esc_html__('Enable', 'yanka'),
			'off'      => esc_html__('Disable', 'yanka'),
			'default'  => 0,
        ),
        array(
            'id'       => 'wc-product-style',
            'type'     => 'image_select',
            'title'    => esc_html__( 'Product Hover Box Style', 'yanka' ),
            'options'  => array(
                '1' => array(
                    'alt' => esc_html__('style 1', 'yanka'),
                    'img' => YANKA_URL . '/assets/images/product-style/style1.jpg'
                ),
            ),
            'default'  => '1',
        ),
        array(
            'id'       => 'wc-product-image-hover',
            'type'     => 'switch',
            'title'    => esc_html__('Hover Thumb Image', 'yanka'),
            'options' => array(
                'on'    => esc_html__( 'Show', 'yanka' ),
                'off' => esc_html__( 'Hide', 'yanka' ),
            ),
            'default'  => 1,
        ),
        array(
            'id'       => 'wc-product-style-thumb',
            'type'     => 'select',
            'title'    => esc_html__( 'Hover Thumb Image Effect', 'yanka' ),
            'options'  => array(
                '1'      => esc_html__( 'Zoom', 'yanka' ),
                '2'      => esc_html__( 'Move top to bottom', 'yanka' ),
                '3'      => esc_html__( 'Move bottom to top', 'yanka' ),
                '4'      => esc_html__( 'Move right to left', 'yanka' ),
                '5'      => esc_html__( 'Move left to right', 'yanka' ),
                '6'      => esc_html__( 'Move top left to right bottom', 'yanka' ),
                '7'      => esc_html__( 'Move top right to bottom left', 'yanka' ),
                '8'      => esc_html__( 'Move right bottom to top right', 'yanka' ),
                '9'      => esc_html__( 'Move left bottom to top right', 'yanka' ),
                '10'     => esc_html__( 'Scale', 'yanka' ),
                '11'     => esc_html__( 'Scale rotate', 'yanka' ),
                '12'     => esc_html__( 'Skew Y rotate', 'yanka' ),
                '13'     => esc_html__( 'Skew X rotate', 'yanka' ),
                '14'     => esc_html__( 'Skew', 'yanka' ),
            ),
            'default'  => '1',
            'required' => array( 'wc-product-image-hover', '=', 1 ),
        ),
        array(
            'id'       => 'wc-product-hover-presets',
            'type'     => 'image_select',
            'title'    => esc_html__( 'Opacity color on product image', 'yanka' ),
            'options'  => array(
                '2e2e2e' => array(
                    'alt' => '2e2e2e',
                    'img' => YANKA_URL . '/assets/images/color-icons/2e2e2e.png',
                ),
                'ecf0f1' => array(
                    'alt' => 'ecf0f1',
                    'img' => YANKA_URL . '/assets/images/color-icons/ecf0f1.png',
                ),
                '01558f' => array(
                    'alt' => '01558f',
                    'img' => YANKA_URL . '/assets/images/color-icons/01558f.png',
                ),
                '3498db' => array(
                    'alt' => '3498db',
                    'img' => YANKA_URL . '/assets/images/color-icons/3498db.png',
                ),
                '1abc9c' => array(
                    'alt' => '1abc9c',
                    'img' => YANKA_URL . '/assets/images/color-icons/1abc9c.png',
                ),
                '2ecc71' => array(
                    'alt' => '2ecc71',
                    'img' => YANKA_URL . '/assets/images/color-icons/2ecc71.png',
                ),
                '9b59b6' => array(
                    'alt' => '9b59b6',
                    'img' => YANKA_URL . '/assets/images/color-icons/9b59b6.png',
                ),
                'f1c40f' => array(
                    'alt' => 'f1c40f',
                    'img' => YANKA_URL . '/assets/images/color-icons/f1c40f.png',
                ),
                'd35400' => array(
                    'alt' => 'd35400',
                    'img' => YANKA_URL . '/assets/images/color-icons/d35400.png',
                ),
                'e74c3c' => array(
                    'alt' => 'e74c3c',
                    'img' => YANKA_URL . '/assets/images/color-icons/e74c3c.png',
                ),
                'c0392b' => array(
                    'alt' => 'c0392b',
                    'img' => YANKA_URL . '/assets/images/color-icons/c0392b.png',
                ),
                'none' => array(
                    'alt' => 'none',
                    'img' => YANKA_URL . '/assets/images/color-icons/none.png',
                ),
            ),
            'default'  => 'ecf0f1',
        ),
        array(
            'id'       => 'product-category-label',
            'type'     => 'select',
            'data'      => 'terms',
            'args'      => array('taxonomies'=>'product_cat', 'args'=>array()),
            'title'    => esc_html__('Box Product Category Label', 'yanka' ),
            'subtitle' => esc_html__('Choose parent category products you want to show', 'yanka' ),
            'desc'      => esc_html__('List of product categories', 'yanka'),
        ),                     
        array(
			'id'		=> 'wc-product-onsale',
			'type'		=> 'button_set',
			'title'		=> esc_html__( 'Product Sale Flash', 'yanka' ),
			'subtitle'	=> esc_html__( 'Product sale flash badges.', 'yanka' ),
			'options'	=> array(
                'txt' => esc_html__('Display sale Text', 'yanka'),
                'pct' => esc_html__('Display sale Percentage', 'yanka')
            ),
			'default'	=> 'pct'
		),
        array(
            'id'       => 'wc-quick-view',
            'type'     => 'switch',
            'title'    => esc_html__('Show/Hide Quickview Button', 'yanka'),
            'on'       => esc_html__('Show', 'yanka'),
			'off'      => esc_html__('Hide', 'yanka'),
			'default'  => 1,
        ),
        array(
            'id'       => 'wc-wishlist',
            'type'     => 'switch',
            'title'    => esc_html__('Show/Hide Wishlist', 'yanka'),
            'on'       => esc_html__('Show', 'yanka'),
			'off'      => esc_html__('Hide', 'yanka'),
			'default'  => 1,
        ),
        array(
            'id'       => 'wc-compare',
            'type'     => 'switch',
            'title'    => esc_html__('Show/Hide Compare', 'yanka'),
            'on'       => esc_html__('Show', 'yanka'),
            'off'      => esc_html__('Hide', 'yanka'),
            'default'  => 1,
        ),
        array(
            'id'       => 'wc-rating',
            'type'     => 'switch',
            'title'    => esc_html__('Show/Hide Rating', 'yanka'),
            'on'       => esc_html__('Show', 'yanka'),
			'off'      => esc_html__('Hide', 'yanka'),
			'default'  => 1,
        ),
        array(
            'id'       => 'wc-category-name',
            'type'     => 'switch',
            'title'    => esc_html__('Show/Hide Category Name', 'yanka'),
            'on'       => esc_html__('Show', 'yanka'),
			'off'      => esc_html__('Hide', 'yanka'),
			'default'  => 1
        ),
        array(
            'id'    => 'wc-attribute-variation',
            'type'  => 'switch',
            'title' => esc_html__('Show Attribute Variation','yanka'),
            'desc'  => esc_html__('Show attribute variation on product box', 'yanka'),
            'on'    => esc_html__('Show','yanka'),
			'off'   => esc_html__('Hide','yanka'),
			'default' => 1,
        ),
    )
) );

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Page Title', 'yanka' ),
    'id'         => 'wc_shop_page_title',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'             => 'shop-title-color',
            'type'           => 'color',
            'title'          => esc_html__('Shop heading color', 'yanka'),
            'default'        => '#333',
            'output'           => array('.title-shop.page-heading .entry-title'),
            'subtitle'       => esc_html__('Set your color options for heading.', 'yanka'),
        ),
        array(
            'id'       => 'shop-title-background',
            'type'     => 'background',
            'title'    => esc_html__('Shop heading background', 'yanka'),
            'subtitle' => esc_html__('Set background image or color for shop.', 'yanka'),
            'output'   => array('.title-shop.page-heading'),
            'default'  => array(
                'background-color'    => '',
                'background-position' => 'center center',
                'background-size'     => 'cover'
            ),
        ),
    )
) );

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Shop action', 'yanka' ),
    'id'         => 'wc_shop_action',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'wc-product-view',
            'type'     => 'button_set',
            'title'    => esc_html__('Shop products view', 'yanka'),
            'subtitle' => esc_html__('You can set different view mode for the shop page', 'yanka'),
            'options'  => array(
                'grid' => esc_html__('Grid', 'yanka'),
                'list' => esc_html__('List', 'yanka'),
            ),
            'default'  => 'grid'
        ),
        array(
            'id'       => 'wc-product-style-load',
            'type'     => 'select',
            'title'    => esc_html__( 'Load Product Effect', 'yanka' ),
            'options'  => array(
                ''                      => esc_html__( 'None', 'yanka' ),
                'bounceIn'              => esc_html__( 'bounceIn', 'yanka' ),
                'bounceInDown'          => esc_html__( 'bounceInDown', 'yanka' ),
                'bounceInLeft'          => esc_html__( 'bounceInLeft', 'yanka' ),
                'bounceInRight'         => esc_html__( 'bounceInRight', 'yanka' ),
                'bounceInUp'            => esc_html__( 'bounceInUp', 'yanka' ),
                'fadeIn'                => esc_html__( 'fadeIn', 'yanka' ),
                'fadeInDown'            => esc_html__( 'fadeInDown', 'yanka' ),
                'fadeInDownBig'         => esc_html__( 'fadeInDownBig', 'yanka' ),
                'fadeInLeft'            => esc_html__( 'fadeInLeft', 'yanka' ),
                'fadeInLeftBig'         => esc_html__( 'fadeInLeftBig', 'yanka' ),
                'fadeInRight'           => esc_html__( 'fadeInRight', 'yanka' ),
                'fadeInRightBig'        => esc_html__( 'fadeInRightBig', 'yanka' ),
                'fadeInUp'              => esc_html__( 'fadeInUp', 'yanka' ),
                'fadeInUpBig'           => esc_html__( 'fadeInUpBig', 'yanka' ),
                'flipInX'               => esc_html__( 'flipInX', 'yanka' ),
                'flipInY'               => esc_html__( 'flipInY', 'yanka' ),
                'lightSpeedIn'          => esc_html__( 'lightSpeedIn', 'yanka' ),
                'rotateIn'              => esc_html__( 'rotateIn', 'yanka' ),
                'rotateInDownLeft'      => esc_html__( 'rotateInDownLeft', 'yanka' ),
                'rotateInDownRight'     => esc_html__( 'rotateInDownRight', 'yanka' ),
                'rotateInUpLeft'        => esc_html__( 'rotateInUpLeft', 'yanka' ),
                'rotateInUpRight'       => esc_html__( 'rotateInUpRight', 'yanka' ),
                'rollIn'                => esc_html__( 'rollIn', 'yanka' ),
                'zoomIn'                => esc_html__( 'zoomIn', 'yanka' ),
                'zoomInDown'            => esc_html__( 'zoomInDown', 'yanka' ),
                'zoomInLeft'            => esc_html__( 'zoomInLeft', 'yanka' ),
                'zoomInRight'           => esc_html__( 'zoomInRight', 'yanka' ),
                'zoomInUp'              => esc_html__( 'zoomInUp', 'yanka' ),
                'slideInDown'           => esc_html__( 'slideInDown', 'yanka' ),
                'slideInLeft'           => esc_html__( 'slideInLeft', 'yanka' ),
                'slideInRight'          => esc_html__( 'slideInRight', 'yanka' ),
                'slideInUp'             => esc_html__( 'slideInUp', 'yanka' ),
                'slideInDown'           => esc_html__( 'slideInDown', 'yanka' ),
                'slideInDown'           => esc_html__( 'slideInDown', 'yanka' ),
                'slideInDown'           => esc_html__( 'slideInDown', 'yanka' ),
                'slideInDown'           => esc_html__( 'slideInDown', 'yanka' ),
            ),
            'default'  => '',
        ),
        array(
            'id'       => 'wc-shop-ordering',
            'type'     => 'switch',
            'title'    => esc_html__('Products ordering', 'yanka'),
            'on'       => esc_html__('Enable', 'yanka'),
			'off'      => esc_html__('Disable', 'yanka'),
			'default'  => 1,
        ),
        array(
            'id'       => 'wc-products-per-page',
            'type'     => 'switch',
            'title'    => esc_html__('Products per page', 'yanka'),
            'on'       => esc_html__('Enable', 'yanka'),
			'off'      => esc_html__('Disable', 'yanka'),
			'default'  => 1,
        ),
    )
) );

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Product List Setting', 'yanka' ),
    'id'         => 'wc_product_list_setting',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'wc-number-per-page',
            'type'     => 'text',
            'title'    => esc_html__( 'Per page', 'yanka' ),
            'subtitle' => esc_html__( 'How much items per page to show.', 'yanka' ),
            'validate' => 'numeric',
            'default'  => '12'
        ),
        array(
            'id'       => 'wc-product-column',
            'type'     => 'button_set',
            'title'    => esc_html__('Columns', 'yanka'),
            'options'  => array(
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
            ),
            'default'  => '3'
        ),
        array(
            'id'       => 'wc-gutter-space',
            'type'     => 'select',
            'title'    => esc_html__('Gutter Space', 'yanka'),
            'options'  => array(
                '0'  => '0',
                '10' => '10',
                '20' => '20',
                '30' => '30',
                '40' => '40',
                '50' => '50',
                '60' => '60'
            ),
            'default' => '30'
        ),
        array(
            'id'       => 'wc-pagination-type',
            'type'     => 'button_set',
            'title'    => esc_html__('Shop Pagination', 'yanka'),
            'options'  => array(
                'number'   => esc_html__('Pagination links', 'yanka'),
                'loadmore' => esc_html__('Load more button', 'yanka'),
                'infinite' => esc_html__('Infinit scrolling', 'yanka'),
            ),
            'default' => 'loadmore'
        ),
        array(
            'id'       => 'wc-shop-layout',
            'type'     => 'image_select',
            'title'    => esc_html__( 'Product List Layout', 'yanka' ),
            'subtitle' => esc_html__( 'Select shop page layout with sidebar postion.', 'yanka' ),
            'options'  => array(
                'left' => array(
                    'alt' => esc_html__('Left Sidebar', 'yanka'),
                    'img' => YANKA_URL . '/assets/images/layout/left-sidebar.jpg'
                ),
                'no' => array(
                    'alt' => esc_html__('No Sidebar', 'yanka'),
                    'img' => YANKA_URL . '/assets/images/layout/no-sidebar.jpg'
                ),
                'right' => array(
                    'alt' => esc_html__('Right Sidebar', 'yanka'),
                    'img' => YANKA_URL . '/assets/images/layout/right-sidebar.jpg'
                ),
            ),
            'default'  => 'left'
        ),
    )
) );

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Single Product Setting', 'yanka' ),
    'id'         => 'wc_product_page',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'single-product-sidebar',
            'type'     => 'image_select',
            'title'    => esc_html__( 'Single Product Layout', 'yanka' ),
            'subtitle' => esc_html__( 'Select single product page layout with sidebar postion.', 'yanka' ),
            'options'  => array(
                'left' => array(
                    'alt' => esc_html__('Left Sidebar', 'yanka'),
                    'img' => YANKA_URL . '/assets/images/layout/left-sidebar.jpg'
                ),
                'no' => array(
                    'alt' => esc_html__('No Sidebar', 'yanka'),
                    'img' => YANKA_URL . '/assets/images/layout/no-sidebar.jpg'
                ),
                'right' => array(
                    'alt' => esc_html__('Right Sidebar', 'yanka'),
                    'img' => YANKA_URL . '/assets/images/layout/right-sidebar.jpg'
                ),
            ),
            'default'  => 'no'
        ),
        array(
            'id'       => 'wc-product-sticky-addtocart',
            'type'     => 'switch',
            'title'    => esc_html__('Show/Hide Sticky Add To Cart Bottom', 'yanka'),
            'default'  => 0,
        ),        
        array(
            'id'       => 'wc-product-zoom-image',
            'type'     => 'switch',
            'title'    => esc_html__('Zoom image?', 'yanka'),
			'default'  => 1,
        ),
        array(
            'id'       => 'product-tab-layout',
            'type'     => 'button_set',
            'title'    => esc_html__('Tabs layout', 'yanka'),
            'options'  => array(
                'tabs'      => esc_html__('Tabs Full Width', 'yanka'),
                'accordion' => esc_html__('Accordion Full Width', 'yanka'),
            ),
            'default' => 'accordion'
        ),
        array(
            'id'       => 'position-accordion',
            'type'     => 'button_set',
            'title'    => esc_html__('Position Accordion', 'yanka'),
            'options'  => array(
                'right'      => esc_html__('Right', 'yanka'),
                'bottom' => esc_html__('Bottom', 'yanka'),
            ),
            'default' => 'right',
            'required'    => array( 'product-tab-layout', '=', 'accordion' )
        ),     
        array(
            'id'    => 'wc-single-shipping-return',
            'type'  => 'editor',
            'title' => esc_html__( 'Shipping & Return content', 'yanka' ),
            'desc'  => esc_html__( 'HTML is allowed', 'yanka' ),
        ),
        array(
            'id'    => 'wc-single-size-guide',
            'type'  => 'editor',
            'title' => esc_html__( 'Size guide', 'yanka' ),
            'desc'  => esc_html__( 'HTML is allowed', 'yanka' ),
        ),
        array(
            'id'    => 'wc-single-shipping',
            'type'  => 'editor',
            'title' => esc_html__( 'Shipping', 'yanka' ),
            'desc'  => esc_html__( 'HTML is allowed', 'yanka' ),
        ),
        array(
            'id'    => 'wc-single-ask-about-product',
            'type'  => 'editor',
            'title' => esc_html__( 'Ask about this product', 'yanka' ),
            'desc'  => esc_html__( 'HTML is allowed', 'yanka' ),
        ),                                
        array(
            'id'       => 'wc-single-nagivation',
            'type'     => 'switch',
            'title'    => esc_html__('Enable Navigation?', 'yanka'),
			'default'  => 1,
        ),
        array(
            'id'       => 'section-upsell-product-start',
            'type'     => 'section',
            'title'    => esc_html__( 'You may also like..', 'yanka' ),
            'indent'   => true,
        ),
        array(
            'id'       => 'upsell-product-title',
            'type'     => 'text',
            'title'    => esc_html__('Title', 'yanka'),
            'default'  => 'You May Also Like..',
        ),
        array(
            'id'       => 'upsell-product-desc',
            'type'     => 'text',
            'title'    => esc_html__('Description', 'yanka'),
            'default'  => 'Includes products updated are similar or are same of quality',
        ),
        array(
            'id'       => 'section-upsell-product-end',
            'type'     => 'section',
            'indent'   => true,
        ),
        array(
            'id'       => 'section-related-product-start',
            'type'     => 'section',
            'title'    => esc_html__( 'Related Products', 'yanka' ),
            'indent'   => true,
        ),
        array(
            'id'       => 'related-product-title',
            'type'     => 'text',
            'title'    => esc_html__('Title', 'yanka'),
            'default'  => 'Related Products',
        ),
        array(
            'id'       => 'related-product-desc',
            'type'     => 'text',
            'title'    => esc_html__('Description', 'yanka'),
            'default'  => '',
        ),
        array(
            'id'       => 'section-related-product-end',
            'type'     => 'section',
            'indent'   => true,
        ),
    )
) );

Redux::setSection( $opt_name, array(
    'title'      => esc_html__('Catalog mode', 'yanka'),
    'id'         => 'shop-catalog',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'catalog-mode',
            'type'     => 'switch',
            'title'    => esc_html__('Enable catalog mode', 'yanka'),
            'subtitle' => esc_html__('You can hide all "Add to cart" buttons, cart widget, cart and checkout pages. This will allow you to showcase your products as an online catalog without ability to make a purchase.', 'yanka'),
            'default'  => false
        ),
        array(
            'id'       => 'cart-right-col-mode',
            'type'     => 'switch',
            'title'    => esc_html__('Enable Cart with Right Col', 'yanka'),
            'subtitle' => esc_html__('Cart with Right Col.', 'yanka'),
            'default'  => false
        ),        
    ),
) );

// Portfolio
Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Portfolio', 'yanka' ),
    'id'     => 'portfolio',
    'icon'   => 'el el-filter',
    'fields' => array(
        array(
            'id'       => 'portfolio-title',
            'type'     => 'text',
            'title'    => esc_html__('Portfolio Title', 'yanka'),
            'default'  => esc_html__('Portfolio', 'yanka')
        ),
        array(
            'id'             => 'portfolio-title-color',
            'type'           => 'color',
            'title'          => esc_html__('Page heading color', 'yanka'),
            'default'        => '#000',
            'output'           => array('.title-portfolio.page-heading .entry-title'),
            'subtitle'       => esc_html__('Set your color options for heading.', 'yanka'),
        ),
        array(
            'id'               => 'portfolio-title-background',
            'type'             => 'background',
            'title'            => esc_html__('Portfolio heading background', 'yanka'),
            'subtitle'         => esc_html__('Set background image or color for portfolio.', 'yanka'),
            'output'           => array('.page-heading.title-portfolio'),
            'default'          => array(
                'background-color'    => '',
                'background-position' => 'center center',
                'background-size'     => 'cover'
            ),
        ),
        array(
            'id'       => 'portfolio-fullwidth',
            'type'     => 'switch',
            'title'    => esc_html__('Full Width portfolio', 'yanka'),
            'subtitle' => esc_html__('Makes container 100% width of the page', 'yanka'),
            'on'       => esc_html__('On', 'yanka'),
			'off'      => esc_html__('Off', 'yanka'),
			'default'  => 0,
        ),
        array(
            'id'       => 'portfolio-cat-filter',
            'type'     => 'switch',
            'title'    => esc_html__('Show categories filters', 'yanka'),
            'on'       => esc_html__('On', 'yanka'),
			'off'      => esc_html__('Off', 'yanka'),
			'default'  => 1,
        ),
        array(
            'id'       => 'portfolio-style',
            'type'     => 'select',
            'title'    => esc_html__( 'Portfolio Style', 'yanka' ),
            'subtitle' => esc_html__('You can use different styles for your projects.', 'yanka'),
            'options'  => array(
                'default'                 => esc_html__('Show text on mouse over', 'yanka'),
                'hover-inverse'           => esc_html__('Alternative', 'yanka'),
                'text-under-image'        => esc_html__('Text under image', 'yanka'),
                'text-under-image-shadow' => esc_html__('Text under image with shadow', 'yanka'),
            ),
            'default'  => 'default'
        ),
        array(
            'id'       => 'portfolio-columns',
            'type'     => 'button_set',
            'title'    => esc_html__('Portfolio columns', 'yanka'),
            'subtitle' => esc_html__('How many projects you want to show per row', 'yanka'),
            'options'  => array(
                2 => '2',
                3 => '3',
                4 => '4',
                5 => '5',
                6 => '6'
            ),
            'default' => 2
        ),
        array(
            'id'       => 'portfolio-spacing',
            'type'     => 'button_set',
            'title'    => esc_html__('Space between projects', 'yanka'),
            'subtitle' => esc_html__('You can set different spacing between blocks on portfolio page', 'yanka'),
            'options'  => array(
                0  => '0',
                10 => '10',
                20 => '20',
                30 => '30',
                40 => '40',
            ),
            'default' => 10
        ),
        array(
            'id'       => 'portfolio-number-per-page',
            'type'     => 'text',
            'title'    => esc_html__( 'Items per page', 'yanka' ),
            'subtitle' => esc_html__( 'How much items per page to show.', 'yanka' ),
            'validate' => 'numeric',
            'default'  => '11'
        ),
        array(
            'id'       => 'portfolio-pagination-type',
            'type'     => 'button_set',
            'title'    => esc_html__('Portfolio pagination', 'yanka'),
            'options'  => array(
                'number'   => esc_html__('Pagination links', 'yanka'),
                'loadmore' => esc_html__('Load more button', 'yanka'),
                'infinite' => esc_html__('Infinit scrolling', 'yanka'),
            ),
            'default' => 'number'
        ),
        array(
            'id'       => 'portfolio-navigation',
            'type'     => 'switch',
            'title'    => esc_html__('Portfolio navigation', 'yanka'),
            'on'       => esc_html__('On', 'yanka'),
			'off'      => esc_html__('Off', 'yanka'),
			'default'  => 1,
        ),
        array(
            'id'       => 'portfolio-related',
            'type'     => 'switch',
            'title'    => esc_html__('Related Portfolio', 'yanka'),
            'subtitle' => esc_html__('Show related portfolio carousel.', 'yanka'),
            'default' => true
        ),
    )
) );


// START Social Network
Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Social Network', 'yanka' ),
    'id'     => 'social',
    'icon'   => 'el el-dribbble',
    'fields' => array(
        array(
            'id'       => 'facebook',
            'type'     => 'text',
            'title'    => esc_html__('Facebook', 'yanka'),
            'default'  => '#Dc6978'
        ),
        array(
            'id'       => 'twitter',
            'type'     => 'text',
            'title'    => esc_html__('Twitter', 'yanka'),
            'default'  => '#'
        ),
        array(
            'id'       => 'google-plus',
            'type'     => 'text',
            'title'    => esc_html__('Google Plus', 'yanka'),
            'default'  => '#'
        ),
        array(
            'id'       => 'instagram',
            'type'     => 'text',
            'title'    => esc_html__('Instagram', 'yanka'),
            'default'  => '#'
        ),
        array(
            'id'       => 'pinterest',
            'type'     => 'text',
            'title'    => esc_html__('Pinterest', 'yanka'),
            'default'  => ''
        ),
        array(
            'id'       => 'vimeo',
            'type'     => 'text',
            'title'    => esc_html__('Vimeo', 'yanka'),
            'default'  => ''
        ),
        array(
            'id'       => 'youtube',
            'type'     => 'text',
            'title'    => esc_html__('YouTube', 'yanka'),
            'default'  => ''
        ),
        array(
            'id'       => 'dribbble',
            'type'     => 'text',
            'title'    => esc_html__('Dribbble', 'yanka'),
            'default'  => ''
        ),
        array(
            'id'       => 'tumblr',
            'type'     => 'text',
            'title'    => esc_html__('Tumblr', 'yanka'),
            'default'  => ''
        ),
        array(
            'id'       => 'linkedin',
            'type'     => 'text',
            'title'    => esc_html__('LinkedIn', 'yanka'),
            'default'  => ''
        ),
        array(
            'id'       => 'flickr',
            'type'     => 'text',
            'title'    => esc_html__('Flickr', 'yanka'),
            'default'  => ''
        ),
        array(
            'id'       => 'github',
            'type'     => 'text',
            'title'    => esc_html__('GitHub', 'yanka'),
            'default'  => ''
        ),
        array(
            'id'       => 'lastfm',
            'type'     => 'text',
            'title'    => esc_html__('Last.fm', 'yanka'),
            'default'  => ''
        ),
        array(
            'id'       => 'paypal',
            'type'     => 'text',
            'title'    => esc_html__('PayPal', 'yanka'),
            'default'  => ''
        ),
        array(
            'id'       => 'wordpress',
            'type'     => 'text',
            'title'    => esc_html__('WordPress', 'yanka'),
            'default'  => ''
        ),
        array(
            'id'       => 'skype',
            'type'     => 'text',
            'title'    => esc_html__('Skype', 'yanka'),
            'default'  => ''
        ),
        array(
            'id'       => 'yahoo',
            'type'     => 'text',
            'title'    => esc_html__('Yahoo', 'yanka'),
            'default'  => ''
        ),
        array(
            'id'       => 'reddit',
            'type'     => 'text',
            'title'    => esc_html__('Reddit', 'yanka'),
            'default'  => ''
        ),
        array(
            'id'       => 'deviantart',
            'type'     => 'text',
            'title'    => esc_html__('DeviantART', 'yanka'),
            'default'  => ''
        ),
        array(
            'id'       => 'steam',
            'type'     => 'text',
            'title'    => esc_html__('Steam', 'yanka'),
            'default'  => ''
        ),
        array(
            'id'       => 'foursquare',
            'type'     => 'text',
            'title'    => esc_html__('Foursquare', 'yanka'),
            'default'  => ''
        ),
        array(
            'id'       => 'behance',
            'type'     => 'text',
            'title'    => esc_html__('Behance', 'yanka'),
            'default'  => ''
        ),
        array(
            'id'       => 'xing',
            'type'     => 'text',
            'title'    => esc_html__('Xing', 'yanka'),
            'default'  => ''
        ),
        array(
            'id'       => 'stumbleupon',
            'type'     => 'text',
            'title'    => esc_html__('StumbleUpon', 'yanka'),
            'default'  => ''
        ),
    )
) );

// Maintenance
Redux::setSection( $opt_name, array(
    'title' => esc_html__( 'Maintenance Mode', 'yanka' ),
    'id'     => 'maintenance',
    'icon'   => 'el el-time',
    'fields' => array(
        array(
            'id'       => 'maintenance-mode',
            'type'     => 'switch',
            'title'    => esc_html__('Maintenance Mode', 'yanka'),
            'on'       => esc_html__('Enable', 'yanka'),
			'off'      => esc_html__('Disable', 'yanka'),
			'default'  => 0,
        ),
        array(
            'id'       => 'section-maintenance-background-start',
            'title'    => esc_html__('Maintenance Background', 'yanka'),
            'type'     => 'section',
            'indent'   => true,
        ),
        array(
            'id'      => 'maintenance-background',
            'type'    => 'background',
            'title'   => esc_html__( 'Background', 'yanka' ),
            'background-color'      => false,
            'default' => array(
                'background-image'      => '',
                'background-color'      => ''
            ),
            'output' => 'body.offline'
        ),
        array(
            'id'       => 'section-maintenance-background-end',
            'type'     => 'section',
            'indent'   => true,
        ),
        array(
            'id'       => 'section-maintenance-text-start',
            'title'    => esc_html__('Maintenance Text', 'yanka'),
            'type'     => 'section',
            'indent'   => true,
        ),
        array(
            'id'    => 'maintenance-title',
            'type'  => 'text',
            'title' => esc_html__( 'Title', 'yanka' ),
            'default' => 'COMING SOON'
        ),
        array(
            'id'    => 'maintenance-message',
            'type'  => 'textarea',
            'title' => esc_html__( 'Message', 'yanka' ),
            'default' => 'We are working very hard to give you the best experience with this one. You will love Jms Yanka as much as we do. It will morph perfectly on your needs!'
        ),
        array(
            'id'       => 'section-maintenance-text-end',
            'type'     => 'section',
            'indent'   => true,
        ),
        array(
            'id'       => 'maintenance-countdown',
            'type'     => 'switch',
            'title'    => esc_html__('Enable Countdown', 'yanka'),
            'on'       => esc_html__('Enable', 'yanka'),
			'off'      => esc_html__('Disable', 'yanka'),
			'default'  => 1,
        ),
        array(
            'id'       => 'maintenance-date',
            'type'     => 'select',
            'title'    => esc_html__('Date', 'yanka'),
            'options'  => array(
                '01' => '01',
				'02' => '02',
				'03' => '03',
				'04' => '04',
				'05' => '05',
				'06' => '06',
				'07' => '07',
				'08' => '08',
				'09' => '09',
				'10' => '10',
				'11' => '11',
				'12' => '12',
				'13' => '13',
				'14' => '14',
				'15' => '15',
				'16' => '16',
				'17' => '17',
				'18' => '18',
				'19' => '19',
				'20' => '20',
				'21' => '21',
				'22' => '22',
				'23' => '23',
				'24' => '24',
				'25' => '25',
				'26' => '26',
				'27' => '27',
				'28' => '28',
				'29' => '29',
				'30' => '30',
				'31' => '31'
            ),
            'default'  => '15',
            'required' => array( 'maintenance-countdown', '=', 1 )
        ),
        array(
            'id'       => 'maintenance-month',
            'type'     => 'select',
            'title'    => esc_html__('Month', 'yanka'),
            'options'  => array(
                '01' => esc_html__('January', 'yanka'),
			    '02'  => esc_html__('Febuary', 'yanka'),
			    '03'  => esc_html__('March', 'yanka'),
			    '04'  => esc_html__('April', 'yanka'),
			    '05'  => esc_html__('May', 'yanka'),
			    '06'  => esc_html__('June', 'yanka'),
			    '07'  => esc_html__('July', 'yanka'),
			    '08'  => esc_html__('August', 'yanka'),
			    '09'  => esc_html__('September', 'yanka'),
			    '10' => esc_html__('October', 'yanka'),
			    '11' => esc_html__('November', 'yanka'),
			    '12' => esc_html__('December', 'yanka'),
            ),
            'default'  => '03',
            'required' => array( 'maintenance-countdown', '=', 1 )
        ),
        array(
            'id'       => 'maintenance-year',
            'type'     => 'select',
            'title'    => esc_html__('Year', 'yanka'),
            'options'  => array(
				'2018' => '2018',
				'2019' => '2019',
				'2020' => '2020'
            ),
            'default'  => '2018',
            'required' => array( 'maintenance-countdown', '=', 1 )
        ),
    ),
) );