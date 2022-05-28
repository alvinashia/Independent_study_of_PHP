<?php

$db_host = 'localhost'; // 主機名稱
$db_user = 'alvina'; // 資料庫連線的用戶
$db_pass = 'host'; // 連線用戶的密碼
$db_name = 'tourist_attract';  // 資料庫名稱

$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";

$pdo_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    // ATTR是屬性的意思
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    //如果沒有設定上面的會有兩組結果
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);
} catch (PDOException $ex) {
    echo $ex->getMessage();
}
