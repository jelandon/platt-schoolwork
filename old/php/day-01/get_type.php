<?php 
//$my_var = $_GET['blah'] gives me a warnimg because I am usiong a variable to set the valuej of another variable.

$my_var = 'I am a string';
echo $my_var.'<br>';
echo gettype($my_var).'<br>';
$my_var = 5; //reassigns the variable's value
echo $my_var.'<br>';
echo gettype($my_var).'<br>'; //integer
$my_var += 2.5; //adds to the current value and reassigns it
echo $my_var.'<br>'; //7.5
echo gettype($my_var).'<br>'; //double
$my_var = ['I',  'am', 'an', 'array'];
var_dump($my_var);
echo '<br>';
echo $my_var.'<br>';
echo gettype($my_var).'<br>'; //
$my_var = implode('|', $my_var);
echo $my_var.'<br>';
echo gettype($my_var).'<br>';


 ?>