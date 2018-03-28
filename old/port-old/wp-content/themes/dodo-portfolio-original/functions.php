<?php 
//suupport featured image in the ui
add_theme_support('post-thumbnails');

//upgrade any HTML output to html5
add_theme_support('html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));
 
 //delete the <title> tag from the header, then add this function
add_theme_support( 'title-tag' );

//customizer features
add_theme_support('custom-background');

$args = array(
	'width' => 1000,
	'height' => 600,
	'flex-width' => true,
	'flex-height' => true,
);
add_theme_support( 'sustom-header' , $args);

$args = array(
	'width' => 200,
	'height' => 200,
	'flex-width' => true,
	'flex-height' => true,
);
add_theme_support ('custom-logo', $args );

//make editor-stylr.css
add_editor_style();


//change the behavior of the_exerpt()
//example of how to appply filters
function dodo_exerpt_length(){
	if( is_search() ):
		return 10;
	else:
			return 75;
	endif;
}
add_filter('exerpt_length', 'dodo_exerpt_length');

function dodo_dotdotdot(){
	return '&hellip; <a href="' . get_permalink() . '">Keep Reading</a>';
}
add_filter('exerpt_more', 'dodo_dotdotdot');






 //no close php
