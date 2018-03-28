<?php 
//only JS here... let's use post so no get... temp $_REQUEST for testing
//connect to db:
require_once('db-connect.php');

$options = ['liked', 'unliked'];
//the user either liked or unliked

if(isset($_POST['like'])){
	if(! in_array($_POST['like'],$options)){
	die('Not valid. I call shennanagans.');	
	}else{
	$like = $_POST['like'];
	$user_id = $_POST['user_id'];
	$post_id = $_POST['post_id'];		
	}	
}else{
	die('Not valid. I call shennanagans.');	
}


if($like == 'liked'){
	//we assume there is not a row of data in the db for this user to like this post, because if there was, the option to like would not be shown.
$query = "INSERT INTO likes
		  (user_id, post_id)
		  VALUES
		  ($user_id, $post_id)";

}else{
//$like can only be unliked otherwise at this point in this page -- find the row in the db and delete it

$query = "DELETE FROM likes
		  WHERE user_id = $user_id
		  AND post_id = $post_id";
}

//echo $query;

$result = $db->query($query);

 ?>
