<?php

namespace App\Controllers;
use PDO;
use App\Models\User;
use App\Models\Course;

class CoreController
{   
    /**
     * Méthode permettant d'afficher du code HTML en se basant sur les views
     * @param string $viewName Nom du fichier de vue
     * @param array $viewData Tableau des données à transmettre aux vues
     * @return void
     */
    protected function show(string $viewName, $viewData = [])
    {   
        // Globalise l'instance courante d'AltoRouter crée sur l'index
        // cet objet permettra d'accéder aux méthodes d'AltoRouter dans les views
        // eg : $router->generate('main-home')...
        global $router;
        
        //$viewData = le tableau contenant toutes les variable à transmettre aux vues
        //qui s'ajoutent aux paires clé/valeur définies ci-dessous
        $viewData['routeinfo'] = $router->match();
        $viewData['navValues'] = Course::findAllPublishedCourseForNav();
        $viewData['users'] = User::findUserCount();
        
        // https://www.php.net/manual/fr/function.extract.php
        // extract $viewData to access and use this values in all views
        extract($viewData);

        //dump($_SESSION);
        require_once __DIR__ . '/../views/layout/header.tpl.php';
        require_once __DIR__ . '/../views/' . $viewName . '.tpl.php';
        require_once __DIR__ . '/../views/layout/footer.tpl.php';

    }

}