<?php 
/**
 * Load up any styles or scripts
 */
function baby_scripts(){
	//parent theme style.css
	wp_enqueue_style('parent-css', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'baby_scripts');


/**
 * Add Widget Area(s)
 */
function baby_widget_areas(){
	register_sidebar(array(
		'name' => 'Footer Area',
		'id' => 'footer-area',
	));
}
add_action('widgets_init', 'baby_widget_areas', 999);


/**
 * redefine the fgoogle fonts url
 * this is a pluggable function on the parent theme, so we can override it
 */
function twentysixteen_fonts_url(){
	return 'https://fonts.googleapis.com/css?family=Indie+Flower%7CRanga';
}

/**
 * example of unhooking an action or filter from the parent theme
 */
function baby_unhook(){
	remove_filter('widget_tag_cloud_args', 'twentysixteen_widget_tag_cloud_args');
	//unhook more actions and filters here
	}
add_action('after_setup_theme', 'baby_unhook');


/**
 * add our own filter to the tag cloud
 */
function baby_tag_cloud ($args){
	$args['largest'] = .5;
	$args['smallest'] = .5;
	$args['unit'] = 'em';
	$args['format'] = 'list';

	return $args;
}
add_filter('widget_tag_cloud_args', 'baby_tag_cloud');

//no close php