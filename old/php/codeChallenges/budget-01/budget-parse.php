<?php 

if($_POST['did_add_trans']){
	//sanitize the data
	$trans = trim(clean_int($_POST['trans']));
	$type = trim(clean_int($_POST['selectedType']));
	$description = trim(clean_string($_POST['description']));
	$category = trim(clean_int($_POST['selectedCategory']));
	//validate
	$valid = true;
	echo $trans;

	if($trans !='' AND strlen($trans)>13){
		$valid=false;
		$errors['trans'] = 'Transaction is too large.';
	}elseif($trans ==''){
		$valid=false;
		$errors['trans'] = 'Amount required';
	}

	if(strlen($description)>50){
		$valid=false;
		$errors['description'] = 'Description is too long';
	}


	if($valid){
			$query="INSERT into income
					(date, amount, category_id, description, user_id)
					VALUES
					(now(), '$trans', '$category', '$description', $user_id)";
			$result = $db->query($query);

			//if it works, we will have an affected row
			if($db->affected_rows !=1){
				$did_create = false;
			}else{
				$did_create = true;
				//success!
				//header('Location:login.php');
				echo "success";
				//on a production/live server like hostgator, you may have to change the output buffering. (ob_start())
			}
			//get rid of the newly created post/pic for step 2
			$post_id = $db->insert_id;
	}

if($did_create){
	//it worked, send them to step 2
	//on a production server, you may need to manipulate the obsettings
	header("Location:budget.php?trans=$trans");
}else{
	//stay on the page and show feedback:
	$feedback = "There was an error uploading the file. Please try again!<br>";
}

}




//no close php