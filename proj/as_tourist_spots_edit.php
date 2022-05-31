<?php require __DIR__ . '/parts/connect_db.php';
$pageName = 'as_tourist_spots_edit';
$title = '編輯景點資料 - 舒營';


// 概念：接受SID 沒有值就不做，拿到資料到row的變數裡面，再放到JS裡面，並且用JSON輸出

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {

    header('Location: ab-list.php');
    exit;
}
// 如果$sid是空字串或者是0，那就不做了（false）
// 有的話就會進去上面if的循環，直接讓query執行
// 沒有就直接exit轉回列表頁

$row = $pdo->query("SELECT * FROM tourist_spot WHERE sid=$sid")->fetch();
if (empty($row)) {
    // 拿到sid（帶入上面的變數）後執行fetch，要嘛拿到一筆，要嘛什麼都沒拿到
    // 如果是空的陣列，empty會拿到true,也是跟上面一樣直接跳轉到列表頁
    header('Location: ab-list.php');
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
                            <label for="pic" class="form-label">圖片</label>
                            <input type="text" class="form-control" id="pic" name="pic" required value="<?= htmlentities($row['name']) ?>">
                            <!-- TODO:待修 -->
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="area" class="form-label">地區</label>
                            <textarea class="form-control" name="area" id="area" cols="30" rows="3"><?= $row['area'] ?></textarea>
                            <div class="form-text"></div>
                            <!-- TODO:做下拉式選單 -->
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">名稱</label>
                            <textarea class="form-control" name="name" id="name" cols="30" rows="3"><?= $row['name'] ?></textarea>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">類型</label>
                            <textarea class="form-control" name="type" id="type" cols="30" rows="3"><?= $row['type'] ?></textarea>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="open_time" class="form-label">開放時間</label>
                            <textarea class="form-control" name="open_time" id="open_time" cols="30" rows="3"><?= $row['open_time'] ?></textarea>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="close_day" class="form-label">休館日</label>
                            <textarea class="form-control" name="close_day" id="close_day" cols="30" rows="3"><?= $row['close_day'] ?></textarea>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="tel" class="form-label">電話</label>
                            <textarea class="form-control" name="tel" id="tel" cols="30" rows="3"><?= $row['tel'] ?></textarea>
                            <div class="form-text"></div>
                            <!-- TODO:設定or判斷式 -->
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">地址</label>
                            <textarea class="form-control" name="address" id="address" cols="30" rows="3"><?= $row['address'] ?></textarea>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">描述</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="3"><?= $row['description'] ?></textarea>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="event_site" class="form-label">活動網址</label>
                            <textarea class="form-control" name="event_site" id="event_site" cols="30" rows="3"><?= $row['event_site'] ?></textarea>
                            <div class="form-text"></div>
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
<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
    const row = <?= json_encode($row, JSON_UNESCAPED_UNICODE); ?>;
    // 這邊的JS就是當有資料時轉換成json_encode，並且設定不要跳脫
    // 

    // const email_re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zAZ]{2,}))$/;
    // const mobile_re = /^09\d{2}-?\d{3}-?\d{3}$/;

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

    const fields = [name_f, area_f, type_f, open_time_f, close_day_f, tel_f, address_f, description_f, pic_f, event_site_f];
    const fieldTexts = [];
    for (let f of fields) {
        fieldTexts.push(f.nextElementSibling);
    }



    async function sendData() {
        for (let i in fields) {
            fields[i].classList.remove('red');
            fieldTexts[i].innerText = '';
        }
        info_bar.style.display = 'none'; // 隱藏訊息列

        // TODO: 欄位檢查, 前端的檢查
        let isPass = true; // 預設是通過檢查的

        // if (name_f.value.length < 2) {
        //     // alert('姓名至少兩個字');
        //     // name_f.classList.add('red');
        //     // name_f.nextElementSibling.classList.add('red');
        //     // name_f.closest('.mb-3').querySelector('.form-text').classList.add('red');
        //     fields[0].classList.add('red');
        //     fieldTexts[0].innerText = '姓名至少兩個字';
        //     isPass = false;
        // }
        // if (email_f.value && !email_re.test(email_f.value)) {
        //     // alert('email 格式錯誤');
        //     fields[1].classList.add('red');
        //     fieldTexts[1].innerText = 'email 格式錯誤';
        //     isPass = false;
        // }
        // if (mobile_f.value && !mobile_re.test(mobile_f.value)) {
        //     // alert('手機號碼格式錯誤');
        //     fields[2].classList.add('red');
        //     fieldTexts[2].innerText = '手機號碼格式錯誤';
        //     isPass = false;
        // }

        // if (!isPass) {
        //     return; // 結束函式
        // }

        const fd = new FormData(document.form1);
        // 打包
        const r = await fetch('ab-edit-api.php', {
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
<?php include __DIR__ . '/parts/html-foot.php' ?>