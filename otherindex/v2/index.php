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
		
		if (empty($_POST['file'])){
		$file = "";

		} else {
			$file = test_input($_POST['file']);
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

	if (isset($firstName) && !empty($firstName) && preg_match("/^[a-zA-Z ]*$/",$firstName) && isset($lastName) && !empty($lastName)  && preg_match("/^[a-zA-Z ]*$/",$lastName)&& isset($file) && !empty($file) && isset($photoDesc) && !empty($photoDesc) && isset($photoTags) && !empty($photoTags) && isset($copyright) && !empty($copyright) && isset($access) && !empty($access) && !$error){
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
		
	} else {
		include "content.inc";
	}

	include "footer.inc";
	
	
?>