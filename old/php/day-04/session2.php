<?php 
//error reporting, this is not needed on a production server
error_reporting(E_ALL & ~E_NOTICE);


session_start(); //required any time you want to access sessions. Should be at top of page

$_SESSION['question'] = "What happens when you throw a green stone in the red sea?";
$_SESSION['answer'] = 'It gets wet!';

if(isset($_SESSION['question']) AND isset($_SESSION['answer'])){
//	echo$_SESSION['question'].'<br>'.$_SESSION['answer'].'<br><a href="session2.php">Session 2</a>';

	unset($_SESSION['question']);
	unset($_SESSION['answer']);
	session_unset();
	session_destroy(); //disconnectxs us from session data
	echo 'Your sessions have been destroyed. Come back to the <a href="session2.php">Session2</a> page to see how this works.';
}else{
	echo 'Your sessions are not set. To reset your sessions, go to <a href="session1.php">Session1</a>';
}

 ?>




<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Post My Data</title>
	<style type="text/css">
		body{
			font-family: Verdana;
			font-size: 16px;
		}
		input{
			display: block;
			margin: 1em 0;
		}
	</style>
</head>
<body>
	
</body>
</html>