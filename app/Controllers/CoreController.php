<?php

namespace App\Controllers;
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
        $viewData['routeinfo'] = $router->match();
        $viewData['currentPage'] = $viewName;

        //$viewData['assetsBaseUri'] = $_SERVER['BASE_URI'] . 'assets/';
        //$viewData['baseUri'] = $_SERVER['BASE_URI'];
        $viewData['assetsBaseUri'] = $_SERVER['HTTP_HOST'] . 'assets/';
        $viewData['baseUri'] = $_SERVER['HTTP_HOST'];

        // Array $viewData is now available in all views
        // https://www.php.net/manual/fr/function.extract.php
        extract($viewData);
        
        // Each couse is now available in all views for navbar
        $navValues = Course::findAllPublishedCourseForNav();

        //dump($_SESSION);
        require_once __DIR__ . '/../views/layout/header.tpl.php';
        require_once __DIR__ . '/../views/' . $viewName . '.tpl.php';
        require_once __DIR__ . '/../views/layout/footer.tpl.php';

    }
        
}