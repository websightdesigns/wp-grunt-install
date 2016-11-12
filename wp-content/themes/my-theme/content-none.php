<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package my_theme
 */
?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php _e( 'Nothing Found', 'my_theme' ); ?></h1>
	</header><!-- .page-header -->

	<ol class="breadcrumb">
		<li><a href="<?php echo site_url().'/'; ?>">Home</a></li>
		<li class="active">Search Results</li>
	</ol>

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'my_theme' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Use one of the links below, or try a new search.', 'my_theme' ); ?></p>

		<?php else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'my_theme' ); ?></p>
			<?php
				if( !is_active_widget( '', '', 'search') ) {
					get_search_form();
				}
			?>

		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
