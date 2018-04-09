<form action="" method="POST">
    <input type="range" min="1" max="12" step="1" value="1" id="foo" name="passengers" onchange='document.getElementById("bar").value = "Slider Value = " + document.getElementById("foo").value;'/>
<input type="text" name="bar" id="bar" value="Slider Value = 1" disabled />
<br />
<input type=submit value=Submit />
</form>

<?php
if(isset($_POST["passengers"])){
    echo "Number of selected passengers are:".$_POST["passengers"];
    // Your Slider value is here, do what you want with it. Mail/Print anything..
} else{
Echo "Please slide the Slider Bar and Press Submit.";
}

$radius =1;
    $imagick = new \Imagick(realpath($_SERVER['DOCUMENT_ROOT'] . '/demo/gallery/56fce136f0be5.jpg'));
    $imagick->edgeImage($radius);
    //header("Content-Type: image/jpg");
    //echo $imagick->getImageBlob();


?>