<?php 

//logout action TODO
if( isset($_GET['action']) AND $_GET['action'] == 'logout'){
//close the session and associated cookies. This snippet is from PHP.net
	if(ini_get("session.use_cookies")){
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time()-42000,
		$params["path"], $params["domain"],
		$params["secure"], $params["httponly"]	
	);
	}
	session_destroy();

	//erase all session vars and cookies
	$_SESSION['user_id'] = '';
	setcookie('user_id', '', time()-42000);

	$_SESSION['secret_key'] = '';
	setcookie('secret_key', '', time()-42000);
} //end of logout section


//if the form was submitted, parse it
error_reporting(E_ALL & ~E_NOTICE); 
if($_POST['did_login']){
//extract and clean the data:
	$username = trim(clean_string($_POST['username']));
	$password = trim(clean_string($_POST['password']));
	var_dump($_POST);
//validate the data:
	$valid = true;

//check email:
	if($username == ''){
		$valid = false;
		$errors['username'] = 'You did not enter a username.';
	}
	if(strlen($password)< 8){
	 $valid = false;
	 $errors['password'] = 'Password too short.';	
	}
echo $valid;
//if still valid, check credentials against the DB
if($valid){
	$password = sha1($password.PEPPER);
	$query = "SELECT user_id
	          FROM users
	          WHERE password = '$password'
	          AND username = '$username'
	          LIMIT 1";
	 echo $query;
	$result = $db->query($query);

 	//send the user to the home page if they got it right
 	if($result->num_rows == 1){
 		//we found a username and pw that match!
 		$secret_key = sha1(microtime().PEPPER);

 		$row = $result->fetch_assoc();
 		$user_id = $row['user_id'];

 		//store the key in the db for THIS user

 		$query = "UPDATE users
 				  SET secret_key = '$secret_key'
 				  WHERE user_id = $user_id"; 
 		$result = $db->query($query);
 		
 		//make sure the query works....
 		if($db->affected_rows == 1){
 			$expiration = time() + 60*60*24; //one day
 			setcookie('secret_key', $secret_key, $expiration);
 			$_SESSION['secret_key'] = $secret_key;

 			setcookie('user_id', $user_id, $expiration);
 			$_SESSION['user_id'] = $user_id;

 			//send to budget page:
 			header('Location:budget.php');
 		}else{
 			$error_message = 'no rows affected.';
 		}		  

 	}else{
 		//no rows of results from db - no match!
 		$error_message = 'Sorry, your email/password combination is incorrect. Try again.';
 	}


 }else{
 	//if not valid:
 	$error_message = 'Sorry. You made some errors. Fix them.';
 }

}











//no close