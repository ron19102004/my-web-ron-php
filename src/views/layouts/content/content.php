<!DOCTYPE html>
<html lang="en">
<head>
    <?php require Import::view_layout_path("head.php")?>
    <title><?php echo $_METADATA["title"];?></title>
</head>
<body>
<?php if (isset($_METADATA["header-path"]) && !empty($_METADATA["header-path"])) {
    require Import::view_layout_path($_METADATA["header-path"]);
} ?>