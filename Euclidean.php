<?php
$canvas = new \Imagick(realpath($_SERVER['DOCUMENT_ROOT'] . '/demo/gallery/56fce136f0be5.jpg'));
$kernel = \ImagickKernel::fromBuiltIn(\Imagick::KERNEL_EUCLIDEAN, "4");
$canvas->morphology(\Imagick::MORPHOLOGY_DISTANCE, 3, $kernel);
$canvas->autoLevelImage();
header("Content-Type: image/png");
echo $canvas->getImageBlob();
?>