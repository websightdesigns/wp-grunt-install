<?php
/*
Template Name: Media Element
*/

/**
 * @package my_theme
 */

/**
 * Page template to display an image carousel using Bootstrap 3 and Advanced Custom Fields Pro.
 */

get_header(); ?>

<div id="primary" class="content-area col-md-<?php echo ( is_active_sidebar( 'sidebar-1' ) ? '9' : '12' ); ?> col-sm-12">
  <div class="well">
    <main id="main" class="site-main" role="main">

      <header class="entry-header page-header">
        <h1 class="entry-title">MediaElement.js</h1>
      </header>

      <?php
        echo do_shortcode('[video width="1024" height="576" src="' . get_template_directory_uri() . '/media/example.mp4"]');
      ?>

      <div class="video-links" style="margin: 1em 0;">
        <ul id="video-thumbs-1">
          <li><a href="" data-url="<?php echo get_template_directory_uri(); ?>/media/test7.mp4">Load test7.mp4...</a></li>
          <li><a href="" data-url="<?php echo get_template_directory_uri(); ?>/media/bunny.mp4">Load bunny.mp4...</a></li>
        </ul>
      </div>

      <hr />

      <?php
        echo do_shortcode('[video width="1024" height="576" src="' . get_template_directory_uri() . '/media/gravity01.mp4"]');
      ?>

      <div class="video-links" style="margin: 1em 0;">
        <ul id="video-thumbs-2">
          <li><a href="" data-url="<?php echo get_template_directory_uri(); ?>/media/gravity02.mp4">Load gravity02.mp4...</a></li>
          <li><a href="" data-url="<?php echo get_template_directory_uri(); ?>/media/gravity03.mp4">Load gravity03.mp4...</a></li>
        </ul>
      </div>

    </main>
  </div>
</div>

<?php
get_sidebar();
get_footer();
