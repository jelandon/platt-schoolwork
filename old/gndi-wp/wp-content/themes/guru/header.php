<!DOCTYPE html>
<html>
<head>
	<title><?php bloginfo( 'name' ); ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" 
			href="<?php echo get_stylesheet_uri(); ?>">

	<?php wp_head(); //HOOK. required for the admin bar and plugins to work ?>
</head>
<body>

	<header class="header">
		<div class="header-bar">
			<h1 class="site-title"><a href="<?php echo home_url(); ?>">
				<?php bloginfo( 'name' ); ?></a></h1>
			<h2><?php bloginfo( 'description' ); ?></h2>
			<nav>
				<ul class="nav">
					<?php wp_list_pages( array(
						'title_li' => '',
					) ); ?>
				</ul>
			</nav>

			<form method="get" action="#">
				<label>Search for:</label>
				<input type="text" />
				<input type="submit" value="Search" />
			</form>
		</div>
	</header>
	<div class="wrapper">