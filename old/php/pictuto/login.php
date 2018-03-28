<?php 
/**
 * stand-alone login form.
 * it does not load the normal site header so we need to manually include all dependencies here
 */
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require_once('db_connect.php');
include_once('functions.php');
//parser goes here
include_once('includes/login-parse.php');

 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-=1">
 	<title>Login in to Pictuto</title>
 	<link rel="stylesheet" type="text/css" href="css/login-style.css">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Libre+Franklin:200,400,700">
 </head>
 <body>
 	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" novalidate>
 		<!-- TODO: remove novalidate when done -->
 			<h1>Login to Pictuto</h1>
 			<?php 
 			show_feedback($feedback, $errors);
 			

 			 ?>

 			 <label for="the_email">Email Addresses</label>
 			 <input type="email" name="email" id="the_email" required value="">

 			 <label for="the_password">Password</label>
 			 <input type="password" name="password" id="the_password" required>
 			 <button id="show-hide">Show</button>

 			 <input type="submit" value="Login">
 			 <input type="hidden" name="did_login" value="1">

 	</form>
 	<footer>
 		<p>Pictuto uses cookies to enhance your experience.</p>
 		<a href="index.php">&larr; Back to Pictuto</a>
 		  |  
 		<a href="register.php">Register</a>

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