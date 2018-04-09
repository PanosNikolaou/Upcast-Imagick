<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>UpCast</title>
<link rel="stylesheet" type="text/css" href="lightbox/css/jquery.lightbox-0.5.css" />
<link rel="stylesheet" type="text/css" href="css/demo.css" />
<link href="css/sticky-footer.css" rel="stylesheet">
<link rel="stylesheet" href="css/bootstrap.min.css">

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="lightbox/js/jquery.lightbox-0.5.pack.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script src="js/bootstrap.min.js"></script>

</head>

<?php	

		session_start();
		if (isset($_SESSION["userid"])){
		//header("Location: loggedindex.php");
	}


error_reporting(E_ALL ^ E_DEPRECATED);


	$descriptionarray = array();


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
	if(!$sqlquery)
	echo "<script type='text/javascript'>alert('This ip has already voted');</script>"; 
	$uid = str_replace(" ","",$_GET['uid']);
	$mysqlquery = mysql_query("SELECT * FROM upcast_photos_reg WHERE photo_uid='$uid'");
	$row = mysql_fetch_assoc($mysqlquery);
	$photo_likes = $row['photo_likes'];
	$photo_likes = $photo_likes + 1;
	$mysql = mysql_query("UPDATE upcast_photos_reg SET photo_likes=$photo_likes WHERE photo_uid='$uid'");

	}
	
	$filtersarray = array();
	$textarray = array();
	
	if(isset($_POST['people'])){
		//echo "people"; 
		$filtersarray[1] = "people";
	}
	if(isset($_POST['animals'])){
		//echo "animals"; 
		$filtersarray[2] = "animals";
	}
	if(isset($_POST['landscapes'])){
		//echo "landscapes"; 
		$filtersarray[3] = "landscapes";
	}	
	if(isset($_POST['other'])){
		//echo "other"; 
		$filtersarray[4] = "other";
	}	
	//print_r ($filtersarray);
	
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
	  	<li><a href="search.php">Αναζήτηση φωτογραφιών</a></li>
		<li><a href="searchmapphotos.php">Αναζήτηση φωτογραφιών σε χάρτη</a></li>
		<li><a href="topfive.php">Κορυφαίες εικόνες</a></li>
		<li><a href="login.php">Σύνδεση/Εγγραφή</a></li>
		<li><a href="contactus.php">Επικοινωνήστε μαζί μας</a></li>
		</ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="container">
<form action="search.php" method="post" name="catform" class="form-inline" role="form">
<p class="bg-info"> <h4> Φιλτράρισμα βάση κατηγοριών </h4></p>
<label class="checkbox-inline"><input type="checkbox" checked="checked" name="people">Άνθρωποι</label>
<label class="checkbox-inline"><input type="checkbox" checked="checked" name="animals">Ζώα</label>
<label class="checkbox-inline"><input type="checkbox" checked="checked" name="landscapes">Τοπία</label>
<label class="checkbox-inline"><input type="checkbox" checked="checked" name="other">Άλλα</label>
<button type="submit" name="catsub" class="btn btn-success">Προβολή</button>
<p class="bg-info"> <h4> Αναζήτηση βάση κειμένου </h4></p>
<input type="text" class="form-control" name="srctxt">
<button type="submit" name="srchsub" class="btn btn-success">Υποβολή</button>
</form>
</div>

<div id="container">
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
		$description  = $user['photo_text'];
		$category = $user['photo_category_id'];
		
			foreach($filtersarray as $x=>$x_value)
			{			
				if(strcmp($category,$x_value)==0){				
				if(isset($_POST['srctxt'])){
					$txtstring = $_POST['srctxt'];
					if($txtstring!=""){
					if(strchr($description,$txtstring)){				
						echo '
						<div class="picont">
						<div class="pic '.$nomargin.'" style="background:url('.$directory.'/'.$file.') no-repeat 50% 50%;">
						<a href="'.$directory.'/'.$file.'" title="'.$description .'" target="_blank">'.$description .'</a>
						<div class="desc">
						<form action="index.php">
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
						}						
					}
				}
				if(isset($_POST['catsub'])){
				if(strcmp($category,$x_value)==0){				
						echo '
						<div class="picont">
						<div class="pic '.$nomargin.'" style="background:url('.$directory.'/'.$file.') no-repeat 50% 50%;">
						<a href="'.$directory.'/'.$file.'" title="'.$description .'" target="_blank">'.$description .'</a>
						<div class="desc">
						<form action="index.php">
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
				}
				}
				}
			}
		$i++;
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
