<?php 

//which post are we editing?
$user_id = $_GET['user_id'];

if($_POST['did_add_balance']){
	//sanitize the data
	$addBalance = trim(clean_int($_POST['add_balance']));
	//validate
	$valid=true;
	// echo $addBalance;
	if($addBalance !='' AND strlen($addBalance)>13){
		$valid=false;
		$errors['add_balance'] = "Slow down Mr. Moneybags! Let's start with 
		less than 1 quadrillion dollars.";
	}elseif($addBalance ==''){
		$valid=false;
		$errors['add_balance'] = "Apologies for your circumstances, come back when you have at least $1";
	}
	//echo $balance;
	$newBalance=$balance+$addBalance;

	$query="UPDATE users
			SET balance = $newBalance
			WHERE user_id = $user_id";
	$result=$db->query($query);
	//echo $query;
	if($db->affected_rows !=1){
		$did_create = false;
		//echo "fail";
	}else{
		$did_create = true;
		//success!
		//echo "success";
		//on a production/live server like hostgator, you may have to change the output buffering. (ob_start())
	}
}


if($did_create){
	//it worked, reload balance
	//on a production server, you may need to manipulate the obsettings
	header('Location:budget.php?user_id='.$user_id);
}else{
	//stay on the page and show feedback:
	$feedback = "There was an error uploading the file. Please try again!<br>";
}


//no close php