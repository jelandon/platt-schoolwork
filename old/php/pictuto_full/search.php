<?php  
require('includes/header.php');
//search stuff to go here

$phrase = clean_string($_GET['phrase']);

//results per page
$per_page = 3;

//parse the search form if the phrase is not blank

if($phrase != ''){
	//get all the posts that contain the phrase
	$query = "SELECT posts.*, users.user_id, users.profile_pic
			  FROM posts, users
			  WHERE (title LIKE '%$phrase%'
			  OR body LIKE '%$phrase%')
			  AND is_published = 1
			  AND posts.user_id = users.user_id
			  ORDER BY post_date DESC";
			  
	$result = $db->query($query);
	$total = $result->num_rows;
			  
//pagination goes below:

//figure out how many pages we need
	$max_page = ceil($total/$per_page);

//figure what page we are currently on
//url query string  will look like: search.php?phrase=blah&page=2
if($_GET['page']){
	$current_page = $_GET['page'];
}else{
	$current_page = 1;
}	

if($current_page > $max_page){
	//change it to the last page:
	$current_page = $max_page;
}


}//end parser
?>
<main class="content search grid">
<!-- if there are results from search -->
<?php  
	if($total >= 1){

?>
<div class="search-header full-column">
	<h1>Search Results for <i><?php echo $phrase ?></i></h1>
	<h2><?php echo $total ?> Posts found.</h2>
	<h3>Showing Page: <?php echo $current_page; ?> of <?php echo $max_page; ?></h3>
</div>
<?php  
//figure out the offset of this page
$offset = ($current_page - 1) * $per_page;
$query .= " LIMIT $offset, $per_page";
$result = $db->query($query);

while($row = $result->fetch_assoc()){

?>
<article class="medium-post">
	<a href="single.php?post_id=<?php echo $row['post_id']; ?>">
		<img src="<?php image_url($row['post_id'], 'medium') ?>" class="post-image">
	</a>
	<h2 class="user-card">
		<a href="singlefeed.php?user_id=<?php echo $row['user_id']; ?>"><?php show_profile_pic($row['user_id']) ?>
		<span class="username">
			<?php 
			echo display_user_name($row['user_id']);
			?>
		</span>
		</a>	
	</h2>
	<h3><?php echo $row['title']; ?></h3>
	<div class="post-info">
	<span class="datetime"><?php echo convert_date($row['post_date']); ?> </span>
	<div class="tags"><?php echo show_post_tags($row['post_id']); ?></div>
	<div class="likes-number">Likes: <?php count_post_likes($row['post_id']); ?></div>	
	<div class="comments-number"><?php count_comments($row['post_id'], ' comment on this post', ' comments on this post'); ?></div>	
	</div>

</article>
<!-- end while -->
<?php 
	}//end while
	$result->free();
?>	
<section class="pagination full-column">
	<?php 
	$previous = $current_page - 1;
	$next = $current_page + 1;
	if($current_page != 1){ ?>
	<a href="search.php?phrase=<?php echo $phrase ?>&amp;page=<?php echo $previous; ?>">&larr; Previous Page</a>
<?php
	}
	//loop for numbered pagination
	for ($i = 1; $i<= $max_page; $i++){
	?>
	<a href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $i; ?>"><?php echo $i; ?></a>
<?php
	}

	if($current_page != $max_page){ ?>
	<a href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $next; ?>">Next Page &rarr;</a>
<?php
	}
	 ?>
</section>
<?php
 }//end if $result is >=1
 else{
 	echo 'No posts found matching '.$phrase;
 }
 ?>
</main>	
<?php 
include('includes/sidebar.php'); 
include('includes/footer.php'); 
 ?>