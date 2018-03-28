<?php 
 /*
Edit any profile as long as ?user_id=X is in the query string
and the logged_in_user is the one who belongs to this profile

otherwise kill the page
*/
require('includes/header.php');
//include('includes/edit-post-parse.php');
//get the user id
if(isset($_GET['user_id'])){
$page_user_id = clean_int($_GET['user_id']);

}

if($logged_in_user){
$page_user_id = $logged_in_user['user_id'];

}else{
	die('You need to be <a href="login.php">logged in</a> to view this page.');
}


//parse must be below the header, which means on a live server we may need ob_start and ob_end_flush at the end. Footer may be a good place for it

//quick reminder: $_FILES gets all the data from a file uploaded. It is NOT in the $_POST array

//parse our data
if($_POST['did_edit']){

//get and clean the data:
	$username = clean_string($_POST['username']);
	$email = clean_email($_POST['email']);
	$pass1 = clean_string($_POST['pass1']);
	$pass2 = clean_string($_POST['pass2']);

$valid = true;
//validate:

if($username != ''){
	//check to see if it exists in db:
	$query_un = "SELECT username, user_id FROM users WHERE username = $username LIMIT 1";
	$result_un = $db->query($query_un);
	if($result_un->num_rows == 1){
		//found one... is it the user's?
		$un_row = $result_un->fetch_assoc();
		if($un_row['user_id'] != $page_user_id){
			$valid = false;
			$feedback .= 'That username is already taken. Try another. ';
		}
		$result_un->free();
	}else{
		//that username does not exist so we can update the current username
	$update_un = "UPDATE users
				  SET username = '$username'
				  WHERE user_id = $page_user_id";
	$result_un = $db->query($update_un);

	}


}

	if($email != ''){
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$valid = false;
			$feedback = 'Please choose a valid email address. ';
		}else{
			//this means the email is good, check the db to see if anyone else is using it
			$query_email = "SELECT email 
							FROM users
							WHERE email = '$email'
							AND user_id != $user_id
							LIMIT 1";
			$result_email = $db->query($query_email);
			
			if($result_email->num_rows == 1){
				$valid = false;
				$feedback .= 'That email address is already taken. Try another. ';
			}				
			//if still valid, update email
		//	$result_email->free();
			if($valid){
				$update_email = "UPDATE users
								 SET email = '$email'
								 WHERE user_id = $user_id";
				$result_email = $db->query($update_email);
			}
			//user will see results in form below

		}//end of else (email is good, so update it)

	}//is email blank? end email validate

//check if passwords match:
	if($pass1 == $pass2 AND $pass2 != ''){
		//encrypt and update new password
		
		//check for valid password
		if(strlen($pass1)< 7){
			$valid = false;
			$feedback .="Your password must be at least 7 characters long.";
		}else{
			//make sha version of pw for storage in db
			$sha_password = sha1($pass1.SALT);
			
			$update_pass = "UPDATE users
							SET password = '$sha_password'
							WHERE user_id = $page_user_id";
			$result_pass = $db->query($update_pass);
			if($db->affected_rows == 1){
				$feedback .= 'Your password was updated.';
			}else{
				$feedback .= 'Your password could not be updated.';
			}

		} //pass is good

	}//end check new password

//check if name of uploaded file is not blank

	//file uploading stuff begins
	$target_path = "avatars/";

	//list of image sizes to generate
	$sizes = array(
		'thumb' => 50,
		'medium' => 80,
		'large' => 128
	);

