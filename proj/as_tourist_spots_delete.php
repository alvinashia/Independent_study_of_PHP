<?php require __DIR__ . '/parts/connect_db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
// isset判斷有沒有，然後就GET SID,如果有設定就轉換成（intval）整數，沒有的話就預設值為零
if (!empty($sid)) {
    $pdo->query("DELETE FROM `tourist_spot` WHERE sid=$sid");
}
// 如果$sid是空字串或者是0，那就不做了（false）
// 有的話就會進去上面if的循環，直接讓query執行

$come_from = 'as_tourist_spots_list.php';
if (!empty($_SEVER['HTTP_REFERER'])) {
    $come_from = $_SERVER['HTTP_REFERER'];
}
// come_from 這個變數的意思是要回到哪裡
// 如果HTTP_REFERER不是空的，就把ab-list.php的結果設定給他
// 檔頭的屬性REFERER會告訴server段，來到這裡是通過哪個頁面（可到Devtool 的network 點name 看headers 5/27 02:51）
// 用意是讓他從哪裡來就從哪裡回去


// $_SEVER內建的便是
header("Location: as_tourist_spots_list.php");
// header是讓結果做跳轉，讓頁面重整後回到最上面（編輯也有，但不太一樣）
// https://www.aiwalls.com/php%E7%B7%A8%E7%A8%8B%E6%95%99%E5%AD%B8/26/33893.html



// TODO: 5/26 14:15 開始
// 要是忘記語法就去phpmyadmin看
// 這邊是做直接刪除再回來
// 如果用AJAX的方式比較麻煩
// header是做轉向，這邊是轉到列表頁上

//點到就刪除比較危險，所以需要做再確認的動作

// 刪除的方法 原則上資料不要做刪除，有些公司會另外設定欄位