<?php 
//add-
//temporarily using the get method to get user id

if(isset($_GET['user_id'])){
	$user_id = $_GET['user_id'];
	$s_user_id = $_SESSION['user_id'];
	if($user_id != $s_user_id){
		die('naughty naughty!');
	}

}else{
	die('You need to have a user_id in order to use this page.');
}

//parsing initial data for picture/post

//parses step 1 of "add new picture" process and redirects to step 2 on success

if(isset($_POST['did_add_post']) AND $_POST['did_add_post'] ){
	//file uploading stuff begins!
	$target_path = "uploads/";

	//list of image sizes to generate
	$sizes = array(
		'thumb' => 150,
		'medium' => 200,
		'large' =>400
	);


	//this is the temp file created by PHP
	$uploadedfile = $_FILES['uploadedfile']['tmp_name'];
	//capture the original size of the uplaaded image
	list($width, $height) = getimagesize($uploadedfile);

	//make sure that a width and height exist, otherwise it is not a valid image:
	if($width>0 AND $height>0){
		//what kind of image is it?
		$filetype = $_FILES['uploadedfile']['type'];

		switch($filetype){
			case 'image/gif':
			//create an image from it so we ca do the resize:
				$src = imagecreatefromgif($uploadedfile);
				break;
			case 'image/pjpeg':
			case 'image/jpg':
			case 'image/jpeg':
			//create an image from it so we ca do the resize:
				$src = imagecreatefromjpeg($uploadedfile);
				break;

			case 'image/png':
				//$required_memory = Round($width * $height * $size['bits']);
				//$new_limit = memory_get_usage() + $required_memory;
				//ini_set("memory_limit", $new_limit);
				ini_set('memory_limit', '-1');
				$src = imagecreatefrompng($uploadedfile);
				ini_restore("memory_limit");
				break;
		}//end switch

		//create random file name:
		$randomsha = sha1(microtime());

		foreach($sizes as $size_name => $size_width){
			if($width>=$size_width){
				$new_width = $size_width;
				$new_height = ($height/$width)*$new_width;
			}else{
				$new_width = $width;
				$new_height = $height;
			}

			$tmp = imagecreatetruecolor($new_width, $new_height);
			imagecopyresampled($tmp, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

			$filename = $target_path.$randomsha.'_'.$size_name.'.jpg';
			//below will have a 1 or 0 upon completion of creating the image and storing it in our folder:
			
			$did_create = imagejpeg($tmp, $filename, 70);

			//clean up temp canvas:
			imagedestroy($tmp);


		}//end foreach

		imagedestroy($src); //gets rid of original image

		if($did_create){
			//if it successfully saved the file, add the file name to the db
			//echo "image uploaded";		
			$query = "INSERT INTO posts
			(image, date, user_id)
			VALUES
			('$randomsha', now(), $user_id)";
			echo $query;
			$result = $db->query($query);
			//check to see if there was a problem
			if($db->affected_rows !=1){
				$did_create = false;
			}
			//get rid of the newly created post/pic for step 2
			$post_id = $db->insert_id;





	
		}else{
			//if picture was not created...
			echo $_FILES['uploadedfile']['error'];
		}
	}else{ //end if
		//width or height of uploaded image was not greater than 0
		$did_create = false;
	}

if($did_create){
	//it worked, send them to step 2
	//on a production server, you may need to manipulate the obsettings
	header("Location:edit_post.php?post_id=$post_id");
}else{
	//stay on the page and show feedback:
	$feedback = "There was an error uploading the file. Please try again!<br>";
}

}//end if add post


 ?>