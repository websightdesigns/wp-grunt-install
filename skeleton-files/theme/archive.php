<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package SKEL_THEME_PREFIX
 */

get_header(); ?>

<?php
	// if this is a category, get the category slug
	if( is_category() ) {
		$category = get_the_category();
		$category_slug = $category[0]->category_nicename;
	} else {
		$category_slug = null;
	}

	// get all categories into an array
	$categories_args = array(
		'show_option_all'	=> '',
		'orderby'					=> 'ID',
		'order'						=> 'DESC',
	);
	$categories = get_categories( $categories_args );
?>

	<section id="primary" class="content-area col-md-<?php echo ( is_active_sidebar( 'sidebar-1' ) ? '9' : '12' ); ?> col-sm-12">
		<div class="well">
			<main id="main" class="site-main" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title">
						<?php
							// Show the page title
							if ( is_category() ) :
								single_cat_title();

							elseif ( is_tag() ) :
								single_tag_title();

							elseif ( is_author() ) :
								printf( __( 'Posts by %s', 'SKEL_THEME_PREFIX' ), '<span class="vcard">' . get_the_author() . '</span>' );

							elseif ( is_day() ) :
								printf( __( 'Posts from %s', 'SKEL_THEME_PREFIX' ), '<span>' . get_the_date() . '</span>' );

							elseif ( is_month() ) :
								printf( __( 'Posts from %s', 'SKEL_THEME_PREFIX' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'SKEL_THEME_PREFIX' ) ) . '</span>' );

							elseif ( is_year() ) :
								printf( __( 'Posts from %s', 'SKEL_THEME_PREFIX' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'SKEL_THEME_PREFIX' ) ) . '</span>' );

							elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
								_e( 'Asides', 'SKEL_THEME_PREFIX' );

							elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
								_e( 'Galleries', 'SKEL_THEME_PREFIX' );

							elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
								_e( 'Images', 'SKEL_THEME_PREFIX' );

							elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
								_e( 'Videos', 'SKEL_THEME_PREFIX' );

							elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
								_e( 'Quotes', 'SKEL_THEME_PREFIX' );

							elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
								_e( 'Links', 'SKEL_THEME_PREFIX' );

							elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
								_e( 'Statuses', 'SKEL_THEME_PREFIX' );

							elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
								_e( 'Audios', 'SKEL_THEME_PREFIX' );

							elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
								_e( 'Chats', 'SKEL_THEME_PREFIX' );

							else :
								_e( 'Archives', 'SKEL_THEME_PREFIX' );

							endif;
						?>
					</h1>
					<?php
						// Show an optional term description.
						$term_description = term_description();
						if ( ! empty( $term_description ) ) :
							printf( '<div class="taxonomy-description">%s</div>', $term_description );
						endif;
					?>
				</header><!-- .page-header -->

				<?php if( is_category() || is_month() || is_day() || is_year() || is_author() ) { ?>
					<ol class="breadcrumb">
						<li><a href="<?php echo site_url().'/'; ?>">Home</a></li>
						<li class="active"><?php
							if( is_category() ) {
								echo single_cat_title();
							} elseif( is_month() ) {
								printf( __( 'Posts from %s', 'SKEL_THEME_PREFIX' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'SKEL_THEME_PREFIX' ) ) );
							} elseif( is_day() ) {
								printf( __( 'Posts from %s', 'SKEL_THEME_PREFIX' ), get_the_date() );
							} elseif( is_year() ) {
								printf( __( 'Posts from %s', 'SKEL_THEME_PREFIX' ), get_the_date( _x( 'Y', 'yearly archives date format', 'SKEL_THEME_PREFIX' ) ) );
							} elseif( is_author() ) {
								printf( __( 'Posts by %s', 'SKEL_THEME_PREFIX' ), get_the_author() );
							}
						?></li>
					</ol>
				<?php } ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );

						if( isset($post_id) ) {
							$the_category = get_the_category( $post_id );
						}
					?>

				<?php endwhile; ?>

				<?php
					// Set up pagination
					wp_reset_postdata();
					global $wp_query;
					$big = '999999999';
					$current_page = max( 1, get_query_var('paged') );
					$paginate_links = paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => '?paged=%#%',
						'current' => $current_page,
						'total' => $wp_query->max_num_pages,
						'mid_size' => '2',
						'end_size' => '2',
						'show_all' => false,
						'prev_next' => false,
						'prev_text' => __('&#8592; Previous', 'SKEL_THEME_PREFIX'),
						'next_text' => __('Next &#8594;', 'SKEL_THEME_PREFIX'),
						'type' => 'array'
					) );
					?>
					<div class="pagination-container">
						<?php
							function paginationLinks($paginate_links, $current_page, $post_name) {
								if( isset($paginate_links) && $paginate_links ) {
									foreach ($paginate_links AS $key => $value) {
										if(strpos($value, 'dots') !== false) {
											?><li><?php echo $value; ?></li><?php
										} elseif(strpos($value, 'prev') !== false || strpos($value, 'next') !== false) {
											?><li><?php echo $value; ?></li><?php
										} else {
											$get_wpurl = site_url();

											if( strpos( substr($get_wpurl, -strlen("/wordpress")), "/wordpress" ) !== false ) {
												$get_wpurl = str_replace( "/wordpress", '', $get_wpurl );
											}

											if( strpos($_SERVER['REQUEST_URI'], "/page/") !== false ) {
												$page_url_parts = explode( "/page/", $_SERVER['REQUEST_URI'] );
												$page_url_prefix = $page_url_parts[0];
												if( substr($page_url_prefix, -1) != '/' ) $page_url_prefix .= '/';
											} else {
												$page_url_prefix = $_SERVER['REQUEST_URI'];
											}

											$page_url = $get_wpurl . $page_url_prefix . 'page/' . strip_tags($value) . '/';
											$request_uri = $get_wpurl . $_SERVER['REQUEST_URI'];

											if($request_uri == $get_wpurl . $page_url_prefix) {
												$request_uri = $get_wpurl . $page_url_prefix . 'page/1/';
											}
											?>
											<li<?php if($current_page == strip_tags($value)) echo ' class="active"'; ?>>
												<a href="<?php echo $page_url; ?>"><?php echo strip_tags($value); ?></a>
											</li>
											<?php
										}
									}
								}
							}
						?>
						<ul class="pagination pagination-sm pull-right">
							<?php
								paginationLinks($paginate_links, $current_page, $category_slug);
							?>
						</ul>
					</div>
					<?php
					wp_reset_postdata();
				?>

				<?php SKEL_THEME_PREFIX_paging_nav(); ?>

			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>

			</main><!-- #main -->
		</div><!-- .well -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>