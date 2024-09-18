<?php
require "../utils/import.util.php";
Import::entities(["comment.entity.php"]);
Import::repositories(["comment.repository.php"]);
Import::controllers(["comment.controller.php"]);
class CommentRoute extends Route
{
    private $commentController;
    public function __construct()
    {
        $commentRepo = new CommentRepository();
        $this->commentController = new CommentController($commentRepo);
    }
    public function get_action($action)
    {
        switch ($action) {
            case "getAllCommentByPostId": {
                    echo $this->commentController
                        ->getAllCommentByPostId()
                        ->toJson();
                    break;
                }
        }
    }
    public function post_action($action)
    {
        switch ($action) {
            case "new": {
                    echo $this->commentController
                        ->add()
                        ->toJson();
                    break;
                }
        }
    }
}
$route = new CommentRoute();
$route->run();
