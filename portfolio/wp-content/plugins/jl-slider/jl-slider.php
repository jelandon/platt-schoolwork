<?php 
/*
Plugin Name: JL Slider
Description: A slider demonstrating CPTs, JavaScript, and WP_Query
Author: John Landon
Author URI: http://johnlandon.design
Version: 0.1
License: GPLv3
*/

/**
 * Register a Custom Post Type (Slide) 
 * Since ver. 1.0
 */
add_action('init', 'slide_init');
function slide_init() {
	$args = array(
		'labels' => array(
			'name' => 'Slides', 
			'singular_name' => 'Slide', 
			'add_new' => 'Add New', 'slide',
			'add_new_item' => 'Add New Slide',
			'edit_item' => 'Edit Slide',
			'new_item' => 'New Slide',
			'view_item' => 'View Slide',
			'search_items' => 'Search Slides',
			'not_found' => 'No slides found',
			'not_found_in_trash' => 'No slides found in Trash', 
			'parent_item_colon' => '',
			'menu_name' => 'Slides'
		),
		'public' => true,
		'exclude_from_search' => true,
		'show_in_menu' => true, 
		'rewrite' => true,
		'has_archive' => true, 
		'hierarchical' => false,
		'menu_position' => 20,
		'supports' => array('title', 'editor', 'thumbnail')
	); 
	register_post_type('slide', $args);
}

/**
 * Put little help box at the top of the editor 
 * Since ver 1.0
 */
add_action('contextual_help', 'slide_help_text', 10, 3);
function slide_help_text($contextual_help, $screen_id, $screen) {
	if ('slide' == $screen->id) {
		$contextual_help ='<p>Things to remember when adding a slide:</p>
		<ul>
		<li>Give the slide a title. The title will be used as the slide\'s headline</li>
		<li>Attach a Featured Image to give the slide its background</li>
		<li>Enter text into the Visual or HTML area. The text will appear within each slide during transitions</li>
		</ul>';
	}
	elseif ('edit-slide' == $screen->id) {
		$contextual_help = '<p>A list of all slides appears below. To edit a slide, click on the slide\'s title</p>';
	}
	return $contextual_help;
}

/**
 * This prevents 404 errors when viewing our custom post archives
 * always do this whenever introducing a new post type or taxonomy
 * Since ver 1.0
 */
function jl_slider_rewrite_flush(){
	slide_init();
	flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'jl_slider_rewrite_flush');

/**
* Add the image size for the slider 
* Since ver 1.0
*/
function jl_slider_image(){
	add_image_size( 'jl-slider', 1120, 330, true );	
}
add_action('init', 'jl_slider_image');


/**
 * Front-end Display of the slider
 */
function jl_slider(){
	//get up to 5 slides
	$slides = new WP_Query( array(
		'post_type' => 'slide',
		'posts_per_page' => 5,
	) );
	//custom "loop"
	if( $slides->have_posts() ):
	?>
	<div id="jl-slider">
		<ul class="slideshow">
			<?php 
			while( $slides->have_posts() ):
				$slides->the_post();
			?>
			<li>
				<?php the_post_thumbnail( 'jl-slider' ); ?>
				<div class="info">
					<h2><?php the_title(); ?></h2>
					<?php the_excerpt(); ?>
				</div>
			</li>
		<?php endwhile; ?>
		</ul>
	</div>
	<?php
	endif;
	//clean-up!
	wp_reset_postdata();
}

/**
 * Enqueue scripts and styles
 */
function jl_slider_scripts(){
	$css_url = plugins_url( 'css/jl-slider.css', __FILE__ );
	wp_enqueue_style( 'jl-slider-style', $css_url );

	//add jquery
	wp_enqueue_script( 'jquery' );
	
	//add responsiveslides.js
	$rs_url = plugins_url( 'js/responsiveslides.min.js', __FILE__ );
						//handle,         url, 			deps,		ver, in footer?
	wp_enqueue_script( 'responsiveslides', $rs_url, array('jquery'), '1.55', true );
	
	//add our custom JS to activate
	$custom_url = plugins_url( 'js/jl-slider.js', __FILE__ );
	wp_enqueue_script('jl-slider-js', $custom_url, array( 'jquery', 'responsiveslides' ),
	 '0.1', true );
	
}
add_action( 'wp_enqueue_scripts', 'jl_slider_scripts' );