//this is the temp file created by PHP
	$uploadedfile = $_FILES['uploadedfile']['tmp_name'];
	
	if(strlen($uploadedfile) > 0){
//capture the original size of the uploaded image
list($width,$height) = getimagesize($uploadedfile);

//make sure that the width and height exist, otherwise it is not a valid image
if($width>0 AND $height>0){
	//what kind of image is it?
	$filetype = $_FILES['uploadedfile']['type'];

//do a specific set of instructions based on the uploaded file's type, eg: gif, jpg, png
	switch ($filetype) {
		case 'image/gif':
		//create an image from it so we can do the resize
		$src = imagecreatefromgif($uploadedfile);
		break;

		case 'image/pjpeg':
		case 'image/jpg':
		case 'image/jpeg':
		//create an image from it so we can do the resize
		$src = imagecreatefromjpeg($uploadedfile);
		break;

		case 'image/png':
		//create an image from it so we can do the resize
		//because pngs have alpha, they often require more memory than is allowed via the server's default settings, we can temporarily reset the memory with this code.
		$required_memory = Round($width * $height * $size['bits']);
		$new_limit = memory_get_usage() + $required_memory;
		ini_set("memory_limit", $new_limit);
		$src = imagecreatefrompng($uploadedfile);
		//make sure we put things back the way they were when we are done.
		ini_restore("memory_limit");
		break;
	}

	//create random filename
	$randomsha=sha1(microtime());

	//resize the images
	//TODO: Add square cropper portion to this script

	foreach($sizes as $size_name => $size){
		//Check the width vs the height
		if($width > $height){
		//width needs to be cropped
		$crop_y = 0;
		$crop_x = ($width - $height)/2; //finds placement of where horizontally the same space as height can be cropped from center.
		$smallestSide = $height;	
		}else{
			$crop_x = 0;
			$crop_y = ($height - $width)/2;
		$smallestSide = $width;
		}

		$tmp = imagecreatetruecolor($size, $size);
		imagecopyresampled($tmp, $src, 0,0,$crop_x,$crop_y, $size, $size, $smallestSide, $smallestSide);

		$filename = $target_path.$randomsha.'_'.$size_name.'.jpg';
		//below will have a 1 or 0 upon completion of creating the image and storing it in our folder
		$didcreate = imagejpeg($tmp,$filename,70);

		//clean up temp canvas
		imagedestroy($tmp);

	}//end for each

	//clean up original full sized file now that we are done with it.
	imagedestroy($src);

	//if it successfully saved the file, add the filname to the db
	if($didcreate){
		$update_img = "UPDATE users
					   SET profile_pic = '$randomsha'
					   WHERE user_id = $page_user_id";
		$result_img = $db->query($update_img);

		//check to see if there was a problem
		if($db->affected_rows != 1){
			$didcreate = false;
			$feedback .= 'The database rejected your image.';
		}		  

	}//end if didcreate

}else{
	//width and height not greater than 0
	$didcreate = false;
	$feedback .= 'No image was uploaded.';
}	

}//end if strlen > 0


}//end parsing
//query database for information based on  user id

?>

<main class="center">
<h2 class="full-column">Edit Your Profile</h2>
<?php  

	if(isset($feedback)){
		echo $feedback;
	}


//get pertenant data from current user
$user_query = "SELECT email, username
			   FROM users
			   WHERE user_id = $page_user_id
			   LIMIT 1";

$user_result = $db->query($user_query);
if($user_result->num_rows ==1){
	$row = $user_result->fetch_assoc();
?>

<form class="center cf full-column" action="<?php echo $_SERVER['PHP_SELF'] ?>?user_id=<?php echo $page_user_id; ?>" method="post" enctype="multipart/form-data">
	<div class="one-third">
	<h2>Your Current User Pic</h2>
	<!-- display current user picture if any here -->
	<?php show_profile_pic($page_user_id, 'large'); ?>
	<label>Choose a New Profile Picture</label>
	<input type="file" name="uploadedfile">		
	</div>
	<div class="one-half">
		<label>Username:</label>
		<input type="text" name="username" value="<?php echo $row['username']; ?>">
		<label>Email:</label>
		<input type="email" name="email" value="<?php echo $row['email']; ?>">
		<label>New Password:</label>
		<p>If you want a new password, type your new password twice.</p>
		<input type="password" name="pass1" placeholder="new password">	
		<input type="password" name="pass2" placeholder="repeat password">	
	</div>	
<div class="full-column">
	<input type="submit" name="submit" value="Update Profile">
	<input type="hidden" name="did_edit" value="1">
</div>	
</form>
<?php
}//if no result...
die();
?>
</main>
<?php 
include_once('includes/footer.php');
 ?>