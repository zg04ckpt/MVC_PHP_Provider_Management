<?php
require_once 'database.php';

$sql = file_get_contents('schema.sql');
$db = (new Database())->getConnection();
try {
    echo $db->exec($sql);
    echo "Khởi tạo cơ sở dữ liệu thành công!";
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}