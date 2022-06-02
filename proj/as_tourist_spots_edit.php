<?php require __DIR__ . '/parts/connect_db.php';
$pageName = 'as_tourist_spots_edit';
$title = '編輯景點資料 - 舒營';


// 概念：接受SID 沒有值就不做，拿到資料到row的變數裡面，再放到JS裡面，並且用JSON輸出

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {

    header('Location: as_tourist_spots_list.php');
    exit;
}
// 如果$sid是空字串或者是0，那就不做了（false）
// 有的話就會進去上面if的循環，直接讓query執行
// 沒有就直接exit轉回列表頁

$row = $pdo->query("SELECT * FROM `tourist_spot` WHERE sid=$sid")->fetch();
if (empty($row)) {
    // 拿到sid（帶入上面的變數）後執行fetch，要嘛拿到一筆，要嘛什麼都沒拿到
    // 如果是空的陣列，empty會拿到true,也是跟上面一樣直接跳轉到列表頁
    header('Location: as_tourist_spots_list.php');
    exit;
}


?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<style>
    .form-control.red {
        border: 1px solid red;
    }

    .form-text.red {
        color: red;
    }
</style>

<!-- htmlentitles 把標籤全部用掉 -->
<!-- 還有另外一種tag的方法-->
<div class="container p-5 pt-0">
    <div class="w-100 d-flex justify-content-end">
        <a class="nav-link text-dark p-3" href="as_tourist_spots_list.php">
            <i class="fa-solid fa-arrow-rotate-left"></i>
            返回上層
        </a>
        <a class="nav-link text-dark p-3" href="as_tourist_spots_add.php">
            <i class="fa-solid fa-plus">
                新增景點
            </i>
        </a>
        <a class="nav-link text-dark p-3" href="" target="_blank">
            <i class="fa-solid fa-eye"></i>
            View Site
        </a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">編輯資料</h5>
                        <form name="form1" onsubmit="sendData();return false;" novalidate>
                            <input type="hidden" name="sid" value="<?= $row['sid'] ?>">
                            <!-- 為了讓後端知道是哪一筆，最好是其他資料一起送，最方便的做法就是直接在這邊放input隱藏欄位 ,雖然看不到，但是當送出的時候會一起送出-->
                            <!-- name sid 就是primarykey的 欄位-->
                            <div class="mb-3">
                                <label for="name" class="form-label">名稱</label>
                                <textarea class="form-control" name="name" id="name" cols="30" rows="1"><?= $row['name'] ?></textarea>
                                <div class="form-text red"></div>
                            </div>
                            <div class="mb-3">
                                <div action="as_upload_picture_api.php" method="post" enctype="multipart/form-data" style="display: none">
                                    <input type="file" name="picture" accept="image/*" />

                                </div>
                                <label for="pic" class="form-label">配圖</label>
                                <button id="pic" name="pic" onclick="uploadPicture()">上傳圖片</button>
                                <br>
                                <img id="myimg" src="" alt="" style="width: 250px;" class="pt-2" />
                            </div>
                            <div class="mb-3">
                                <label for="area" class="form-label">區域</label>
                                <select class="form-control" name="area" id="area">
                                    <option value="" selected disabled>-- 請選擇所在鄉鎮 --</option>
                                    <option value="頭城鎮" <?= $row['area'] == '頭城鎮' ? 'selected' : ''  ?>>頭城鎮</option>
                                    <option value="礁溪鄉  <?= $row['area'] == '礁溪鎮' ? 'selected' : ''  ?>">礁溪鄉</option>
                                    <option value="員山鄉" <?= $row['area'] == '員山鄉' ? 'selected' : ''  ?>>員山鄉</option>
                                    <option value="宜蘭市" <?= $row['area'] == '宜蘭市' ? 'selected' : ''  ?>>宜蘭市</option>
                                    <option value="三星鄉" <?= $row['area'] == '三星鄉' ? 'selected' : ''  ?>>三星鄉</option>
                                    <option value="大同鄉" <?= $row['area'] == '大同鄉' ? 'selected' : ''  ?>>大同鄉</option>
                                    <option value="南澳鄉" <?= $row['area'] == '南澳鄉' ? 'selected' : ''  ?>>南澳鄉</option>
                                    <option value="羅東鎮" <?= $row['area'] == '羅東鎮' ? 'selected' : ''  ?>>羅東鎮</option>
                                    <option value="冬山鄉" <?= $row['area'] == '冬山鄉' ? 'selected' : ''  ?>>冬山鄉</option>
                                    <option value="蘇澳鎮" <?= $row['area'] == '蘇澳鎮' ? 'selected' : ''  ?>>蘇澳鎮</option>
                                    <option value="五結鄉" <?= $row['area'] == '五結鄉' ? 'selected' : ''  ?>>五結鄉</option>
                                    <option value="壯圍鄉" <?= $row['area'] == '壯圍鄉' ? 'selected' : ''  ?>>壯圍鄉</option>
                                    <!-- TODO:是否能用廻圈判斷？ -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="type" class="form-label">類型</label>
                                <textarea class="form-control" name="type" id="type" cols="30" rows="1"><?= $row['type'] ?></textarea>
                                <div class="form-text red"></div>
                            </div>
                            <div class="mb-3">
                                <label for="open_time" class="form-label">開放時間</label>
                                <textarea class="form-control" name="open_time" id="open_time" cols="30" rows="1"><?= $row['open_time'] ?></textarea>
                                <div class="form-text red"></div>
                            </div>
                            <div class="mb-3">
                                <label for="close_day" class="form-label">休館日</label>
                                <textarea class="form-control" name="close_day" id="close_day" cols="30" rows="1"><?= $row['close_day'] ?></textarea>
                                <div class="form-text red"></div>
                            </div>
                            <div class="mb-3">
                                <label for="tel" class="form-label">電話</label>
                                <input type="text" class="form-control" id="tel" name="tel" value="<?= $row['tel'] ?>">
                                <div class="form-text red"></div>
                                <!-- TODO:設定or判斷式 -->
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">地址</label>
                                <textarea class="form-control" name="address" id="address" cols="30" rows="2"><?= $row['address'] ?></textarea>
                                <div class="form-text red"></div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">描述</label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="3"><?= $row['description'] ?></textarea>
                                <div class="form-text red"></div>
                            </div>
                            <div class="mb-3">
                                <label for="event_site" class="form-label">活動網址</label>
                                <textarea class="form-control" name="event_site" id="event_site" cols="30" rows="2"><?= $row['event_site'] ?></textarea>
                                <div class="form-text red"></div>
                            </div>
                            <button type="submit" class="btn btn-primary">修改</button>
                        </form>
                        <br>
                        <div id="info-bar" class="alert alert-success" role="alert" style="display:none;">
                            資料編輯成功
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
    const row = <?= json_encode($row, JSON_UNESCAPED_UNICODE); ?>;
    // 這邊的JS就是當有資料時轉換成json_encode，並且設定不要跳脫
    // 

    const tel_re = /\d{2,4}-?\d{3,4}-?\d{3,4}#?(\d+)?/;

    const pic = document.querySelector('#pic');
    const myimg = document.querySelector('#myimg');
    const picture = document.form1.picture;

    picture.addEventListener('change', async function() {
        const fd = new FormData(document.form1);
        const r = await fetch('as_upload_picture_api.php', {
            method: 'POST',
            body: fd,
        });
        const obj = await r.json();
        console.log(obj);
        //obj['filename'];
        // 這裡是抓到亂碼的圖片檔名，現在要想這麼把他傳回資料庫
        myimg.src = "./uploaded/" + obj.filename;
    });

    function uploadPicture() {
        picture.click();
    }

    const info_bar = document.querySelector('#info-bar');
    const name_f = document.form1.name;
    const area_f = document.form1.area;
    const type_f = document.form1.type;
    const open_time_f = document.form1.open_time;
    const close_day_f = document.form1.close_day;
    const tel_f = document.form1.tel;
    const address_f = document.form1.address;
    const description_f = document.form1.description;
    const pic_f = document.form1.pic;
    const event_site_f = document.form1.event_site;


    const fields = [name_f, pic_f, area_f, type_f, open_time_f, close_day_f, tel_f, address_f, description_f, event_site_f];
    const fieldTexts = [];
    // for (let f of fields) {
    //     fieldTexts.push(f.nextElementSibling);
    // }

    for (let i = 0; i < fields.length; i++) {
        // console.log(i, fields[i])
        fieldTexts.push(fields[i].nextElementSibling);
    }


    async function sendData() {

        // for (let i in fields) {
        //     // fields[i].classList.remove('red');
        //     fieldTexts[i].innerText = '';
        // }
        info_bar.style.display = 'none'; // 隱藏訊息列


        // TODO: 欄位檢查, 前端的檢查
        let isPass = true; // 預設是通過檢查的

        if (name_f.value.length < 3) {
            // alert('姓名至少兩個字');
            // name_f.classList.add('red');
            // name_f.nextElementSibling.classList.add('red');
            // name_f.closest('.mb-3').querySelector('.form-text').classList.add('red');
            fields[0].classList.add('red');
            fieldTexts[0].innerText = '至少輸入三個字';
            isPass = false;
        }

        if (tel_f.value && !tel_re.test(tel_f.value)) {
            // alert('手機號碼格式錯誤');
            fields[6].classList.add('red');
            fieldTexts[6].innerText = '號碼格式錯誤';
            isPass = false;
        }

        if (address_f.value.length < 3) {
            // alert('姓名至少兩個字');
            // name_f.classList.add('red');
            // name_f.nextElementSibling.classList.add('red');
            // name_f.closest('.mb-3').querySelector('.form-text').classList.add('red');
            fields[7].classList.add('red');
            fieldTexts[7].innerText = '至少輸入三個字';
            isPass = false;
        }
        if (description_f.value.length < 10) {
            fields[8].classList.add('red');
            fieldTexts[8].innerText = '至少輸入十個字';
            isPass = false;
        }
        // if (email_f.value && !email_re.test(email_f.value)) {
        //     // alert('email 格式錯誤');
        //     fields[1].classList.add('red');
        //     fieldTexts[1].innerText = 'email 格式錯誤';
        //     isPass = false;
        // }
        if (!isPass) {
            return; // 結束函式
        }

        const fd = new FormData(document.form1);
        // 打包
        const r = await fetch('as_tourist_spots_edit_api.php', {
            // 丟出去
            method: 'POST',
            body: fd,
        });
        const result = await r.json();
        console.log(result);
        info_bar.style.display = 'block'; // 顯示訊息列
        if (result.success) {
            info_bar.classList.remove('alert-danger');
            info_bar.classList.add('alert-success');
            info_bar.innerText = '修改成功';

            setTimeout(() => {
                // location.href = 'ab-list.php'; // 跳轉到列表頁
            }, 2000);
        } else {
            info_bar.classList.remove('alert-success');
            info_bar.classList.add('alert-danger');
            info_bar.innerText = result.error || '資料沒有修改';
        }

    }
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>>