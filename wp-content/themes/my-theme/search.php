<?php
/**
 * The template for displaying search results pages.
 *
 * @package my_theme
 */

get_header(); ?>

	<section id="primary" class="content-area col-md-<?php echo ( is_active_sidebar( 'sidebar-1' ) ? '9' : '12' ); ?> col-sm-12">
		<div class="well">
			<main id="main" class="site-main" role="main">

			<?php if ( have_posts() && strlen( trim(get_search_query()) ) != 0 ) : ?>

				<header class="page-header">
					<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'my_theme' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header><!-- .page-header -->

				<ol class="breadcrumb">
					<li><a href="<?php echo site_url().'/'; ?>">Home</a></li>
					<li class="active">Search Results</li>
				</ol>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					get_template_part( 'content', 'search' );
					?>

				<?php endwhile; ?>

				<?php my_theme_paging_nav(); ?>

			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>

			</main><!-- #main -->
		</div><!-- .well -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
