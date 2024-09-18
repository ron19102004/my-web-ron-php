<?php
require $_SERVER['DOCUMENT_ROOT'] . "/ron/src/utils/import.util.php";
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
                    echo $this->cateController
                        ->add()
                        ->toJson();
                    break;
                }
            case "delete": {
                    echo $this->cateController
                        ->delete()
                        ->toJson();
                    break;
                }
            case "update": {
                    echo $this->cateController
                        ->update()
                        ->toJson();
                    break;
                }
        }
    }
}
$route = new CategoryRoute();
$route->run();
