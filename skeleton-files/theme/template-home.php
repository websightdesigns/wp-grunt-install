<?php
/*
Template Name: Home
*/

/**
 * @package SKEL_THEME_PREFIX
 */

get_header(); ?>

<div id="primary" class="content-area col-md-<?php echo ( is_active_sidebar( 'sidebar-1' ) ? '9' : '12' ); ?> col-sm-12">

  <main id="main" class="site-main" role="main">

    <div class="jumbotron">
      <header class="entry-header">
        <h1 class="entry-title site-title"><?php bloginfo( 'name' ); ?></h1>
      </header>
      <?php
        $description = get_bloginfo( 'description', 'display' );
        if( $description || is_customize_preview() ):
          ?><p class="site-description"><?php echo $description; ?></p><?php
        endif;
      ?>
      <p><a class="btn btn-primary btn-lg" href="<?php echo geturl('About'); ?>" role="button">Learn more <span class="glyphicon glyphicon-link" aria-hidden="true"></span></a></p>
    </div>

    <div class="content-editable">
      <?php
        // Start the Loop.
        while ( have_posts() ) : the_post();
          // Include the page content template.
          get_template_part( 'content', 'page' );
          // If comments are open or we have at least one comment, load up the comment template.
          if ( comments_open() || get_comments_number() ) {
            comments_template();
          }
        endwhile;
      ?>
    </div>

  </main>

</div>

<?php
get_sidebar();
get_footer();
