<?php 
/*
Edit any post as long as ?post_id=X is in the query string
This is also step 2 of adding a new post - edit the details, like title, body, etc
*/
require('includes/header.php');
include('includes/edit-post-parse.php');

//which post are we editing?
$post_id = $_GET['post_id'];
$show_post = true;
//check for invalid post_id in Query string:
if(! $post_id){
	die('invalid post id. go back to step 1');
}else{
//$is_admin = $logged_in_user['is_admin'];

		//check if this user is authorized to post on this post
		if(! $logged_in_user['is_admin'] ){
			//if user is not an admin, check to see if this is their post in the first place.
			$query = "SELECT user_id from posts
					  WHERE post_id = $post_id
					  AND user_id = $user_id";		  
			$result = $db->query($query);
			if($result->num_rows == 0){
			$show_post = false;
			$show = 1;	
			$errors['not_authorized'] = 'This is either an invalid post number or you may not have authorization to edit this post. Confirm with an admin that this post is yours.';
			}
		}

}

//make sure that the proper author is editing this post and that they are logged in.

//get the current data about this post - we'll UPDATE it when they submit this form. this also allows us to make the form "sticky"
if($show_post){
$query = "SELECT * FROM posts WHERE post_id = $post_id LIMIT 1";
}
$result = $db->query($query);
if(!$result){
	echo $db->error;
	//when the user is not authorized there is no database error, it just returns no rows of data.
}
$row = $result->fetch_assoc(); //only one row of data, no while loop
?>

<main class="content">
<h2>Image Details</h2>
<img src="<?php image_url($post_id, 'large'); ?>" class="post-image">
<?php show_feedback( $show, $feedback, $errors ); ?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?post_id=<?php echo $_GET['post_id'] ?>" method="post" >
<label for="the_title">Title</label>
<input type="text" name="title" id="the_title" value="<?php echo $row['title'] ?>" maxlength="100">

<label for="the_body">Post Body</label>
<textarea name="body" id="the_body" rows="10"><?php echo $row['body'] ?></textarea>
<label>Current Tags:</label>
<div class="tags"><?php echo show_post_tags($post_id); ?></div>
<label for="autocomplete">Add A Tag:</label>
<div id="searchfield">
<input type="text" name="new_tag" class="biginput" id="autocomplete">
</div>	
<label>
<input type="checkbox" name="is_published" value="1" <?php 
//echo checked if the checkbox is to be displayed as checked, affirming that the answer to the label is true (ex. this is a published post, not a draft)
if( $row['is_published'] ){ echo 'checked'; } ?> >
Make published
</label>

<label>
<input type="checkbox" name="allow_comments" value="1" <?php 
//same as above
if( $row['allow_comments'] ){ echo 'checked'; } ?> >
Allow comments on this post
</label>
			
<input type="submit" value="Save Post">
<input type="hidden" name="did_edit" value="1">

</form>
</main>

<?php 
$result->free(); 
include_once('includes/sidebar.php'); ?>
<!-- change out with a cdn -->
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery.autocomplete.min.js"></script>
 <?php include('js/tags-autocomplete.php');  ?>
<script type="text/javascript">
//straight JS
//querySelectorAll gathers up all the items requested into a NodeList, selected like we would with css
var delete_buttons = document.querySelectorAll('.tags a');

//for each .button.delete that is in delete_buttons
for(var i = 0; i<delete_buttons.length; i++){
	var button = delete_buttons[i];
	button.onclick = confirmAction;
}	

function confirmAction(e){
	var tagName = this.innerHTML;
	var agree = confirm("This will remove the tag: "+tagName+" from this post. Are you sure?");
	if(agree){
//direct user to top of page where dissassociating action will reside in parse
	e.preventDefault();
	//get the id of where the tag would be going...
	var tagId = this.getAttribute('href').split('=')[1];
	//send it to a new location
	var newLocation = window.location+'&delete='+tagId
	window.location=newLocation;
	}else{
		return false;
	}
}

</script>	
<?php 
include_once('includes/footer.php');
?>