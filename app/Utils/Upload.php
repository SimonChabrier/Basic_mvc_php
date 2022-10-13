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

        $picture = $_FILES['picture']['tmp_name'];
        $name = $_FILES['picture']['name'];
        $name  = uniqid() . '.jpeg';

        if($_FILES['picture']['size'] > 500000){
            throw new \Exception('Le fichier est trop gros');
        };
        
        if($_FILES['picture']['error'] > 0){
            throw new \Exception('Erreur lors du transfert de l\'image');
        };

        $object->setPicture($name);

        // move file to public assets/images folder
        move_uploaded_file($picture, self::ROOT . $name);
        //then set the user rigths on this file
        chmod(self::ROOT . $name, 0777);
        self::cropPicture($name, 400, 400);
    }

    static function cropPicture($file_name, $width, $height)
    {
        //On récupère la liste des images dans le dossier
        $all_files = scandir(Upload::ROOT);
        //On nettoie pour extraire uniquement les noms de fichiers
        $all_files = array_diff(scandir(Upload::ROOT), array('.', '..'));        
        //On parcourt la liste des images pour trouver celle qui correspond à l'image à redimensionner
        $file_find = array_search($file_name, $all_files);
        // On recrée un fihcier jpeg à partir de la valeur récupérée
        $file_create = imagecreatefromjpeg(Upload::ROOT . $all_files[$file_find]); 
        // On redimensionne l'image
        $resized_file = imagescale($file_create , $width, -1); 
        // On crope l'image
        $croped_file = imagecrop($resized_file, ['x' => 0, 'y' => 0, 'width' => $width, 'height' => $height]); 
        // suppression le fond blanc ou noir
        $final_file = imagecropauto($croped_file, IMG_CROP_SIDES);
        // On enregistre la nouvelle image
        imagejpeg($final_file, Upload::ROOT . $all_files[$file_find]); 

    }

}