<?php 

error_reporting(E_ALL ^ E_DEPRECATED);

define('DB_HOST', 'localhost'); 
define('DB_NAME', 'upcast'); 
define('DB_USER','root'); 
define('DB_PASSWORD',''); 

$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: ".mysql_error()); 
$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error()); 

function newuser() 
{
$username = trim($_POST['user']);	
$firstname = trim($_POST['fname']); 
$lastname = trim($_POST['lname']); 
$email = trim($_POST['email']); 
$password = trim($_POST['pass']); 
$confirmed_password = trim($_POST['verpass']);
if($password==$confirmed_password) {
$query = "INSERT INTO upcast_users (username,firstname,lastname,email,password) VALUES ('$username','$firstname','$lastname','$email','$password')"; 
$data = mysql_query ($query)or die(mysql_error()); 
if($data) { echo "YOUR REGISTRATION IS COMPLETED..."; 
header("Location: index.php");
} 
}else echo "INCORECT DATA"; 
}

function SignUp() 
{ 
if(!empty($_POST['user'])) //checking the 'user' name which is from Sign-Up.html, is it empty or have some text 
{ $query = mysql_query("SELECT * FROM upcast_users WHERE userName = '$_POST[user]' AND password = '$_POST[pass]'") or die(mysql_error()); 
if(!$row = mysql_fetch_array($query) or die(mysql_error())) 
{ newuser(); } else { echo "SORRY...YOU ARE ALREADY REGISTERED USER..."; } } 
} 

if(isset($_POST['submit'])) { SignUp(); 
} 

?>