<?php

            /*
			This is very useful when you need to identify identical images, because if you just hash the files, you may get different hashes even if the image is the same pixel by pixel because of differences in metadata or different format (ie PNG vs BMP) or perhaps stray bytes at the end of file etc...
			*/
    
        // Imagick Type
        // ---------------------------------------------

    $imagick_type = new Imagick();
    
        // Open File
        // ---------------------------------------------
        
    $file_to_grab = $_SERVER['DOCUMENT_ROOT'] . '/upcast/gallery/test2.jpg';
    
    $file_handle_for_viewing_image_file = fopen($file_to_grab, 'a+');
    
        // Grab File
        // ---------------------------------------------

    $imagick_type->readImageFile($file_handle_for_viewing_image_file);
    
        // Get Image SHA-256 Signature / Hash Value
        // ---------------------------------------------
        
    $imagick_type_signature = $imagick_type->getImageSignature();
    
        // Print Image Signature / Hash Value
        // ---------------------------------------------
        
    print($imagick_type_signature);

?>