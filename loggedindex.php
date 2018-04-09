<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>UpCast</title>

<link rel="stylesheet" type="text/css" href="lightbox/css/jquery.lightbox-0.5.css" />
<link rel="stylesheet" type="text/css" href="css/demo.css" />
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/sticky-footer.css">

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="lightbox/js/jquery.lightbox-0.5.pack.js"></script>
<script type="text/javascript" src="js/script.js"></script>

</head>
<?php
	error_reporting(E_ALL ^ E_DEPRECATED);
	session_start();
	define('DB_HOST', 'localhost'); 
	define('DB_NAME', 'upcast'); 
	define('DB_USER','root'); 
	define('DB_PASSWORD',''); 

	$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: ".mysql_error()); 
	$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error()); 
	
	if(isset($_SESSION["userid"])){
	$userid = $_SESSION["userid"];
	//echo $userid;
	}else {
	header('Location:index.php');	
	}
	
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
	if(!$sqlquery)
	echo "<script type='text/javascript'>alert('This ip has already voted');</script>"; 
	$uid = str_replace(" ","",$_GET['uid']);
	$mysqlquery = mysql_query("SELECT * FROM upcast_photos_reg WHERE photo_uid='$uid'");
	$row = mysql_fetch_assoc($mysqlquery);
	$photo_likes = $row['photo_likes'];
	$photo_likes = $photo_likes + 1;
	$mysql = mysql_query("UPDATE upcast_photos_reg SET photo_likes=$photo_likes WHERE photo_uid='$uid'");
	}
?>	
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="loggedindex.php">UpCast</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      </ul>

      <ul class="nav navbar-nav navbar-right">
	    <li><a href="find.php">CBIR</a></li>
	    <li><a href="usergallery.php">Έκθεση χρήστη</a></li>
		<li><a href="histograms.php">Ιστογράμματα</a></li>
	    <li><a href="upload.php">Μεταφόρτωση νέας εικόνας</a></li>
		<li><a href="topfive.php">Κορυφαίες εικόνες</a></li>
        <li><a href="logout.php">Αποσύνδεση</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div id="container">

<div id="gallery">

<?php

$directory = 'gallery';

$allowed_types=array('jpg','jpeg','gif','png');
$file_parts=array();
$ext='';
$title='';
$i=0;

$dir_handle = @opendir($directory) or die("There is an error with your image directory!");

while ($file = readdir($dir_handle)) 
{
	if($file=='.' || $file == '..') continue;
	
	$file_parts = explode('.',$file);
	$ext = strtolower(array_pop($file_parts));

	$title = implode('.',$file_parts);
	$title = htmlspecialchars($title);
	
	$nomargin='';
	
	if(in_array($ext,$allowed_types))
	{
		if(($i+1)%5==0) $nomargin='nomargin';
		$mysql = mysql_query("SELECT * FROM upcast_photos_reg WHERE photo_uid='$title'");
		$user = mysql_fetch_assoc($mysql);
		$descritption = $user['photo_text'];
		//echo $descritption;
		echo '
		<div class="picont">
		<div class="pic '.$nomargin.'" style="background:url('.$directory.'/'.$file.') no-repeat 50% 50%;">
		<a href="'.$directory.'/'.$file.'" title="'.$descritption.'" target="_blank">'.$descritption.'</a>
		<div class="desc">
		<form action="loggedindex.php">
		<button class="btn" name="like" type="submit">  Like 
		<img src="like.png" height="20"/>
		</button>
		<button class="btn" name="share" type="submit">  Share this
		<img src="share.png" height="20"/>
		</button>
		<input type="hidden" name="uid" value="' . $title . '"><br>
		</form>
		</div>
		</div>
		</div>';	
		$i++;
	}	
}

closedir($dir_handle);

?>
<div class="clear"></div>
</div>
</div>

    <footer class="footer">
      <div class="container">
        <p class="text-muted">Copyright NIT</p>
      </div>
    </footer>
</body>
</html>
