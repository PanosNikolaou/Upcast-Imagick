<?php

/* Text to write */
$text = "Hello World!";

/* Create Imagick objects */
$image = new Imagick();
$draw = new ImagickDraw();
$color = new ImagickPixel('#000000');
$background = new ImagickPixel('none'); // Transparent

/* Font properties */
$draw->setFont('Arial');
$draw->setFontSize(50);
$draw->setFillColor($color);
$draw->setStrokeAntialias(true);
$draw->setTextAntialias(true);

/* Get font metrics */
$metrics = $image->queryFontMetrics($draw, $text);

/* Create text */
$draw->annotation(0, $metrics['ascender'], $text);

/* Create image */
$image->newImage($metrics['textWidth'], $metrics['textHeight'], $background);
$image->setImageFormat('png');
$image->drawImage($draw);

/* Save image */
file_put_contents('file.png', $image);
?>