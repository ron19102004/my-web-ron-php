<?php
require $_SERVER['DOCUMENT_ROOT'] . "/ron/src/utils/env.util.php";
require $_SERVER['DOCUMENT_ROOT'] . "/ron/src/utils/response.util.php";
require $_SERVER['DOCUMENT_ROOT'] . "/ron/src/utils/session.util.php";
require $_SERVER['DOCUMENT_ROOT'] . "/ron/src/utils/route.util.php";
require $_SERVER['DOCUMENT_ROOT'] . "/ron/src/configs/database.config.php";
require $_SERVER['DOCUMENT_ROOT'] . "/ron/src/entities/user.entity.php";
require $_SERVER['DOCUMENT_ROOT'] . "/ron/src/repositories/user.repository.php";
require $_SERVER['DOCUMENT_ROOT'] . "/ron/src/middlewares/auth.middleware.php";
class Import
{
    public static function migration(string $file_name): void
    {
        require $_SERVER['DOCUMENT_ROOT'] . "/ron/src/migrations/" . $file_name;
    }
    public static function configs(array $files_name): void
    {
        foreach ($files_name as $file_name) {
            require $_SERVER['DOCUMENT_ROOT'] . "/ron/src/configs/" . $file_name;
        }
    }
    public static function interfaces(array $files_name): void
    {
        foreach ($files_name as $file_name) {
            require $_SERVER['DOCUMENT_ROOT'] . "/ron/src/interfaces/" . $file_name ;
        }
    }
    public static function controllers(array $files_name): void
    {
        foreach ($files_name as $file_name) {
            require $_SERVER['DOCUMENT_ROOT'] . "/ron/src/controllers/" . $file_name;
        }
    }
    public static function utils(array $files_name): void
    {
        foreach ($files_name as $file_name) {
            require $_SERVER['DOCUMENT_ROOT'] . "/ron/src/utils/" . $file_name;
        }
    }
    public static function entities(array $files_name): void
    {
        foreach ($files_name as $file_name) {
            require $_SERVER['DOCUMENT_ROOT'] . "/ron/src/entities/" . $file_name;
        }
    }
    public static function repositories(array $files_name): void
    {
        foreach ($files_name as $file_name) {
            require $_SERVER['DOCUMENT_ROOT'] . "/ron/src/repositories/" . $file_name;
        }
    }
    public static function middlewares(array $files_name): void
    {
        foreach ($files_name as $file_name) {
            require $_SERVER['DOCUMENT_ROOT'] . "/ron/src/middlewares/" . $file_name;
        }
    }
    public static function route_path(string $file_name): string
    {
        return Env::get("server") . "/ron/src/routes/" . $file_name;
    }
    public static  function view_layout_path(string $file_name):string
    {
        return $_SERVER['DOCUMENT_ROOT'] . "/ron/src/views/layouts/" . $file_name;
    }
    public static function view_assets_path(string $file_name): string
    {
        return "/ron/src/views/assets/" . $file_name;
    }
    public static function view_component_path(string $file_name): string
    {
        return Env::get("server") . "/ron/src/views/components/" . $file_name;
    }
    public static function view_page_path(string $file_name): string
    {
        return Env::get("server") . "/ron/src/views/pages/" . $file_name;
    }
}
