<?php
namespace App\src\controller;
use App\src\DAO\ArticleDAO;
use App\src\DAO\CommentDAO;
use App\src\model\View;

class FrontController
{
    private $articleDAO;
    private $commentDAO;
    private $view;

    public function __construct()
    {
        $this->articleDAO = new ArticleDAO();
        $this->commentDAO = new CommentDAO();
        $this->view = new View();
    }

    public function home()
    {
        $articles = $this->articleDAO->getArticles();
        return $this->view->render('home', ['articles' => $articles]);
    }

    public function article($articleId)
    {
        $article = $this->articleDAO->getArticle($articleId);
        $comments = $this->commentDAO->getComments($articleId);
        return $this->view->render('single', [
            'article' => $article,
            'comments' => $comments
        ]);
    }

    public function addComment($articleId, $pseudo, $content) {
        if (!$this->validateCommentData($articleId, $pseudo, $content)) {
            $this->errorController->errorNotFound();
            return;
        }

        $this->commentDAO->addComment($articleId, $pseudo, $content);
        // Rediriger vers l'article pour voir le commentaire ajouté
        header('Location: index.php?route=article&articleId=' . $articleId);
        exit;

    }
    // Exemple validation à améliorer
    private function validateCommentData($articleId, $pseudo, $content) {
        return !empty($pseudo) && !empty($content) && !empty($articleId) && $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    // Fonction pour générer un jeton CSRF
    function generateCsrfToken() {
        return bin2hex(random_bytes(32)); // Génère un jeton CSRF aléatoire

        // Générer un jeton CSRF et le stocker dans la session
        if (!isset($_SESSION['csrf_token']))
        {
            $_SESSION['csrf_token'] = generateCSRFToken();
        }
    }

    // Vérifie si le jeton CSRF est valide
    function isCSRFTokenValid($token) {
        return isset($_SESSION['csrf_token']) && $token === $_SESSION['csrf_token'];
        // Vérification du token CSRF
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            // Gérer l'erreur CSRF (par exemple, rediriger vers une page d'erreur)
            header("Location: erreur_csrf.php"); // Redirection vers une page d'erreur CSRF
            exit();
        }
    }

//    // Vérification du token CSRF
//if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
//    // Gérer l'erreur CSRF (par exemple, rediriger vers une page d'erreur)
//header("Location: erreur_csrf.php"); // Redirection vers une page d'erreur CSRF
//exit();
//}

}
//let's ride - kantrast