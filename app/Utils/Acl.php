<?php

namespace App\Utils;

//1 récupèrer le rôle du user
//2 récupèrer le nom des routes : $viewData['routeinfo']['name']
//3 vérifier si le rôle du user est dans les routes
//4 si oui, on autorise l'accès
//5 si non, on refuse l'accès 403

class Acl
{
    public static function check($role, $route)
    {
        //dump($role);
        //dump($route);

        $ressources = [
            "course-form" => [ "ROLE_ADMIN", "ROLE_USER"],
        ];
        //dump($ressources);
        //est ce que la route est dans le tableau des ressources ?
        //est ce que le role du user est dans le tableau des ressources ?
        //est ce que les deux sont ok ?

        foreach ($ressources as $route => $roleArray) {
           //dump($ressources);
           dump($route);
           dump($roleArray);
           if(array_key_exists($route, $ressources) && in_array($role, $roleArray)) {
                dump('ok');
               return true;
           } else {
            dump('pas ok');
               return false;
           }
        }

        // if (array_key_exists($route, $ressources)) {
        //     dump($role == $ressources[$route]);

        //         if ($role == $ressources[$route]) {
        //             return true;
        //         } else {
        //             return false;
        //         }
        //     }

        
    }
}
