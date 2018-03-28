<?php  
include_once('includes/header.php');
if(isset($_GET['user_id'])){
	$page_user_id = clean_int($_GET['user_id']);
}

?>
<main class="content grid">
<div class="search-header full-column">
<h2 class="user-card">
<?php 		   
	if(confirm_valid_user($page_user_id) ){
 ?>	
	<?php show_profile_pic($page_user_id) ?>
		<span class="username">
		<?php 
		echo display_user_name($page_user_id);
		?>
	</span>	
<?php }else{
	echo 'This is an invalid user.';	


} ?>	
</h2>	
</div>	
<?php  
//get the most recent posts for the main feed page

if(confirm_valid_user($page_user_id) ){
$query = "SELECT posts.*, users.username, users.email, users.user_id
		  FROM posts, users
          WHERE posts.is_published = 1
          AND users.user_id = posts.user_id
          AND posts.user_id = $page_user_id
          ORDER BY posts.post_date DESC
          LIMIT 10";
$result = $db->query($query);

if(! $result){
	echo $db->error;
}

if($result->num_rows>=1){
//loop through all the rows
	while($row=$result->fetch_assoc()){

?>
<article id="post_id_<?php echo $row['post_id'] ?>">
<a href="single.php?post_id=<?php echo $row['post_id'] ?>"><img src="<?php image_url($row['post_id'], 'large') ?>" class="post-image"></a>
<h3><?php echo $row['title'] ?> <span class="like-button <?php echo you_like($logged_in_user['user_id'], $row['post_id']); ?>" data-userid="<?php echo $logged_in_user['user_id'] ?>" data-postid="<?php echo $row['post_id'] ?>">Like</span></h3>
<p><?php echo $row['body'] ?></p>
<div class="post-info">
<span class="datetime"><?php echo convert_date($row['post_date']); ?> </span>
<span class="username">by <?php echo $user_name; ?></span>
<div class="tags"><?php echo show_post_tags( $row['post_id'] ); ?></div>
<!-- maybe put a heart icon here -->
<div class="likes-number">Likes: <?php count_post_likes($row['post_id']); ?></div>	
<div class="comments-number">
	<?php count_comments( $row['post_id'], ' comment on this post', 
			' comments on this post' ); ?>			
</div>	
</div>
</article>
<?php
	}//end while
}//end if result>=1
else{
	echo 'This user has no posts.';
}
}
?>
</main>	
<?php 
include_once('includes/sidebar.php');
include_once('includes/footer.php');
 ?>
