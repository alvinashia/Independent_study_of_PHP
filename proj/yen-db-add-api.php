<?php

require __DIR__ . '/databse-connect.php';
header('Content-Type:application/json');



$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => '',
    'filename' => ''
];

//後端欄位檢查

if (empty($_POST['name'])) {
    $output['error'] = '沒有姓名資料';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (empty($_POST['username'])) {
    $output['error'] = '請填寫使用者名稱';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (empty($_POST['password'])) {
    $output['error'] = '請填寫密碼';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$name = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$birthday = empty($_POST['birthday']) ? NULL : $_POST['birthday'];
$address = $_POST['address'] ?? '';

//''是因為要存進資料庫，不能為空值，但birthday在資料表時就有勾選空值


//upload-avatar-api

$folder = __DIR__ . '/uploaded/';

// 用來篩選檔案, 用來決定副檔名
$extMap = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png',
    'image/gif' => '.gif',
];

if (empty($extMap[$_FILES['avatar']['type']])) {
    $output['error'] = '檔案類型錯誤';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
$ext = $extMap[$_FILES['avatar']['type']]; // 副檔名

$filename = md5($_FILES['avatar']['name'] . rand()) . $ext;

$output['filename'] = $filename;

// 把上傳的檔案搬移到指定的位置
if (move_uploaded_file($_FILES['avatar']['tmp_name'], $folder . $filename)) {
    $output['success'] = true;
} else {
    $output['error'] = '無法搬動檔案';
}

// $avatar = $filename;




$password = password_hash($password, PASSWORD_BCRYPT);


$sql2 = "SELECT 1 FROM `memberdata` WHERE `m_username` = ?";

$result = $pdo->prepare($sql2);

$result->execute(
    [$_POST['username']]
);


if ($result->rowCount() == 1) {

    $output['error'] = '使用者名稱已存在';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
} else {

    //email不為空值 且 email不通過驗證
    if (!empty($email) and filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $output['error'] = 'email 格式錯誤';
        $output['code'] = 405;
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
    }

    //其他欄位檢查：

    $sql = "INSERT INTO `memberdata`(
    `m_name`,`m_username`, `m_passwd`,
    `m_email`, `m_phone`, `m_birthday`, `m_address`,`m_avatar`
    ) VALUES (
        ?, ?, ?, ?,
        ?, ?, ?,?
    )";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $name,
        $username,
        $password,
        $email,
        $mobile,
        $birthday,
        $address,
        $filename
    ]);

    if ($stmt->rowCount() == 1) {
        $output['success'] = true;

        //最近新增資料的primary key
        $output['lastInsertId'] = $pdo->lastInsertId();
    } else {
        $output['error'] = '資料無法新增';
    }
};


echo json_encode($output, JSON_UNESCAPED_UNICODE);
