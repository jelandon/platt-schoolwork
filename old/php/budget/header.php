<?php
session_start();//allows acces to sessions

require_once('db_connect.php');
$logged_in_user = check_login();
 ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>BudgeTrckr</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/normalize.css">
	</head>
	<body>
		<header class="cf">
			<a class="logo" href="index.php">
				<img src="images/budgeTrckrLogo.png" alt="BudgeTrckr Logo">
			</a>
			<nav>
				<ul class="menu">
					<!-- if user is not logged on show this part of nav -->
					<?php if(! $logged_in_user){  ?>
						<!-- stuff anyone can see -->
						<li><a href="login.php">Login</a></li>
						<li><a href="register.php">Register</a></li>
					<?php }else{ ?>
						<!-- if user is logged on show this stuff that only logged in people can see -->
						<li><a href="budget.php?user_id=<?php echo $logged_in_user['user_id']; ?>">My Budget</a></li>
						<li><a href="add_transaction.php?user_id=<?php echo $logged_in_user['user_id']; ?>">Add a Transaction</a></li>
						<li><a href="login.php?action=logout">Log Out</a></li>
					<?php } ?>
				</ul>
			</nav>
		</header>
		<div class="wrapper cf"><!-- no close div -->
