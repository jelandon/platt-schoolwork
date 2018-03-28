<?php 
//error reporting, this is not needed on a production server
error_reporting(E_ALL & ~E_NOTICE);

if($_POST['did_submit']){
//	var_dump($_GET);
	$name=$_POST['name'];
	$quest=$_POST['quest'];
	$color=$_POST['color'];
	$message= "<p>$name, seeker of $quest, I hope you find what you are looking for in $color.</p>";
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
	<?php echo $message; ?>
	<h1>Gatekeeper's Questions</h1>
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
		<label for="the_name">What is your name?</label>
		<input type="text" name="name" id="the_name" placeholder="Your name, good sir">

		<label for="quest">What is your quest?</label>
		<input type="text" name="quest" id="quest" placeholder="What do you seek?">

		<label for="color">What is your favorite color?</label>
		<input type="text" name="color" id="the_color" placeholder="This one is easy">

		<input type="hidden" name="did_submit" value="true">
		<input type="submit" value="I am unafraid">
	</form>

</body>
</html>