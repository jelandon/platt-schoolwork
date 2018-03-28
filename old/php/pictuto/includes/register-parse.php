<?php 

if($_POST['did_register']){
	//sanitize the data
	$username = trim(clean_string($_POST['username']));
	$email = trim(clean_email($_POST['email']));
	$password = trim(clean_string($_POST['password']));
	$policy = clean_int($_POST['policy']);
	//validate
	$valid = true;

	//username tests:
	if($username != '' AND strlen($username)>40){
		$valid = false;
		$errors['username'] = 'User must be less than 40 characters long.';
	}elseif($username != ''){
		//usernames msut be unique
		$query = 	"SELECT username
					FROM users
					WHERE username = '$username'
					LIMIT 1";
		$result = $db->query($query);
		//if a result is found...
		if($result->num_rows == 1){
			$valid = false;
			$errors['username'] = 'That username is already taken. Try another.';
		}
	}elseif($username == ''){
		$valid = false;
		$errors['username'] = 'You need to enter a username.';
	}

	//email tests: is it blank or invalid?
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$valid = false;
		$errors['email'] = 'Please provide a valid email address.';
	}else{
		$query = 	"SELECT email
					FROM users
					WHERE email = '$email'
					LIMIT 1";
		$result = $db->query($query);
		if($result->num_rows==1){
			$valid = false;
			$errors['email'] = 'That email is already registered. Do you want to login?';
		}
	}

	//password check: is it 8 or more characters?
	if(strlen($password)<8){
		$valid = false;
		$errors['password'] = 'Choose a password longer than 7 characters.';
	}

	//policy box checked
	if($policy != 1){
		$valid = false;
		$errors['policy'] = 'Please agree to the terms of service before registering.';
	}
	//if valid is still true, add the user to the db
	if($valid){
		//pepper and hash our password before storage
		$password = sha1($password.PEPPER);
		$query =	"INSERT into users
					(username, password, email, is_admin, join_date, profile_pic)
					VALUES
					('$username', '$password', '$email', 0, now(), 'avatar')";
		$result = $db->query($query);

		//if it works, we will have an affected row
		if($db->affected_rows == 1){
			//success!
			header('Location:login.php');
			//on a production/live server like hostgator, you may have to change the output buffering. (ob_start())
		}else{
			$feedback = 'Sorry, your account could not be created at this time.';
		}


	}else{
			//if not valid...
			$feedback = 'Please fix the following errors:';
		}



}




//no close php