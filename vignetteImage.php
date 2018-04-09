<?php
    $imagick = new \Imagick(realpath($_SERVER['DOCUMENT_ROOT'] . '/upcast/gallery/56fce136f0be5.jpg'));
    $imagick->vignetteImage(0, 1, 4, 4);
    header("Content-Type: image/jpg");
    echo $imagick->getImageBlob();
?>