<?php

namespace App\config;

use App\src\controller\FrontController;
use App\src\controller\ErrorController;
use Exception;

class Router
{
    private $frontController;
    private $errorController;

    public function __construct()
    {
        $this->frontController = new FrontController();
        $this->errorController = new ErrorController();
    }

    public function run()
    {
        try {
            if (isset($_GET['route'])) {
                if ($_GET['route'] === 'article') {
                    if (isset($_GET['articleId']) && $_GET['articleId'] > 0) { //
                        $this->frontController->article($_GET['articleId']);
                    } else {
                        $this->errorController->errorNotFound();
                    }
                } elseif ($_GET['route'] === 'addComment') {
                    if (isset($_POST['articleId']) && isset($_POST['pseudo']) && isset($_POST['content'])) {
                        $this->frontController->addComment($_POST['articleId'], $_POST['pseudo'], $_POST['content']);
                    } else {
                        // Rediriger vers la méthode error_csrf pour gérer l'erreur CSRF
                        $this->errorController->errorCSRF();
                    }
                } else {
                    $this->errorController->errorNotFound();
                }
            } else {
                $this->frontController->home();
            }
        } catch (\Exception $e) {
            $this->errorController->errorServer();
        }
    }
}