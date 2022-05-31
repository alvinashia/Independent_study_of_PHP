<?php require __DIR__ . './part/connect_db.php';
header('Content-Type: application/json');

$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => ''
];

$sid = isset($_POST['sid']) ? intval($_POST['sid']) : 0;

$pic = $_POST['pic'];
$area = $_POST['area'] ?? '';
$name = $_POST['name']  ?? '';
$type = $_POST['type'] ?? '';
$open_time = $_POST['open_time'] ?? '';
$close_day  = $_POST['close_day'] ?? '';
$tel  = $_POST['tel'] ?? '';
$address  = $_POST['address'] ?? '';
$description  = $_POST['description'] ?? '';
$event_site  = $_POST['event_site'] ?? '';

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $_POST['pic'],
    $_POST['area'],
    $_POST['name'],
    $_POST['type'],
    $_POST['open_time'],
    $_POST['close_day'],
    $_POST['tel'],
    $_POST['address'],
    $_POST['description'],
    $_POST['event_site'],
]);



if ($stmt->rowCount() == 1) {
    $output['success'] = true;
} else {
    $output['error'] = '資料沒有修改';
}



echo json_encode($output, JSON_UNESCAPED_UNICODE);
