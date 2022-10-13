<?php
namespace App\Utils;

class Upload 
{

    /**
     * @param array $_FILES['picture']
     * @param Course $course
     * @return void
     */
    public static function processUploadPicture(array $picture, object $object)
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
        move_uploaded_file($picture, __DIR__ . '/../../public/assets/images/' . $name);
        //then set the user rigths on this file
        chmod(__DIR__ . '/../../public/assets/images/'.$name, 0777);
    }

}