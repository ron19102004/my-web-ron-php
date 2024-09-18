<?php
$sql_file_path = $_SERVER['DOCUMENT_ROOT'].'/ron/src/migrations/create-table.sql';  // Đường dẫn đến file SQL
$sql_content = file_get_contents($sql_file_path);

if ($sql_content === false) {
    die('Không thể đọc file SQL');
}
$sqlStatements = explode(';', $sql_content);

$pdo = Database::connect();
try {
    foreach ($sqlStatements as $statement) {
        $trimmedStatement = trim($statement);
        if (!empty($trimmedStatement)) {
            $pdo->exec($trimmedStatement);
        }
    }
    echo "Chạy file SQL thành công";
} catch (PDOException $e) {
    echo "Lỗi khi chạy file SQL: " . $e->getMessage();
}
$pdo = null;