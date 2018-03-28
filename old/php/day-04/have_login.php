<?php 

session_start(); //opens or resumes session

error_reporting(E_ALL & ~E_NOTICE); //suppresses minor non-page fail errors

//work w/ post data here:
if($_POST['did_login']){
	//was an attempt made to login? if yes, parse data
	$username=filter_var($_POST['username'], FILTER_SANITIZE_STRING);
	$password=filter_var($_POST['password'], FILTER_SANITIZE_STRING);

	//THESE ARE FAKE CREDENTIALS TO COMPARE AGAINST (normally these values would be retrieved from the database and the password encrypted w/ SHA1 or MDBSS)

	$correct_username = 'jelandon';
	$correct_password = 'password';

	if($username == $correct_username AND $password == $correct_password){
	//if this is true, the log in is successful!
	setcookie('loggedin', true, time()+60*60*24*7);
	setcookie('username', $username, time()+60*60*24*7);
	$_SESSION['loggedin'] = true;
	$_SESSION['username'] = $username;

	$message = 'You are now logged in.';
	}else{
	$message = 'Your username and password combination did not match.';
	}//end check user/pass



}

//for logging out:
if($_GET['action'] == 'logout'){
	if(ini_get("session.use-cookies")){
		//gets the cookies and sets them back
		$params = session_get_cookie_params();
		setcookie(session_name(), null, time()-42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
	}
	session_destroy();
	unset($_SESSION['loggedin']);
	unset($_SESSION['username']);
		setcookie('loggedin', null);
		setcookie('username', null);
}elseif($_COOKIE['loggedin']){
	//if the user did not logout - the cookie will remember the user and set the session back to true
	$_SESSION['loggedin'] = true;
	$_SESSION['username'] = $_COOKIE['username'];
}


 ?>




<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Post My Data</title>
	<style type="text/css">
		body{
			font-family: Verdana;
			font-size: 16px;
		}
		input{
			display: block;
			margin: 1em 0;
		}
	</style>
</head>
<body>
	<?php 
		if($_SESSION['loggedin']){
			echo $message;
			include('content-loggedin.php');
		}else{
//if user is not logged in

	 ?>
	<h1>Log in to your account</h1>
	<?php echo $message; ?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<label for="username">Username:</label>
		<input type="text" name="username" id="username" placeholder="Username">
		<label for="password">Password</label>
		<input type="password" name="password" id="password" placeholder="password"></label>
		<input type="hidden" name="did_login" value="true">
		<input type="submit" value="Log In!">
	</form>
	<?php 
		}//end if user is not logged in
	 ?>
</body>
</html>