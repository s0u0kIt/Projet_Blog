<!DOCTYPE html>
<html lang="fr">
<head>
    <!--<link rel="stylesheet" href="../public/css/style.css">-->
    <meta charset="utf-8">
    <title>Mon blog</title>
</head>
<body>
<?php $this->title = "Article"; ?>

<h1>Mon blog</h1>
<p>En construction</p>
<!-- Code d'Affichage d'un Article-->
<div id="articles" class="text-left" style="margin-left: 5px">
    <h2><?= htmlspecialchars($article->getTitle()); ?></h2>
    <p><?= htmlspecialchars($article->getContent()); ?></p>
    <p><?= htmlspecialchars($article->getAuthor()); ?></p>
    <p>Créé le : <?= htmlspecialchars($article->getCreatedAt()); ?></p>
</div>


<!-- Code d'Affichage des Commentaires-->
<div id="comments" class="text-left" style="margin-left: 50px">
    <h3>Commentaires</h3>
    <?php
    foreach ($comments as $comment):
        ?>
        <h4><?= htmlspecialchars($comment->getPseudo()); ?></h4>
        <p><?= htmlspecialchars($comment->getContent()); ?></p>
        <p>Posté le <?= htmlspecialchars($comment->getCreatedAt()); ?></p>
    <?php endforeach; ?>
</div>
<!-- Code d'Ajout de Commentaire sous un article-->
<div>
    <form action="../public/index.php?route=addComment&articleId=<?= ($article->getId()); ?>" method="post">
        <label for="Pseudo">Pseudo :</label><br>
        <input id="Pseudo" type="text" name="pseudo" required>
        <br>
        <br>
        <label for="Commentaire">Commentaire :</label>
        <br>
        <textarea id="Commentaire" type="text" name="content" required="true"></textarea>
        <br>
        <input type="hidden" name="csrf_token" value="<?php echo $frontController->generateCsrfToken(); ?>">
        <br>
        <input type="submit" value="Ajouter"/>
    </form>
</div>
<br>
<a href="../public/index.php">Retour à l'accueil</a>
</body>
</html>