<?php

	include 'connect.php';

	//Routes

	$tpl    ='includes/templates/';  //Template Directory 
	$func   ='includes/functions/'; // Functions Directory
	$css    ='layout/css/';  //CSS Directory 
	$js     ='layout/js/';  //JS Directory 

	// Include the important files 

	include $func . 'functions.php';
	include $tpl . 'header.php'; 
	 

	// Include Navbar On All Pages Expect The One With $noNavbar Variable 
	
	if (!isset($noNavbar)) { include $tpl . 'navbar.php'; } 