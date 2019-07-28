<?php

	// Error Reportion 

	ini_set('display_errors', 'On');
	error_reporting(E_ALL);

	include 'admin/connect.php';

	$sessionUser = '';
	
	if (isset($_SESSION['user'])) {  
		$sessionUser = $_SESSION['user'];
	}

	//Routes

	$tpl    ='includes/templates/';  //Template Directory 
	$func   ='includes/functions/'; // Functions Directory
	$css    ='layout/css/';  //CSS Directory 
	$js     ='layout/js/';  //JS Directory 

	// Include the important files 

	include $func . 'functions.php';
	include $tpl . 'header.php'; 
	 
