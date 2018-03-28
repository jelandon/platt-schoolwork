<?php 
session_start(); //allows us to access sessions

require_once('db_connect.php');
$logged_in_user = check_login();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-=1">	
	<title>Pictuto - Powered by PHP &amp; MySQL</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Libre+Franklin:200,400,700">
</head>
<body>
	<header>
	<!-- image width: 198, height: 57 -->
	<a class="logo" href="index.php">LOGO GOES HERE</a>
	</header>
	<nav class="main-navigation wrapper">
		<section class="search-bar">
			<form action="search.php">
				<label class="screen-reader-text">Search:</label>
				<input type="search" name="phrase" value="" placeholder="Search">
				<button type="submit">Search</button>
			</form>
		</section>
		<ul class="menu">
		<!-- if user is not logged on show this part of nav -->	
		<?php if(! $logged_in_user){  ?>
		<!-- stuff anyone can see -->
		<li><a href="login.php">Log In</a></li>
		<li><a href="register.php">Register</a></li>
		<?php }else{ ?>
		<!-- if user is logged on show this stuff that only logged in people can see -->
		<li><a href="add_post.php?user_id=<?php echo $logged_in_user['user_id']; ?>">Add A Picture</a></li>
		<li><a href="profile.php?user_id=<?php echo $logged_in_user['user_id']; ?>">My Profile</a></li>
		<li><a href="login.php?action=logout">Log Out</a></li>
		<?php } ?>			
		</ul>
	</nav>
	<div class="wrapper">