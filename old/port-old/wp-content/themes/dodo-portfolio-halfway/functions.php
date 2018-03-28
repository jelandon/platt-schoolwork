<?php
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
add_editor_style();


/**
 * change the deafult length of the_excerpt()
 * search results will show fewer words in the excerpts
 * 
 * @return int the number of words displayed in the exerpt
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

//change the [...]
function dodo_dotdotdot(){
	return '&hellip; <a href="' . get_permalink() . '">Keep Reading</a>';
}
add_filter( 'excerpt_more', 'dodo_dotdotdot' );

/**
 * set up 2 menu locations 
 * @since 0.1 added the function
 * @author John
 */

add_action( 'init', 'dodo_menu_locations');
function dodo_menu_locations(){
	register_nav_menus( array(
		'main_menu' => 'Main Menu',
		'social_icons' => 'Social Media Icons'
	) );
}

/**
 * enqueue all stylesheets or JS
 */
add_action( 'wp_enqueue_scripts', 'dodo_scripts' );
function dodo_scripts(){
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css');
}

/**
 * Helper function to display archive or single pagination (next/prev buttons)
 */
function dodo_pagination(){
	if( is_singular() ):
		//single post pagination
		previous_post_link('%link', '&larr; Previous: %title' );
		next_post_link( '%link', 'Next: %title &rarr;');
	else:
		//archive pagination
		if (wp_is_mobile() ):
			previous_posts_link( '&larr; Previous Page');
			next_posts_link( 'Next Page &rarr;');
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
 * register all the widget areas (i.e. dynamic sidebars)
 */
add_action( 'widgets_init', 'dodo_widget_areas');

function dodo_widget_areas(){
	register_sidebar( array(
		'name'			=> 'Blog Sidebar',
		'id'			=> 'blog_sidebar',
		'description'	=> 'Appears alongside the Blog and archive pages',
		'before_widget'	=> '<section class="widget %2$s" id="%1$s">',
		//the below 4 lines are good in almost every context
		'after_widget'	=> '</section>',
		'before_title'	=> '<h3 class="widget-title">',
		'after_title'	=> '</h3>',
	));
	register_sidebar( array(
		'name'			=> 'Footer Area',
		'id'			=> 'footer_area',
		'description'	=> 'Appears at the bottom of every screen',
		//the below 4 lines are good in almost every context
		'before_widget'	=> '<section class="widget %2$s" id="%1$s">',
		'after_widget'	=> '</section>',
		'before_title'	=> '<h3 class="widget-title">',
		'after_title'	=> '</h3>',
	));
	register_sidebar( array(
		'name'			=> 'Home Area',
		'id'			=> 'home_area',
		'description'	=> 'Appears only on the front page',
		//the below 4 lines are good in almost every context
		'before_widget'	=> '<section class="widget %2$s" id="%1$s">',
		'after_widget'	=> '</section>',
		'before_title'	=> '<h3 class="widget-title">',
		'after_title'	=> '</h3>',
	));
	register_sidebar( array(
		'name'			=> 'Page Sidebar',
		'id'			=> 'page_sidebar',
		'description'	=> 'Appears on every page',
		//the below 4 lines are good in almost every context
		'before_widget'	=> '<section class="widget %2$s" id="%1$s">',
		'after_widget'	=> '</section>',
		'before_title'	=> '<h3 class="widget-title">',
		'after_title'	=> '</h3>',
	));

}



//hide all of this file if the post if password protected
if( post_password_required() ){
	return;
}
//get distinct counts of comments and pings
$comments_by_type = separate_comments( get_comments( array(
	'status' => 'approve',
	'post_id' => $id, //THIS post
) ) ); 
$comment_count = count( $comments_by_type['comment'] );
$pings_count = count( $comments_by_type['pings'] );
?>
<?php if( $comment_count ){ ?>
<section class="comments">
	<h3><?php echo $comment_count == 1 ? 'One comment' : $comment_count . ' comments'; ?> on this post:</h3>

	<ol>
		<?php 
		//just show normal comments
		wp_list_comments( array(
			'type' 		=> 'comment',
			'avatar_size' 	=> 50,
		) ); 
		?>
	</ol>

	<div class="pagination">
		<?php previous_comments_link(); ?>
		<?php next_comments_link(); ?>
	</div>

</section>
<?php } //end if there are comments ?>

<section class="comments-form">
	<?php comment_form(); ?>
</section>

<?php if( $pings_count ){ ?>
<section class="pings">
	<h3><?php echo $pings_count == 1 ? 'One site' : $pings_count . ' sites' ; ?> mention this post:</h3>
	<ol>
		<?php 
		//just show pingbacks and trackbacks
		wp_list_comments( array(
			'type' 		=> 'pings', //pingbacks and trackbacks
			'short_ping' 	=> true,
		) ); 
		?>
	</ol>	
</section>
<?php } //end if there are pings ?>