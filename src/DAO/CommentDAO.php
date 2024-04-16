<?php

namespace App\src\DAO;
use App\src\model\Comment;

class CommentDAO extends DAO
{
    private function buildObject($row)
    {
        $comment = new Comment();
        $comment->setId($row['id']);
        $comment->setPseudo($row['pseudo']);
        $comment->setContent($row['content']);
        $comment->setCreatedAt($row['createdAt']);
        //$comment->setArticleId($row['article_id']);
        return $comment;
    }

    public function getComments($articleId)
    {
        $sql = 'SELECT id, pseudo, content, createdAt, article_id FROM comment 
                                     WHERE article_id = ? 
                                     ORDER BY createdAt DESC';
        $result = $this->createQuery($sql, [$articleId]);
        $comments = [];
        foreach ($result as $row) {
            $commentId = $row['id'];
            $comments[$commentId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $comments;
    }

    public function addComment($articleId,$pseudo,$content)
    {
        $sql = 'INSERT INTO comment (pseudo, content, createdAt, article_id) VALUES (?, ?, NOW(), ?)';
        $this->createQuery($sql, [$pseudo, $content, $articleId]);
    }
}