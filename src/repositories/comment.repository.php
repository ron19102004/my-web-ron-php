<?php
class CommentRepository
{
    public function save(Comment $comment)
    {
        $conn = Database::connect();
        $stmt = $conn->prepare(
            "INSERT INTO `comments` (`id`, `post_id`, `user_id`, `reply_id`, `content`, `created_at`) 
            VALUES (NULL, :post_id, :user_id, :reply_id, :content, NOW());"
        );
        $stmt->bindParam(":post_id", $comment->post_id, PDO::PARAM_INT);
        $stmt->bindParam(":user_id", $comment->user_id, PDO::PARAM_INT);
        $stmt->bindParam(":reply_id", $comment->reply_id, PDO::PARAM_INT);
        $stmt->bindParam(":content", $comment->content, PDO::PARAM_STR);
        $result = $stmt->execute();
        $conn = null;
        return $result;
    }
}
