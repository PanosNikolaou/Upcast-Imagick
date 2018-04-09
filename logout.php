<?php
	session_start();
	unset($_SESSION["userid"]);
	unset($_SESSION["username"]);
	unset($_SESSION["password"]);
	// remove all session variables
	//session_unset(); 
	// destroy the session 
	session_destroy(); 
	$_SESSION = array();
	//echo 'You have cleaned session';
	header("Location: index.php");
	exit;
?>