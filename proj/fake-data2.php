<div>
    <?php require __DIR__ . '/parts/connect_db.php';
    exit; // 關閉功能
    // 怕之後不小心點到，變成無限新增，可以在執行完想要的次數後使用exit關掉

    echo microtime(true) . "<br>";
    // 這邊是最後在點下此檔案後會在空白頁上顯示的處理秒數
    //https://www.wibibi.com/info.php?tid=PHP_microtime_%E5%87%BD%E6%95%B8

    // 用亂數決定名字（last&first）
    $lname = ['陳', '林', '李', '吳', '王'];
    $fname = ['小明', '小華', '雅玲', '怡君', '大頭'];

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

    $stmt = $pdo->prepare($sql);

    for ($i = 0; $i < 100; $i++) {
        shuffle($lname);
        shuffle($fname);
        $ts = rand(strtotime('1980-01-01'), strtotime('1995-12-31'));
        $stmt->execute([
            $lname[0] . $fname[0],
            "ming{$i}@test.com",
            '0918' . rand(100000, 999999),
            date('Y-m-d', $ts),
            '南投市',
        ]);
    }

    // 用廻圈去隨機新增新資料，這邊目前是設定100筆
    // shuffle($lname);shuffle($fname); 去跑上面設定的亂數
    //rand 000000是六位數 999999是範圍，對應的是電話後面六碼（要是前面電信公司要換可以隨機用$lname的方法來用？）
    // 生日可以通過strtotime開始以及結束範圍

    echo microtime(true) . "<br>";
    ?>
</div>
<!-- // 要記得最後要用div包起來，不然顯示的順序會有問題 -->