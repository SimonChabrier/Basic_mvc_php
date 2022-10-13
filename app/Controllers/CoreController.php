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
        //dump($_SERVER['HTTP_HOST']);
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
        extract($navValues);

        //dump($_SESSION);
        require_once __DIR__ . '/../views/layout/header.tpl.php';
        require_once __DIR__ . '/../views/' . $viewName . '.tpl.php';
        require_once __DIR__ . '/../views/layout/footer.tpl.php';

    }
    
    /**
     * Méthode permettant de faire une redirection vers une autre page
     * à partir l'id de la route définie dans AltoRouter
     *
     * @param string $routeId
     * @return void
     */
    protected function redirect($routeId)
    {
        global $router;
        header('Location: ' . $router->generate($routeId));
        exit();
    }

    protected function redirectLastPageVisited($redirect)
    {
        header('Location: ' . $redirect);
        exit();
    }
    
    protected function initToken()
    {
        // if (!isset($_SESSION['token'])) {
        //     $_SESSION['token'] = bin2hex(random_bytes(32));
        // }
        $token = bin2hex(random_bytes(32));
        $_SESSION['token'] = $token;
        return $token;

    }
        
}