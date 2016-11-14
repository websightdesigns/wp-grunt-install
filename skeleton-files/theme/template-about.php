<?php
/*
Template Name: About
*/

/**
 * @package SKEL_THEME_PREFIX
 */

get_header(); ?>

<div id="primary" class="content-area col-md-<?php echo ( is_active_sidebar( 'sidebar-1' ) ? '9' : '12' ); ?> col-sm-12">
  <div class="well">
    <main id="main" class="site-main" role="main">

      <header class="entry-header">
        <h1 class="entry-title">Custom Theme</h1>
      </header>

      <div role="tabpanel">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#theme" aria-controls="theme" role="tab" data-toggle="tab">The Theme</a></li>
          <li role="presentation"><a href="#todo" aria-controls="todo" role="tab" data-toggle="tab">To-Do List</a></li>
          <li role="presentation"><a href="#download" aria-controls="download" role="tab" data-toggle="tab">Download</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="theme">
            <h3>Tools &amp; Libraries</h3>
            <ul>
              <li>Twitter Bootstrap 3.0.3</li>
              <li>jQuery Colorbox 1.5.14</li>
              <li>jQuery Mobile 1.4.5</li>
              <li>jQuery matchHeight 0.5.2</li>
              <li>Font Awesome 4.3.0</li>
              <li>Remote calls to html5shiv.js 3.7.0 and respond.js 1.4.2</li>
            </ul>
            <h3>Features</h3>
            <ul class="checklist">
              <li><i class="fa fa-check"></i> Displays a navigation menu with <code>wp_nav_menu()</code></li>
              <li><i class="fa fa-check"></i> Supports sub-page dropdown menus with <a href="https://github.com/twittem/wp-bootstrap-navwalker" target="_blank"><code>wp_bootstrap_navwalker()</code></a></li>
              <li><i class="fa fa-check"></i> Loads JS with <code>wp_enqueue_script()</code></li>
              <li><i class="fa fa-check"></i> Loads CSS with <code>wp_enqueue_style()</code></li>
              <li><i class="fa fa-check"></i> Sidebar widgets support</li>
              <li><i class="fa fa-check"></i> Footer widgets support</li>
              <li><i class="fa fa-check"></i> Bootstrap pagination</li>
              <li><i class="fa fa-check"></i> Automatically uses unminified styles and scripts over local hosts</li>
            </ul>
          </div>
          <div role="tabpanel" class="tab-pane" id="todo">
            <h3>To-Do List</h3>
            <ul class="checklist">
              <li><i class="fa fa-check-square-o"></i> <s>Sidebar widgets support</s></li>
              <li><i class="fa fa-check-square-o"></i> <s>Footer widgets support</s></li>
              <li><i class="fa fa-check-square-o"></i> <s>Pagination for archives</s></li>
              <li><i class="fa fa-square-o"></i> Theme customizations</li>
              <!--<li><i class="fa fa-square-o"></i> Incomplete Tasks</li>-->
              <!--<li><i class="fa fa-check-square-o"></i> <s>Completed Tasks</s></li>-->
            </ul>
          </div>
          <div role="tabpanel" class="tab-pane" id="download">
            <h3>Github Repository</h3>
            <p class="text-muted"><a href="https://github.com/websightdesigns/SKEL_THEME_PREFIX" target="_blank">https://github.com/websightdesigns/SKEL_THEME_PREFIX</a></p>
            <h3>Clone the Repository</h3>
            <div id="copy-wrapper">
              <span class="code text-muted copytext">git clone https://github.com/websightdesigns/SKEL_THEME_PREFIX.git</span>
            </div>
            <h3>Contributing</h3>
            <p>Customtheme is an open source project so if you'd like to contribute in any way simply submit a pull request via Github.</p>
          </div>
        </div>

      </div>

    </main>
  </div>
</div>

<?php
get_sidebar();
get_footer();
