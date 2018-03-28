<?php 
/**
 * stand-alone login form
 * it does not load the normal site header so we need to manually include all dependencies here
 */
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require_once('db_connect.php');
include_once('functions.php');
//INCLUDE PARSER
include_once('login-parse.php');

 ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="device-width, initial=1">
		<title>Login to BudgeTrkr</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" novalidate>
			<!-- TODO: REMOVE NOVALIDATE -->
			<h1>Login to BudgeTrkr</h1>
			<!-- <?php 
			show_feedback($feedback, $errors);
			 ?> -->

			<label for="the_username">Username</label>
			<input type="text" name="username" id="the_username" required value="">

			<label for="the_password">Password</label>
			<input type="password" name="password" id="the_password" required>
			<button id="show-hide">Show</button>

			<input type="submit" value="Login">
			<input type="hidden" name="did_login" value="1">

		</form>
		<footer>
			<p>BudgetTrkr uses cookies to enhance your experience.</p>
			<a href="index.php">&larr; Back to BudgeTrkr</a>  |  <a href="register.php">Register</a>
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