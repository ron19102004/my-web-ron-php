<?php
require "../utils/import.util.php";
Import::controllers(["auth.controller.php"]);
class AuthRoute extends Route
{
    private $authController;
    public function __construct()
    {
        $userRepository = new UserRepository();
        $this->authController = new AuthController($userRepository);
    }
    public function get_action($action)
    {
        switch ($action) {
            case "countRole": {
                    echo $this->authController
                        ->countRole()
                        ->toJson();
                    break;
                }
        }
    }
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
                    if (AuthMiddleware::isAuthenticated()) {
                        echo $this->authController
                            ->changePassword()
                            ->toJson();
                    } else {
                        $res = new Response(false, null, "Yêu cầu đăng nhập");
                        echo $res->toJson();
                    }
                    break;
                }
            case "update_info": {
                    if (AuthMiddleware::isAuthenticated()) {
                        echo $this->authController
                            ->updateInfo()
                            ->toJson();
                    } else {
                        $res = new Response(false, null, "Yêu cầu đăng nhập");
                        echo $res->toJson();
                    }
                    break;
                }
        }
    }
}
$route = new AuthRoute();
$route->run();
