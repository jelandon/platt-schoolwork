<?php 
//temporary dynamic user id:
//TODO: Now that we have login, fix this so it is not needed, but be sure to capture the user id as we need it.

// if(isset($_GET['user_id'])){
// 	$user_id = $_GET['user_id'];
// }else{
// 	die('You need to have a user_id in order to use this page.');
// }

if($logged_in_user){
$user_id = $logged_in_user['user_id'];

}else{
	die('You need to be <a href="login.php">logged in</a> to view this page.');
}


//parsing initial data for post
//parses step 1 of "add new post" process and redirects to step 2 on success
if($_POST['did_add_post']){
	$show = clean_boolean($_POST['did_add_post']);
	//file uploading stuff begins
	$target_path = "uploads/";

	//list of image sizes to generate
	$sizes = array(
		'thumb' => 150,
		'medium' => 200,
		'large' => 400
	);

//this is the temp file created by PHP
	$uploadedfile = $_FILES['uploadedfile']['tmp_name'];
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
		$query = "INSERT INTO posts
				  (image, post_date, user_id)
				  VALUES
				  ('$randomsha', now(), $user_id)";
		$result = $db->query($query);
		//check to see if there was a problem
		if($db->affected_rows != 1){
			$didcreate = false;
		}		  
		//get the id of the newly created post for step 2
		$post_id = $db->insert_id;

	}//end if didcreate

}else{
	//width and height not greater than 0
	$didcreate = false;
}	

if($didcreate){
	//it worked, send them to step 2
	header("Location: edit-post.php?post_id=$post_id");
}else{
	//stay on same page and show feedback:
	$feedback = "There was an error uploading the file. Please try again!<br>";
}

}//end of step 1

//this code was to see if we were getting to the page when there was no post data, but still seeing the page. We don't need it now.
// else{
// 	echo 'There is no post data.';
// }

//no close php