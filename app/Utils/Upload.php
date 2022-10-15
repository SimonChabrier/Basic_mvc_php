<?php
namespace App\Utils;

class Upload 
{
    const ROOT = './assets/images/';

    /**
     * @param array $_FILES['picture']
     * @param Course $course
     * @return void
     */
    static function processUploadPicture(array $picture, object $object)
    {   
        $picture_name = $picture['name'];
        $picture_tmp_name = $picture['tmp_name'];
        $picture_size = $picture['size'];
        $picture_error = $picture['error'];
        $picture_type = $picture['type'];
        $picture_width = getimagesize($picture_tmp_name);
        $picture_width = $picture_width[0];
        $picture_height = getimagesize($picture_tmp_name);
        $picture_height = $picture_height[1];
        $picture_ext = explode('.', $picture_name);
        $picture_actual_ext = strtolower(end($picture_ext));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($picture_actual_ext, $allowed)) {
            if ($picture_error === 0) {
                if ($picture_size < 100000 && $picture_width > 400 && $picture_height > 400) {

                    $picture_new_name = uniqid('', true) . "." . $picture_actual_ext;
                    $picture_destination = self::ROOT . $picture_new_name;
                    move_uploaded_file($picture_tmp_name, $picture_destination);
                    $object->setPicture($picture_new_name);
                    chmod(self::ROOT . $picture_new_name, 0777);
                    self::cropPicture($picture_new_name, 400, 400);

                } else {
                    $object->setPicture('default.jpg');
                    echo "Le fichier est trop volumineux!";
                }
            } else {
                echo "Il y a eu une erreur dans l'ajout du fichier!";
            }
        } else {
            $object->setPicture('default.jpg');
            echo "On ne peut pas uploader de fichier de ce type. Il a été remplacé par l'image par défaut!";
        }
    }

    static function cropPicture($file_name, $width, $height)
    {
        //On récupère la liste des images dans le dossier
        $all_files = scandir(self::ROOT);
        //On nettoie pour extraire uniquement les noms de fichiers
        $all_files = array_diff(scandir(self::ROOT), array('.', '..'));        
        //On parcourt la liste des images pour trouver celle qui correspond à l'image à redimensionner
        $file_find = array_search($file_name, $all_files);
        // On recrée un fihcier jpeg à partir de la valeur récupérée
        $file_create = imagecreatefromjpeg(self::ROOT . $all_files[$file_find]); 
        // On redimensionne l'image
        $resized_file = imagescale($file_create , $width, -1); 
        // On crope l'image
        $croped_file = imagecrop($resized_file, ['x' => 0, 'y' => 0, 'width' => $width, 'height' => $height]); 
        // suppression le fond blanc ou noir
        $final_file = imagecropauto($croped_file, IMG_CROP_SIDES);
        // On enregistre la nouvelle image
        imagejpeg($final_file, self::ROOT . $all_files[$file_find]); 

    }

}