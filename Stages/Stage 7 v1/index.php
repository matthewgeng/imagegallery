<?php

	include "header.inc"; // header of html

	// gets page value
	if (isset($_GET["page"])){
		$page = $_GET["page"];
	} else {
		$page = "home";
	} // else

	// gets edit value
	if (isset($_GET["edit"])){
		$isEditing = $_GET["edit"];
	} else {
		$isEditing = false;
	} // else

	session_start(); // starts session
	
	// check page for moderator and assign session variable
	if ($page === "moderator"){
		$_SESSION['isModerator'] = true;
	} else if ($page === "home"){
		$_SESSION['isModerator'] = false;
	} // else

	// checks if session variable is set and sets varible to session value
	if(isset($_SESSION['isModerator'])){
		$isEditor = $_SESSION['isModerator'];
	} else {
		$isEditor = false;
	} // else


// how to unset a session variable
/*
if(isset($_SESSION['views']))
  unset($_SESSION['views']);
*/
  
// how to completely destroy a session
/* session_destroy();  */

	$jsonstring = ""; // json in string format
	$error = false; // error from upload form
	$valid = false; // valid from upload form
	$target_dir = "uploads/"; // directory
	$uploadOk = 10; // intialized upload value
	$target_file = ""; // target file
	$imageFileType = ""; // image uploaded type
	$UID = 1; // unique identifier
	$fileUID = 1; // file indetifier
	$errorImage = ""; // error message
	$photoDesc = ""; // phot description
	$approveImage = ""; // approve image value
	$deleteImage = ""; // delete image value
	$filesForApproval = ""; // string value of input for approval or delete
	$filesForApprovalArray = ""; // array of input for approval or delete

		// check if approved image value is set
		if (isset($_POST['approveImage'])){

			$approveImage = $_POST['approveImage']; // set approve image variable

			// check if files for approval is empty
			if (empty($_POST['filesForApproval'])){
				$filesForApproval =  ""; // set variable 
			} else {
				$filesForApproval = test_input($_POST['filesForApproval']); // assign varible
				$filesForApprovalArray= explode(',', $filesForApproval); // get array from varible
			}

			// unset varibles 
			unset($_POST['filesForApproval']);
			unset($_POST['approveImage']);
		} // if

		// check if delete image value is set
		if (isset($_POST['deleteImage'])){

			$deleteImage = $_POST['deleteImage']; // set delete image variblw

			// check if files for approval is empty
			if (empty($_POST['filesForApproval'])){
				$filesForApproval =  ""; // set varible
			} else {
				$filesForApproval = test_input($_POST['filesForApproval']); // assign variable
				$filesForApprovalArray= explode(',', $filesForApproval); // get array from varible
			}
			// unset varibles
			unset($_POST['filesForApproval']);
			unset($_POST['deleteImage']);
		} // if

		if ($deleteImage === "delete"){

			$number = 0; // Unique id of upload input

			// read json file into array of strings
			 $file = "galleryinfo.json";
			 $filearray = file($file);
		 
			 // create one string from the file
			 foreach ($filearray as $line) {
			   $jsonstring .= $line;
			 } // foreach

			 //decode the string from json to PHP array
			 $phparray = json_decode($jsonstring, true);

			 	// check if json key value is same as input key value of image to be deleted
				foreach($phparray as $key => $value) {

					// get  image input file values
					foreach ($filesForApprovalArray  as $value2) {
						if($value['imagefile'] === $value2) {
				    		
				    		$number = preg_replace('/[^0-9]/', '', $value['imagefile']); // get UID for input image
				    		unlink($value['imagefile']); // delete input image
							unlink("thumbnails/thumb".$number. ".jpg"); // delete input image thumbnail
							array_splice($phparray, $key,1); // delete object from JSON

				   		} // if
					} // foreach
				} // foreach

			

		 // encode the php array to formatted json 
		 $jsoncode = json_encode($phparray, JSON_PRETTY_PRINT);
		 
		 // write the json to the file
		 file_put_contents($file, $jsoncode); 

		} elseif ($approveImage === "approve"){

			$number = 0; // Unique id of upload input

			// read json file into array of strings
			 $file = "galleryinfo.json";
			 $filearray = file($file);
			 
			 // create one string from the file

			 foreach ($filearray as $line) {
			   $jsonstring .= $line;
			 }

		 	//decode the string from json to PHP array
		 	$phparray = json_decode($jsonstring, true);

			 // check if json key value is same as input key value of image ot be deleted
			foreach($phparray as $key => $value) {

				// get  image input file values
				foreach ($filesForApprovalArray  as $value2) {
					if($value['imagefile'] === $value2) {
			    		
			    		$phparray[$key]['approved'] = true; // set approved to true
			   		} // if

				} // foreach
			   
			} // foreach

			

		 // encode the php array to formatted json 
		 $jsoncode = json_encode($phparray, JSON_PRETTY_PRINT);
		 
		 // write the json to the file
		 file_put_contents($file, $jsoncode); 
		} // elseif


		// check if submit is pressed
	if (isset($_POST['submit'])){

		// gets first name
		if (empty($_POST['first-name'])){
		$firstName = "";

		} else {
			$firstName = test_input($_POST['first-name']);
		}
		
		// gets last name
		if (empty($_POST['last-name'])){
		$lastName = "";

		} else {
			$lastName = test_input($_POST['last-name']);
		}
		
		// gets description
		if (empty($_POST['description'])){
			$photoDesc =  "";
		} else {
			$photoDesc = test_input($_POST['description']);
		}


		// gets tag
		if (empty($_POST['tag'])){
			$photoTags =  "";
		} else {
			$photoTags = test_input($_POST['tag']);
		}
		
		// gets copyright
		if (empty($_POST['copyright'])){

		} else {
			$copyright = test_input($_POST['copyright']);
		}
		
		// gets access
		if (empty($_POST['access'])){

		} else {
			$access = test_input($_POST['access']);
		}
		
		// sets approved value to false
		$_POST["approved"] = false;
		
		// remove submit
		unset($_POST['submit']); 

	} // if

		// checks if files is set
		if (isset($_FILES["file"])){

			// read json file into array of strings

			$file = "indentifier.txt";
			$filearray = file($file);
			
			// create one string from the file
			 foreach ($filearray as $line) {
			   $fileUID = intval ($line);
			 }
			
			// get image type
			$imageFileType = strtolower(pathinfo($target_dir . basename($_FILES["file"]["name"]),PATHINFO_EXTENSION));

			// sets target file
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
			} // if
			
				// checks if upload was good
				if ($uploadOk === 0 || $uploadOk === 1 || $uploadOk === 10 ){
					$check = getimagesize($_FILES["file"]["tmp_name"]);
				
					if($check !== false) {
						echo "File is an image - " . $check["mime"] . ".";
						$uploadOk = 1;
					} else {
						echo "File is not an image.";
						$uploadOk = 0;
					} // else

			} // if

		} // if
		
	// clears unnecessary characters in input
	function test_input($data) {

		  $data = trim($data);
		  $data = stripslashes($data);
		  $data = htmlspecialchars($data);
		  return $data;

	} // test_input

	// checks if there is an error
	function checkError($data){
		if (!empty($_POST) && empty($_POST[$data])){
			return true;
			$error = true;
		}  else {
			return false;
			$error = true;
		} // else
	} // checkError

	// checks if there is an error for name input form
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

		} // else
	} // checkErrorName
	
	// checks if image upload was ok
	function checkImageOk($data){
		if (isset($data) && $data !== 10){
			if ($data !== 1){
				return true;
			} else {
				return false;
			} // else
		} // if
	} // checkImageOK

	// checks if everything is set and things are submitted
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
				// change text identifier value
			file_put_contents($file, $fileUID + 1); 

				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
				
					echo "The file ". $target_file . " has been uploaded.";
					
			// creates image resource
			$image = imagecreatefromstring(file_get_contents($target_file));

				// Target dimensions
			$max_width = 300;
			$max_height = 225;

			// Get current dimensions
			list($old_width, $old_height) = getimagesize($target_file);

			// Calculate the scaling we need to do to fit the image inside dimensions
			$scale = min($max_width/$old_width, $max_height/$old_height);

			// Get the new dimensions
			$new_width  = ceil($scale*$old_width);
			$new_height = ceil($scale*$old_height);

			// create new image resource with new dimensions
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
			} // switch

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
			    } // switch

				} else {
					echo "Sorry, there was an error uploading your file.";
				} // else
			


		$page = "home"; // set page
		
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
	
	// include files according to page values
	if ($page == "form" || $uploadOk !== 1 && $uploadOk != 10){
		include "navbaruser.inc";
		include "content.inc";
		
	} else if ($page === "moderator") {
		$page = 'moderator';
		include "navbarmoderator.inc";
		include "albummoderator.inc";

		// displays images
		 echo '<div class="container"><div class="row">';
		 displayModeratorApprovedImages();
		 echo '</div></div>';
	} else if ($page === "moderator" && $isEditing === true) {
		$page = 'moderator';
		include "navbarmoderator.inc";
		include "albumedit.inc";
		 
		// displays images
		 echo '<div class="container"><div class="row">';
		 displayModeratorApprovedImages();
		 echo '</div></div>';
	} else if ($page === "approve") {
		$page = 'approve';
		include "navbarmoderator.inc";
		include "albumapprove.inc";
		 
		// displays image
		 echo '<div class="container"><div class="row">';
		 displayModeratorUnapprovedImages();
		 echo '</div></div>';
	} else {
		$page = 'home';
		include "navbaruser.inc";
		include "albumuser.inc";
		 
		 // displays image
		 echo '<div class="container"><div class="row">';
		 displayUserApprovedImages();
		 echo '</div></div>';

	} // else

	include "footer.inc"; // include footer of html
	
	// displays approved images for moderator
	function displayModeratorApprovedImages(){
		$jsonstring = "";
		 $files = glob("uploads/*.*");
		 $thumbs = glob("thumbnails/*.*");

		 $file = "galleryinfo.json";
		 $filearray = file($file);
		 
		 // create one string from the file

		 foreach ($filearray as $line) {
		   $jsonstring .= $line;
		 } // foreach

		 //decode the string from json to PHP array
		 $phparray = json_decode($jsonstring, true);

		for ($i=0; $i<count($files); $i++){
			$num = $files[$i];
			$thumb = $thumbs[$i];
			$description = $phparray[$i]["description"];
			$firstname = $phparray[$i]["first-name"];
			$lastname = $phparray[$i]["last-name"];
			$tag = $phparray[$i]["tag"];
			//echo '<img src="'.$num.'" alt="random image">'."&nbsp;&nbsp;";
			//echo '<a href="'.$num.'" data-lightbox="image-1" data-title="My caption">Image #1</a>';
			if ($phparray[$i]["approved"] === true){
					echo '<div class="col-auto thumbnail" ><a href="'.$num.'" data-fancybox="gallery"  data-caption="'.$firstname . " " . $lastname . "<br> " .$description.'" class="lightbox"><img src="'.$thumb.'"/><div class="caption">
		          <p>Name: '.$firstname . " " . $lastname .'  Description: '.$description.' <br> Tags: '.$tag.'</p>
		        </div></a></div>';
		    } // if
		} // for
	} // displayModeratorApprovedImages


	// display unapproved images for approval page
	function displayModeratorUnapprovedImages(){
		$jsonstring = "";
		 $files = glob("uploads/*.*");
		 $thumbs = glob("thumbnails/*.*");

		 $file = "galleryinfo.json";
		 $filearray = file($file);
		 
		 // create one string from the file

		 foreach ($filearray as $line) {
		   $jsonstring .= $line;
		 } // foreach

		 //decode the string from json to PHP array
		 $phparray = json_decode($jsonstring, true);

		for ($i=0; $i<count($files); $i++){
			$num = $files[$i];
			$thumb = $thumbs[$i];
			$description = $phparray[$i]["description"];
			$firstname = $phparray[$i]["first-name"];
			$lastname = $phparray[$i]["last-name"];
			$tag = $phparray[$i]["tag"];
			//echo '<img src="'.$num.'" alt="random image">'."&nbsp;&nbsp;";
			//echo '<a href="'.$num.'" data-lightbox="image-1" data-title="My caption">Image #1</a>';
			if ($phparray[$i]["approved"] === false){
			echo '<div class="col-auto thumbnail" ><a href="'.$num.'" data-fancybox="gallery"  data-caption="'.$firstname . " " . $lastname . "<br> " .$description.'" class="lightbox"><img src="'.$thumb.'"/><div class="caption">
          <p>Name: '.$firstname . " " . $lastname .'  Description: '.$description.' <br> Tags: '.$tag.'</p>
        </div></a></div>';
    		} // if
		} // for
	} // displayModeratorUnapprovedImages


	// display user's images that are approved
	function displayUserApprovedImages(){
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
			$tag = $phparray[$i]["tag"];
			//echo '<img src="'.$num.'" alt="random image">'."&nbsp;&nbsp;";
			//echo '<a href="'.$num.'" data-lightbox="image-1" data-title="My caption">Image #1</a>';
			if ($phparray[$i]["access"] === "public" && $phparray[$i]["approved"] === true){
			echo '<div class="col-auto thumbnail"><a href="'.$num.'" data-fancybox="gallery"  data-caption="'.$firstname . " " . $lastname . "<br> " .$description.'" class="lightbox"><img src="'.$thumb.'"/><div class="caption">
          <p>Name: '.$firstname . " " . $lastname .' Description: '.$description.' <br> Tags: '.$tag.'</p>
        </div></a></div>';
			} // if
		} // for
	} // displayUserApprovedImages
	
?>