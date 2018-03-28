<?php
	//INCLUDE PARSER
	include_once('login-parse.php');
?>
<aside class="sidebar">
	<h2>Login to track your budget</h2>
	<!-- if user is not logged on show this part of nav -->
	<?php if(! $logged_in_user){  ?>
		<!-- stuff anyone can see -->
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
	<?php }else{ ?>
		<!-- if user is logged on show this stuff that only logged in people can see -->
		<a href="budget.php?user_id=<?php echo $logged_in_user['user_id']; ?>">My Budget</a>
		<a href="login.php?action=logout">Log Out</a>
		<?php } ?>



</aside>
