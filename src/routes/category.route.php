<?php
require "../utils/import.util.php";
Import::entities(["category.entity.php"]);
Import::repositories(["category.repository.php"]);
Import::controllers(["category.controller.php"]);
class CategoryRoute extends Route
{
    private $cateController;
    public function __construct()
    {
        $cateRepo = new CategoryRepository();
        $this->cateController = new CategoryController($cateRepo);
    }
    public function get_action($action) {}
    public function post_action($action)
    {
        switch ($action) {
            case "new": {
                    if (AuthMiddleware::hasRoles([UserRole::ADMIN])) {
                        echo $this->cateController
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
                        echo $this->cateController
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
                        echo $this->cateController
                            ->update()
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
$route = new CategoryRoute();
$route->run();
