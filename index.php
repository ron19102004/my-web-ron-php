<?php
require "./src/utils/import.util.php";
// Import::migration("create-table.migration.php");
header("Location: ".Env::get("root-path")."/src/views/pages/user/home/page.php");

// Những thứ cần chỉnh sửa lên vps 
// đường dẫn ở file env.util.php
// file env.json