<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package SKEL_THEME_PREFIX
 */
?>
		</div><!-- .container -->

		<div id="footer-widgets">
			<?php if(is_active_sidebar('footer-sidebar-4')) { ?>
				<div id="footer-sidebar-fullwidth-above" class="row">
					<div id="footer-sidebar4" class="col-sm-12 col-xs-12">
						<div class="well">
							<?php dynamic_sidebar('footer-sidebar-4'); ?>
						</div>
					</div>
				</div>
			<?php } ?>
			<div id="footer-sidebar" class="row">
				<div id="footer-sidebar1" class="footer-sidebar col-sm-4 col-xs-12">
					<?php if(is_active_sidebar('footer-sidebar-1')) { ?>
						<div class="well">
							<?php dynamic_sidebar('footer-sidebar-1'); ?>
						</div>
					<?php } ?>
				</div>
				<div id="footer-sidebar2" class="footer-sidebar col-sm-4 col-xs-12">
					<?php if(is_active_sidebar('footer-sidebar-2')) { ?>
						<div class="well">
							<?php dynamic_sidebar('footer-sidebar-2'); ?>
						</div>
					<?php } ?>
				</div>
				<?php if(is_active_sidebar('footer-sidebar-3')) { ?>
					<div id="footer-sidebar3" class="footer-sidebar col-sm-4 col-xs-12">
						<div class="well">
							<?php dynamic_sidebar('footer-sidebar-3'); ?>
						</div>
					</div>
				<?php } ?>
			</div>
			<?php if(is_active_sidebar('footer-sidebar-5')) { ?>
				<div id="footer-sidebar-fullwidth-below" class="row">
					<div id="footer-sidebar5" class="col-sm-12 col-xs-12">
						<div class="well">
							<?php dynamic_sidebar('footer-sidebar-5'); ?>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>

	</div><!-- .main-row -->

	<div id="footer">
		<div class="container">
			<p class="text-muted">&copy; Copyright <?php echo date('Y'); ?>. Some Rights Reserved. <?php printf( __( 'Website by %1$s.', 'SKEL_THEME_PREFIX' ), '<a href="SKEL_THEME_AUTHOR_URL" rel="author" target="_blank">SKEL_THEME_AUTHOR</a>' ); ?></p>
		</div>
	</div>

	<?php wp_footer(); ?>

</body>
</html>