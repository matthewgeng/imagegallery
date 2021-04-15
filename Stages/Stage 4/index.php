<?php

	include "header.inc";

	if (isset($_GET["page"])){
		$page = $_GET["page"];
	} else {
		$page = "home";
	}

	$jsonstring = "";
	$error = false;
	$valid = false;
	
	$target_dir = "uploads/";
	$uploadOk = 0;
	$target_file = "";
	$imageFileType = "";
	$UID = 1;
	$fileUID = 1;

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
			
			file_put_contents($file, $fileUID + 1); 
			
			// Check if file already exists
			if (file_exists($target_file)) {
				echo "Sorry, file already exists.";
				$uploadOk = 0;
			}
			
			// Check file size
			if ($_FILES["file"]["size"] > 4000000) {
				echo "Sorry, your file is too large.";
				$uploadOk = 0;
			}

			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk = 0;
			}
			
	
				$check = getimagesize($_FILES["file"]["tmp_name"]);
			
				if($check !== false) {
					echo "File is an image - " . $check["mime"] . ".";
					$uploadOk = 1;
				} else {
					echo "File is not an image.";
					$uploadOk = 0;
				}


			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {

				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
				
					echo "The file ". $target_file . " has been uploaded.";
				} else {
					echo "Sorry, there was an error uploading your file.";
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
	
	function checkImageOk(){
		if (isset($uploadOk)){
			if ($uploadOk !== 1){
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
		$page = "validated";
		
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
	
	if ($page == "validated"){

		include "validated.inc";
		echo "<pre>";
		var_dump($_POST);
		echo "</pre>";
		$valid = false;
		
	} elseif ($page == "album"){
	
		include "album.inc";
		
		$file = "galleryinfo.json";
		$filearray = file($file);
		 
		 // create one string from the file

		 foreach ($filearray as $line) {
		   $jsonstring .= $line;
		 }
		 
		 echo "<pre>";
		 var_dump(json_decode($jsonstring));
		 echo "</pre>";
		 
		 $files = glob("uploads/*.*");
		for ($i=1; $i<count($files); $i++){
			$num = $files[$i];
			echo '<img src="'.$num.'" alt="random image">'."&nbsp;&nbsp;";
		}
				
	} else {
		$page = 'home';
		include "content.inc";
	}

	include "footer.inc";
	
	
?>