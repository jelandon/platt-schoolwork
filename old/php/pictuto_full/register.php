<?php 
/*
stand-alone register form.
It does not load the normal site header, 
so we need to manually include all dependencies here:
 */
error_reporting( E_ALL & ~E_NOTICE ); 
require('includes/db-connect.php');
include_once('includes/functions.php');

include('includes/register-parse.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register for an account</title>
	<link rel="stylesheet" type="text/css" href="css/login-style.css">
	<link href="https://fonts.googleapis.com/css?family=Libre+Franklin:200,400,700" rel="stylesheet">
</head>
<body>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" novalidate>
	<h1>Create an Account</h1>
	<p>Sign up and share your pictures with friends</p>
		<?php 
		//TODO: Update show_feedback
		show_feedback( $show, $message, $errors );
		?>
	<label for="the_username">Choose a Username</label>
	<input type="text" name="username" maxlength="40" id="the_username" value="<?php echo $username; ?>">
	<span class="hint">Username must be under 40 characters long. Username is not required.</span>	

	<label for="the_email">Email Address</label>
	<input type="email" name="email" id="the_email" required value="<?php echo $email; ?>">
	<span class="hint">This is Required.</span>

	<label for="the_password">Password</label>
	<input type="password" name="password" id="the_password" required>
	<span class="hint">Password must be at least 7 characters long</span>

	<label>
		<input type="checkbox" name="policy" value="1" required>
		Yes, I agree to the <a href="#">terms of service</a>.
	</label>

	<input type="submit" value="Register">
	<input type="hidden" name="did_register" value="1">
</form>
<footer><a href="index.php">&larr; Back to Pictuto</a> | <a href="login.php">Login</a></footer>

</body>
</html>