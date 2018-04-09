<?php

	if(isset($_SESSION["userid"])){
	$userid = $_SESSION["userid"];
	//echo $userid;
	}

 function getColorStatistics($histogramElements, $colorChannel) {
    $colorStatistics = [];

    foreach ($histogramElements as $histogramElement) {
        $color = $histogramElement->getColorValue($colorChannel);
        $color = intval($color * 255);
        $count = $histogramElement->getColorCount();

        if (array_key_exists($color, $colorStatistics)) {
            $colorStatistics[$color] += $count;
        }
        else {
            $colorStatistics[$color] = $count;
        }
    }

    ksort($colorStatistics);
    
    return $colorStatistics;
}
    


function getImageHistogram($imagePath,$filename) {

    $backgroundColor = 'black';

    $draw = new \ImagickDraw();
    $draw->setStrokeWidth(0); //make the lines be as thin as possible

    $imagick = new \Imagick();
    $imagick->newImage(500, 500, $backgroundColor);
    $imagick->setImageFormat("png");
    $imagick->drawImage($draw);

    $histogramWidth = 256;
    $histogramHeight = 100; // the height for each RGB segment

    $imagick = new \Imagick(realpath($imagePath));
    //Resize the image to be small, otherwise PHP tends to run out of memory
    //This might lead to bad results for images that are pathologically 'pixelly'
    $imagick->adaptiveResizeImage(200, 200, true);
    $histogramElements = $imagick->getImageHistogram();

    $histogram = new \Imagick();
    $histogram->newpseudoimage($histogramWidth, $histogramHeight * 3, 'xc:black');
    $histogram->setImageFormat('png');

    $getMax = function ($carry, $item)  {
        if ($item > $carry) {
            return $item;
        }
        return $carry;
    };

    $colorValues = [
        'red' => getColorStatistics($histogramElements, \Imagick::COLOR_RED),
        'lime' => getColorStatistics($histogramElements, \Imagick::COLOR_GREEN),
        'blue' => getColorStatistics($histogramElements, \Imagick::COLOR_BLUE),
    ];

    $max = array_reduce($colorValues['red'] , $getMax, 0);
    $max = array_reduce($colorValues['lime'] , $getMax, $max);
    $max = array_reduce($colorValues['blue'] , $getMax, $max);

    $scale =  $histogramHeight / $max;

    $count = 0;
    foreach ($colorValues as $color => $values) {
        $draw->setstrokecolor($color);

        $offset = ($count + 1) * $histogramHeight;

        foreach ($values as $index => $value) {
            $draw->line($index, $offset, $index, $offset - ($value * $scale));
        }
        $count++;
    }

    $histogram->drawImage($draw);
    
	$histogram->writeImage ($_SERVER['DOCUMENT_ROOT'] . '/upcast/histograms/' . $filename);

}

function get_ip_address() {
    $ip_keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
    foreach ($ip_keys as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                // trim for safety measures
                $ip = trim($ip);
                // attempt to validate IP
                if (validate_ip($ip)) {
                    return $ip;
                }
            }
        }
    }
    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
}

function validate_ip($ip)
{
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
        return false;
    }
    return true;
}

error_reporting(E_ALL ^ E_DEPRECATED);

	define('DB_HOST', 'localhost'); 
	define('DB_NAME', 'upcast'); 
	define('DB_USER','root'); 
	define('DB_PASSWORD',''); 

	$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: ".mysql_error()); 
	$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error()); 
	
$ip=$_SERVER['REMOTE_ADDR'];

//echo "IP address= $ip";	

