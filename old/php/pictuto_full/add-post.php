<?php  
/*The first step to upload an image. If successful, the post is saved, and the user is directed to the second step to complete the post title, body, etc.
*/
require_once('includes/header.php');
include('includes/add-post-parse.php');
?>
<main class="content">
	<h2>Add a Post</h2>
	<?php show_feedback($show, $feedback, $errors); ?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" novalidate>
		<label for="the_image">Image</label>
		<input type="file" name="uploadedfile" id="the_image" required>
		<input type="submit" value="Next Step: Details &rarr;">
		<input type="hidden" name="did_add_post" value="1">
	</form>
</main>	
<?php  
include_once('includes/sidebar.php');
include_once('includes/footer.php');
?>