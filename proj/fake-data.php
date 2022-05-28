<?php require __DIR__ . '/parts/connect_db.php';








// $sql = "INSERT INTO `address_book`(
//     `name`, `email`, `mobile`, 
//     `birthday`, `address`, `created_at`
//     ) VALUES (
//         '李小明', 'ming@test.com', '0918123456',
//         '1987-11-23', '南投市', NOW()
//     )";

// $stmt = $pdo->query($sql);
// 新增一筆資料

//要新增資料都會長這樣 
$sql = "INSERT INTO `address_book`(
    `name`, `email`, `mobile`, 
    `birthday`, `address`, `created_at`
    ) VALUES (
        ?, ?, ?,
        ?, ?, NOW()
    )";
// 用？幫忙做跳脫避免隱碼攻擊，也就是挖一個洞在那邊
// query-直接執行
// 若新增資料有單引號，外面就是要用雙引號
// ？不要有單引號，因為當他跳脫的時候就自動會有單引號在旁邊

$stmt = $pdo->prepare($sql);
$stmt->execute([
    "李小明's pen",
    'ming@test.com',
    '0918123456',
    '1987-11-23',
    '南投市',
    //如果是圖片就是放圖片的檔名
]);

// 有外來的資料都是用prepare+execute做，因為可以自動幫忙做squl的跳脫，並把跳脫過的値帶到上面的？中，主要是跳脫單引號的字元，詳細可以查看index_的檔案
// 原則上如果是客戶自己輸入的東西都是用prepare+execute 做
// 不要直接用query執行.


echo $stmt->rowCount();
