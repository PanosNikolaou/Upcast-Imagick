<?php
	error_reporting(E_ALL ^ E_DEPRECATED);
	session_start();
	define('DB_HOST', 'localhost'); 
	define('DB_NAME', 'upcast'); 
	define('DB_USER','root'); 
	define('DB_PASSWORD',''); 

	$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: ".mysql_error()); 
	$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error()); 
	
// Gets data from URL parameters
$title = $_GET['title'];
//echo $title;
$sql=mysql_query("SELECT * FROM upcast_photos_reg WHERE photo_uid = '$title'");
$user = mysql_fetch_array($sql);
echo $user['photo_path'];
?>