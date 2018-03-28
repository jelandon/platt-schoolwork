<?php  
include_once('includes/header.php');
?>
<main class="content grid">
<?php  
//get the most recent posts for the main feed page

//super basic query
// $query =  "SELECT *
// 		  	   FROM posts";
// $query .= " WHERE is_published = 1";

$query = "SELECT posts.*, users.username, users.email, users.user_id
		  FROM posts, users
          WHERE posts.is_published = 1
          AND users.user_id = posts.user_id
          ORDER BY posts.post_date DESC
          LIMIT 10";
$result = $db->query($query);

if(! $result){
	echo $db->error;
}

if($result->num_rows>=1){
//loop through all the rows
	while($row=$result->fetch_assoc()){
//		var_dump($row);
//		echo '<br>';
?>

<article id="post_id_<?php echo $row['post_id'] ?>">
<h2 class="user-card">
	<a href="singlefeed.php?user_id=<?php echo $row['user_id']; ?>"><?php show_profile_pic($row['user_id']) ?>
		<span class="username">
		<?php 
		echo display_user_name($row['user_id']);
		?>
	</span>
	</a>	
</h2>
<a href="single.php?post_id=<?php echo $row['post_id'] ?>"><img src="<?php image_url($row['post_id'], 'large') ?>" class="post-image"></a>
<h3><?php echo $row['title'] ?> <span class="like-button <?php echo you_like($logged_in_user['user_id'], $row['post_id']); ?>" data-userid="<?php echo $logged_in_user['user_id'] ?>" data-postid="<?php echo $row['post_id'] ?>">Like</span></h3>
<p><?php echo $row['body'] ?></p>
<div class="post-info">
<span class="datetime"><?php echo convert_date($row['post_date']); ?> </span>
<div class="tags"><?php echo show_post_tags($row['post_id']); ?></div>
<div class="likes-number">Likes: <?php count_post_likes($row['post_id']); ?></div>	
<div class="comments-number"><?php count_comments($row['post_id'], ' comment on this post', ' comments on this post'); ?></div>	
</div>
</article>
<?php
	}//end while
}//end if result>=1

?>
</main>	
<?php 
include_once('includes/sidebar.php');
include_once('includes/footer.php');
 ?>
