<?php 
$today = date('l');
$favorite_food = 'Choco Taco';

//function example
function do_something( $tag ='p' , $content = 'I just did something'){
	echo "<$tag class='awesome'>";
	echo $content;
	echo "</$tag>";
}

//array example
$pizza = array(
	'crust'		=> 'Whole Wheat',
	'sauce'		=> 'Pizza Sauce',
	'cheese'	=> 'Three Cheese Blend',
	'toppings'	=> array('Sausage', 'Ricotta', 'Red Peppers'),
	'deep_dish'	=> false,
	'slices'	=> 8,

);



//add another thing
	$pizza['size'] = 'Extra Large';
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>My First PHP File</title>
	<style type="text/css">
		.awesome{
			color: hotpink;
		}
		.main-menu{
			background-color: grey;
		}
	</style>
</head>
<body>
	Hello World!
	<br>
	<?php include('menu.php'); ?>
	<?php //work with the array
	echo $pizza['toppings'][0];
	echo '<pre>';
	print_r ($pizza);
	echo '</pre>';

	//example foreach loop (for each thin in an 
	$shopping = array ('milk', 'eggs', 'beer', 'donuts');

	echo '<ul class="shopping">';

	foreach( $shopping as $item){
		echo "<li> $item </li>";
	}
	echo '<ul>';

	?>


	<h1><?php

	//this is a comment

	/*
	block comment
	*/

	# another comment

	echo date('Y');

	?></h1>


	<?php $theYear = '<h1>' . date('Y') . '</h1>';

	echo $theYear;
	 ?>
	 <?php 
	 if( 'Friday' == $today){
	 	echo "<h2>$favorite_food</h2>";
	 }else{
	 	echo 'No ' . $favorite_food . ' for you!';
	 } ?>
	 <?php 
	 do_something();
	 do_something( 'h1' , 'second arg' );
	 do_something( 'h2' );
	 do_something( 'h3' );
	 do_something( 'h4' );
	 do_something( 'h5' );
	 do_something( 'h6' );
	  ?>
</body>
</html>