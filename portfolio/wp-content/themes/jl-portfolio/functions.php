<?php
//customizer features
add_theme_support( 'custom-background' );

//Support Featured Images
add_theme_support( 'post-thumbnails' );

//custom image sizes
//				name    width  height  crop?
add_image_size( 'banner', 1200, 300, true );
add_image_size( 'big_thumbnail', 300, 300, true );

//custom header
$args = array(
	'width' => 1000,
	'height' => 600,
	'flex-width' => true,
	'flex-height' => true,
 );
add_theme_support( 'custom-header', $args );

//custom logo
$default = array(
	'width' => 200,
	'height' => 200,
	'flex-width' => true,
	'flex-height' => true,
);
add_theme_support( 'custom-logo', $default );

//upgrade any HTML output to HTML5
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

//delete the <title> tag from the header, then add this function
add_theme_support( 'title-tag' );

//make editor-style.css
add_editor_style();

//add google fonts
function jl_add_google_fonts() {
	wp_enqueue_style( 'jl-google-fonts', 'https://fonts.googleapis.com/css?family=Lato|Titillium+Web', false ); 
}
add_action( 'wp_enqueue_scripts', 'jl_add_google_fonts' );

/**
 * change the default length of the_excerpt()
 * Search results will show fewer words in the excerpts
 * 
 * @return int the number of words displayed in the excerpt
 */
function jl_excerpt_length() {
	//example of adding conditional logic
	if( is_search() ):
		return 10;
	else:
		return 75;
	endif;
}
add_filter( 'excerpt_length', 'jl_excerpt_length' );

/**
 * change the [...]
 */
function jl_dotdotdot() {
	return '&hellip; <a href="' . get_permalink() . '">Keep Reading</a>';
}
add_filter( 'excerpt_more', 'jl_dotdotdot' );

/**
 * Helper function to display archive or single pagination (next/prev buttons)
 */
