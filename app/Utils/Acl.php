<?php
namespace App\Utils;

//1 récupèrer le rôle du user
//2 récupèrer le nom des routes : $viewData['routeinfo']['name']
//3 vérifier si le rôle du user est dans les routes
//4 si oui, on autorise l'accès
//5 si non, on refuse l'accès 403

class Acl
{   
    /**
     * Méthode permettant de vérifier si l'utilisateur a le droit d'accéder à la page
     * @param string $role
     * @param string $routeName
     * @return void
     */
    static function checkAcl($userRole, $route)
    {

        $acl = [
            "course-form" => [ "ROLE_ADMIN"],
        ];

        if(array_key_exists($route, $acl)){
        dump('la route est bien dans le tableau acl');
            foreach ($acl as $route => $roleArray) {
            dump('je controle le role du user dans le tableau des roles autorisés sur cette route');
               if(array_key_exists($route, $acl) && in_array($userRole, $roleArray)) {
                dump('ok le role du user est dans le tableau des roles autorisés sur cette route');
                   return true;
               } else {
                    dump('403 pas ok le role du user n\'est pas dans le tableau des roles autorisés sur cette route');
                    return false;
               }
            } 
        } else {
            dump('la route n\'est pas dans le tableau acl');
            return true;
        }
    }
}
