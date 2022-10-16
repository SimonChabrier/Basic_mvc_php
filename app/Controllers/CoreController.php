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
        $viewData['routeinfo'] = $router->match();
        $viewData['currentPage'] = $viewName;

        $viewData['assetsBaseUri'] = $_SERVER['HTTP_HOST'] . 'assets/';
        $viewData['baseUri'] = $_SERVER['HTTP_HOST'];
        // Array $viewData is now available in all views
        // https://www.php.net/manual/fr/function.extract.php
        extract($viewData);

        //get Users to display User count in navbar
        //$users = User::dynamicFindAll('user', User::class, 'fetchAll', PDO::FETCH_CLASS);
        $users = User::findUserCount();
        extract($users);
        
        //get Courses for navbar (select only course.id and course.title)
        $navValues = Course::findAllPublishedCourseForNav();

        dump($_SESSION);
        require_once __DIR__ . '/../views/layout/header.tpl.php';
        require_once __DIR__ . '/../views/' . $viewName . '.tpl.php';
        require_once __DIR__ . '/../views/layout/footer.tpl.php';

    }

}