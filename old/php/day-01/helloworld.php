<?php 

$name = $_GET['name'];

if(isset($name)){
	$name = $name;
}else{
	$name = 'World';
}
var_dump($_GET);
var_dump($_SERVER);

 ?>
<!DOCTYPE html>
<html>
	<head>
 		<meta charset="utf-8">
 			<title>PHP HELLO WORLD</title>
 	<style type="text/css">
 		body{font-family:Verdana;}
 	</style>
 	</head>
 <body>
 	<h1>
 		<?php echo "Hello $name";
 		//echo 'Hello '.$name
 	 ?>
 	</h1>
 </body>
 </html>