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
// if (empty($sid) or empty($_POST['name'])) {
//     // 這兩個是必有，如果其中一個沒有就是結束
//     $output['error'] = '沒有姓名資料';
//     $output['code'] = 400;
//     echo json_encode($output, JSON_UNESCAPED_UNICODE);
//     exit;
// }

$pic = $_POST['pic'] ?? '';
$area = $_POST['area'] ?? '';
$name = $_POST['name'] ?? '';
$type = $_POST['type'] ?? '';
$open_time = $_POST['open_time'] ?? '';
$close_day = $_POST['close_day'] ?? '';
$tel = $_POST['tel'] ?? '';
$address = $_POST['address'] ?? '';
$descripition = $_POST['description'] ?? '';
$event_site = $_POST['event_site'] ?? '';

// if (!empty($email) and filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
//     $output['error'] = 'email 格式錯誤';
//     $output['code'] = 405;
//     echo json_encode($output, JSON_UNESCAPED_UNICODE);
//     exit;
// }
// TODO: 其他欄位檢查


$sql = "UPDATE `tourist_spot` SET `pic`=?,`area`=?,`name`=?,`type`=?,`open_time`=?,`close_day`=?,`tel`=?,`address`=?,`description`=?,`event_site`=? WHERE `sid`=$sid ";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $pic,
    $area,
    $name,
    $type,
    $open_time,
    $close_day,
    $tel,
    $address,
    $descripition,
    $event_site,
]);


if ($stmt->rowCount() == 1) {
    // 這邊的rowCount是看有沒有修改
    $output['success'] = true;
} else {
    $output['error'] = '資料沒有修改';
}
// isset() vs empty()


echo json_encode($output, JSON_UNESCAPED_UNICODE);
