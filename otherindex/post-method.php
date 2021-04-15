<?php

	$firstName = "";
	$lastName = "";
	$file = "";
	$photoDesc = "";
	$photoTags = "";
	$copyright = "";
	$access = "";
	
	if (isset($_POST['submit'])){
	
		if (empty($_POST['first-name'])){
			$firstName =  "";
		} else {
			$firstName = $_POST['first-name'];
		}
		
		if (empty($_POST['last-name'])){
			$lastName =  "";
		} else {
			$lastName = $_POST['last-name'];
		}
		
		if (empty($_POST['file'])){
			$file =  "";
		} else {
			$file = $_POST['file'];
		}
		
		if (empty($_POST['description'])){
			$photoDesc =  "";
		} else {
			$photoDesc = $_POST['description'];
		}
		
		if (empty($_POST['tag'])){
			$photoTags =  "";
		} else {
			$photoTags = $_POST['tag'];
		}
		
		if (empty($_POST['copyright'])){
			$copyright = "";
		} else {
			$copyright = $_POST['copyright'];
		}
		
		if (empty($_POST['access'])){
			$access = "";
		} else {
			$access = $_POST['access'];
		}
			
	}
	
	
?>