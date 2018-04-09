<?php
	error_reporting(E_ALL ^ E_DEPRECATED);
	session_start();

	if(isset($_SESSION["userid"])){
	$userid = $_SESSION["userid"];
	//echo $userid;
	}else {
	header('Location:index.php');	
	}
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
	    <li><a href="usergallery.php">Έκθεση χρήστη</a></li>
		<li><a href="histograms.php">Ιστογράμματα</a></li>
	    <li><a href="upload.php">Μεταφόρτωση νέας εικόνας</a></li>
		<li><a href="topfive.php">Κορυφαίες εικόνες</a></li>
        <li><a href="logout.php">Αποσύνδεση</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->

  </div><!-- /.container-fluid -->

</nav>


 <div class = "form-signin">
	<div id="message">
	<?php include 'uploadphp.php';?>
	</div>
<form action="" enctype="multipart/form-data" id="form" method="post" accept-charset="UTF-16" name="form">

	<input id="file" class = "form-control" name="file" type="file" style="width: 500px">
	</br>	
	Κατηγορία εικόνας
	</br>
	<input type="radio" name="category" value="people"> Άνθρωποι
	</br> 
	<input type="radio" name="category" value="animals"> Ζώα
	</br>
	<input type="radio" name="category" value="landscapes"> Τοπία
	</br>
	<input type="radio" name="category" value="other" checked> Άλλα
	</br>
	<div id="preview">
	<span class="pre">Προεπισκόπηση Εικόνας</span>
	<img id="previewimg" src="">
	</div>
	</br>
	<input id="text" size="50" placeholder = "Κείμενο εικόνας" class ="form-control" name="phototext" type="text" style="width: 500px">
	</br>	
	<input type="text" class ="form-control" placeholder = "Τοποθεσία" name= "address" id="address" style="width: 500px"/>
	<br>
	<div id="us2" style="width: 500px; height: 500px;"></div>	
	</br>	
	<input type="text" class ="form-control" placeholder = "latitude" name="latitude" id="latitude" style="width: 500px" />
	</br>
	<input type="text" class ="form-control" placeholder = "longitude" name="longitude" id="longitude" style="width: 500px" />				
	<script>$('#us2').locationpicker({
	location: {latitude: 37.51029322806887, longitude: 22.37235379219055},	
	radius: 300,
	inputBinding: {
        latitudeInput: $('#latitude'),
        longitudeInput: $('#longitude'),
        radiusInput: $('#radius'),
        locationNameInput: $('#address')
		},
	enableAutocomplete: true,
	markerIcon: 'map-marker-2-xl.png'
	});
	</script>
		</br>
	<input id="submit" class = "btn btn-lg btn-primary btn-block" name="submit" type="submit" value="Μεταφόρτωση" style="width: 500px">
	</br>
</div>
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