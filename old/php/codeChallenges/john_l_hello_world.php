<?php 
//error reporting, this is not needed on a production server
error_reporting(E_ALL & ~E_NOTICE);

 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Hello World!</title>
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
	<?php echo '<p>Hello World</p>'; ?> 
</body>
</html>