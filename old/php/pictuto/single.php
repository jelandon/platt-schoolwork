<?php  
	include_once('includes/header.php');
	if(isset($_GET['post_id'])){
		$post_id = $_GET['post_id'];
	}
	include('includes/comment-parse.php');
?>
<main class="content">
<?php  
	$query = "SELECT posts.*, users.username, users.user_id, users.profile_pic, users.email
		      FROM posts, users
		      WHERE posts.is_published = 1
		      AND posts.post_id = $post_id
		      AND users.user_id = posts.user_id
		      LIMIT 1";
	$result = $db->query($query);
	//easy check db for error
	
	if(!$result){
		echo $db->error;
	}	      

	if($result->num_rows == 1){
		$row = $result->fetch_assoc();
	}
?>
	<article id="post_id_<?php echo $row['post_id'] ?>" class="post">
	<?php  
	//if this user is the user that made the post or otherwise authorized, show an edit button
	if($row['user_id'] == $logged_in_user['user_id'] OR $logged_in_user['is_admin']){
		$authorized_user = true;
?>		
	<br>
	<a class="button" href="edit_post.php?post_id=<?php echo $row['post_id']; ?>">Edit</a>
<?php	
	}else{
		$authorized_user = false;
	}
	?>	
	<h2 class="user-card">
		<a href="feed.php?user_id=<?php echo $row['user_id']; ?>">
			<?php 
				show_profile_pic($row['user_id']);
			 ?>
		<span class="username"><?php echo $row['username'] ?></span>
		</a>	
	</h2>	
	<img src="<?php image_url($row['post_id'], 'large') ?>" class="post-image">
	<h3><?php echo $row['title']; ?>
		<span class="button like-button" <?php echo you_like($logged_in_user['user_id'], $row['post_id']); ?>" data-userid="<?php echo $logged_in_user['user_id']; ?>" data-postid="<?php echo row['post_id]']; ?>">
			<?php echo you_like($logged_in_user['user_id'], $row['post_id']); ?>

		</span></h3>	
	<p><?php echo $row['body']; ?></p>
	<div class="post-info">
		<span class="datetime"><?php echo convert_date($row['date']); ?></span>
		<span class="tags">TAGS GO HERE</span>
		<div class="likes-number">#OF LIKES</div>
	<?php 
		//alternate is to pass unique arguments for $one and $many - example:
		//count_comments($row['post_id'], ' comment on this post', ' comments on this post')
	 ?>

		<div class="comments-number"><?php count_comments($row['post_id']); ?></div>		
	</div>
	</article>
<!-- comments go here -->

<?php 
	//get all the approved comments on THIS post, newest last
	$query_comments =	"SELECT comments.comment_id, comments.user_id, comments.body, comments.date, comments.is_approved
						FROM comments, users
						WHERE comments.post_id = $post_id
						AND users.user_id = comments.user_id ";
				//if user is unauthorized, get only the approved comments
				if(!$authorized_user){
					$query_comments .="AND comments.is_approved = 1";
				}
					$query_comments .="ORDER BY comments.is_approved DESC, comments.date ASC LIMIT 20";

				//getting the right data, while() the query_comments
				$result_comments = $db->query($query_comments);
				if($result_comments->num_rows>=1){

 ?>

<section class="comments-list">
	<h2>Comments:</h2>
	<ul>
		<?php 
		//start while
		while($row_comments = $result_comments->fetch_assoc()){
			//display will be different for those allowed to edit this page
			if($row_comments['is_approved'] == 0){
				$class = 'unapproved';
				$text = 'Approve';
			}else{
				$text = 'Unapprove';
			}
	?>
	<li class="one-comment <?php echo $class; ?>">
		<h2 class="user-card">
			<a href="feed.php?user_id=<?php echo $row_comments['user_id']; ?>">
				<?php show_profile_pic($row_comments['user_id']); ?>
				<span class="username"><?php echo display_user_name($row_comments['user_id']); ?></span>
			</a>
		</h2>
		<br>
		<?php if($authorized_user){ ?>
			<a href="single.php?post_id=<?php echo $post_id; ?>&comment_id=<?php echo $row_comments['comment_id']; ?>&action=<?php echo $text; ?>"><?php echo $text; ?>?</a>

			<?php if($text == 'Approve'){
				//display the delete button
				$text = 'Delete';

			 ?>
			 <a class="button delete" href="single.php?post_id=<?php echo $post_id; ?>&comment_id=<?php echo $row_comments['comment_id']; ?>&action=Delete">Delete</a>


			<?php }//end if text == approve
		}//end if authorized_user ?>
		<p><?php echo $row_comments['body']; ?></p>
		<div class="date"><?php echo convert_date($row_comments['date']); ?></div>
	</li>

	<?php
		}//end while
		$result_comments->free();

		 ?>
		
	</ul>
</section>


<?php 
}//end if $result_comments

 ?>

<section class="comment-form">
	<?php 
	//find out if the user is logged in... then show them the form
	if($logged_in_user['user_id']){
	 ?>

	 <h2>Leave a Comment</h2>
	 <?php //show_feedback($show, $feedback, $errors);
	 	if(isset($feedback)){
	 		echo $feedback;
	 	 ?>
	 	<?php } ?>
	 <form action="single.php?post_id=<?php echo $post_id; ?>" method="post" novalidate>
	 	<!-- TODO: remove the novalidate attribute when done troubleshooting -->
	 	<label for="the_comment">Comment:</label>
	 	<textarea name="comment" id="the_comment" required></textarea>
	 	<input type="hidden" name="did_comment" value="1">
	 	<input type="hidden" name="post_id" value="<?php echo $post_id ?>">
	 	<input type="submit" name="Add Comment">
	 </form>

	<?php }//end if user logged in 
		else{
			echo 'You must be logged in to comment.';
		}

	?>
</section>



</main>
<?php  
	include_once('includes/sidebar.php');
?>

<script type="text/javascript">
	//straight JS
	//querySelectorAll gathers up all the items requested in a Nedelist, selected like we would with CSS
	
	var delete_buttons = document.querySelectorAll('.button.delete');

	//for each .button.delete that is in delete_buttons
	for(var i=0; i<delete_buttons.length; i++){
		var button = delete_buttons[i];
		button.onclick = confirmAction;
	}

	function confirmAction(){
		var agree = confirm("This is permanent. Are you sure?");
		if(agree){
			return true;
		}else{
			return false;
		}
	}

</script>









<?php  
	include_once('includes/footer.php');
?>



 </body>
 </html>