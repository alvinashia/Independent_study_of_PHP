<?php require __DIR__ . './parts/connect_db.php';
$pageName = 'as_tourist_spots_detail';
$title = '景點詳情';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location:as_tourist_spots_list.php');
    exit;
}

$row = $pdo->query("SELECT * FROM tourist_spot WHERE sid=$sid")->fetch();
if (empty($row)) {
    header('Location:as_tourist_spots_list.php');
    exit;
};

$open = '開放時間：';

?>

<?php /*<?php include __DIR__ . './part/html-head.php' ?>;
<?php include __DIR__ . './part/navbar.php' ?>; */ ?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>

<style>
    .form-control.red {
        border: 1px solid red;
    }

    .form-text.red {
        color: red;
    }
</style>

<div class="container">
    <div class="row m-5">

        <div class="card">
            <div class="card-header">
                景點詳情
            </div>
            <div class="card-body d-flex justify-content-center flex-column" name="card1">
                <img src="./uploaded/<?= $row['pic'] ?>" class="img-fluid rounded mx-auto d-block" style="width: 600px;" alt="...">
                <div style="width:600px ;">
                    <h2 class="card-title mt-3"><?= $row['name'] ?></h2>
                    <small class="text-muted">位於 <?= $row['area'] ?> 的 <?= $row['type'] ?></small>
                    <h6 class="card-text pt-4"><?= $row['tel'] ?></h6>
                    <h6 class="card-text"><?= $row['address'] ?></h6>
                    <h6 class="card-text"><?= $open . $row['open_time']  ?></h6>
                    <h6 class="card-text"><?= $row['close_day'] ?></h6>
                    <p class="card-text pt-3 "><?= $row['description'] ?></p>
                    <p class="card-text pb-2 "><a href="<?= $row['event_site'] ?? "javascript:void(0);" ?>" name="event" id="event" ?>參加活動</a></p>
                </div>
                <a href="as_tourist_spots_list.php" class="btn btn-primary">返回</a>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
    // const event = document.card1.event;


    const event = document.querySelector('#event');
    event.addEventListener("click", checkEvent);

    function checkEvent() {
        if (event.href === "javascript:void(0);") {
            alert("目前沒有相關活動")
        }
    }
    // TODO:要如何讓他判定更為正確（有網頁的時候不會跳出alert並直接跳轉）
    // 跳轉頁面失靈?
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>
<?php /*<?php include __DIR__ . './part/scripts.php' ?>;
<?php include __DIR__ . './part/html-foot.php' ?>;*/ ?>