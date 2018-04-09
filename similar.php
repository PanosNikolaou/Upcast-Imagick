<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>UpCast</title>
<link rel="stylesheet" type="text/css" href="lightbox/css/jquery.lightbox-0.5.css" />
<link rel="stylesheet" type="text/css" href="css/demo.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="lightbox/js/jquery.lightbox-0.5.pack.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/bootstrap.min.js"></script>
    <link href="css/sticky-footer.css" rel="stylesheet">

</head>

<?php	

		session_start();
		if (!isset($_SESSION["userid"])){
		header("Location: loggedindex.php");
	}


error_reporting(E_ALL ^ E_DEPRECATED);

	define('DB_HOST', 'localhost'); 
	define('DB_NAME', 'upcast'); 
	define('DB_USER','root'); 
	define('DB_PASSWORD',''); 

	$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: ".mysql_error()); 
	$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error()); 
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
      <a class="navbar-brand" href="index.php">UpCast</a>
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

<?php

// init the image objects
$image1 = new imagick();
$image2 = new imagick();

// set the fuzz factor (must be done BEFORE reading in the images)
$image1->SetOption('fuzz', '2%');

$filename = $_GET["uid"] . ".jpg";


// read in the images
$image1->readImage($_SERVER['DOCUMENT_ROOT'] . '/upcast/gallery/' . $filename);

$directory = 'gallery';
$allowed_types=array('jpg','gif','png');
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
		
		$image2->readImage($_SERVER['DOCUMENT_ROOT'] . '/upcast/gallery/' . $file);
		
		// compare the images using METRIC=1 (Absolute Error)
		$result = $image1->compareImages($image2, Imagick::METRIC_MEANSQUAREERROR);

		/*
		you get '0' for undefined, '1' for red, gray, and cyan, '2' for green and magenta,
		'4' for blue and yellow, and '8' for alpha, opacity, and matte, or '32' for black and index.
		*/
		
		//$imagick1 = $image1->getImageChannelStatistics();
		//$imagick2 = $image2->getImageChannelStatistics();

		//print_r($imagick2);
		//echo $imagick2[1]['mean'] . "</br>";
		//echo $imagick2[2]['mean'] . "</br>";
		//echo $imagick2[4]['mean'] . "</br>";
		//$imagemeans = array();
		
		if($result[1]<0.06){
		if(($i+1)%5==0) $nomargin='nomargin';
		$mysql = mysql_query("SELECT * FROM upcast_photos_reg WHERE photo_uid='$title'");
		$user = mysql_fetch_assoc($mysql);
		$descritption = $user['photo_text'];
		echo '
		<div class="picont">
		<div class="pic '.$nomargin.'" style="background:url('.$directory.'/'.$file.') no-repeat 50% 50%;">
		<a href="'.$directory.'/'.$file.'" title="'.$descritption.'" target="_blank">'.$descritption.'</a>
		<div class="desc"> MSE :'.$result[1] .' </div>
		</div>
		</div>';	
		$i++;
		}
	}		
}

closedir($dir_handle);

?>


<div class="clear"></div>
</div>

    <footer class="footer">
      <div class="container">
        <p class="text-muted">Copyright NIT</p>
      </div>
    </footer>

</body>
</html>
