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

$folder = __DIR__ . '/uploaded/';

// 用來篩選檔案, 用來決定副檔名
$extMap = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png',
    'image/gif' => '.gif',
];

print_r([$_FILES['picture']['type']]);
print_r([$_FILES['picture']['name']]);
exit;

if(!empty([$_FILES['picture']['name']])){
    // 如果name不是空白的話就跳過不會走下面
if (empty($extMap[$_FILES['picture']['type']])) {
    $output['error'] = '檔案類型錯誤';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$ext = $extMap[$_FILES['picture']['type']]; // 副檔名

$filename = md5($_FILES['picture']['name'] . rand()) . $ext;

$output['filename'] = $filename;

// 把上傳的檔案搬移到指定的位置
if (move_uploaded_file($_FILES['picture']['tmp_name'], $folder . $filename)) {
    $output['success'] = true;
} else {
    $output['error'] = '無法搬動檔案';
}}


// TODO: 欄位檢查, 後端的檢查
if (empty($_POST['name'])) {
    $output['error'] = '沒有名稱資料';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
$name = $_POST['name'] ?? '';
$pic = $filename ?? '';
$area = $_POST['area'] ?? '';
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
$sql_no_pic = "UPDATE `tourist_spot` SET `area`=?,`name`=?,`type`=?,`open_time`=?,`close_day`=?,`tel`=?,`address`=?,`description`=?,`event_site`=? WHERE `sid`=$sid ";
// 這邊設計的sql是當圖片沒有改變時會跑的地方


if($filename ==""){

    $stmt = $pdo->prepare($sql_no_pic);
    
    $stmt->execute([
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
    }else{
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

}

if ($stmt->rowCount() == 1) {
    // 這邊的rowCount是看有沒有修改
    $output['success'] = true;
} else {
    $output['error'] = '資料沒有修改';
}
// isset() vs empty()


echo json_encode($output, JSON_UNESCAPED_UNICODE);
