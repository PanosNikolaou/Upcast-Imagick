<?php
$canvas = new Imagick(realpath($_SERVER['DOCUMENT_ROOT'] . '/demo/gallery/56ff3a5e292ad.jpg'));
$kernel = ImagickKernel::fromBuiltIn(Imagick::KERNEL_OCTAGON, "3");
$canvas->morphology(Imagick::MORPHOLOGY_EDGE, 1, $kernel);
header("Content-Type: image/png");
echo $canvas->getImageBlob();
?>