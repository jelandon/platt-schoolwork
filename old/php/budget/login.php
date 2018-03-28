<?php
/**
 * stand-alone login form
 * it does not load the normal site header so we need to manually include all dependencies here
 */
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require_once('db_connect.php');
//INCLUDE PARSER
include_once('login-parse.php');

 ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="device-width, initial=1">
		<title>Login to BudgeTrckr</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<div class="modal">
			<h1>Login to BudgeTrckr</h1>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<?php show_feedback($feedback, $errors); ?>
				<div class="styled-input">
					<input type="text" name="username" id="username" required>
					<label for="username">Username</label>
				</div>
				<div class="styled-input">
					<input type="password" name="password" id="password" required>
					<button id="show-hide">Show</button>
					<label for="password">Password</label>
				</div>
				<input type="submit" value="Login">
				<input type="hidden" name="did_login" value="1">
			</form>
		</div>
		<footer class="login">
			<p>BudgeTrckr uses cookies to enhance your experience.</p>
			<a href="index.php">&larr; Back to BudgeTrckr</a>  |  <a href="register.php">Register</a>
		</footer>
		<script type="text/javascript">
			var pwBox = document.querySelector('#password');
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
	</body>
</html>
