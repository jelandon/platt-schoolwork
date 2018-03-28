<?php 
//does this check to see if the user is logged in and if so is it the right user?

if($logged_in_user){
$user_id = $logged_in_user['user_id'];
}else{
	die('You need to be <a href="login.php">logged in</a> to view this page.');
}

//get the post_id...
$post_id = clean_int($_GET['post_id']);


if(isset($_GET['delete'])){
	$tag_id = clean_int($_GET['delete']);
	$query = "DELETE FROM post_tags WHERE post_id = $post_id AND tag_id = $tag_id";
	$result = $db->query($query);
}

if($_POST['did_edit']){
	//clean all fields
	//the post that was created in step 1 (from the query string)
	$title 			= clean_string($_POST['title']);
	$body 			= clean_string($_POST['body']);
	$allow_comments = clean_boolean($_POST['allow_comments']);
	$new_tag = clean_string($_POST['new_tag']);
	$is_published = clean_boolean($_POST['is_published']);
	$show = clean_boolean($_POST['did_edit']);
	
	//validate
	$valid = true;
		//Post_id from step 1 is invalid
		if(! is_numeric($post_id)){
			$valid = false;
			$errors['post_id'] = 'The Post ID is invalid, go back to step 1';
		}else{
			//is the user allowed to update this post?

		}
		//title is blank or longer than 256 chars
		if( $title == '' OR strlen($title) > 100 ){
			$valid = false;
			$errors['title'] = 'Please add a title that is between 1 and 100 characters long.';
		}
		//body is blank
		if( $body == '' ){
			$valid = false;
			$errors['body'] = 'The body of the post cannot be blank.';
		}

		//check if this user is authorized to post on this post
		if(! $logged_in_user['is_admin'] ){
			//if user is not an admin, check to see if this is their post in the first place.
			$query = "SELECT user_id from posts
					  WHERE post_id = $post_id
					  AND user_id = $user_id";		  
			$result = $db->query($query);
			if($result->num_rows == 0){
			$valid = false;	
			$errors['not_valid'] = 'This is either an invalid post number or you may not have authorization to edit this post. Confirm with an admin that this post is yours.';
			}
		}

	if($new_tag != ''){
		//check to see if tag exists in db
		$query1 = "SELECT tag_id
				  FROM tags
				  WHERE tag_name = '$new_tag'
				  LIMIT 1";
		$result1 = $db->query($query1);

		if($result1->num_rows == 1){
			//we have a result!
			$row = $result1->fetch_assoc();
			$tag_id = $row['tag_id'];
			echo 'tag_id: '.$tag_id;

		}else{
			$query2 = "INSERT INTO tags
						(tag_name)
						VALUES
						('$new_tag')";
			$result2 = $db->query($query2);
			if($db->affected_rows > 0){
			 $tag_id = $db->insert_id;
			}
	}
	//at this point the tag now needs to be associated with the post
	$query3 = "INSERT INTO post_tags
				  (post_id, tag_id)
				  VALUES
				  ($post_id, $tag_id)";
		$result3 = $db->query($query3);
		//check to see if new tag was added into the db....
		 
	}//if not blank
		
//echo "query1: $query1 <br> query2: $query2 <br> query3:  $query3";		
	//if it's all valid, Update the post with the new details as long as you are a valid user

	if($valid){
		$query = "UPDATE posts
				  SET 
				  title  = '$title',
				  body = '$body',
				  is_published = $is_published,
				  allow_comments = $allow_comments
				  WHERE post_id = $post_id
				  LIMIT 1";
		$result = $db->query($query);
		if(!$result){
			echo $errors['not_authorized'] = 'You may not have authorization to update this post. Check that this post is yours.';
			 // debugging: echo $db->error;
		}

		if($new_tag_id == 0){
		//add relationship to post_tags table	

		}else{

		}

		if( $db->affected_rows >= 1 ){
			$feedback = 'Success! Your post has been saved.';
		}else{
			$feedback = 'No changes made to the post.';
		}
	}//end if valid
	else{
		$feedback = 'There are problems with the form. Fix them:';
	}
}//end step 2 parser
