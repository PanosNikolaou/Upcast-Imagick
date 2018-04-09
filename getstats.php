<?php
error_reporting(E_ALL ^ E_DEPRECATED);

	define('DB_HOST', 'localhost'); 
	define('DB_NAME', 'upcast'); 
	define('DB_USER','root'); 
	define('DB_PASSWORD',''); 

	$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: ".mysql_error()); 
	$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error()); 

if(isset($_GET['uid'])){
	$uid = str_replace(" ","",$_GET['uid']);
	
	//echo $uid . '\n';
	$file = 'means/' . $uid . '.txt';

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}
}

?>