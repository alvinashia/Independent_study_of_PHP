<?php require __DIR__ . '/parts/connect_db.php';
$pageName = 'ab-add';
$title = '新增景點資料 - 舒營';

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
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">新增資料</h5>
                    <form name="form1" onsubmit="sendData();return false;" novalidate>
                        <!-- novalidate意思是不要用HTML5的檢查方式，也就是禁止表單驗證，畫面上的功能取消，並且不會跳提示 -->
                        <!--   data- 是用戶自己決定的屬性，可以自行控制要不要開，加上就是暫時取消-->
                        <!-- 要是沒有填內容就不會送出資料 -->
                        <!-- sendData()意思是利用AJAX的方式來做欄位檢查 -->
                        <!-- 一般觸發設計會放在表單的上用onsubmit，而不是用在按鈕上按onclick，因為表單上用onsubmit只要按enter也是可以執行，對桌機比較友善 -->
                        <div class="mb-3">
                            <label for="pic" class="form-label">圖片</label>
                            <textarea class="form-control" name="pic" id="pic" cols="30" rows="3"></textarea>
                            <!-- 中間不能有換行或空白，不然會變成textarea的值 -->
                            <!-- TODO:待修 -->
                            <div class="form-text "></div>
                        </div>
                        <div class="mb-3">
                            <label for="area" class="form-label">地區</label>
                            <input type="text" class="form-control" id="area" name="area">
                            <div class="form-text red"></div>
                            <!-- TODO:做下拉式選單 -->
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">名稱</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <div class="form-text red"></div>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">類型</label>
                            <input type="text" class="form-control" id="type" name="type" pattern="09\d{8}">
                            <div class="form-text red"></div>
                        </div>
                        <div class="mb-3">
                            <label for="open_time" class="form-label">開放時間</label>
                            <input type="text" class="form-control" id="open_time" name="open_time">
                            <div class="form-text "></div>
                        </div>
                        <div class="mb-3">
                            <label for="close_day" class="form-label">休館日</label>
                            <input type="text" class="form-control" name="close_day" id="close_day" cols="30" rows="3"></input>
                            <!-- 中間不能有換行或空白，不然會變成textarea的值 -->
                            <div class="form-text "></div>
                        </div>
                        <div class="mb-3">
                            <label for="tel" class="form-label">電話</label>
                            <input type="text" class="form-control" name="tel" id="tel" cols="30" rows="3"></input>
                            <!-- TODO:設定or判斷式 -->
                            <div class="form-text "></div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">地址</label>
                            <textarea class="form-control" name="address" id="address" cols="30" rows="3"></textarea>
                            <!-- 中間不能有換行或空白，不然會變成textarea的值 -->
                            <div class="form-text "></div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">描述</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="3"></textarea>
                            <!-- 中間不能有換行或空白，不然會變成textarea的值 -->
                            <div class="form-text "></div>
                        </div>
                        <div class="mb-3">
                            <label for="event_site" class="form-label">活動網址</label>
                            <textarea class="form-control" name="event_site" id="event_site" cols="30" rows="3"></textarea>
                            <!-- 中間不能有換行或空白，不然會變成textarea的值 -->
                            <div class="form-text "></div>
                        </div>

                        <button type="submit" class="btn btn-primary">新增</button>
                    </form>
                    <div id="info-bar" class="alert alert-success" role="alert" style="display:none;">
                        資料新增成功
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
    // const area_re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zAZ]{2,}))$/;
    // 講義p42，檢查e-mail有無符合格式(正規表示法)
    // const mobile_re = /^09\d{2}-?\d{3}-?\d{3}-?/;
    // 檢查手機有無符合格式（正規表示法）

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
    //這邊是先拿到欄位的參照，表示值，值是要到sendData裡面才會需要
    // TODO: 5/26 9:30

    // 下面的fields是全部都要做檢查的，所以直接丟到一個陣列裡面
    const fields = [name_f, area_f, type_f, open_time_f, close_day_f, tel_f, address_f, description_f, pic_f, event_site_f];
    // 下面的廻圈也可以這樣寫 const filedTexts = [name_f, area_f, mobile_f];等於自動去去這邊參照得到的値
    const fieldTexts = [];
    for (let f of fields) {
        fieldTexts.push(f.nextElementSibling);
    }


    async function sendData() {
        // async 是全域宣告function的意思
        // 讓欄位的外觀回復原來的狀態
        for (let i in fields) {
            fields[i].classList.remove('red');
            fieldTexts[i].innerText = '';
        }

        info_bar.style.display = 'none';
        //隱藏訊息列

        let isPass = true;

        //確認欄位有無通過檢查,預設為通過檢查
        //     // isPass = false就是不會送資料出去

        //     if (name_f.value.length < 2) {
        //         // alert('姓名至少兩個字');
        //         // name_f.classList.add('red');
        //         // name_f.nextElementSibling.classList.add('red') 意思是下一個換色，還有下面的寫法
        //         // name_f.closest('.mb-3').querySelector('.form-text').classList.add('red')
        //         // closest這個是先找到上面那層再繼續往下找，兩種寫法都可以,
        //         // parenNode是只有抓上一層，closest是當中間如果有很多層是他還會繼續往上找，直到找到再停下
        //         fields[0].classList.add('red');
        //         // fieldTexts[0].classList.add('red');
        //         fieldTexts[0].innerText = '姓名至少兩個字';
        //         // 提示錯誤訊息
        //         isPass = false;
        //     }
        //     //如果是該欄位的値(字串少於兩個)就會跑進來出現提示，並且isPass = false

        //     if (
        //         _f.value && !email_re.test(email_f.value)) {
        //         // alert('email 格式不對');
        //         fields[1].classList.add('red');
        //         // fieldTexts[0].classList.add('red');
        //         fieldTexts[1].innerText = 'email格式錯誤';
        //         isPass = false;
        //     }
        //     //如果email有輸入的值，但沒有通過最上面設定的email_re，就會出現提示
        //     //沒有填內容就不檢查

        //     if (mobile_f.value && !mobile_re.test(mobile_f.value)) {
        //         // alert('手機號碼格式錯誤');
        //         fields[2].classList.add('red');
        //         // fieldTexts[0].classList.add('red');
        //         fieldTexts[2].innerText = '手機號碼格式錯誤';
        //         isPass = false;
        //     }

        //     if (!isPass) {
        //         return;
        //     }
        //如果不是isPass就是直接回去不要往下走，結束function ,要是有通過才會往下走，發送fetch(AJAX)

        // TODO: 欄位檢查，後端的檢查
        const fd = new FormData(document.form1);
        // fd=fromdata，意思是拿到有外觀資料的表單form1放到Data裡面
        const r = await fetch('ab-add-api.php', {
            // r=result,等於把資料送給 ab-add-api.php這個檔案
            method: 'POST',
            // 方法是使用"POST"
            body: fd,
            // 送出去的body是 fd這個物件
        });
        const result = await r.json();
        // 回傳的r會是一個json，所以我們這邊就直接用原生的json()
        console.log(result);

        // 顯示訊息列
        info_bar.style.display = 'block'; // 顯示訊息列
        if (result.success) {
            info_bar.classList.remove('alert-danger');
            info_bar.classList.add('alert-success');
            info_bar.innerText = '新增成功';

            setTimeout(() => {
                // location.href = 'ab-list.php'; // 跳轉到列表頁，可做可不用，時間也可以再調
            }, 2000);
        } else {
            info_bar.classList.remove('alert-success');
            info_bar.classList.add('alert-danger');
            info_bar.innerText = result.error || '資料無法新增';
            // 一般來說“資料無法新增”這種提示對用戶來講沒什麼用處，應該要提醒是哪裡有問題比較重要
        }
        // TODO:讓後端處理訊息錯誤的方法 5/26 09:58
    }
    // }
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>