<?php
abstract class Route
{
    /**
     * Main route
     * @return void
     */
    public function run()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->post_action(htmlspecialchars($_POST["action"]));
        } else {
            $this->get_action(htmlspecialchars($_GET["action"]));
        }
    }
    /**
     * @param string|null $action
     * @return void
     */
    public abstract function post_action($action);
     /**
     * @param string|null $action
     * @return void
     */
    public abstract function get_action($action);
}