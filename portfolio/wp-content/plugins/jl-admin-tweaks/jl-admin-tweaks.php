<?php 
/*
Plugin Name: JL Admin Tweaks
Description: Customizing the admin panel, login screen and register screen
Author: John Landon
Plugin URI: http://wordpress.com
Author URI: http://johnlandon.design
Version: 0.1
License: GPLv3
 */

/**
 * Style the Login & Register Forms
 */
function jl_login_style(){
	$url = plugins_url( 'css/login.css', __FILE__ );
	wp_enqueue_style( 'login-css', $url  );
}
add_action( 'login_enqueue_scripts', 'jl_login_style' );

//change the href of the login logo
function jl_login_logo_href(){
	return home_url();
}
add_filter( 'login_headerurl', 'jl_login_logo_href' );


//change the title of the login logo link
function jl_login_logo_title(){
	return 'Return to the home page';
}
add_filter( 'login_headertitle', 'jl_login_logo_title');


/**
 * Remove unnecessary dashboard widgets
 */
function jl_dashboard(){
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );

	//remove the "news" box for non-admin users
	if( ! current_user_can( 'manage_options' ) ):
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	endif;

	//add our custom dashboard widget
	//$widget_id, $widget_name, $callback
	wp_add_dashboard_widget( 'jl_dashboard_widget', 'Useful Video', 
		'jl_dash_widget_content' );
}
add_action( 'wp_dashboard_setup', 'jl_dashboard' );


//custom function for our dashboard widget content
function jl_dash_widget_content(){
	?>
	<p>Here's a helpful thing:</p>
	<iframe width="320" height="200" src="https://www.youtube.com/embed/VxJ69qBn-GQ" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
	<?php 
}

/**
 * Add or remove items from the Toolbar (Admin Bar)
 */
function jl_toolbar( $wp_admin_bar ){
	//remove the WP logo and dropdown
	$wp_admin_bar->remove_node('wp-logo');

	//add a contact button
	$wp_admin_bar->add_node( array(
		'id' 	=> 'jl_contact',
		'title' => '<span class="ab-icon" style="top:2px;"></span>Contact Me',
		'href'	=> 'mailto:jelandon@gmail.com',
	) );
}
add_action( 'admin_bar_menu', 'jl_toolbar', 999 );