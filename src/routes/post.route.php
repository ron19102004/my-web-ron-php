<?php
require $_SERVER['DOCUMENT_ROOT'] . "/src/utils/import.util.php";
Import::entities(["post.entity.php", "category.entity.php"]);
Import::repositories(["post.repository.php"]);
Import::controllers(["post.controller.php"]);
class PostRoute extends Route
{
    private $postController;
    public function __construct()
    {
        $postRepo = new PostRepository();
        $this->postController = new PostController($postRepo);
    }
    public function get_action($action)
    {
        switch ($action) {
            case "getAllByCategoryIdAndPage": {
                    echo $this->postController
                        ->getByCategoryId()
                        ->toJson();
                    break;
                }
            case "getAllByCategoryIdAndPageForAdmin": {
                    echo $this->postController
                        ->getByCategoryIdForAdmin()
                        ->toJson();
                    break;
                }
            case "getById": {
                    echo $this->postController
                        ->findById()
                        ->toJson();
                    break;
                }
            case "getAllWithPage": {
                    echo $this->postController
                        ->getAll()
                        ->toJson();
                    break;
                }
            case "getAllWithPageForAdmin": {
                    echo $this->postController
                        ->getAllForAdmin()
                        ->toJson();
                    break;
                }
        }
    }
    public function post_action($action)
    {
        switch ($action) {
            case "new": {
                    echo $this->postController
                        ->add()
                        ->toJson();
                    break;
                }
            case "delete": {
                    echo $this->postController
                        ->delete()
                        ->toJson();
                    break;
                }
            case "update": {
                    echo $this->postController
                        ->update()
                        ->toJson();
                    break;
                }
            case "hidden-post-update": {
                    echo $this->postController
                        ->hidden()
                        ->toJson();
                    break;
                }
        }
    }
}
$route = new PostRoute();
$route->run();
