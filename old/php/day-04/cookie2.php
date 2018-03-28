<?php 
//error reporting, this is not needed on a production server
error_reporting(E_ALL & ~E_NOTICE);


if(isset($_COOKIE['question']) AND isset($_COOKIE['answer'])){
	echo $_COOKIE['question'].'<br>'.$_COOKIE['answer'];
	setcookie("question","",time()-(60*60));
	setcookie("answer","",time()-(60*60));
	echo '<br>Refresh the page to see what happens.';
}else{
	echo 'no requested cookies were found. Try the next page: <a href="cookie1.php">Cookie Page 1</a>';
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