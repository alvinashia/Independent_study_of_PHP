<?php
require __DIR__ . '/parts/connect_db.php';
header('Content-Type: application/json');

$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => ''
];
// 預設除錯檢查

$sid = isset($_POST['sid']) ? intval($_POST['sid']) : 0;
// 這一段是看有沒有值傳進來，有的話把值轉為整數，沒有則回傳0

// echo json_encode($output,JSON_UNESCAPED_UNICODE);
// exit;
// 測試有沒有正確執行，取得SID


// TODO: 欄位檢查, 後端的檢查
if (empty($sid) or empty($_POST['name'])) {
    // 這兩個是必有，如果其中一個沒有就是結束
    $output['error'] = '沒有姓名資料';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$name = $_POST['name'];
$email = $_POST['email'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$birthday = empty($_POST['birthday']) ? NULL : $_POST['birthday'];
$address = $_POST['address'] ?? '';

if (!empty($email) and filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    $output['error'] = 'email 格式錯誤';
    $output['code'] = 405;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
// TODO: 其他欄位檢查


$sql = "UPDATE `address_book` SET `name`=?, `email`=?, `mobile`=?, `birthday`=?, `address`=? WHERE `sid`=?,";
//在phpmyadmin 的SQL下面選擇update 可以把原始值生出來，再改就好
// 原本有的SID不做修改，所以把原本sid的位置移到最後，並把原本有的1刪除，改成$SID
// `created_at`=？因為原本表單上沒有所以拿掉
// 注意~where前面不要有,

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $name,
    $email,
    $mobile,
    $birthday,
    $address,
]);


if ($stmt->rowCount() == 1) {
    // 這邊的rowCount是看有沒有修改
    $output['success'] = true;
} else {
    $output['error'] = '資料沒有修改';
}
// isset() vs empty()


echo json_encode($output, JSON_UNESCAPED_UNICODE);
