<?php
error_reporting(E_ALL ^ E_DEPRECATED);

	define('DB_HOST', 'localhost'); 
	define('DB_NAME', 'upcast'); 
	define('DB_USER','root'); 
	define('DB_PASSWORD',''); 

	$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: ".mysql_error()); 
	$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error()); 

	
if(isset($_GET['share'])){
	$uid = str_replace(" ","",$_GET['uid']);
	$mysqlquery = mysql_query("SELECT * FROM upcast_photos_reg WHERE photo_uid='$uid'");
	$row = mysql_fetch_assoc($mysqlquery);
	$photo_path = $row['photo_path'];
	header("Location: http://www.facebook.com/sharer.php?u=$photo_path");
}
	
if(isset($_GET['like'])){
    $ip = $_SERVER['REMOTE_ADDR'];
    $sqlquery = mysql_query("INSERT INTO upcast_banned_ips (ipaddress) VALUES ('$ip')");
	$uid = str_replace(" ","",$_GET['uid']);
	$mysqlquery = mysql_query("SELECT * FROM upcast_photos_reg WHERE photo_uid='$uid'");
	$row = mysql_fetch_assoc($mysqlquery);
	$photo_likes = $row['photo_likes'];
	$photo_likes = $photo_likes + 1;
	$mysql = mysql_query("UPDATE upcast_photos_reg SET photo_likes=$photo_likes WHERE photo_uid='$uid'");
	$message = "wrong answer";
	echo "<script type='text/javascript'>alert('$message');</script>";
	//header("Location: index.php");
	//exit;
}














?>