<?php
//custom image sizes
//				name    width  height  crop?
add_image_size( 'banner', 900, 200, true);
add_image_size( 'big_thumbnail', 300, 300, true );

//Support Featured Images
add_theme_support( 'post-thumbnails' );

//upgrade any HTML output to HTML5
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

//delete the <title> tag from the header, then add this function
add_theme_support( 'title-tag' );

//customizer features
add_theme_support( 'custom-background' );

//Custom Header
$args = array(
	'width' => 1000,
	'height' => 600,
	'flex-width' => true,
	'flex-height' => true,
 );
add_theme_support( 'custom-header', $args );

//Custom Logo
$args = array(
	'width' => 200,
	'height' => 200,
	'flex-width' => true,
	'flex-height' => true,
);
add_theme_support( 'custom-logo', $args );

//make editor-style.css
//add_editor_style();

/**
 * change the default length of the_excerpt()
 * Search results will show fewer words in the excerpts
 * 
 * @return int the number of words displayed in the excerpt
 */
function dodo_excerpt_length(){
	//example of adding conditional logic
	if( is_search() ):
		return 10;
	else:
		return 75;
	endif;
}
add_filter( 'excerpt_length', 'dodo_excerpt_length' );

/**
 * change the [...]
 */
function dodo_dotdotdot(){
	return '&hellip; <a href="' . get_permalink() . '">Keep Reading</a>';
}
add_filter( 'excerpt_more', 'dodo_dotdotdot' );

/**
 * Set up 2 menu locations 
 * @since  0.1  added the function
 */
add_action( 'init', 'dodo_menu_locations' );
function dodo_menu_locations(){
	register_nav_menus( array(
		'main_menu' 	=> 'Main Menu',
		'social_icons' 	=> 'Social Media Icons'
	) );
}

/**
 * enqueue all stylesheets or JavaScript
 */
add_action( 'wp_enqueue_scripts', 'dodo_scripts' );
function dodo_scripts(){
	//style.css
	wp_enqueue_style( 'dodo-style', get_stylesheet_uri() );

	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css' );
}

/**
 * Helper function to display archive or single pagination (next/prev buttons)
 */
function dodo_pagination(){
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
	register_sidebar( array(
		'name' 	=> 'Shop Sidebar',
		'id' 	=> 'shop_sidebar',
		'description' => 'Appears on all woocommerce pages',
		'before_widget' => '<section class="widget %2$s" id="%1$s">',
		'after_widget' => '</section>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}


/**
 * WooCommerce Additions
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);


add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);

function my_theme_wrapper_start() {
	//edit this to match the element that wraps your Loop on a typical template
  echo '<main class="content">';
}

function my_theme_wrapper_end() {
	//edit this to close properly
  echo '</main>';
}

//make the admin nag go away!
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

/**
 * Make the header cart total update with AJAX
 */
add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
 
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;	
	ob_start();	
	?>
	<a class="cart-customlocation" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
	<?php	
	$fragments['a.cart-customlocation'] = ob_get_clean();	
	return $fragments;	
}

/**
 * Example of changing the content on the single product with hooks
 * This will change the position of the price so it is above the title
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10  );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 0  );

/**
 * Theme Customizer Additions
 * @link https://codex.wordpress.org/Theme_Customization_API
 */

add_action( 'customize_register', 'dodo_customize' );
function dodo_customize( $wp_customize ){
	//add a new setting for text color
	$wp_customize->add_setting( 'text_color', array(
		'default' => '#FF0000',
	) );

	//add the UI for controlling that setting
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 
		'dodo_text_color', array(
				'label' 	=> 'Body Text Color',
				'section' 	=> 'colors', 
				'settings'	=> 'text_color',
	) ) );

	//Dropdown option - color scheme
	//add a new section
	$wp_customize->add_section( 'color_scheme', array(
		'title'	=> 'Color Scheme',
		'priority' => 20,
	) );
	//add a new setting
	$wp_customize->add_setting( 'current_color_scheme', array(
		'default' => 'light',
	) );
	//add the control UI - dropdown (select)
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 
		'dodo_color_scheme', array(
			'type' 		=> 'select', //dropdown
			'choices' 	=> array(
								'dark' => 'Dark',
								'light' => 'Light',
							),
			'section' 	=> 'color_scheme',
			'settings' 	=> 'current_color_scheme',
			'label' 	=> 'Current Color Scheme',
		) ) );
	
}

//Display the Custom CSS
add_action( 'wp_head', 'dodo_custom_style' );
function dodo_custom_style(){
	?>
	<style>
		.content, .sidebar{
			color: <?php echo get_theme_mod('text_color'); ?>;
		}
		
	</style>
	<?php 
	 //logic for color scheme switching
	 if( get_theme_mod('current_color_scheme') == 'dark' ):
	 	?>
	 	<style>
	 		body{
	 			background-color:black;
	 			color:white;
	 		}
	 		.header{

	 		}
	 	</style>
	 	<?php
	 endif;
}




//no close php