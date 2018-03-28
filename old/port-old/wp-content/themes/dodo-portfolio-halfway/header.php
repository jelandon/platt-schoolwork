<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>">

	<?php wp_head(); //HOOK. Required for plugins & the toolbar to work ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="<?php bloginfo( 'charset' ); ?>">
</head>
<body <?php body_class(); ?>>
	<header class="header" style="background-image:url(<?php header_image(); ?>)">
		<div class="header-bar">
			<?php the_custom_logo(); ?>

			<h1 class="site-title"><a href="<?php echo home_url(); ?>">
				<?php bloginfo('name'); ?>				
			</a></h1>
			<h2><?php bloginfo( 'description' ) ?></h2>
			
			<?php 
			//display a menu location (don't forget to register it in functions.php)
			wp_nav_menu( array(
				'theme_location'	=> 'main_menu',
				'container'			=> 'nav',				// div, nav, or ''
				'container_class'	=> 'main-navigation',	// nav class="main-navigation"
				'menu_class'		=> 'menu', 				// ul class="menu"
				'fallback_cb'		=> false,				// do nothing of no menu exists
				) ); ?>
				<?php 
				//dispaly the social media menu
				wp_nav_menu( array(
					'theme_location'	=> 'social_icons',
					'container_class'	=> 'social-navigation',
					'link_before'		=> '<span class="screen-reader-text">',
					'link_after'		=> '</span>',
				));
				 ?>

			<?php get_search_form(); //default search form OR searchform.php ?>
		</div>
	</header>
	<div class="wrapper">