<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package SKEL_THEME_PREFIX
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<?php if(is_active_sidebar('sidebar-1')) { ?>
	<div id="secondary" class="widget-area col-md-3 col-sm-12" role="complementary">
		<div class="well">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div>
	</div>
<?php } ?>