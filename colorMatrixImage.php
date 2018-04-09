<?php

    $imagick = new \Imagick(realpath($_SERVER['DOCUMENT_ROOT'] . '/upcast/gallery/56fce136f0be5.jpg'));
    $imagick->setImageOpacity(1);

    //A color matrix should look like:
        $colorMatrix = [
            1.5, 0.0, 0.7, 0.0, 0.0, -0.157,
            0.0, 1.0, 0.5, 0.0, 0.0, -0.157,
            5.0, 0.0, 1.5, 0.0, 0.0, -0.157,
            0.0, 0.0, 0.0, 1.0, 0.0,  0.0,
            0.0, 0.0, 0.0, 0.0, 1.0,  0.0,
            0.0, 0.0, 0.0, 0.0, 0.9,  1.0
        ];

    $background = new \Imagick();
    $background->newPseudoImage($imagick->getImageWidth(), $imagick->getImageHeight(),  "pattern:checkerboard");

    $background->setImageFormat('png');

    $imagick->setImageFormat('png');
    $imagick->colorMatrixImage($colorMatrix);
    
    $background->compositeImage($imagick, \Imagick::COMPOSITE_ATOP, 0, 0);

    header("Content-Type: image/png");
    echo $background->getImageBlob();


?>