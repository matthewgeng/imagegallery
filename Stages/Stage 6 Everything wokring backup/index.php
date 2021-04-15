<?php

	include "header.inc";
	if (isset($_GET["page"])){
		$page = $_GET["page"];
	} else {
		$page = "home";
	}

	session_start();
	
	if ($page === "moderator"){
		$_SESSION['isEditor'] = true;
	} else{
		$_SESSION['isEditor'] = false;
	}

	if(isset($_SESSION['isEditor'])){
		$isEditor = $_SESSION['isEditor'];
	} else {
		$isEditor = false;
		}


// how to unset a session variable
/*
if(isset($_SESSION['views']))
  unset($_SESSION['views']);
*/
  
// how to completely destroy a session
/* session_destroy();  */

	$jsonstring = "";
	$error = false;
	$valid = false;
	
	$target_dir = "uploads/";
	$uploadOk = 10;
	$target_file = "";
	$imageFileType = "";
	$UID = 1;
	$fileUID = 1;
	$errorImage = "";
	$photoDesc = "";

	if (isset($_POST['submit'])){

		if (empty($_POST['first-name'])){
		$firstName = "";

		} else {
			$firstName = test_input($_POST['first-name']);
		}
		
		if (empty($_POST['last-name'])){
		$lastName = "";

		} else {
			$lastName = test_input($_POST['last-name']);
		}
		
		if (empty($_POST['description'])){
			$photoDesc =  "";
		} else {
			$photoDesc = test_input($_POST['description']);
		}
		
		if (empty($_POST['tag'])){
			$photoTags =  "";
		} else {
			$photoTags = test_input($_POST['tag']);
		}
		
		if (empty($_POST['copyright'])){

		} else {
			$copyright = test_input($_POST['copyright']);
		}
		
		if (empty($_POST['access'])){

		} else {
			$access = test_input($_POST['access']);
		}
		
		$_POST["approved"] = false;
		
		unset($_POST['submit']);
	}


		if (isset($_FILES["file"])){

			// read json file into array of strings

			$file = "indentifier.txt";
			$filearray = file($file);
			
			// create one string from the file
			 foreach ($filearray as $line) {
			   $fileUID = intval ($line);
			 }
			
			$imageFileType = strtolower(pathinfo($target_dir . basename($_FILES["file"]["name"]),PATHINFO_EXTENSION));
			$target_file = $target_dir . $fileUID . '.' . $imageFileType;
			
			
			// Check if file already exists
			if (file_exists($target_file)) {
				$errorImage =  "Sorry, file already exists.";
				$uploadOk = -1;
			}
			
			// Check file size
			if ($_FILES["file"]["size"] > 4000000) {
				$errorImage = "Sorry, your file is too large.";
				$uploadOk = -2;
			}

			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				$errorImage =  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk = -3;
			}
			

				if ($uploadOk === 0 || $uploadOk === 1 || $uploadOk === 10 ){
					$check = getimagesize($_FILES["file"]["tmp_name"]);
				
					if($check !== false) {
						echo "File is an image - " . $check["mime"] . ".";
						$uploadOk = 1;
					} else {
						echo "File is not an image.";
						$uploadOk = 0;
					}

			}

		}
		
	function test_input($data) {
		  $data = trim($data);
		  $data = stripslashes($data);
		  $data = htmlspecialchars($data);
		  return $data;
	}

	function checkError($data){
		if (!empty($_POST) && empty($_POST[$data])){
			return true;
			$error = true;
		}  else {
			return false;
			$error = true;
		}
	}

	function checkErrorName($data){
		if (!empty($_POST) && empty($_POST[$data])){
			return 1;
			$error = true;
		}  elseif (!empty($_POST) && !preg_match("/^[a-zA-Z ]*$/",$_POST[$data])){
			return 2;
			$error = true;
		} else {
			return 0;
			$error = false;

		}
	}
	
	function checkImageOk($data){
		if (isset($data) && $data !== 10){
			if ($data !== 1){
				return true;
			} else {
				return false;
			}
		}
	}

	if (isset($firstName) && !empty($firstName) && preg_match("/^[a-zA-Z ]*$/",$firstName) 
	&&  isset($uploadOk)&& $uploadOk === 1 && isset($lastName) && !empty($lastName) 
	&& preg_match("/^[a-zA-Z ]*$/",$lastName) && isset($photoDesc) && !empty($photoDesc) 
	&& isset($photoTags) && !empty($photoTags) && isset($copyright) && !empty($copyright)
	&& isset($access) && !empty($access) && !$error){


			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk !== 1) {
				echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
			file_put_contents($file, $fileUID + 1); 

				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
				
					echo "The file ". $target_file . " has been uploaded.";
					
			$image = imagecreatefromstring(file_get_contents($target_file));

				// Target dimensions
			$max_width = 300;
			$max_height = 225;

			// Get current dimensions

			list($old_width, $old_height) = getimagesize($target_file);

			// Calculate the scaling we need to do to fit the image inside our frame
			$scale = min($max_width/$old_width, $max_height/$old_height);

			// Get the new dimensions
			$new_width  = ceil($scale*$old_width);
			$new_height = ceil($scale*$old_height);

			$new = imagecreatetruecolor($new_width, $new_height);
			// start changes
			switch ($imageFileType) {

				case 'gif':
				case 'png':
					// integer representation of the color black (rgb: 0,0,0)
					$background = imagecolorallocate($new , 0, 0, 0);
					// removing the black from the placeholder
					imagecolortransparent($new , $background);

				case 'png':
					// turning off alpha blending (to ensure alpha channel information
					// is preserved, rather than removed (blending with the rest of the
					// image in the form of black))
					imagealphablending($new , false);

					// turning on alpha channel information saving (to ensure the full range
					// of transparency is preserved)
					imagesavealpha($new , true);
					break;

				default:
					break;
			}
		// Resize old image into new
			imagecopyresampled($new, $image, 
		    0, 0, 0, 0, 
		    $new_width, $new_height, $old_width, $old_height);

			switch ($imageFileType)
			    {
			        case 'gif': 
			        
					imagegif($new, 'thumbnails/thumb'.$new.'.gif'); 
			        break;

			        case 'jpeg':
			        case 'jpg':
			        imagejpeg($new, 'thumbnails/thumb'.($fileUID).'.jpg', 100);  break; // best quality

			        case 'png':imagepng($new, 'thumbnails/thumb'.($fileUID).'.png', 0); break; // no compression
			        default: echo ''; break;
			    }

				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			


		$page = "home";
		
		// read json file into array of strings
		 $file = "galleryinfo.json";
		 $filearray = file($file);
		 
		 // create one string from the file

		 foreach ($filearray as $line) {
		   $jsonstring .= $line;
		 }

		 //decode the string from json to PHP array
		 $phparray = json_decode($jsonstring, true);

		 // add form submission to data (this does NOT remove submit button)
		 unset($_POST['submit']);
		 $_POST['UID'] = $fileUID;
		 $_POST['imagefile'] = $target_file;
		 $phparray[] = $_POST;


		 // encode the php array to formatted json 
		 $jsoncode = json_encode($phparray, JSON_PRETTY_PRINT);
		 
		 // write the json to the file
		 file_put_contents($file, $jsoncode); 

		}
	}
	
	if ($page == "form" || $uploadOk !== 1 && $uploadOk != 10){
		include "navbaruser.inc";
		include "content.inc";
		
	} else if ($page == "moderator") {
		$page = 'moderator';
		include "navbarmoderator.inc";
		include "albummoderator.inc";
		 echo '<div class="container"><div class="row">';
		 displayImages();
		 echo '</div></div>';
	} else if ($page == "edit") {
		$page = 'edit';
		include "navbarmoderator.inc";
		include "albumedit.inc";
		 
		 echo '<div class="container"><div class="row">';
		 displayImages();
		 echo '</div></div>';
	} else {
		$page = 'home';
		include "navbaruser.inc";
		include "albumuser.inc";
		 
		 echo '<div class="container"><div class="row">';
		 displayUserImages();
		 echo '</div></div>';
	}

	include "footer.inc";
	
	function displayImages(){
	$jsonstring = "";
		 $files = glob("uploads/*.*");
		 $thumbs = glob("thumbnails/*.*");

		 $file = "galleryinfo.json";
		 $filearray = file($file);
		 
		 // create one string from the file

		 foreach ($filearray as $line) {
		   $jsonstring .= $line;
		 }

		 //decode the string from json to PHP array
		 $phparray = json_decode($jsonstring, true);

		for ($i=0; $i<count($files); $i++){
			$num = $files[$i];
			$thumb = $thumbs[$i];
			$description = $phparray[$i]["description"];
			$firstname = $phparray[$i]["first-name"];
			$lastname = $phparray[$i]["last-name"];
			//echo '<img src="'.$num.'" alt="random image">'."&nbsp;&nbsp;";
			//echo '<a href="'.$num.'" data-lightbox="image-1" data-title="My caption">Image #1</a>';
			echo '<div class="col-auto" ><a href="'.$num.'" data-fancybox="gallery"  data-caption="'.$firstname . " " . $lastname . "<br> " .$description.'" class="lightbox"><img src="'.$thumb.'"/></a></div>';
		}
	}
	
	function displayUserImages(){
	$jsonstring = "";
		 $files = glob("uploads/*.*");
		 $thumbs = glob("thumbnails/*.*");

		 $file = "galleryinfo.json";
		 $filearray = file($file);
		 
		 // create one string from the file

		 foreach ($filearray as $line) {
		   $jsonstring .= $line;
		 }

		 //decode the string from json to PHP array
		 $phparray = json_decode($jsonstring, true);

		for ($i=0; $i<count($files); $i++){
			$num = $files[$i];
			$thumb = $thumbs[$i];
			$description = $phparray[$i]["description"];
			$firstname = $phparray[$i]["first-name"];
			$lastname = $phparray[$i]["last-name"];
			//echo '<img src="'.$num.'" alt="random image">'."&nbsp;&nbsp;";
			//echo '<a href="'.$num.'" data-lightbox="image-1" data-title="My caption">Image #1</a>';
			if ($phparray[$i]["access"] === "public"){
			echo '<div class="col-auto"><a href="'.$num.'" data-fancybox="gallery"  data-caption="'.$firstname . " " . $lastname . "<br> " .$description.'" class="lightbox"><img src="'.$thumb.'"/></a></div>';
			}
		}
	}
	
?>