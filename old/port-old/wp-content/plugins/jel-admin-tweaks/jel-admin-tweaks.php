<?php 
/*
Plugin Name: JEL Admin Tweaks
Description: Customizing the admin panel, login screen and register screen
Author: John Landon
Plugin URI: http://wordpress.melissacabral.com
Author URI: http://johnlandondesigns.com
Version: 0.1
Licece: GPLv3
 */


/**
 * Style the Login & Register Forms
 */
function jel_login_style(){
	$url = plugins_url('css/login.css', __FILE__ );
	wp_enqueue_style('login-css', $url);
}

add_action('login_enqueue_scripts', 'jel_login_style');

//change the href of the login logo
function jel_login_logo_href(){
	return home_url();

}
add_filter('login_headerurl', 'jel_login_logo_href');

//change the title of the login logo link
function jel_login_logo_title(){
	return 'Return to the home page';

}
add_filter('login_headertitle', 'jel_login_logo_title');

/**
 * remove unnecessary dqashboard widgets
 */
function jel_dashboard(){
	//remove_meta_box($id, $screen, $context);
	remove_meta_box('dashboard_quick_press','dashboard','side');
	//remove the "news" box for non-admin users
	if(!current_user_can('manage_options')):
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side');
	endif;

	//add our custom dqashboard widget
	//$widget_id, $widget_name, $callback
	wp_add_dashboard_widget( 'jel_dashboard_widget', 'My Custom Widget', 'jel_dash_widget_content');
}
add_action('wp_dashboard_setup', 'jel_dashboard');

//custom function for our dashboard widget content
function jel_dash_content(){
	?>
	<h2>HTML in my widget</h2>
	<p>This is q widget</p>
	<?php  
}
/**
 * add or remove items from the Toolbar (admin bar)
 */
function jel_toolbar($wp_admin_bar){
	//remove the WP logo and dropdown
	$wp_admin_bar->remove_node('wp-logo');

	$wp_admin_bar->add_node(array(
		'id'=> 'jel_contact',
		'title'=> '<span class ="ab-icon"></span>Contact Me',
		'href' => 'mailto:jelandon@gmail.com',
	));

}
add_action('admin_bar_menu', 'jel_toolbar', 999);