//echo "IP:" . get_ip_address();
	
	
if (isset($_POST['submit'])) {

if (isset($_POST['category']))  $category = $_POST['category'];
//echo $category . '</br>';

if (isset($_POST['latitude'])) { $latitude = $_POST['latitude'];} else{$latitude=0;}
//echo $latitude . '</br>';

if (isset($_POST['longitude']))  {$longitude = $_POST['longitude'];} else{$longitude=0;}
//echo $longitude . '</br>';

$text = $_POST['phototext'];
//echo $text . '</br>';

$validextensions = array("jpeg", "jpg", "png");
$temporary = explode(".", $_FILES["file"]["name"]);
$file_extension = end($temporary);

if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
) && ($_FILES["file"]["size"] < 1000000)//Approx. 1000kb files can be uploaded.
&& in_array($file_extension, $validextensions)) {

if ($_FILES["file"]["error"] > 0) {
echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
} else {
$photouid = uniqid();	
$filename = $photouid . "." . $file_extension ;

//echo "<br/><b>File Name:</b> " . $_FILES["file"]["name"] . "<br>";
//echo "<b>File UID:</b> " . $filename . "<br>";
//echo "<b>Type:</b> " . $_FILES["file"]["type"] . "<br>";
//echo "<b>Size:</b> " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
//echo "<b>Temp file:</b> " . $_FILES["file"]["tmp_name"] . "<br>";


move_uploaded_file($_FILES["file"]["tmp_name"], "gallery/" . $filename);
$imgFullpath = "http://".$_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"].'?').'/'. "gallery/" . $filename ;


    $imagick = new \Imagick(realpath($_SERVER['DOCUMENT_ROOT'] . '/upcast/gallery/' . $filename));
    $imagick->scaleImage(600, 0);
	$imagick->writeImage ($_SERVER['DOCUMENT_ROOT'] . '/upcast/gallery/' . $filename);

	$imagick_type_channel_statistics = $imagick->getImageChannelStatistics();


    //print_r($imagick_type_channel_statistics);
	
	//echo '<pre>'; print_r($imagick_type_channel_statistics); echo '</pre>';

	$myfile = fopen($_SERVER['DOCUMENT_ROOT'] . '/upcast/means/' . $photouid . '.txt', "w") or die("Unable to open file!");
	//fwrite($myfile, $txt);
	//echo "<pre>";
	$txt = "Mean\tMinima\tMaxima\tStandardDeviation\tDepth";
	fwrite($myfile, $txt);
	foreach ( $imagick_type_channel_statistics as $var ) {
    $txt = "\n" . $var['mean'] . "\t" . $var['minima'] . "\t" . $var['maxima'] . "\t" . $var['standardDeviation'] . "\t" . $var['depth'];
	fwrite($myfile, $txt);
	}
	fclose($myfile);
	//echo '</pre>';

	//echo "</br>";
	
	/*
	you get '0' for undefined, '1' for red, gray, and cyan, '2' for green and magenta, '4' for blue and yellow, and '8' for alpha, opacity, and matte, or '32' for black and index.  
	Why do multiple channels share the same evaluated integer values?  
	That's because they're colors from different color spaces, with Red/Green/Blue being the RGB spectrum, Cyan/Magenta/Yellow/blacK being the CMYK spectrum
	*/
	
    //$secimagick = new \Imagick();
    //$secimagick->newPseudoImage(200, 200, "xc:white");
    //$fx = 'xx=i-w/2; yy=j-h/2; rr=hypot(xx,yy); (.5-rr/140)*1.2+.5';
    //$fxImage = $secimagick->fxImage($fx);
	//$fxImage->setimageformat('png');
	//echo $fxImage->getImageBlob();
	//$secimagick->writeImage ($_SERVER['DOCUMENT_ROOT'] . '/demo/gallery/' . $fxImage);

	getImageHistogram($_SERVER['DOCUMENT_ROOT'] . '/upcast/gallery/' . $filename,$filename); 
	
	if(isset($_SESSION["userid"])){
	$userid = $_SESSION["userid"];
	//echo $userid;
	}else {
	header('Location:index.php');	
	}
// DB connection & 
$query = mysql_query("INSERT INTO upcast_photos_reg (photo_uid,photo_name,photo_text,photo_category_id,photo_path,photo_lat,photo_lng,photo_likes,username) 
											VALUES ('$photouid','$filename','$text','$category','$imgFullpath','$latitude','$longitude','0','$userid')");
if($query) { echo "Η εικόνα μεταφορτώθηκε επιτυχώς"; } 
else {echo "Η μεταφόρτωση της εικόνας απέτυχε"; }
//echo mysql_errno($con) . ": " . mysql_error($con) . "\n";

//echo "<b>Stored in:</b><a href = '$imgFullpath' target='_blank'> " .$imgFullpath.'<a>';

}
} else {
echo "<span>***Invalid file Size or Type***<span>";
}
}
?>