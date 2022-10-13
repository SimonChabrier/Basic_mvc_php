<?php

namespace App\Utils;


class Redirect
{

    /**
     * Méthode permettant de faire une redirection vers une autre page
     * à partir l'id de la route définie dans AltoRouter
     *
     * @param string $routeId
     * @return void
     */
    public static function redirect($routeId)
    {
        global $router;
        header('Location: ' . $router->generate($routeId));
        exit();
    }

    /**
     * Méthode permettant de faire une redirection vers la page d'origine
     * à partir d'une URL complète
     *
     * @param string $url
     * @return void
     */
    public static function redirectLastPageVisited($redirect)
    {
        header('Location: ' . $redirect);
        exit();
    }

}
