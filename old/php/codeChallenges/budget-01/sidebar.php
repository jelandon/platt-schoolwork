<aside class="sidebar">
	<h2>Login to track your budget</h2>
	<!-- if user is not logged on show this part of nav -->	
	<?php if(! $logged_in_user){  ?>
		<!-- stuff anyone can see -->
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<?php show_feedback($feedback, $errors); ?>
			<label for="username">
				<input type="text" name="username" id="username" placeholder="Username" required>
				<span>Username</span>
			</label>

			<label for="password">
				<input type="password" name="password" id="password" placeholder="Password" required>
				<span>Password</span>
			</label>
			<button id="show-hide">Show</button>

			<input type="submit" value="Login">
			<input type="hidden" name="did_login" value="1">
	</form>
	<?php }else{ ?>
		<!-- if user is logged on show this stuff that only logged in people can see -->
		<a href="add_post.php?user_id=<?php echo $logged_in_user['user_id']; ?>">Add A Picture</a>
		<a href="budget.php?user_id=<?php echo $logged_in_user['user_id']; ?>">My Budget</a>
		<a href="login.php?action=logout">Log Out</a>
		<?php } ?>			
		


</aside>