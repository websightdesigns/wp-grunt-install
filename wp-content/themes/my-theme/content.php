<?php
/**
 * @package my_theme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="blog-post-thumbnail">

		<?php
			// Page thumbnail and title.
			if ( has_post_thumbnail() ) {
				the_post_thumbnail();
			} else {
				?><img src="http://placehold.it/192x192" class="attachment-post-thumbnail wp-post-image" alt=""><?php
			}
		?>

	</div><!-- .blog-post-thumbnail -->

	<div class="blog-post-content">

		<header class="entry-header">
			<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>

			<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
				<?php my_theme_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php
				//the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'my_theme' ) );
			?>
			<p><?php
				echo get_the_excerpt();
			?> <span class="readmore-link"><a href="<?php echo esc_url( get_permalink() ) ?>" class="readmore" rel="bookmark">READ&nbsp;&raquo;</a></span></p>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'my_theme' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
				<?php
					/* translators: used between list items, there is a space after the comma */
					$categories_list = get_the_category_list( __( ', ', 'my_theme' ) );
					if ( $categories_list && my_theme_categorized_blog() ) :
				?>
				<span class="cat-links">
					<?php printf( __( 'Posted in %1$s', 'my_theme' ), $categories_list ); ?>
				</span>
				<?php endif; // End if categories ?>

				<?php
					/* translators: used between list items, there is a space after the comma */
					$tags_list = get_the_tag_list( '', __( ', ', 'my_theme' ) );
					if ( $tags_list ) :
				?>
				<span class="tags-links">
					<?php printf( __( 'Tagged %1$s', 'my_theme' ), $tags_list ); ?>
				</span>
				<?php endif; // End if $tags_list ?>
			<?php endif; // End if 'post' == get_post_type() ?>

			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
			<span class="comments-link"><?php //comments_popup_link( __( 'Leave a comment', 'my_theme' ), __( '1 Comment', 'SKEL_THEME_PREFIX' ), __( '% Comments', 'SKEL_THEME_PREFIX' ) ); ?></span>
			<?php endif; ?>

			<?php //edit_post_link( __( 'Edit', 'my_theme' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-footer -->

	</div><!-- .blog-post-content -->

</article><!-- #post-## -->