function jl_pagination() {
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
 * Set up 2 menu locations 
 * @since  0.1  added the function
 */
add_action( 'init', 'jl_menu_locations' );
function jl_menu_locations(){
	register_nav_menus( array(
		'main_menu' 	=> 'Main Menu',
		'social_icons' 	=> 'Social Media Icons'
	) );
}

/**
 * enqueue all stylesheets or JavaScript
 */
add_action( 'wp_enqueue_scripts', 'jl_scripts' );
function jl_scripts(){
	//style.css
	wp_enqueue_style( 'jl-style', get_stylesheet_uri() );

	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css' );
}

add_theme_support( 'custom-logo' );

// function jl_custom_logo() {
// 	echo '
// 		<style type="text/css">
// 			#wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
// 				background-image: url(' . get_bloginfo('stylesheet_directory') . '/images/custom-logo.svg) !important;
// 				background-position: 0 0;
// 				color:rgba(0, 0, 0, 0);
// 			}
// 			#wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {
// 				background-position: 0 0;
// 			}
// 		</style>';
// }

//hook into the administrative header output
//add_action('wp_before_admin_bar_render', 'jl_custom_logo');

//change dashboard footer
function jl_remove_footer_admin () {
 
echo 'Fueled by <a href="http://www.wordpress.org" target="_blank">WordPress</a> | Developed by <a href="http://www.johnlandon.design/" target="_blank">John Landon</a></p>';
 
}
 
add_filter('admin_footer_text', 'jl_remove_footer_admin');

// remove junk from head
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

$themename = "jl-portfolio";
$shortname = "jl";
$options = array (

	array(	"name" => $themename." Options",
			"type" => "title"),


	array(	"name" => "General",
			"type" => "section"),

	array(	"type" => "open"),

	array(	"name" => "Color Scheme",
			"desc" => "Select the color scheme for the theme",
			"id" => $shortname."_color_scheme",
			"type" => "select",
			"options" => array("blue", "red", "green"),
			"std" => "blue"),

	array(	"name" => "Logo URL",
			"desc" => "Enter the link to your logo image",
			"id" => $shortname."_logo",
			"type" => "text",
			"std" => ""),

	array(	"name" => "Custom CSS",
			"desc" => "Want to add any custom CSS code? Put in here, and the rest is taken care of. This overrides any other stylesheets. eg: a.button{color:green}",
			"id" => $shortname."_custom_css",
			"type" => "textarea",
			"std" => ""),

	array(	"type" => "close"),

	array(	"name" => "Homepage",
			"type" => "section"),

	array(	"type" => "open"),

	array(	"name" => "Homepage header image",
			"desc" => "Enter the link to an image used for the homepage header.",
			"id" => $shortname."_header_img",
			"type" => "text",
			"std" => ""),

	array(	"name" => "Homepage featured category",
			"desc" => "Choose a category from which featured posts are drawn",
			"id" => $shortname."_feat_cat",
			"type" => "select",
			"options" => $wp_cats,
			"std" => "Choose a category"),

	array(	"type" => "close"),

	array(	"name" => "Footer",
			"type" => "section"),

	array( "type" => "open"),

	array(	"name" => "Footer copyright text",
			"desc" => "Enter text used in the right side of the footer. It can be HTML",
			"id" => $shortname."_footer_text",
			"type" => "text",
			"std" => ""),

	array(	"name" => "Google Analytics Code",
			"desc" => "You can paste your Google Analytics or other tracking code in this box. This will be automatically added to the footer.",
			"id" => $shortname."_ga_code",
			"type" => "textarea",
			"std" => ""),    

	array(	"name" => "Custom Favicon",
			"desc" => "A favicon is a 16x16 pixel icon that represents your site; paste the URL to a .ico image that you want to use as the image",
			"id" => $shortname."_favicon",
			"type" => "text",
			"std" => get_bloginfo('url') ."/favicon.ico"),   

	array(	"name" => "Feedburner URL",
			"desc" => "Feedburner is a Google service that takes care of your RSS feed. Paste your Feedburner URL here to let readers see it in your website",
			"id" => $shortname."_feedburner",
			"type" => "text",
			"std" => get_bloginfo('rss2_url')),

	array(	"type" => "close")

);

function jl_add_admin() {
	
	global $themename, $shortname, $options;

	if($_GET['page'] == basename(__FILE__)) {
		if('save' == $_REQUEST['action']) {
			foreach ($options as $value) {
				update_option($value['id'], $_REQUEST[$value['id']]);
			}
			foreach ($options as $value) {
				if(isset($_REQUEST[$value['id']])) {
					update_option($value['id'], $_REQUEST[$value['id']]);
				}
				else {
					delete_option($value['id']);
				}
			}
			header("Location: admin.php?page=functions.php&saved=true");
			die;
		}
		else if('reset' == $_REQUEST['action']) {
			foreach ($options as $value) {
				delete_option($value['id']);
			}
			header("Location: admin.php?page=functions.php&reset=true");
			die;
		}
	}

	add_menu_page($themename, $themename, 'administrator', basename(__FILE__), 'jl_admin');
}
 
function jl_add_init() {}

function jl_admin() {
	global $themename, $shortname, $options;
	$i=0;

	if($_REQUEST['saved'])echo'<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
	if($_REQUEST['reset']) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
	?>
	<div class="wrap jl_wrap">
		<h2><?php echo $themename; ?> Settings</h2>
		<div class="jl_opts">
			<form method="post">
<?php
				foreach ($options as $value) {
					switch ($value['type']) {
						case "open":
?>
<?php
						break;
						case "close":
?>
		</div>
	</div>
	<br />
<?php
						break;
						case "title":
?>
				<p>To easily use the <?php echo $themename;?> theme, you can use the menu below.</p>
<?php
						break;
						case 'text':
?>
				<div class="jl_input rm_text">
					<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
					<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if (get_settings($value['id'] ) != "") {echo stripslashes(get_settings( $value['id']));}else {echo $value['std']; } ?>" />
					<small><?php echo $value['desc']; ?></small>
					<div class="clearfix"></div>
				</div>
<?php
						break;
						case 'textarea':
?>
				<div class="jl_input rm_textarea">
					<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
					<textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id']) ); } else { echo $value['std']; } ?></textarea>
					<small><?php echo $value['desc']; ?></small>
					<div class="clearfix"></div>
				</div>
<?php
						break;
						case 'select':
?>
				<div class="jl_input jl_select">
					<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
					<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
<?php
						foreach ($value['options'] as $option) { ?>
							<option <?php if (get_settings( $value['id'] ) == $option) {echo 'selected="selected"';}?>>
							<?php echo $option; ?>
					
							</option><?php
						} ?>
					</select>
					<small><?php echo $value['desc']; ?></small>
					<div class="clearfix"></div>
				</div>
<?php
						break;
						case "checkbox":
?>
				<div class="jl_input jl_checkbox">
					<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
						<?php
						if(get_option($value['id'])){
							$checked = "checked=\"checked\"";
						}
						else{
							$checked = "";
						}
						?>
					<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
					<small><?php echo $value['desc']; ?></small>
					<div class="clearfix"></div>
				</div>
<?php
						break;
						case "section":
	
						$i++;
?>
				<div class="jl_section">
					<div class="jl_title">
						<h3>
							<img src="<?php bloginfo('template_directory')?>/functions/images/trans.gif" class="inactive" alt=""">
							<?php echo $value['name']; ?>
						</h3>
						<span class="submit">
							<input name="save<?php echo $i; ?>" type="submit" value="Save changes" />
						</span>
						<div class="clearfix"></div>
					</div>
				<div class="jl_options">
<?php
						break;
					} //END switch ($value['type'])
				} //END foreach ($options as $value)
?>
				<input type="hidden" name="action" value="save" />
			</form>
			<form method="post">
				<p class="submit">
					<input name="reset" type="submit" value="Reset" />
					<input type="hidden" name="action" value="reset" />
				</p>
			</form>
 		</div> 
 	</div>
<?php
} 

add_action('admin_init', 'jl_add_init');
add_action('admin_menu', 'jl_add_admin');

