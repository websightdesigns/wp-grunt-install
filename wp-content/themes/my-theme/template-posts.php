<?php
/*
Template Name: Posts
*/

/**
 * @package my_theme
 */

get_header(); ?>

<div id="primary" class="content-area content-blog col-md-<?php echo ( is_active_sidebar( 'sidebar-1' ) ? '9' : '12' ); ?> col-sm-12">
  <div class="well">
    <main id="main" class="site-main blog-main" role="main">

      <?php
        // Show the contents from the content editor
        while ( have_posts() ) :

          // return the post
          the_post();

          // Include the page content template.
          get_template_part( 'content', 'page' );

          // echo "<hr />";

        endwhile;

        // Get five posts after the first post
        $args = array(
          'numberposts' => -1,
          'posts_per_page' => 5,
          'offset'=> 0,
          'paged' => $paged,
          'post_type' => 'post',
          'post_status' => 'publish'
        );
        $recent_posts = get_posts( $args );
        if($recent_posts) {
          foreach ( $recent_posts as $post ):
            setup_postdata( $post );
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
              </div>

              <div class="blog-post-content">
                <?php the_title( '<header class="entry-header"><h3 class="entry-link-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3></header>' ); ?>
                <p class="postdate"><?php the_date( 'F j, Y' ); ?></p>
                <div class="entry-content">
                <p><?php
                  echo get_the_excerpt();
                  ?> <span class="readmore-link"><a href="<?php echo esc_url( get_permalink() ) ?>" class="readmore" rel="bookmark">READ&nbsp;&raquo;</a></span><?php
                ?></p><?php
                    wp_link_pages( array(
                      'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'my_theme' ) . '</span>',
                      'after'       => '</div>',
                      'link_before' => '<span>',
                      'link_after'  => '</span>',
                    ) );
                  ?>
                </div>
              </div><!-- .entry-content -->
            </article>
          <?php endforeach;
          wp_reset_postdata();
        }
        // Loop through the posts again to set up pagination
        $args = array(
          'numberposts' => -1,
          'posts_per_page' => 5,
          'offset'=> 0,
          'paged' => $paged,
          'post_type' => 'post',
          'post_status' => 'publish'
        );
        $list_of_posts = new WP_Query( $args );
        $big = '999999999';
        $current_page = max( 1, get_query_var('paged') );
        $paginate_links = paginate_links( array(
          'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
          'format' => '?paged=%#%',
          'current' => $current_page,
          'total' => $list_of_posts->max_num_pages,
          'mid_size' => '2',
          'end_size' => '2',
          'show_all' => false,
          'prev_next' => false,
          'prev_text' => __('&#8592; Previous', 'my_theme'),
          'next_text' => __('Next &#8594;', 'my_theme'),
          'type' => 'array'
        ) );
        ?>
        <div class="pagination-container">
          <?php
            function paginationLinks($paginate_links, $current_page, $post_name) {
              if($paginate_links) {
                foreach ($paginate_links AS $key => $value) {
                  if(strpos($value, 'dots') !== false) {
                    ?><li><?php echo $value; ?></li><?php
                  } elseif(strpos($value, 'prev') !== false || strpos($value, 'next') !== false) {
                    ?><li><?php echo $value; ?></li><?php
                  } else {
                    $page_url = site_url().'/'.$post_name.'/page/'.strip_tags($value).'/';
                    $request_uri = site_url().$_SERVER['REQUEST_URI'];
                    if($request_uri == site_url().'/'.$post_name.'/') {
                      $request_uri = site_url().'/'.$post_name.'/page/1/';
                    }
                    ?>
                    <li<?php if($current_page == strip_tags($value)) echo ' class="active"'; ?>>
                    <a href="<?php echo ( $page_url == $request_uri ? '#' : $page_url ); ?>"><?php echo strip_tags($value); ?></a>
                    </li>
                    <?php
                  }
                }
              }
            }
          ?>
          <ul class="pagination pagination-sm pull-right">
            <?php
              paginationLinks($paginate_links, $current_page, $post->post_name);
            ?>
          </ul>
        </div>
        <?php
        wp_reset_postdata();

        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) {
          // comments_template();
        }
      ?>

    </main>
  </div>
</div>

<?php
get_sidebar();
get_footer();
