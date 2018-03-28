<?php 

require_once('../db_connect.php');
$options = ['liked', 'unliked'];
//the user either liked pr unliked the post

//TODO: change to post when done!
if(isset($_REQUEST['like'])){
	if(!in_array($_REQUEST['like'], $options)){
		die('Not valid. I call shenanagans.');
	}else{

		$like = $_REQUEST['like'];
		$user_id = $_REQUEST['user_id'];
		$post_id = $_REQUEST['post_id'];
	}


}//TODO: else die...

if($like == 'liked'){
	//we assume their is not a row of date in db for this user to like this post, b/c if there was the option to like would not be shown
	
	$query="INSERT INTO likes
			(user_id, post_id)
			VALUES
			($user_id, $post_id)";
	}else{
		$query="DELETE FROM likes
				WHERE user_id = $user_id
				AND post_id = $post_id";
	}

	//TODO: get rid of query echo
	echo $query;

	







//no close php