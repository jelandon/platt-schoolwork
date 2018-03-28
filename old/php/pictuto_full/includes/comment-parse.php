<?php 
//only logged in users should be able to comment on posts
$user_id = (int) $logged_in_user['user_id'];

//to approve or unapprove comments from a specific post

if(isset($_GET['action'])){
	$action = clean_string($_GET['action']);
	$comment_id = clean_int($_GET['comment_id']);
	
if($action=='Delete'){
//delete the comment
	$query = "DELETE FROM comments
			  WHERE comment_id = $comment_id";
	$result = $db->query($query);		  
}else{

	if($action == 'Approve'){
		//we want to approve this comment
		$set_approval = 1;
	}else{
		//we want to unapprove this comment
		$set_approval = 0;
	}

	$query = "UPDATE comments SET is_approved = $set_approval 
	          WHERE comment_id = $comment_id";
	 $result = $db->query($query);

}


}//end action section



//parse the comment if one was submitted:

if($_POST['did_comment']){
//extract and sanitize
	$comment = clean_string($_POST['comment']);
	$post_id = clean_int($_POST['post_id']);
	$show = clean_boolean($_POST['did_comment']);

//validate:
	$valid = true;
//check to see if valid user
	if(!is_int($user_id)){
		$valid = false;
		$errors['name'] = 'You must be logged in to comment.';
	}

	if($comment == ''){
		$valid = false;
		$errors['comment'] = 'Comment field cannot be left blank.';
	}else{
		//check if that user commented the same exact way on that post
		$query = "SELECT comment_id
				  FROM comments
				  WHERE body = '$comment'
				  AND user_id = $user_id
				  AND post_id = $post_id";
		$result = $db->query($query);
		if($result->num_rows>=1){
			$valid = false;
			$errors['comment'] = 'You made the same comment on this same post.';
		}

	}

	if($valid){
		$query = "INSERT INTO comments
		          (user_id, comment_date, body, post_id, is_approved)
		          VALUES
		          ($user_id, now(), '$comment', $post_id, 1)";
		$result = $db->query($query);
	//see if there was an affected row
		if($db->affected_rows == 1){
			//success
			$feedback = 'Comment posted successfully.';
		}else{
			$feedback = 'Sorry something went wrong. Your comment could not be posted.';
		}	          

	}//end if valid
	else{
		$feedback = "There are errors in the comment form. Please fix the following:";
	}

}//end parser


//no close php