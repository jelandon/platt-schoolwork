<!DOCTYPE html>
<html>
<head>
	<?php wp_head(); //HOOK. Required for plugins & the toolbar to work ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="<?php bloginfo( 'charset' ); ?>">
</head>
<body <?php body_class(); ?>>
	<header class="header" style="background-image:url(<?php header_image(); ?>)">
		<div class="header-bar">
			<?php if(has_custom_logo(  ) && is_front_page()): ?>
				<div class="logo">
			<?php the_custom_logo(); ?>
</div>
<?php endif; ?>
			<h1 class="site-title"><a href="<?php echo home_url(); ?>">
				<?php bloginfo('name'); ?>				
			</a></h1>
			<h2><?php bloginfo( 'description' ) ?></h2>
			
			<?php 
			//display a menu location  (don't forget to register it in functions.php)
			wp_nav_menu( array(
				'theme_location' 	=> 'main_menu',
				'container'			=> 'nav',			 // div, nav, or ''
				'container_class'	=> 'main-navigation',// nav class="main-navigation"
				'menu_class'		=> 'menu',			 // ul class="menu"
				'fallback_cb'		=> false,			 // do nothing if no menu exists
			) );
			?>

			<?php 
			//display the social media menu
			wp_nav_menu( array(
				'theme_location' 	=> 'social_icons',
				'container_class' 	=> 'social-navigation',
				'link_before' 		=> '<span class="screen-reader-text">',
				'link_after'		=> '</span>',
			) );
			 ?>

			<?php get_search_form(); //default search form OR searchform.php ?>
			
			<a class="cart-customlocation" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>">
				<?php echo sprintf ( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?> - <?php echo WC()->cart->get_cart_total(); ?>	
			</a>

		</div>
	</header>
	<div class="wrapper">