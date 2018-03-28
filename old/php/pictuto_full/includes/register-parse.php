<?php
//parse the register form if it was submitted
if( $_POST['did_register'] ){
//var_dump($_POST);	
	//sanitize every input
	$username 	= clean_string( $_POST['username'] );
	$email 		= clean_email( $_POST['email'] );
	$password 	= clean_string( $_POST['password'] );
	$policy 	= clean_int( $_POST['policy'] );
	$show       = clean_boolean($_POST['did_register']); 
	
	//validate
	$valid = true;
		//username is blank or more than 40 chars
		if(strlen($username) > 40 ){
			$valid = false;
			$errors['username'] = 'Username must be within 1 - 40 characters long';
		}elseif($username != ''){
			//username is already taken	
			$query = "SELECT username FROM users
						WHERE username = '$username'
						LIMIT 1";
			$result = $db->query($query);
			//if one result found, the username is already taken!
			if( $result->num_rows == 1 ){
				$valid = false;
				$errors['username'] = 'That username is already taken. Try another';
			}
		} //end of username tests
		
		//email is blank or invalid format
		if( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
			$valid = false;
			$errors['email'] = 'Please provide a valid email address';
		}else{
			//email is already taken	
			$query = "SELECT email FROM users 
						WHERE email = '$email'
						LIMIT 1";
			$result = $db->query($query);
			if( $result->num_rows == 1 ){
				$valid = false;
				$errors['email'] = 'That email is already registered. Do you want to login?';
			}
		} //end of email tests
		
		//password less than 7 chars
		if( strlen( $password ) < 7 ){
			$valid = false;
			$errors['password'] = 'Choose a password that is longer than 7 characters';
		}
		//if the policy box is not checked
		if( $policy != 1 ){
			$valid = false;
			$errors['policy'] = 'Please agree to the terms of service before registering';
		}
	//if valid, add the user to the DB
	if( $valid ){
		//hash the password before storage
		$password = sha1($password . SALT );
		$query = "INSERT INTO users
					( username, password, email, is_admin, join_date, profile_pic )
					VALUES
					( '$username', '$password', '$email', 0, now(), 'avatar' )";
		echo $query;
					
		$result = $db->query($query);
		//if that works, redirect to the login form
		if( $db->affected_rows == 1 ){
			//success. redirect to login
			header('Location:login.php');
		}else{
			$feedback = 'Sorry, Your account could not be created at this time.';
		}
	}else{
		$feedback = 'Please fix the following errors:';
	}//end if valid
	
}//end parser

//no need to close PHP