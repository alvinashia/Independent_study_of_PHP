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


$folder = __DIR__ . '/uploaded/';


$extMap = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png',
    'image/gif' => '.gif',
];

// if (true){
//     $output['error'] = $_POST['pic_origin'];
//     echo json_encode($output, JSON_UNESCAPED_UNICODE);
//     exit;
// }
if (!empty($_FILES['picture']['name'])){
    // 判斷如果pic name 不是空值就會跑下面，為空則跳過
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
    }
}


// TODO: 欄位檢查, 後端的檢查
if (empty($_POST['name'])) {
    $output['error'] = '沒有名稱資料';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
$name = $_POST['name'] ?? '';
$pic = $filename ?? $_POST['pic_origin'];
// filename存在則上傳filename,沒有的話就是上傳前面設置的隱藏欄位pic_origin
$area = $_POST['area'] ?? '';
$type = $_POST['type'] ?? '';
$open_time = $_POST['open_time'] ?? '';
$close_day = $_POST['close_day'] ?? '';
$tel = $_POST['tel'] ?? '';
$address = $_POST['address'] ?? '';
$descripition = $_POST['description'] ?? '';
$event_site = $_POST['event_site'] ?? '';


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
    $output['success'] = true;
} else {
    $output['error'] = '資料沒有修改';
}



echo json_encode($output, JSON_UNESCAPED_UNICODE);
