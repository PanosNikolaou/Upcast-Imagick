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
<!DOCTYPE html>
<html> 
<head> 
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
  <title>Google Maps Multiple Markers</title> 
  <script src="http://maps.google.com/maps/api/js?sensor=false" 
          type="text/javascript"></script>
		  
	<style TYPE="text/css">
    <!--
	#wrapper { width: 600px; margin: 0 auto }
	#map_canvas { height: 500px; width: 600px }    	
	-->
    </style>
</head> 
<body>

	<div id="map" style="width: 1000px; height: 600px;"></div>

	<script>

	var locationsarray = array(100);
	</script>
		
	<?php

	$i=0;
	$result = mysql_query("SELECT * FROM upcast_photos_reg");
	echo '<script>';
    echo 'var locations = [';
	while($row = mysql_fetch_array( $result )) {	
	$lat = $row['photo_lat'];
	$lng = $row['photo_lng'];
	$text = $row['photo_text'];
    echo '["' . $text . '", '. $lat .',' . $lng .' ,' . $i .'],';
	$i++;
	}
	echo '["' . $text . '", '. $lat .',' . $lng .' ,' . $i .']';
	echo '];';
	echo '</script>';

	?>
		
	<script type="text/javascript">

    function toggleBounce () {
        if (marker.getAnimation() != null) {
            marker.setAnimation(null);
        } else {
            marker.setAnimation(google.maps.Animation.BOUNCE);
        }
    }
	
	var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 5,
      center: new google.maps.LatLng(38.844682, 22.695313),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var marker, i;

    for (i = 0; i < locations.length; i++) {  
		marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map,
		animation: google.maps.Animation.DROP,
		title: locations[i][0]
      });

	infowindow = new google.maps.InfoWindow({
        content: "<div><img width='154' height='255' src='thumbnail.jpg'</div>"
    });
	  
    google.maps.event.addListener(marker, 'click', function () {
        toggleBounce();
        infowindow.open(map, marker);
        setTimeout(toggleBounce, 1500);
		map.setZoom(9);
		map.setCenter(marker.getPosition());
    });
	}
  </script>
</body>
</html>