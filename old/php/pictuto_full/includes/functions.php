<?php 
//file for our helper functions

/*
*Convert any Datetime into a human readable format
*@param: $timestamp, datetime or timestamp format
*@since: ver 0.2
*/
function convert_date($timestamp){
	$date = new DateTime($timestamp);
	return $date->format('l, F j, Y');
	//see: http://php.net/manual/en/datetime.formats.date.php for complete reference 
}		


/*
*Set of helper functions to clean data before sending to database
*@param: $dirty, the raw data for cleaning
*@since: ver 0.2
*/
function clean_string($dirty){
	global $db;
	return mysqli_real_escape_string($db, filter_var($dirty, FILTER_SANITIZE_STRING));

}

function clean_email($dirty){
	global $db;
	return mysqli_real_escape_string($db, filter_var($dirty, FILTER_SANITIZE_EMAIL));

}

function clean_int($dirty){
	global $db;
	return mysqli_real_escape_string($db, filter_var($dirty, FILTER_SANITIZE_NUMBER_INT));
}

function clean_boolean($dirty){
	global $db;
	$clean = mysqli_real_escape_string($db, filter_var($dirty, FILTER_SANITIZE_NUMBER_INT));
	//if value is anything other than 1, change to 0
	if($clean != 1){
		$clean = 0;
	}
	return $clean;
}

/*
*Display the HTML success or error message, with a list of errors if needed
*@param: $show, boolean for whether or not to display the div and its success/error message
*@param: $message, string, default empty string
*@param: $list, array, default empty array
*since: ver 0.2
*update: ver 0.4
*/
function show_feedback($show = 0, $message = '', $list = array()){
//TODO:	fix function to show only when needed. 
//Shows div on page no matter what and I do not like that.
//consider passing the did_submit/did_register value as a way of determining when feedback is necessary.
if($show){

	if(isset($message)){
		
		if(!empty($list)){
			echo $list;
			$class='error';
		}else{
			$class = 'success';
		}
	}
?>
<div class="feedback <?php echo $class; ?>">
	<?php 
	//if the list is not empty, show it
	if(!empty($list)){
		echo '<ul>';
		foreach($list as $item){
			echo "<li>$item</li>";
			}//end foreach 
		echo '</ul>';	
	}//end if not empty
	else{
		//this fixes when there is a single set message.
		echo $message;
	}

	 ?>
</div>

<?php
	}//end if show is true;

}//end show_feedback

/*
*Display an image of appropriate size
@param: $post_id, int, default 0
@param: $size, sting, size of image(thumb, medium, or large )
@since: ver 0.2
*/

function image_url($post_id = 0, $size = 'medium'){
	global $db;
//get the image from the database
	$query = "SELECT image
			  FROM posts
			  WHERE post_id = $post_id
			  LIMIT 1";
	$result = $db->query($query);
	if(!$result){
		die($db->error);
	}		  	

	$row = $result->fetch_assoc(); //only one row of data, no while loop

	if($row['image']){
		echo 'uploads/'.$row['image'].'_'.$size.'.jpg';
	}


}

/*
Checks if user is logged in or not
@param: string, page to redirect user to
@returns: array containing all user info if logged in, false if not logged in
@since: ver 0.3
@updated: ver 0.4
*/
function check_login( $redirect = '' ){
			global $db;
			if( isset($_SESSION['user_id']) AND isset($_SESSION['secret_key']) ){
		//check for a match in the DB
				$sess_user_id = $_SESSION['user_id'];
				$sess_secret_key = $_SESSION['secret_key'];
//decided to focus on specific fields in user table so that the password(specifically) is not also pulled down. If I need additional fields to add to the return value, add them here.
				$query = "SELECT user_id, username, email, is_admin FROM users
				WHERE user_id = $sess_user_id
				AND secret_key = '$sess_secret_key'
				LIMIT 1";
				$result = $db->query($query);

				if( !$result ){
			//query failed. user is not logged in.
					if($redirect != ''){
						header("Location:$redirect");
					}
					return false;

				}

				if($result->num_rows == 1){
			//success - we have a logged in user! return all the info aout this user in an array
					return $result->fetch_assoc();
				}else{
			//credentials don't match. user is not logged in
					if($redirect != ''){
						header("Location:$redirect");
					}
					return false;
				}

			}else{
		//no session data. the user is not logged in
				if($redirect != ''){
					header("Location:$redirect");
				}
				return false;
			}	
		}


