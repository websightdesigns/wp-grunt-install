<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package SKEL_THEME_PREFIX
 */
$global_keywords = 'global,keywords,go,here';
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!-- Styles -->
	<?php wp_head(); ?>
	<meta name="description" content="<?php
		$title_sep = " | ";
		if ( is_single() ) {
			single_post_title('', true);
			echo $title_sep;
			bloginfo('name');
			echo $title_sep;
			bloginfo('description');
		} else if( is_page() ) {
			the_title();
			echo $title_sep;
			bloginfo('name');
			echo $title_sep;
			bloginfo('description');
		} else {
			bloginfo('name');
			echo $title_sep;
			bloginfo('description');
		}
	?>" />
	<meta name="keywords" content="<?php
		if(is_single()) {
			// list tags as keywords
			$metatags = get_the_tags($post->ID);
			if(isset($metatags) && $metatags) {
				foreach ($metatags as $tagpost) {
					$mymetatag = apply_filters('the_tags', $tagpost->name);
					$keyword = utf8_decode($mymetatag); // Your filters...
					echo $keyword.",";
				}
			}
		}
		echo $global_keywords;
	?>" />
	<meta name="author" content="John Doe" />
	<meta name="contact" content="johndoe@domain.com" />
	<meta property="og:url" content="">
	<meta property="og:title" content="">
	<meta property="og:description" content="">
	<meta property="og:site_name" content="">
	<meta property="og:image" content="">
	<meta property="og:locale" content="en_us">
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<body <?php body_class(); ?>>

	<!-- Fixed navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>/">
					<?php
						if ( get_theme_mod( 'SKEL_THEME_PREFIX_logo' ) ) :
							?><img src='<?php echo esc_url( get_theme_mod( 'SKEL_THEME_PREFIX_logo' ) ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'><?php
						else :
							?><div class="navbar-brand-text"><?php bloginfo( 'name' ); ?></div><?php
						endif;
					?>
				</a>
			</div>
			<div class="collapse navbar-collapse">
				<?php
					wp_nav_menu( array(
						'menu'              => 'primary',
						'theme_location'    => 'primary',
						'depth'             => 2,
						'container'         => false,
						'menu_class'        => 'nav navbar-nav',
						'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
						'walker'            => new wp_bootstrap_navwalker())
					);
				?>
				<form class="navbar-form navbar-right" role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
					<div class="form-group">
						<div class="input-group input-group-sm">
							<input type="text" name="s" id="s" class="form-control" placeholder="Search" value="<?php echo ( isset($_GET['s']) ? $_GET['s'] : null ); ?>">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit">
									<span class="glyphicon glyphicon-search"></span>
								</button>
							</span>
						</div>
					</div>
				</form>
			</div>
	  </div>
	</div>

	<!-- Page content -->
	<div id="content" class="container">
		<div class="main-row row">