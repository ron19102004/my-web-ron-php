<?php
require $_SERVER['DOCUMENT_ROOT'] . "/src/utils/import.util.php";

$_METADATA = [
    "title" => "Trang chủ",
];
require Import::view_layout_path("content/content.php") ?>



<?php require Import::view_layout_path("content/end-content.php") ?>