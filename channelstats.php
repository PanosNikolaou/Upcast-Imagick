<?php
$image = new Imagick($_SERVER['DOCUMENT_ROOT'] . '/demo/test.jpg');
    $imagick_type_channel_statistics = $image->getImageChannelStatistics();

        // Print Statistics
        // ---------------------------------------------

    print_r($imagick_type_channel_statistics);
	print( "</br>" );
?>