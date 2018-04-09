<?php
$width =200;
$height =200;
$adaptiveOffset =0.81;

    $imagick = new \Imagick(realpath($_SERVER['DOCUMENT_ROOT'] . '/demo/gallery/56fce136f0be5.jpg'));
    $adaptiveOffsetQuantum = intval($adaptiveOffset * \Imagick::getQuantum());
    $imagick->adaptiveThresholdImage($width, $height, $adaptiveOffsetQuantum);
    header("Content-Type: image/jpg");
    echo $imagick->getImageBlob();
?>