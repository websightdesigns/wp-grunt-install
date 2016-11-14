<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package SKEL_THEME_PREFIX
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if( !is_front_page() ) { ?>
		<header class="entry-header page-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header>
	<?php } ?>

	<?php if( is_page('Posts') ) { ?>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url().'/'; ?>">Home</a></li>
			<li class="active">Posts</li>
		</ol>
	<?php } ?>

	<?php if( $post->post_content ) { ?>
		<div class="entry-content well well-sm testing">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'SKEL_THEME_PREFIX' ),
					'after'  => '</div>',
				) );
			?>
		</div>
	<?php } ?>

	<footer class="entry-footer">
		<?php //edit_post_link( __( 'Edit', 'SKEL_THEME_PREFIX' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
</article>
