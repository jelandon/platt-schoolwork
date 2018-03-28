<?php 
/**
 * list of helper functions
 */

/**
 * Convert any Datetime into a human readable format
 * @param : $timestamp, datetime or timestzmp format
 * @since : v0.2
 */

function convert_date($timestamp){
	$date = new DateTime($timestamp);
	return $date->format('l, F j, Y'); //from php.net/manual/en/datetime.formats.date.php
}

/**
 * Set of helper functions to clean data before sending to the database:
 * @param , $dirty, the raw data for cleaning
 * @since ver 0.25
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
	//return mysqli_real_escape_string($db, filter_var($dirty, FILTER_SANITIZE_NUMBER_INT));
	$clean = filter_var($dirty, FILTER_SANITIZE_NUMBER_INT);
	//if value is anything other than 1, change to 0
	if($clean !=1){
		$clean=0;
	}
	return $clean;
}

/**
 * Display the HTML success or error message with a list of error if needed
 * @param $message, string: default empty string
 * @param :$list, array: default empty array
 */

function show_feedback($message='', $list = array()){
	if(isset($message)){
		$class = 'success';
		if(!empty($list)){
			$class = 'error';
		}
	}//end if isset


?>

<div class="feedback <?php echo $class; ?>">
	<?php 
	//if the list is not empty, show it
	if(!empty($list)){
		echo '<ul>';
		foreach ($list as $item){
			echo "<li>$item</li>";
		}
		echo '</ul>';
	}//end if not empty
	 ?>	

</div>


<?php 

}//end show_feedback

/**
 * Display an image of appropriate size
 * @param $pic_id, int, default: 0
 * @param $size, string, size of image (thumb, medium or large)
 * @since  ver 0.25
 */
function image_url($post_id = 0, $size = 'medium'){
	global $db;
	//retrieve image from database
	$query = "SELECT image
				FROM posts
				WHERE post_id = $post_id
				LIMIT 1";
	$result = $db->query($query);
	if(!$result){
		die($db->error);
	}
	$row = $result->fetch_assoc(); //only one row of data, no need to while away

	if($row['image']){
		echo 'uploads/'.$row['image'].'_'.$size.'.jpg';
	}
}



/**
*checks to see if user is logged in or not
*@param: $redirect - string, page to redirect user to
*@returns: array containing all user info if logged in, false if not logged in
*@since: ver 0.4
*/

function check_login($redirect = ''){
	global $db;
	if(isset($_SESSION['user_id']) AND isset($_SESSION['secret_key'])){
		//check for a match in the db
		$sess_user_id = $_SESSION['user_id'];
		$sess_secret_key = $_SESSION['secret_key'];

		$query = "SELECT user_id, username, email, is_admin
		          FROM users
		          WHERE user_id = $sess_user_id
		          AND secret_key = '$sess_secret_key'
		          LIMIT 1";        
		$result = $db->query($query);
		          if($result->num_rows == 0){
		          	//query returned no rows
		          	if($redirect != ''){
		          		header("Location:$redirect");
		          	}
		          	return false;
		          }

		          if($result->num_rows == 1){
		          	//we have a logged in user
		          	return $result->fetch_assoc();
		          }
	//end of if isset	          
	}else{
		//no session data, no logged in user
		if($redirect != ''){
			header("Location:$redirect");
		}
		return false;
	}	

}

/**
 * @param : $user_id, int, no default, must b e included
 * @param $user_id int, no default, must be included
 * @param $size, string, size of image (thumb, medium or large)
 * @since ver 0.5
 */
function show_profile_pic($user_id, $size = 'thumb'){
	global $db;

	$query =	"SELECT profile_pic
				FROM users
				WHERE user_id = $user_id
				LIMIT 1";

	$result = $db->query($query);
	if($result->num_rows == 1){
		$row = $result->fetch_assoc();
		//show the image:
		echo '<img src="'.SITE_URL.'avatars/'.$row['profile_pic'].'_'.$size.'.jpg'.'" alt="Profile Picture" class="profile_pic">';
	}
}

/**
 * Display appropriate username
 * this uses the email address to create a username adhoc
 * @param: $the_id, int, default 0
 * @since: ver 0.5
 */
function display_user_name($the_id = 0){
	global $db;
	$query =	"SELECT email, username
				FROM users
				WHERE user_id = $the_id
				LIMIT 1";
	$result = $db->query($query);
	if ($result->num_rows == 1){
		$row = $result->fetch_assoc();
		$name = $row['username'];
		$email = (explode('@', $row['email'])[0]);
		//explode and separates at the character (in this case the @)
		if($name != ''){
			$display_name = $name;
		}else{
			$display_name = $email;
		}
		$result->free();
		return $display_name;
	}
}

/**
 * Count the number of comments on any post/pic
 * @param $post_id, int. any valid post_id
 * @param $one, string. Text to show if there's one comment
 * @param $many, string. Text to show of there are many or no comments
 * @since ver 0.5
 */

function count_comments($post_id, $one = ' comment', $many = ' comments'){
	global $db;

	$query="SELECT COUNT(*) AS total
			FROM comments
			WHERE post_id = $post_id
			AND is_approved = 1";
	$result = $db->query($query);

	if(!$result){
		$db->error;
	}

	if($result->num_rows >=1){
		//loop it:
		while($row = $result->fetch_assoc()){
			if($row['total'] == 1){
				echo $row['total'].$one;
			}else{
				echo $row['total'].$many;
			}
		}
		$result->free();
	}

}//end count comments


/**
 * Display if user viewing the page liked this post or not
 * @param: $$user_id, int, the current user's id
 * @param: $post_id, int, the current post
 * @since ver 0.6 
 */

function you_like($user_id=0, $post_id=0){
	global $db;
	$query="SELECT like_id
			FROM likes
			WHERE user_id = $user_id
			AND post_id = $post_id
			LIMIT 1";
	$result = $db->query($query);
	if($result->num_rows == 1){
		//this user liked this picture
		return 'liked';
	}else{
		return 'like';
	}


}

//no close PHP