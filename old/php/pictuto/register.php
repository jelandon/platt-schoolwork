<?php 
/**
 * stand-alone register form.
 * it does not load the normal site header so we need to manually include all dependencies here
 */
error_reporting(E_ALL & ~E_NOTICE);
require_once('db_connect.php');
include_once('functions.php');
//parser goes here
include_once('includes/register-parse.php');

 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-=1">
 	<title>Register for an Account</title>
 	<link rel="stylesheet" type="text/css" href="css/login-style.css">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Libre+Franklin:200,400,700">
 </head>
 <body>
 	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" novalidate>
 		<!-- TODO: remove novalidate when done -->
 			<h1>Create an Account</h1>
 			<p>Sign up and share to your pictures with your friends.</p>
 			<?php 
 			show_feedback($feedback, $errors);
 			

 			 ?>
 			 <label for="the_username">Choose a Username</label>
 			 <input type="text" name="username" maxlength="40" required id="the_username" value="">
 			 <span class="hint">Username must be under 40 characters long.</span>

 			 <label for="the_email">Email Addresses</label>
 			 <input type="email" name="email" id="the_email" required value="">
 			 <span class="hint">This is required.</span>
 			 <label for="the_password">Password</label>
 			 <input type="password" name="password" id="the_password" required>
 			 <button id="show-hide">Show</button>
 			 <span class="hint">Password must be at least 7 characters long.</span>
 			 <label>
 			 	<input type="checkbox" name="policy" value="1" required>
 			 	Yes I agree to the <a href="#">Terms of Service</a>
 			 </label>

 			 <input type="submit" value="Register">
 			 <input type="hidden" name="did_register" value="1">

 	</form>
 	<footer>
 		<a href="index.php">&larr; Back to Pictuto</a>
 		  |  
 		<a href="login.php">Login</a>

 	</footer>
 </body>
<script type="text/javascript">
	var pwBox = document.querySelector('#the_password');
	var showBtn = document.querySelector('#show-hide');

	showBtn.onclick = function(e){
		e.preventDefault();
		var theType = pwBox.getAttribute('type');
		console.log(theType);
		if(theType == 'password'){
			theNewType = 'text';
			theText = 'Hide';
		}else{
			theNewType = 'password';
			theText = 'Show';
		}
		pwBox.setAttribute('type', theNewType);
		this.textContent=theText;
	}


</script>










 </html>