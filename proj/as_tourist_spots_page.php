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

    <!-- <div class="productcard d-flex flex-wrap justify-content-center mt-5" id="productcard"> -->

    <div class="area d-flex flex-wrap justify-content-center mt-5 mr-2 " id="area">



    </div>
    <!-- 
    </div> -->
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
        sid,
        area,
        type,
        description,
        pic,
        address,
        tel,
        name,
        open_time,
        close_day,
        event_site,

    }) => {

        // return `<h2 class="text-white">${address}</h2>`
        // <div class="card-header">
        // </div>justify-content-center 

        return `<div class="card col-lg-6 mb-5 pb-5 ">
            <div class="card-body d-flex flex-column mr-2 position-relative">
                <img src="./imgs/${pic}.jpg" class="img-fluid rounded mx-auto d-block" style="width: 600px;height:400px" alt="...">
                <div style="width:600px ;">
                <h2 class="card-title mt-3">${name}</h2>
                <small class="text-muted">位於 ${area} 的${type}</small>
                <h6 class="card-text pt-4">${tel}</h6>
                <h6 class="card-text">${address}</h6>
                <h6 class="card-text">開放時間：${open_time}</h6>
                <h6 class="card-text">${close_day}</h6>
                <p class="card-text pt-3 ">${description}</p>
                </div>
                <br>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <a href="${event_site}" class="btn btn-primary position-absolute top-100 start-50 translate-middle ">參加活動</a>
                    </div>
                </div>
            </div>`

        // return `<div class="card col-3 d-flex m-1 mb-5 flex-column justify-content-between ">
        //     <img src="./imgs/product/${pic}.jpg" alt="" class="card-img-top">
        //     <div class="cardbody m-2">
        //     <h5>${area}</h5>
        //     <h6 class="text-secondary">${name}</h6>

        //     </div>
        //        <div class="cardfoot m-2">

        //            <h2 class ="fw-light text-primary">NT<span>${type}</span></h2>
        //         </div>
        //         <a  href="c_detail.php?sid=${open_time}" class="btn btn-outline-secondary m-2">商品詳情</a>
        //     <button type="button" class="btn btn-primary m-2">+加入購物車</button>
        //     </div>

        // </div>`
    };

    // console.log(renderRow);

    function renderTable() {
        const tbody = document.getElementById("area")
        let html = "";
        if (data.rows && data.rows.length) {
            html = data.rows.map((r) => renderRow(r)).join("");
        }
        tbody.innerHTML = html;
    }

    fetch("as_tourist_spots_list_api.php?page=1")
        .then((r) => r.json())
        .then((obj) => {
            data = obj;
            renderTable();
            renderPagination();
        });
</script>
<?php include __DIR__ . '/c_part/c_foot.php' ?>