<?php
require "../utils/import.util.php";
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
            case "getAllByCategorySlugAndPage": {
                    echo $this->postController
                        ->getByCategorySlug()
                        ->toJson();
                    break;
                }
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
            case "searchByTitleAndPage": {
                    echo $this->postController
                        ->searchByTitle()
                        ->toJson();
                    break;
                }
            case "searchByTitleAndPageAdmin": {
                    echo $this->postController
                        ->searchByTitle()
                        ->toJson();
                    break;
                }
            case "searchByTitleAndCategoryAndPageAdmin": {
                    echo $this->postController
                        ->searchByTitleAndCategoryIdForAdmin()
                        ->toJson();
                    break;
                }
            case "searchByTitleAndCategorySlugAndPage": {
                    echo $this->postController
                        ->searchByTitleCategorySlug()
                        ->toJson();
                    break;
                }
            case "countPosts": {
                    echo $this->postController
                        ->countPosts()
                        ->toJson();
                    break;
                }
        }
    }
    public function post_action($action)
    {
        switch ($action) {
            case "new": {
                    if (AuthMiddleware::hasRoles([UserRole::ADMIN])) {
                        echo $this->postController
                            ->add()
                            ->toJson();
                    } else {
                        $res = new Response(false, null, "Không có quyền truy cập");
                        echo $res->toJson();
                    }
                    break;
                }
            case "delete": {
                    if (AuthMiddleware::hasRoles([UserRole::ADMIN])) {
                        echo $this->postController
                            ->delete()
                            ->toJson();
                    } else {
                        $res = new Response(false, null, "Không có quyền truy cập");
                        echo $res->toJson();
                    }

                    break;
                }
            case "update": {
                    if (AuthMiddleware::hasRoles([UserRole::ADMIN])) {
                        echo $this->postController
                            ->update()
                            ->toJson();
                    } else {
                        $res = new Response(false, null, "Không có quyền truy cập");
                        echo $res->toJson();
                    }


                    break;
                }
            case "hidden-post-update": {
                    if (AuthMiddleware::hasRoles([UserRole::ADMIN])) {
                        echo $this->postController
                            ->hidden()
                            ->toJson();
                    } else {
                        $res = new Response(false, null, "Không có quyền truy cập");
                        echo $res->toJson();
                    }
                    break;
                }
        }
    }
}
$route = new PostRoute();
$route->run();
