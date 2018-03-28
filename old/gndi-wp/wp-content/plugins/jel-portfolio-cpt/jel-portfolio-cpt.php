<?php 
/*
Plugin Name: JEL Portfolio CPT
Description: Creates the "Portfolio" Custom Post Type, so we can add portfolio pieces
Author: John Landon
Version: 0.1
License: GPLv3
 */
add_action('init', 'jel_register_stuff');
function jel_register_stuff(){
	//register_post_type( $post_type, $args = array )
	register_post_type('portfolio_piece', array(
		'public' 			=> true,
		'has_archive'		=> true,
		'label'				=> 'Portfolio',
		'menu_icon'			=> 'dashicons-format-gallery',
		'menu_position'		=> 5,
		'labels'			=> array(
			'add_new_item'	=> 'Add New Portfolio Piece',
			'not_found'		=> 'No Portfolio Pieces Found',
		),
		//for bettter looking urls, like site.com/portfolio
		'rewrite'			=> array('slug' => 'portfolio'),
		'supports'			=> array('title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields'),
	) );

	//add the "type of work" taxonomy to the portfolio
	register_taxonomy('type_of_work','portfolio_piece', array(

		'label' => 'Work Types',
		'show_admin_column'	=> true,
		'hierarchical' => true,
		'labels'		=> array(
			'add_new_item' => 'Add New Work Type',
			'serach_items' => 'Search Work Types',
			'parent_type' => 'Parent Work Type',
		),

		) );

}

function jel_cpt_flush(){
	jel_register_stuff();
	flush_rewrite_rules();
}
//run this function when this plugin activates
register_activation_hook(__FILE__, 'jel_cpt_flush');