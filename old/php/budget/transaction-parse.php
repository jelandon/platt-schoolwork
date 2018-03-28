<?php 

//which post are we editing?
$user_id = $_GET['user_id'];

if($_POST['did_add_trans']){
	//sanitize the data
	$addTrans = trim(clean_int($_POST['add_trans']));
	//validate
	$valid=true;
	//echo $addTrans;
	if($addTrans !='' AND strlen($addTrans)>13){
		$valid=false;
		$errors['add_trans'] = "Slow down Mr. Moneybags! Let's start with 
		less than 1 quadrillion dollars.";
	}elseif($addTrans ==''){
		$valid=false;
		$errors['add_trans'] = "Apologies for your circumstances, come back when you have at least $1";
	}
	//echo $balance;
	
	$type=trim(clean_int($_POST['selectedType']));
	//echo $type;
	if($type==1){
		$newBalance=$balance+$addTrans;
	}else{
		$newBalance=$balance-$addTrans;
	}
	

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