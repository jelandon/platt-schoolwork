<?php 
//var_dump($_POST);

if($_POST['did_contact']){
	$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$reason = filter_var($_POST['reason'], FILTER_SANITIZE_STRING);
	$message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

//validation
	$valid = true;

	//check to see if name is blank
	if(strlen($name)==0){
		$valid = false;
		$errors['name'] = 'Please fill in your name.<br>';
	}

	//check for invalid email or blank email
	if(! filter_var($email, FILTER_VALIDATE_EMAIL)){
		$valid = false;
		$errors['email'] = 'Please provide a valid email address, like: bob@example.com<br>';
	}

	//check for invalid reasons...
	$valid_reasons = array('help', 'hi', 'bug');
	//$valid_reasons = ['help', 'hi', 'bug'];
	//
	if(! in_array($reason, $valid_reasons)){
		$valid = false;
		$errors['reason'] = 'Please choose a reason from the list';
	}
	
	//check to see if we have a blank message
	if(strlen($message)==0){
		$valid = false;
		$errors['message']= 'Please tell me what you need to know...<br>';
	}
	if($valid){
		//create parts of the mail
		$to = 'jelandon@gmail.com';
		$subject = $reason; //$main.' wants to get in touch with you via your website'
		$body = "Name: $name \n";
		$body .= "Email Address: $email \n";
		$body .= 'IP Address: '.$_SERVER['REMOTE_ADDR'];
		$body .= "\n\nMessage: $message";

		//headers
		$headers = "From: no-reply@jelandon.com\r\n";
		$headers .= "CC: contact@jelandon.com\r\n";
		$headers .= "Reply-tp: $email"; //last one: no \r\n


		//send the mail
		$did_send = mail($to, $subject, $body, $headers);

		if($did_send){
			$feedback = 'Your message was received.';
		}
	}//end if($valid)

}
//no close php