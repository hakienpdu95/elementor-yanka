<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @since   1.0.0
 * @package Yanka
 */

get_header();
?>
<div class="page-heading title-align-left">
    <div class="container-fluid">
        <header class="entry-header">
            <div class="breadcrumb"><a href="<?php echo esc_url( home_url('/') ); ?>"><?php esc_html_e( 'Home', 'yanka' ); ?></a> <span></span> <?php esc_html_e( '404', 'yanka' ); ?></div>
        </header>
    </div>
</div>

<div class="page-content">
    <div class="error-404 container tc">
		<div class="pt-empty-layout">
		    <h2 class="pt-title-02"><?php esc_html_e( 'Error 404...', 'yanka' ); ?></h2>
		    <h1 class="pt-title pt-size-large"><?php esc_html_e( 'Page Not Found', 'yanka' ); ?></h1>
		    <p><?php esc_html_e( 'We looked everywhere for this page. Are you sure the website URL is correct? Go to the', 'yanka' ); ?> <strong><a href="<?php echo esc_url( home_url('/') ); ?>" class="pt-link pt-color-base"><?php esc_html_e( 'main page', 'yanka' ); ?></a></strong> <?php esc_html_e( 'or select suitable category.', 'yanka' ); ?>
		    </p>
		</div>
    </div>
</div><!-- page-content -->

<?php get_footer();