<?php 
/**
 * edit only post entry as long as ? post_id=x is in the url query string
 * This is step 2 of adding a new picture - edit the details, like title, body, etc.
 */

require_once('includes/header.php');
//parse will got here when complete
include('includes/edit-post-parse.php');

//which entry are we getting
$post_id = clean_int($_GET['post_id']);
//echo $post_id;
//check for invalid post in query string
if(! $post_id){
	die('Invalid. Go back to step 1');
}

//get current data about this - we will update it when they submit the form
$query = "SELECT * FROM posts WHERE post_id = $post_id LIMIT 1";

//echo $query;

$result = $db->query($query);

if(!$result){
	echo $db->error;
}

$row = $result->fetch_assoc();

 ?>

 <main class="content">
 	<h2>Image Details</h2>
 	<img src="<?php echo image_url($post_id, 'large'); ?>" class="post-image">
 	<?php show_feedback($feedback, $errors); ?>
 	<form action="<?php $_SERVER['PHP_SELF']; ?>?post_id=<?php echo $post_id; ?>" method="post">
 		<label for="the_title">Title:</label>
 		<input type="text" name="title" id="the_title" value="<?php echo $row['title']; ?>">
 		<label for="the_body">Description:</label>
 		<textarea name= "body" id="the_body" rows="10"><?php echo $row['body']; ?></textarea>
 		<label>
 			<input type="checkbox" name="is_published" value="1" <?php 
 				if($row['is_published']){echo 'checked';}
 			 ?>>
 			 Make Published
 		</label>
 		<label>
 			<input type="checkbox" name="allow_comments" value="1" <?php 
 				if($row['allow_comments']){echo 'checked';}
 			 ?>>
 			 Allow Comments on this post
 		</label>
 		<input type="submit" value="Save Post">
 		<input type="hidden" name="did_edit" value="1">
 		
 	</form>
 </main>
 <?php 
$result->free();
  ?>
  <?php 
include_once('includes/sidebar.php');
   ?>
 <?php 
include_once('includes/footer.php');
  ?>