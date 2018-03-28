<?php 

/*
Database connection credentials
The whole site connects through here
 */


//minor error reporting, this is not needed on a production server
error_reporting(E_ALL & ~E_NOTICE);
//when debugging, comment out above line
//other debiggung settings: ini_set('desplay_errors', 1);
//error_reporting(E_ALL);

$dbhost = 'localhost';
$dbusername = 'john_php';
$dbpw = 'password';
$dbname = 'john_php';


//database object: host, username, paswword, database name
$db = new mysqli($dbhost, $dbusername, $dbpw, $dbname);

//handle any connection errors by killing page:
if($db->connect_errno>0){
	die('Unable to connect to database.'.$db->connect_error);
}

//define constants - these are pieces of data we can call over and over and never reset the value by accident like we might w/ a regular variable


define('PEPPER', 'fdg6h3eri6u36gher6u64iseqd7yf2gt781gwer67yfg5v67yifgweri');

define('SITE_URL', 'http://localhost/john-wp/php/pictuto/'); //the url for the site

define('SITE_PATH', 'C:/xampp/htdocs/john-wp/php/pictuto/'); //where the files reside on the server

//include functions.php when we make it
include_once('functions.php');



//no close php