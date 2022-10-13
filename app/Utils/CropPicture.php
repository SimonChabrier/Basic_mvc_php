<?php
namespace App\Utils;

class CropPicture 
{

    /**
     * @param array $_FILES['picture']
     * @param Course $course
     * @return void
     */
    public static function cropPicture($picture)
    {
        $cropped = imagecropauto($picture,IMG_CROP_DEFAULT);

        if ($cropped !== false) { // in case a new image object was returned
            imagedestroy($picture);    // we destroy the original image
            $picture = $cropped; 
            return $picture;      // and assign the cropped image to $im
        }

        
    }

}