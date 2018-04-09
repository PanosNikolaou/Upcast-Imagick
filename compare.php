<?php
// init the image objects
$image1 = new imagick();
$image2 = new imagick();

// set the fuzz factor (must be done BEFORE reading in the images)
$image1->SetOption('fuzz', '2%');

// read in the images
// read in the images
$image1->readImage($_SERVER['DOCUMENT_ROOT'] . '/upcast/gallery/56ff3ac7029d9.jpg');
$image2->readImage($_SERVER['DOCUMENT_ROOT'] . '/upcast/gallery/56ff3ad031711.jpg');

// compare the images using METRIC=1 (Absolute Error)
$result = $image1->compareImages($image2, 1);

$result[0]->setImageFormat("png");

header("Content-Type: image/png");
//echo $image1->getImageBlob();
//echo $image2->getImageBlob();
echo $result[0];
?>

