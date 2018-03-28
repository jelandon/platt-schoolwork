<?php 
//TODOL Add a check to ensure that the user logged in has permission to edit this
if(isset($_POST['did_edit']) AND $_POST['did_edit']){
	//clean all the iields:
	$post_id = clean_int($_GET['post_id']);
	$title = clean_string($_POST['title']);
	$body = clean_string($_POST['body']);
	$allow_comments = clean_boolean($_POST['allow_comments']);
	$is_published = clean_boolean($_POST['is_published']);

	$user_id = $logged_in_user['user_id'];
	$is_admin = $logged_in_user['is_admin'];

	if(!$is_admin){
		//check to see if user is authorized....
		$query = "SELECT user_id
          FROM pictures
          WHERE pic_id = $pic_id
          LIMIT 1";	
		$result = $db->query($query);
		if($result->num_rows == 1){
		// we have a match... cool.
		$row = $result->fetch_assoc();
		$pic_user = $row['user_id'];
		}
		if( $user_id == $pic_user){
		//validate the data
		$valid = true;
		}else{
		$valid = false;
		die('you are not authorized to edit this picture.');
		}
	}else{
		$valid = true;
	}

	//post id from step 1 is invalid?
	
	if(! is_numeric($post_id)){
		$valid = false;
		$errors['post_id'] = 'The picture id is invalid. Go back to step 1';
	}

	//title is blank or longer than 100 charaters
	if($title == '' OR strlen($title) > 100){
		$valid = false;
		$errors['title'] = 'Please add a title that is between 1 and 100 character long.';
	}

	if($body == ''){
		$valid = false;
		$errors['body'] = 'The body of the post cannot be blank.';
	}

	//if everything is still valid................ update the post!
	if($valid){
		$query = "UPDATE posts
		SET
		title = '$title',
		body = '$body',
		is_published = $is_published,
		allow_comments = $allow_comments
		WHERE post_id = $post_id
		LIMIT 1";

		$result = $db->query($query);
		if(!$result){
			echo $db->error;
		}
		if($db->affected_rows == 1){
			$feedback = 'Success! Your picture has been saved.';
		}
	}//end if valid
	else{
		$feedback = 'There are problems with this form. Fix them.';
	}












}//end parser


 ?>