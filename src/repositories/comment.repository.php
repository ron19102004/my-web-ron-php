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
    public function getCommentByPostId($post_id,$page){
        $offset = ($page - 1) * 10;
        $conn = Database::connect();
        $stmt = $conn->prepare("SELECT c.*,u.fullName as fullName FROM comments c 
        INNER JOIN users u ON c.user_id = u.id
        WHERE c.post_id = :post_id LIMIT 10 OFFSET :offset");
        $stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conn = null;
        return $comments;
    }
}
