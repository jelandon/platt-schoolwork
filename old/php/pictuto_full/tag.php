<?php  
include_once('includes/header.php');
if(isset($_GET['tag_id'])){
	$tag_id = clean_int($_GET['tag_id']);
	$query = "SELECT tag_name FROM tags WHERE tag_id = $tag_id LIMIT 1";
	$result = $db->query($query);
	if($result->num_rows == 1){
		//we have a result
		$tag_name = $result->fetch_assoc();

	}else{
		echo "<h2>This is not a valid tag.</h2>";
	}


}

?>
<main class="content grid">
	<h2 class="full-column caps"><?php echo $tag_name['tag_name']; ?></h2>
	<?php 
	$result->free();
	//get all the posts in this tag. make sure they are published posts
	$query = "SELECT *
	FROM posts, tags, post_tags, users
	WHERE posts.is_published = 1
	AND tags.tag_id = $tag_id
	AND tags.tag_id = post_tags.tag_id 
	AND posts.post_id = post_tags.post_id
	AND users.user_id = posts.user_id
	ORDER BY posts.post_date DESC
	LIMIT 10";
	$result = $db->query($query);
	//check it
	if( !$result ){
		echo $db->error;
	}
	if( $result->num_rows >= 1 ){

		while( $row = $result->fetch_assoc() ){
		?>

			<article class="medium-post">
				<a href="single.php?post_id=<?php echo $row['post_id'] ?>">
				<img src="<?php image_url($row['post_id'], 'medium') ?>" class="post-image">
				</a>
					<h2 class="user-card">
						<a href="singlefeed.php?user_id=<?php echo $row['user_id']; ?>">
							<?php show_profile_pic($row['user_id']); ?>				
							<?php echo $row['username']; ?>	
						</a>
					</h2>
					<h3><?php echo $row['title']; ?></h3>
					<div class="post-info"> 
						<?php echo convert_date($row['post_date']); ?> 
						<?php show_post_tags($row['post_id']); ?>	
					</div>		
				</article>
	
	<?php 
		} //end while
	} //end if one post to show
	else{
		echo 'Invalid Tag.';
	} 
	?>

</main>

<?php include('includes/sidebar.php'); ?>
<?php include('includes/footer.php'); ?>