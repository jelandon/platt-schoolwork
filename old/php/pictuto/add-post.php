<?php 

/**
 * the first step to upload an image, If successful, the post is saved and the user is directed to the second step to complete the post title, body, etc.
 */

require_once('includes/header.php');

include('includes/add-post-parse.php');

$user_id = 1;
//parser



 ?>
<main class="content">
	<h2>Add a Picture</h2>
	<!-- feedback goes here -->
	<!-- enctype attribute is necessary for file uploads -->
	<!-- the URL user_id param is temporary -->
	<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>?user_id=<?php echo $user_id; ?>" method="post">
		<label for="the_image">Image:</label>
		<input type="file" name="uploadedfile" id="the_image" required>
		<input type="submit" value = "Next Step: Details &rarr;">
		<input type="hidden" name="did_add_post" value = 1>
	</form>
</main>
<?php 
include_once('includes/sidebar.php');

 ?>
 <?php 
include_once('includes/footer.php');
  ?>