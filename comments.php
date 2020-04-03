<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( wp_kses( _nx( 'One Thought on &ldquo;%2$s&rdquo;', '%1$s Thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'yanka' ), array() ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>			
		</h2>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
				 'style'    => 'ol',
				 'callback' => 'yanka_comments_list',
				) );
			?>
		</ol><!-- .comment-list -->

		<?php
			// Are there comments to navigate through?
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
		?>
		<nav class="navigation comment-navigation" role="navigation">
			<h1 class="screen-reader-text section-heading"><?php esc_html_e( 'Comment navigation', 'yanka' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'yanka' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'yanka' ) ); ?></div>
		</nav><!-- .comment-navigation -->
		<?php endif; // Check for comment navigation ?>

		<?php if ( ! comments_open() && get_comments_number() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.' , 'yanka' ); ?></p>
		<?php endif; ?>

	<?php endif; ?>

	<?php
		$args = array(
			'comment_notes_before' => '',
			// Redefine your own textarea (the comment body)
			'comment_field' => '<div class="comment-form-comment mb_30 mt_30"><textarea rows="8" placeholder="' . esc_attr__( 'Write your comments here', 'yanka' ) . '" name="comment" aria-required="true"></textarea></div>',
			// Change the title of the reply section
			'title_reply'=> esc_html__( 'Leave a Comment', 'yanka' ),

			// Change the title of send button
			'label_submit'=> esc_html__( 'Post comment', 'yanka' ),
		);

		comment_form( $args );
	?>

</div><!-- #comments -->
