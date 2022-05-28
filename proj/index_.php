<?php require __DIR__ . '/parts/connect_db.php';
$pageName = 'index';
// 給網頁一個名字
$title = '首頁 - 舒營';

?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<div class="container">
    <h2>Home</h2>
    <!-- $pdo->quote() 用來跳脫 SQL 裡值的單引號, 避免 SQL injection 是手動跳脫  -->
    <p><?= $pdo->quote("Alice's cats") ?></p>

</div>
<?php include __DIR__ . '/parts/scripts.php' ?>
<?php include __DIR__ . '/parts/html-foot.php' ?>