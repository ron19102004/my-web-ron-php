<?php
require $_SERVER['DOCUMENT_ROOT'] . "/src/utils/import.util.php";
Import::controllers(["auth.controller.php"]);
class AuthRoute extends Route
{
    private $authController;
    public function __construct()
    {
        $userRepository = new UserRepository();
        $this->authController = new AuthController($userRepository);
    }
    public function get_action($action) {}
    public function post_action($action)
    {
        switch ($action) {
            case "register": {
                    echo $this->authController
                        ->register()
                        ->toJson();
                    break;
                }
            case "login": {
                    echo $this->authController
                        ->login()
                        ->toJson();
                    break;
                }
            case "logout": {
                    echo $this->authController
                        ->logout()
                        ->toJson();
                    break;
                }
            case "change_password": {
                    echo $this->authController
                        ->changePassword()
                        ->toJson();
                    break;
                }
        }
    }
}
$route = new AuthRoute();
$route->run();
