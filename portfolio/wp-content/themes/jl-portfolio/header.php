<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>">
    <?php wp_head(); //HOOK. required for the admin bar and plugins to work ?>
</head>
<body>
    <header role="banner" id="header" class="header">
        <h1 class="site-title"><a href="<?php echo home_url(); ?>">
            <?php bloginfo('name'); ?> 
        </a></h1>
        <h2><?php bloginfo( 'description' ); ?></h2>

        <nav>
            <ul class="nav">
                <?php wp_list_pages( array(
                    'title_li'  => '', //no "pages" title
                    'depth'     => 1, //only top level pages
                ) ); ?>
            </ul>
        </nav>

    <?php get_search_form(); ?>
</header>