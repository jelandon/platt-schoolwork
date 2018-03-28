<?php
/**
 * The template for displaying comments and the comment form
 * include it with comments_template()
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
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
<?php 
//if there are text comments, show them
if( $comment_count ){ ?>
<section class="comments">
	<h3><?php echo $comment_count == 1 ? 'One comment' : $comment_count . ' comments'; ?> on this post:</h3>

	<ol>
		<?php 
		//just show normal comments
		wp_list_comments( array(
			'type' 			=> 'comment',
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
		//just show normal comments
		wp_list_comments( array(
			'type' 			=> 'pings', //pingbacks and trackbacks
			'short_ping' 	=> true,
		) ); 
		?>
	</ol>	
</section>
<?php } //end if there are pings ?>