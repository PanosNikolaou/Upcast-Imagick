<?php
// init the image objects
$image1 = new imagick();
$image2 = new imagick();

// set the fuzz factor (must be done BEFORE reading in the images)
$image1->SetOption('fuzz', '5%');

// read in the images
// read in the images
$image1->readImage($_SERVER['DOCUMENT_ROOT'] . '/upcast/histograms/56fd9b4fb5638.jpg');
$image2->readImage($_SERVER['DOCUMENT_ROOT'] . '/upcast/histograms/56fd9b59c5a3c.jpg');

// compare the images using METRIC=1 (Absolute Error)
$result = $image1->compareImages($image2, Imagick::METRIC_MEANSQUAREERROR);

//echo $result[1];

$result[0]->setImageFormat("png");

header("Content-Type: image/png");

echo $result[0];

?>