<?php  
error_reporting(E_ALL & ~E_NOTICE); 
//error suppression probably not needed on a live/production server
session_start();
require_once('db-connect.php'); //sibling to header
require_once('functions.php'); //sibling to header
$logged_in_user = check_login();
?>
<!DOCTYPE html>
<html>
<head>
	<?php  
	//TODO: After debugging is done, comment out all this stuff...
		echo '<!-- ';
		//let's see what we can use
		echo "session data:";
		var_dump($_SESSION);
		//secret_key, user_id
		echo "cookie data:";
		var_dump($_COOKIE);
		//secret_key, user_id, phpsessid
	    echo "logged_in_user data:";
		var_dump($logged_in_user);//user_id, username, email, is_admin,
		echo '-->'
	?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pictuto - Powered by PHP &amp; MySQL</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Libre+Franklin:200,400,700">
	<!-- RSS Feed? -->
</head>
<body>
<header class="header">
	<a class="logo" href="index.php"><img src="images/logo.svg" width="198" height="57"></a>
</header>
<nav class="main-navigation wrapper">
<section class="search-bar">
	<form action="search.php">
	<label class="screen-reader-text">Search:</label>
	<input type="search" name="phrase" value="" placeholder="Search">
	<button type="submit"><img src="images/search.svg" width="22" height="24"></button>
	</form>
</section>
<ul class="menu">
<!-- stuff anyone can see -->
			<?php if(!$logged_in_user){ ?>
			<li><a href="login.php">Login</a></li>
			<li><a href="register.php">Register</a></li>

			<!-- Stuff only logged in people can see -->
			<?php }else{ ?>
			<li><a href="add-post.php">Add a post</a></li>
			<li><a href="profile.php?user_id=<?php echo $logged_in_user['user_id'] ?>">My Profile</a></li>
			<li><a href="login.php?action=logout">Logout</a></li>
			<?php } ?>
		</ul>
</nav>
<div class="wrapper"><!--closes at footer-->
