<?php
	error_reporting(E_ALL ^ E_DEPRECATED);
	session_start();

	define('DB_HOST', 'localhost'); 
	define('DB_NAME', 'upcast'); 
	define('DB_USER','root'); 
	define('DB_PASSWORD',''); 

	$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: ".mysql_error()); 
	$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error()); 
	
?>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Upload Image</title>
<script src="js/jquery.min.js"></script>
<script src="js/upscript.js"></script>
<link rel="stylesheet" href="css/bootstrap.min.css">
<script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places'></script>
<script src="locationpicker/dist/locationpicker.jquery.js"></script>
<link href="css/sticky-footer.css" rel="stylesheet">

      <style>
         
         .form-signin {
            max-width: 500px;
            padding: 0px;
            margin: 0 auto;
            color: #017572;
         }
		
		.info-windows{
		width: 144px;
		height:106px;
		color: #ffedc8;
		font: "Lucida Grande", "Lucida Sans Unicode", Helvetica, Arial, Verdana, sans-serif;
		max-width: none;
		padding:0px;
		margin:0px;
		}
		
		.info-windows img{ 
		padding:0px;
		margin:0px;
		}
	
		#map_canvas {height:200px}
 
		#map_canvas  img  {max-width: none;}
		
		 </style>
</head>
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
	  	<li><a href="search.php">Αναζήτηση φωτογραφιών</a></li>
		<li><a href="searchmapphotos.php">Αναζήτηση φωτογραφιών σε χάρτη</a></li>
		<li><a href="topfive.php">Κορυφαίες εικόνες</a></li>
		<li><a href="login.php">Σύνδεση/Εγγραφή</a></li>
		<li><a href="contactus.php">Επικοινωνήστε μαζί μας</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div>
	<div id="map" style="width: 100%; height: 600px;"></div>
	<?php
	$i=0;
	$result = mysql_query("SELECT * FROM upcast_photos_reg");
	echo '<script>';
    echo 'var locations = [';
	while($row = mysql_fetch_array( $result )) {
	$lat = $row['photo_lat'];
	$lng = $row['photo_lng'];
	$text = $row['photo_text'];
	$name = $row['photo_path'];
	$category = $row['photo_category_id'];
	$marker_colour = "";
	if ($category==="landscapes"){
		$marker_colour = "http://maps.google.com/mapfiles/ms/icons/blue-pushpin.png";
	}
	elseif ($category==="other"){
		$marker_colour = "http://maps.google.com/mapfiles/ms/icons/grn-pushpin.png";
	}
	elseif ($category==="animals"){
		$marker_colour = "http://maps.google.com/mapfiles/ms/icons/ylw-pushpin.png";
	}    
	elseif ($category==="people"){
		$marker_colour = "http://maps.google.com/mapfiles/ms/icons/red-pushpin.png";
	}   	
	echo '["' . $name . '", '. $lat .',' . $lng . ',' . $i . ',"' . $text . '","'. $marker_colour . '"],';
	$i++;
	}
	echo '["' . $name . '", '. $lat .',' . $lng . ',' . $i . ',"' . $text . '","'. $marker_colour . '"]';
	echo '];';
	echo '</script>';
	?>
		
	<script type="text/javascript">
	
	var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 5,
      center: new google.maps.LatLng(38.844682, 22.695313),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var marker, i, id;

    for (i = 0; i < locations.length; i++) {  
		marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map,
		icon : locations[i][5],
		animation: google.maps.Animation.DROP,
		title : locations[i][4],
		content: locations[i][4] + "<br/><center><img id=\"map_canvas\" src='" + locations[i][0] + "'  /> </center>"
      });
				 	 
	infowindow = new google.maps.InfoWindow({
		//content: html //"<div> <img width='154' height='255' src=thumbnail.jpg /> </div>"
	});

	  
    google.maps.event.addListener(marker, 'click', function () {
        infowindow.setContent(this.content);
        infowindow.open(map, this);
    });
	}
  </script>
</body>
</html>
</div>
    <div id="message"></div>
<div id="clear"></div>
</div>
    <footer class="footer">
      <div class="container">
        <p class="text-muted">Copyright NIT</p>
      </div>
    </footer>
</div>
</body>
</html>