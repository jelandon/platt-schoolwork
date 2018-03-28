<?php 
//error reporting, this is not needed on a production server
error_reporting(E_ALL & ~E_NOTICE);

//functions
include_once('functions.php');

//parser
include_once('parser.php');

 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Contact</title>
	<style type="text/css">
		body{
			font-family: Calibri, Arial, sans-serif;
			width: 90%;
			max-width: 400px;
			font-size: 16px;
			margin: 0 auto;
		}
		input, textarea, select{
			width: 100%;
			padding: .25em;
			box-sizing: border-box;
			display: block;
			margin: 1em 0;
			resize: vertical;
		}
		label{
			display: block;
			margin: 1em 0 .2em;
		}
		input[type=submit]{
			width: auto;
		}
		/*styles for user feedback*/
		.feedback{
			background-color: wheat;
			padding: 1em;
		}
		.error{
			background-color: #F9CDCD;
		}
		.success{
			background-color: #C4FCC3;
		}
	</style>
</head>
<body>
	<h1>Contact Me</h1>
	<p>Please take a moment to fill out the form and I will get back to you shortly.</p>
	<?php 
	if(isset($feedback)){
		echo $feedback;
	}

	//output errors here
	if(! empty($errors)){
		echo '<ul>';
		foreach($errors as $error){
			echo '<li>';
			echo $error;
			echo '</li>';
		}
		echo '</ul>';
	}
	 ?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<label for="the_name">Your Name:</label>
		<input type="text" name="name" id="the_name" value="<?php echo $name ?>"<?php inline_error('name', $errors); ?>>
		<label for="the_email">Email Address:</label>	
		<input type="email" name="email" id="the_email" value="<?php echo $email ?>"<?php inline_error('email', $errors); ?>>
		<label for="the_reason">How can I help you?</label>
		<select name="reason" id="the_reason" <?php inline_error('reason', $errors); ?>>
			<option>Choose One</option>
			<option value="help" <?php select_it($reason, 'help'); ?>>I need help with my website</option>
			<option value="bug" <?php select_it($reason, 'bug'); ?>>I found a bug on your website</option>
			<option value="hi" <?php select_it($reason, 'hi'); ?>>I just wanted to say hi</option>
		</select>
		<label for="the_message">Message:</label>
		<textarea name="message" id="the_message" placeholder="type your message" <?php inline_error('name', $errors); ?>><?php echo $message ?></textarea>
		<input type="hidden" name="did_contact" value="1">
		<input type="submit" name="Send Message">
	</form>
</body>
</html>