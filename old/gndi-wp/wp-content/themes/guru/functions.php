<?php 
//turn on tumblr-style post formats 
add_theme_support('post-formats', array('image', 'video', 'audio', 'quote', 'gallery'));
//adds ability to have one featured image per post or page
add_theme_support('post-thumbnails'); 
//more robust feed links on every page
add_theme_support('automatic-feed-links');
//adds CSS to the admin text editor. create a CSS file in your theme called editor-style.css
add_editor_style();
//upgrade any HTML output to HTML5
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

//delete the <title> tag from the header, then add this function
add_theme_support( 'title-tag' );
//turn on background image uploader
add_theme_support('custom-background');
//turn on custom header uploader
$args = array(
	'width' => 1000,
	'height' => 600,
	'flex-width' => true,
	'flex-height' => true,
 );
add_theme_support( 'custom-header', $args );
//add more image sizes
//(name, width, height, crop?)
add_image_size('guru-tiny', 90, 90, true );
add_image_size('guru-banner', 960, 150, true);
add_image_size('guru-frontpage', 960, 330, true);
//Custom Logo
$args = array(
	'width' => 200,
	'height' => 200,
	'flex-width' => true,
	'flex-height' => true,
);
add_theme_support( 'custom-logo', $args );
/**
 * change the default length of the_excerpt()
 * Search results will show fewer words in the excerpts
 * 
 * @return int the number of words displayed in the excerpt
 */
function guru_excerpt_length(){
	//example of adding conditional logic
	if( is_search() ):
		return 10;
	else:
		return 75;
	endif;
}
add_filter( 'excerpt_length', 'guru_excerpt_length' );

/**
 * change the [...]
 */
function guru_dotdotdot(){
	return '&hellip; <a href="' . get_permalink() . '">Keep Reading</a>';
}
add_filter( 'excerpt_more', 'guru_dotdotdot' );

/**
 * Set up 2 menu locations 
 * @since  0.1  added the function
 */
add_action( 'init', 'guru_menu_locations' );
function guru_menu_locations(){
	register_nav_menus( array(
		'main_menu' 	=> 'Main Menu',
		'social_icons' 	=> 'Social Media Icons'
	) );
}

/**
 * enqueue all stylesheets or JavaScript
 */
add_action( 'wp_enqueue_scripts', 'guru_scripts' );
function guru_scripts(){
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css' );
}

/**
 * Helper function to display archive or single pagination (next/prev buttons)
 */
function guru_pagination(){
	if( is_singular() ):
		//single post pagination
		previous_post_link( '%link', '&larr; Previous: %title' );
		next_post_link( '%link', 'Next: %title &rarr;' );
	else:
		//archive pagination
		if( wp_is_mobile() ):
			previous_posts_link( '&larr; Previous Page' );
			next_posts_link( 'Next Page &rarr;' );
		else:
			//numbered pagination
			the_posts_pagination(array(
				'mid_size' => 2,
				'next_text' => 'Next Page &rarr;',
			));
		endif;
	endif;
}

/**
 * register all the widget areas (dynamic sidebars)
 */
add_action( 'widgets_init', 'dodo_widget_areas' );
function dodo_widget_areas(){
	register_sidebar( array(
		'name' 	=> 'Blog Sidebar',
		'id' 	=> 'blog_sidebar',
		'description' => 'Appears alongside the Blog and archive pages',
		'before_widget' => '<section class="widget %2$s" id="%1$s">',
		'after_widget' => '</section>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' 	=> 'Footer Area',
		'id' 	=> 'footer_area',
		'description' => 'Appears at the bottom of every screen',
		'before_widget' => '<section class="widget %2$s" id="%1$s">',
		'after_widget' => '</section>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	register_sidebar( array(
		'name' 	=> 'Home Area',
		'id' 	=> 'home_area',
		'description' => 'Appears only on the front page',
		'before_widget' => '<section class="widget %2$s" id="%1$s">',
		'after_widget' => '</section>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}

//no close php