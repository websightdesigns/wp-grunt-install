<?php
/**
 * The template for displaying all single posts.
 *
 * @package my_theme
 */

get_header(); ?>

	<div id="primary" class="content-area col-md-<?php echo ( is_active_sidebar( 'sidebar-1' ) ? '9' : '12' ); ?> col-sm-12">
		<div class="well">
			<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'single' ); ?>

				<?php my_theme_post_nav(); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->
		</div><!-- .well -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