/*
*Display an image of appropriate size
@param: $user_id, int, no default - must be included
@param: $size, sting, size of image(thumb, medium, or large )
@since: ver 0.4
*/
function show_profile_pic( $user_id, $size = 'thumb' ){
	global $db;
	$query = "SELECT profile_pic FROM users
	WHERE user_id = $user_id
	LIMIT 1";
	$result = $db->query($query);
	if( $result->num_rows == 1 ){
		$row = $result->fetch_assoc();
			//show the image
		echo '<img src="'.SITE_URL.'/avatars/' . $row['profile_pic'] . '_' . $size . '.jpg" alt="Profile Picture" class="profile_pic">';
		
	}
}

/*
*Display the appropriate username
@param: $the_id, int, default 0
@since: ver 0.4
*/


function display_user_name($the_id = 0){
	global $db;
	$query = "SELECT email, username FROM users
	        WHERE user_id = $the_id
	        LIMIT 1";
	$result = $db->query($query);
	if($result->num_rows == 1){
		$row = $result->fetch_assoc();
		$name = $row['username'];
		$email = (explode('@', $row['email'])[0]);
		//explode separates at the character (in this case an @)
		if($name != ''){
			$display_name = $name;
		}else{
			$display_name = $email;
		}
		$result->free();
		return $display_name;
	}        
}

/*
Count the number of comments on anyh post
$post_id - int. any valid post ID
$one - string. text to show if there's one comment
$many - string. text to show if there are many or 0 comments
*/

function count_comments($post_id, $one = ' comment', $many = ' comments'){
	global $db;
	$query = "SELECT COUNT(*) AS total
	          FROM comments 
	          WHERE post_id = $post_id
	          AND is_approved = 1";
	$result = $db->query($query);

	if(!$result){
		$db->error;
	}

	if($result->num_rows >=1){
		//loop it
		while($row = $result->fetch_assoc()){
			if($row['total'] == 1){
				echo $row['total'].$one;
			}else{
				echo $row['total'].$many;
			}
		}
		$result->free();
	}

}//end count_comments

/*
show all the tags for any post
$post_id = int. any valid postg
*/
function show_post_tags($post_id){
 global $db;
 $query = "SELECT tags.*
 		   FROM tags, post_tags
 		   WHERE post_tags.post_id = $post_id
 		   AND post_tags.tag_id = tags.tag_id";
 		   $result = $db->query($query);

 		   if(! $result){
 		   	echo $db->errror;
 		   }
 		   if($result->num_rows>=1){
 		   	while($row=$result->fetch_assoc()){
 		   		$tags[] = '<a href="tag.php?tag_id='.$row['tag_id'].'">'.$row['tag_name'].'</a>';
 		   	}
 		   	$result->free();
 		   	if(!empty($tags)){
 		   	echo '<span class="tags">tagged: '.implode(', ', $tags).'</span>';
 		   }
 		 }else{
 		 	echo 'there are no tags for this post.';
 		 }  

}//end show post tags

/*
Count the number of likes on any post
*/
function count_post_likes($post_id){
	global $db;
	$query = "SELECT COUNT(*) AS likes
			  FROM likes
			  WHERE post_id = $post_id";
	$result_likes = $db->query($query);
	$row_likes = $result_likes->fetch_assoc();
	echo $row_likes['likes'];		  
}

//confirm the requested user id is a valid user
function confirm_valid_user($user_id){
//confirm this is a valid user in the db
	global $db;

	$query = "SELECT user_id
				   FROM users
				   WHERE user_id = $user_id";
	$result = $db->query($query);

	if($result->num_rows == 1){
		return true;
	}else{
		return false;
	}	



}


/*
*Display if user viewing the page liked this post or not
*@param: $user_id, int, current user's id
*@param: $post_id, int, current post id
*since: ver 0.9
*/
function you_like($user_id, $post_id){
//search likes table to see if current user liked current post.
	global $db;
	$query = "SELECT like_id
			  FROM likes
			  WHERE user_id = $user_id
			  AND post_id = $post_id
			  LIMIT 1";	  		  
	$result = $db->query($query);
	if($result->num_rows == 1){
		//user liked this post
		return 'you-liked';
	}else{
		return 'not-liked';
	}
}



//no close