<?php
require __DIR__ . '/parts/connect_db.php';
header('Content-Type: application/json');

// 檔名設置xxx-api，表明這個檔案只有功能，沒有呈現頁面

$output = [
    'success' => false,
    // 預設值是沒有新增成功
    'postData' => $_POST,
    // 看傳過來的表單是什麼再把它丟回去（前端丟什麼資料過來再把它丟回去）
    'code' => 0,
    'error' => ''
];
// 後端欄位的檢查，在phpmyadmin 的SQL寫 INSERT 可以把原始值生出來，再改就好

// TODO: 欄位檢查, 後端的檢查
if (empty($_POST['name'])) {
    $output['error'] = '沒有姓名資料';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$sql = "INSERT INTO `address_book`(
    `name`, `email`, `mobile`, 
    `birthday`, `address`, `created_at`
    ) VALUES (
        ?, ?, ?,
        ?, ?, NOW()
    )";
// NOW()的意思his取得當下時間

$stmt = $pdo->prepare($sql);
//拿到pdo stament的物件見
$stmt->execute([
    $_POST['name'],
    $_POST['email'],
    $_POST['mobile'],
    empty($_POST['birthday']) ? NULL : $_POST['birthday'],
    $_POST['address'],
    //如果是圖片就是放圖片的檔名
    //如果有填值但是沒有符合格式，則是顯示錯誤
]);

// 如果新增數量是1就顯示成功，如果沒有就會顯示錯誤
// 空的時候送出在devtol 的preview那邊會顯示錯誤
if ($stmt->rowCount() == 1) {
    $output['success'] = true;
    // 最近新增資料的 primery key
    $output['lastInsertId'] = $pdo->lastInsertId();
} else {
    $output['error'] = '資料無法新增';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
