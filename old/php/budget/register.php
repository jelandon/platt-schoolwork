<?php
/**
 * stand-alone register form
 * it does not load the normal site header so we need to manually include all dependencies here
 */
error_reporting(E_ALL & ~E_NOTICE);
require_once('db_connect.php');
include_once('functions.php');
//INCLUDE PARSER
include_once('register-parse.php');

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
			<h1>Create an Account</h1>
			<p>Sign up to start tracking your budget</p>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get"> <!-- TODO: CHANGE TO POST -->
				<?php show_feedback($feedback, $errors); ?>
				<div class="styled-input">
					<input type="email" name="email" id="email" required>
					<label for="email">Enter your email address</label>
					<span class="hint">This is required.</span>
				</div>
				<div class="styled-input">
					<input type="text" maxlength="40" name="username" id="username" required>
					<label for="username">Enter a Username</label>
					<span class="hint">Username must be under 40 characters long.</span>
				</div>
				<div class="styled-input">
					<input type="password" name="password" id="password" required>
					<button id="show-hide">Show</button>
					<label for="password">Password</label>
					<span class="hint">Password must be at least 7 characters long.</span>
				</div>
				<div class="styled-input">
					<input type="password" name="password2" id="password2" required>
					<button id="show-hide2">Show</button>
					<label for="password2">Verify Password</label>
					<span class="hint">Password must be at least 7 characters long.</span>
				</div>
				<div class="checkbox">
 					<input type="checkbox" name="policy" value="1" required>
					 <label for"checkbox"></label>
					<p>Yes I agree to the <a href="#">Terms of Service</a></p>
				</div>
				<input type="submit" value="Register">
				<input type="hidden" name="did_register" value="1">
			</form>
		</div>
		<footer>
			<a href="index.php">&larr; Back to BudgeTrckr</a>  |  <a href="login.php">Login</a>
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

			var pwBox2 = document.querySelector('#password2');
			var showBtn2 = document.querySelector('#show-hide2');

			showBtn2.onclick = function(f){
				f.preventDefault();
				var theType = pwBox2.getAttribute('type');
				console.log(theType);
				if(theType == 'password'){
					theNewType = 'text';
					theText = 'Hide';
				}else{
					theNewType = 'password';
					theText = 'Show';
				}
				pwBox2.setAttribute('type', theNewType);
				this.textContent=theText;
			}
		</script>
	</body>
</html>
