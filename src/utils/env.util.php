<?php
class Env {
    /**
     * @param string $key
     * @return mixed
     */
    public static function get($key){
        $env_file = $_SERVER['DOCUMENT_ROOT'] . "/env.json";
        $env_data = json_decode(file_get_contents($env_file), true);
        return $env_data[$key]?? null;
    }
}