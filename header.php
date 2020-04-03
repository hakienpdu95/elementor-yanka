<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php if ( !wp_is_mobile() ){ ?>
		<?php yanka_preloader(); ?>

		<div id="sidebar-open-overlay"></div>
		<?php if ( yanka_get_option('show-toggle-sidebar', 0) ) : ?>
			<div class="toggle-sidebar-widget toggleSidebar">
	            <div class="closetoggleSidebar"></div>
	            <div class="widget-area">
	                <?php dynamic_sidebar( 'toggle-sidebar' ); ?>
	            </div>
	        </div>
	    <?php endif; ?>
	    <?php locate_template('template-parts/menu-mobile.php', true);?>
		<?php locate_template('template-parts/menu-popup.php', true);?>

		<div id="page" class="site">
			<div id="page-open-overlay"></div>
			<?php yanka_top_panel(); ?>
			<?php yanka_promo_bar(); ?>
			<?php yanka_header(); ?>
			<?php yanka_page_title(); ?>			
<?php }else{ ?>
		<?php yanka_preloader(); ?>
		<?php locate_template('template-parts/menu-mobile.php', true);?>
		<div id="page" class="site">
			<?php yanka_header_mobile(); ?>
			<?php yanka_page_title(); ?>
<?php } ?>