<?php
get_header();

$content_class = $sidebar_class = $layout_classes = '';

// Get blog options
$smart_sidebar        = yanka_get_option( 'smart-sidebar', 0 );
$blog_single_layout   = yanka_get_option('blog-single-layout', 'left');
$blog_design     = yanka_get_option( 'blog-design', 'default' );
$show_featured_image  = yanka_get_option('show-feature-image', 1);
$show_post_navigation = yanka_get_option('show-post-navigation', 1);
$show_related_posts   = yanka_get_option('show-related-posts', 1);

// DEMO
if ( isset($_GET['sidebar']) && $_GET['sidebar'] != '' ) {
	$blog_single_layout = $_GET['sidebar'];
}


if( isset( $blog_design ) && $blog_design != '' && $blog_design == 'default') {
	$content_class = 'col-lg-8';
}

if( isset( $blog_design ) && $blog_design != '' && $blog_design != 'default') {
	$content_class = 'col-lg-12 masonry-blog';
}


// Render columns number
if ( $blog_single_layout == 'left' && is_active_sidebar( 'primary-sidebar' ) ) {
	$content_class .= ' col-lg-8 col-md-8 col-sm-12 col-xs-12';
	$sidebar_class = 'col-lg-4 col-md-4 col-sm-12 col-xs-12';
	$layout_classes = 'left-sidebar';
} elseif ( $blog_single_layout == 'right' && is_active_sidebar( 'primary-sidebar' )) {
	$content_class .= ' col-lg-8 col-md-8 col-sm-12 col-xs-12';
	$sidebar_class = 'col-lg-4 col-md-4 col-sm-12 col-xs-12';
} elseif ( $blog_single_layout == 'no' || !is_active_sidebar( 'primary-sidebar' ) ) {
	$content_class .= ' col-md-12 col-sm-12 col-xs-12 no-sidebar unset-float';
	$sidebar_class = '';
}

if ( isset($smart_sidebar) && $smart_sidebar == 1 ) {
	$sidebar_class .= ' smart-sidebar';
}

?>

<div class="page-content">
	<div class="container mt_100 mb_100">
		<div class="row <?php echo esc_attr($layout_classes); ?>">

			<div id="main-content" class="<?php echo esc_attr( $content_class ); ?>">
				<?php
                while ( have_posts() ) : the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-single-page' ); ?>>
						<div class="article-inner">
				            <h1 class="entry-title"><?php the_title(); ?></h1>

							<?php
							$show_author     = yanka_get_option('show-author', 1);
					        $show_comments   = yanka_get_option('show-comment', 1);
					        $show_categories = yanka_get_option('show-category', 1);
							?>

							<ul class="entry-meta-list">
								<?php if( get_post_type() === 'post' ): ?>
									<?php // Author ?>
									<?php if ($show_author == 1): ?>
										<li class="meta-author">
											<?php esc_html_e('By', 'yanka'); ?>
											<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php echo get_the_author(); ?></a>
										</li>
									<?php endif ?>
									<?php // Date ?>
				                    <li class="meta-date">
				                        <a href="<?php echo esc_url( get_permalink() ); ?>" class="time updated"><?php echo get_the_date(); ?></a>
				                    </li>

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
								<?php endif; ?>
							</ul>

							<?php if ( $show_featured_image == 1 ) : ?>
								<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
								<header class="entry-header pr">
									<figure class="entry-thumbnail">
										<div class="post-img-wrap">
											<?php echo yanka_get_post_thumbnail( 'large' ); ?>
										</div>
									</figure>
								</header><!-- .entry-header -->
								<?php endif; ?>
							<?php endif; ?>

							<div class="article-body-container">
								<div class="entry-content yanka-entry-content">
									<?php the_content(); ?>
								</div>
								<div class="clearfix"></div>
					        </div>

							<?php
							wp_link_pages( array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'yanka' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
								'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'yanka' ) . ' </span>%',
								'separator'   => '<span class="screen-reader-text">, </span>',
							) );
							?>

							<?php if ( is_single() && get_the_author_meta( 'description' ) ) : ?>
								<footer class="entry-author">
									<?php get_template_part( 'author-biography' ); ?>
								</footer><!-- .entry-author -->
							<?php endif; ?>

						</div>
					</article><!-- #post-# -->

					<?php if( get_the_tag_list( '', ', ' ) ): ?>
					<div class="yanka-single-bottom flex between-xs">
						<div class="single-meta-tags flex middle-xs">
							<span class="tags-title mr_10"><?php esc_html_e('Tags', 'yanka'); ?>:</span>
							<div class="tags-list">
								<?php echo get_the_tag_list( '', ', ' ); ?>
							</div>
						</div>
					</div>
					<?php endif; ?>

					<?php

					if( isset($show_post_navigation) && $show_post_navigation == 1 ) {
						yanka_post_navigation();
					}

					if( isset($show_related_posts) && $show_related_posts == 1 ) {
					    yanka_related_posts();
					}

					comments_template();

                endwhile; // End of the loop.
				?>
			</div>

			<?php if ( isset( $blog_single_layout ) && $blog_single_layout != 'no' && is_active_sidebar( 'primary-sidebar' ) ) : ?>
				<div id="main-sidebar" class="<?php echo esc_attr( $sidebar_class ); ?>">
					<?php
						if ( is_active_sidebar( 'primary-sidebar' ) ) {
							dynamic_sidebar( 'primary-sidebar' );
						}
					?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</div><!-- page-content -->

<?php get_footer();
