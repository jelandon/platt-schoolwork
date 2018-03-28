<?php  
/*
list of helper functions
*/


/**
*Convert any Datetime into a human readable format
*@param: $timestamp, datetime or timestamp format
*@since: V0.2
*/
function convert_date($timestamp){
	$date = new DateTime($timestamp);
	return $date->format('l, F j, Y');
//see: http://php.net/manual/en/datetime.formats.date.php for complete reference 
}

/**	
*Set of helper functions to clean data before sending to the database:
*@param $dirty, the raw data for cleaning
*@since ver 0.25
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
	$clean = filter_var($dirty, FILTER_SANITIZE_NUMBER_INT);
	//if value is anything other than 1, change to 0
	if($clean !=1){
		$clean = 0;
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
*checks to see if user is logged in or not
*@param: $redirect - string, page to redirect user to
*@returns: array containing all user info if logged in, false if not logged in
*@since: ver 0.1
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












//no close php