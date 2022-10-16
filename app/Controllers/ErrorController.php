<?php

namespace App\Controllers;


class ErrorController extends CoreController
{
    /**
     * Méthode gérant l'affichage de la page 404
     * @return void
     */
    public function err404()
    {
        header('HTTP/1.0 404 Not Found');
        $this->show('error/err404');
        exit();
    }

     /**
     * Méthode gérant une 403
     * @return void
     */
    public function err403()
    {
        header('HTTP/1.1 403 Forbidden');
        $this->show('error/err403');
        exit();
    }
}