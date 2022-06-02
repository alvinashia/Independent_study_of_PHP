<?php require __DIR__ . './parts/connect_db.php';
$pageName = 'as_tourist_spots_page';
$title = '周邊景點';

?>
<?php include __DIR__ . '/c_part/c_head.php' ?>
<?php include __DIR__ . '/c_part/c_nav.php' ?>
<style>
    body {
        background: url(./imgs/pexels-lumn-167696.jpg);
        background-size: cover;
        background-repeat: no-repeat;
    }

    /* #logo{
                width: 30px;
                filter: invert(1);
            } */
</style>

<div class="container">

    <!-- <div class="filter text-center mt-5">
               <button class="filter-btn btn btn-outline-info px-5" data-id="all">all</button>
               <button class="filter-btn btn btn-outline-info px-5" data-id="餐廚">餐廚</button>
               <button class="filter-btn btn btn-outline-info px-5" data-id="桌椅">桌椅</button>
               <button class="filter-btn btn btn-outline-info px-5" data-id="帳篷">帳篷</button>
           </div> -->

    <div class="productcard d-flex flex-wrap justify-content-center mt-5" id="productcard">

    </div>
</div>





<?php include __DIR__ . '/c_part/c_scripts.php' ?>

<script>
    // let data;
    // const renderPageBtn = (pageNum) => {
    //     return `
    //                 <li class="page-item ">
    //                     <a class="page-link" href="#">${pageNum}</a>
    //                 </li>
    //             `;
    // };
    // const renderPagination = (page = 1, totalPages = 10) => {
    //     let str = "";
    //     for (let i = 1; i <= 5; i++) {
    //         str += renderPageBtn(i);
    //     }
    //     document.querySelector(".pagination").innerHTML = str;
    // };
    const renderRow = ({
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
    }) => {

        return `<div class="card-body d-flex justify-content-center flex-column" name="card1">
                <img src="./imgs/${pic}.jpg" class="img-fluid rounded mx-auto d-block" style="width: 600px;" alt="...">
                <div style="width:600px ;">
                    <h2 class="card-title mt-3">${name}</h2>
                    <small class="text-muted">位於 ${area} 的${type}</small>
                    <h6 class="card-text pt-4">${tel}</h6>
                    <h6 class="card-text">${address}</h6>
                    <h6 class="card-text">開放時間：${open_time}</h6>
                    <h6 class="card-text">${close_day}</h6>
                    <p class="card-text pt-3 ">${$descripition}</p>
                    <p class="card-text pb-2 "><a href="${event_site} ?? "javascript:void(0)" name="event" id="event">參加活動</a></p>
                </div>
                <a href="as_tourist_spots_list.php" class="btn btn-primary">返回</a>
            </div>`

        //     return `<div class="card col-3 d-flex m-1 mb-5 flex-column justify-content-between ">
        //     <img src="./imgs/product/${productimg}.jpg" alt="" class="card-img-top">
        //     <div class="cardbody m-2">
        //     <h5>${productname}</h5>
        //     <h6 class="text-secondary">${productcategory}</h6>

        //     </div>
        //        <div class="cardfoot m-2">

        //            <h2 class ="fw-light text-primary">NT<span>${productprice}</span></h2>
        //         </div>
        //         <a  href="c_detail.php?sid=${sid}" class="btn btn-outline-secondary m-2">商品詳情</a>
        //     <button type="button" class="btn btn-primary m-2">+加入購物車</button>
        //     </div>

        // </div>
        //     `
    };



    function renderTable() {
        const tbody = document.getElementById("productcard")
        let html = "";
        if (data.rows && data.rows.length) {
            html = data.rows.map((r) => renderRow(r)).join("");
        }
        tbody.innerHTML = html;
    }

    fetch("as_tourist_spots_list_api.php?page=1")
        .then((r) => r.text())
        .then((obj) => {
            data = obj;
            renderTable();
            // renderPagination();
        });
</script>
<?php include __DIR__ . '/c_part/c_foot.php' ?>