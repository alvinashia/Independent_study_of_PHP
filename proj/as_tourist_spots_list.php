<?php require __DIR__ . '/parts/connect_db.php';
$pageName = 'as_tourist_spots_list';
$title = '周圍景點列表 - 舒營';

// MVC 
// 拿到資料出來資料都要在html之前

// $rows = $pdo->query("SELECT * FROM address_book LIMIT 5")->fetchAll();

$perPage = 5; // 每一頁有幾筆，可以自己決定

// 用戶要看第幾頁，如果有的話就是取intval($_GET['page'])，intval是轉換成整數的意思
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
// 因為如果打0or以下網頁會出錯，所以要寫下面判斷式去避免錯誤,並且修正預設頁數為1
if ($page < 1) {
    header('Location: ?page=1');
    exit;
}
//php走的是同步的方式
//要算總筆數
$t_sql = "SELECT COUNT(1) FROM tourist_spot";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
// echo  $totalRows; exit; 查看運作是否正常
//fetch拿到的結果是索引式陣列

$totalPages = ceil($totalRows / $perPage); //用總行數除以頁數就能得到總頁數

$rows = []; //先給一個預設值
if ($totalRows > 0) {
    if ($page > $totalPages) {
        header("Location: ?page=$totalPages");
        exit;
    }

    $sql = sprintf("SELECT * FROM tourist_spot LIMIT %s,%s", ($page - 1) * $perPage, $perPage);
    //"SELECT * FROM address_book LIMIT 是取變數的意思， %s,%s兩個洞左邊是索引，右邊是幾筆，以$perPage = 5為例;第一頁就是0,5第二頁就是5,5，第三頁就是10,5所以要用($page - 1) * $perPage, $perPage 去算這兩個值是多少，減1的原因是如果不減的話當1的時候就會是5，所以需要減掉
    // ORDER BY sid DESC 的意思是要降冪排序
    $rows = $pdo->query($sql)->fetchAll();
}


// 在網頁上打 ?page=x r去查看頁數


?>
<!-- 下面是V的部分 -->
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>


<div class="container p-5 pt-0">

    <div class="w-100 d-flex justify-content-end">
        <a class="nav-link text-dark p-3" href="ab-add.php">
            <i class="fa-solid fa-plus">
                新增景點
            </i>
        </a>
        <a class="nav-link text-dark p-3" href="" target="_blank">
            <i class="fa-solid fa-eye"></i>
            View Site
        </a>
    </div>
    <div class="card p-4">
        <div class="row">
            <div class="col-4">

            </div>
        </div>


        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col p-3">序號</th>
                    <th scope="col p-3">圖片</th>
                    <th scope="col p-3">地區</th>
                    <th scope="col p-3">名稱</th>
                    <th style="display: none" scope="col p-3">類型</th>
                    <th scope="col p-3">開放時間</th>
                    <th style="display: none" scope="col p-3">休館日</th>
                    <th style="display: none" scope="col p-3">電話</th>
                    <th style="display: none" scope="col p-3">地址</th>
                    <th style="display: none" scope="col p-3">描述</th>
                    <th style="display: none" scope="col p-3">活動網址</th>
                    <th style="display: none" scope="col p-3">有無活動</th>
                    <th scope="col p-3"><i class="fa-solid fa-trash-can"></i></th>
                    <th scope="col p-3"><i class="fa-solid fa-pen-to-square"></i></th>
                    <th scope="col p-3"> <i class="fa-solid fa-list"></i></th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r) : ?>
                    <tr class="p-5">

                        <?php /*
                        <a href="ab-delete.php?sid=<?= $r['sid'] ?>" onclick="return confirm('確定要刪除編號為 <?= $r['sid'] ?> 的資料嗎?')">
                        */
                        // 這邊是直接連接到a標籤，並且告訴他要刪除的是哪一筆，後面是再加一個刪除確認（防誤刪
                        // 注意註解時要使用特殊方式，不然會讀到註解裡面的php
                        ?>
                        <td class="p-3"><?= $r['sid'] ?></td>
                        <td class="p-3"><img src="./imgs/<?= $r['pic'] ?>.jpg" alt="" class="card-img" style="width:100px"></td>
                        <td class="p-3"><?= htmlentities($r['area']) ?></td>
                        <td class="p-3"><?= htmlentities($r['name']) ?></td>
                        <td style="display: none" class="p-3"><?= htmlentities($r['type']) ?></td>
                        <td><?= htmlentities($r['open_time']) ?></td>
                        <td style="display: none" class="p-3"><?= htmlentities($r['close_day']) ?></td>
                        <td style="display: none" class="p-3"><?= htmlentities($r['tel']) ?></td>
                        <td style="display: none" class="p-3 size"><?= htmlentities($r['address']) ?></td>
                        <td style="display: none" class="p-3"><?= htmlentities($r['description']) ?></td>
                        <td style="display: none" class="p-3"><?= htmlentities($r['event_site']) ?></td>
                        <td style="display: none" class="p-3"><?= htmlentities($r['event_situation']) ?></td>
                        <?php /*  <td><?= htmlentities($r['address']) ?></td> --> */ ?>
                        <!-- 防止被攻擊ex:爛芭樂事件，就需要再列表頁這邊設置htmlentities，但也有以下方法-->
                        <?php /*<td><?= strip_tags($r['address']) ?></td>*/ ?>
                        <!-- strip_tags的意思是當有輸出內容的時候直接把tag拿掉，直接把原本的> <符號去做跳脫 -->
                        <td class="p-3">
                            <a href="javascript: delete_it(<?= $r['sid'] ?>)">
                                <!-- 刪除他，并告訴他是哪一筆 -->
                                <!-- 用js去做一個假標籤，去呼叫 delete_it 這個function -->
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </td>
                        <td class="p-3">
                            <a href="as_tourist_spots_edit.php?sid=<?= $r['sid'] ?>">
                                <!-- 編輯他，并告訴他是哪一筆 -->
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </td>
                        <td class="p-3">
                            <a href="as_tourist_spots_detail.php?sid=<?= $r['sid'] ?>">
                                <i class="fa-solid fa-list"></i>
                                <!-- 看詳情 -->
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=1">
                        <i class="fa-solid fa-angles-left"></i>
                    </a>
                </li>
                <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>">
                        <i class="fa-solid fa-angle-left"></i>
                    </a>
                </li>
                <?php for ($i = $page - 2; $i <= $page + 2; $i++) :
                    if ($i >= 1 and $i <= $totalPages) :
                ?>
                        <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                <?php endif;
                endfor; ?>
                <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>">
                        <i class="fa-solid fa-angle-right"></i>
                    </a>
                </li>
                <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $totalPages ?>">
                        <i class="fa-solid fa-angles-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
        </nav>
    </div>
</div>


</div>
</div>

<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
    function delete_it(sid) {
        if (confirm(`確定要刪除編號為 ${sid} 的資料嗎?`)) {
            location.href = `ab-delete.php?sid=${sid}`;
            // 如果是確定就是做轉向，轉向到ab-delete.php?sid=
        }
    }
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>