<?php
class CommentController
{
    private $commentRepo;
    public function __construct(CommentRepository $commentRepo)
    {
        $this->commentRepo = $commentRepo;
    }
    public function add()
    {
        try {
            $data = [
                "post_id" => htmlspecialchars($_POST["post_id"]),
                "content" => htmlspecialchars($_POST["content"]),
                "reply_to" => htmlspecialchars($_POST["reply_to"]),
            ];
            $comment = new Comment(
                0,
                $data["post_id"],
                Session::get("user_id"),
                $data["reply_to"] == 0 ? null : $data["reply_to"],
                $data["content"],
                0
            );
            $result = $this->commentRepo->save($comment);
            if ($result) {
                return new Response(true, $comment, "Bình luận thành công");
            } else {
                return new Response(false, null, "Bình luận thất bại");
            }
        } catch (Exception $e) {
            return new Response(false, null, "An error occurred: " . $e->getMessage());
        }
    }
    public function getAllCommentByPostId()
    {
        try {
            $post_id = htmlspecialchars($_GET["post_id"]);
            $page = htmlspecialchars($_GET["page"]);
            $comments = $this->commentRepo->getCommentByPostId($post_id, $page);
            return new Response(true, $comments, "Lấy bình luận thành công");
        } catch (Exception $e) {
            return new Response(false, null, "An error occurred: " . $e->getMessage());
        }
    }
}
