<?php
if (!isset($pageName)) {
    $pageName = '';
}
?>
<style>
    .navbar .navbar-nav .nav-link.active {
        background-color: #eac18a;
        color: black;
        font-weight: 800;
        border-radius: 5px;
        /* 設定當按下去之後會呈現什麼顏色 */
    }

    .logo {
        width: 40px;

    }
</style>
<div class="all d-flex">
    <div class="col-auto min-vh-100 col-2 bg-info">
        <div class="d-flex align-items-baseline justify-content-center mt-5">
            <img src="" alt="" class="logo">
            <!-- logo還沒放 -->
            <a class="navbar-brand" href="#">舒營</a>
        </div>
        <br>
        <ul class="p-0">
            <button type="button" class="btn btn-outline-light w-100 border-0">
                <a class="text-dark text-decoration-none<?= $pageName == 'ab-list' ? 'active' : '' ?>" href="ad_list.php">
                    <!-- php壓在class裡面 -->
                    <i class="fa-solid fa-user-large"></i>
                    會員列表
                </a>
            </button>
            <button type="button" class="btn btn-outline-light w-100 border-0">
                <a class="text-dark text-decoration-none<?= $pageName == 'ab-list' ? 'active' : '' ?>" href="campland_list.php">
                    <i class="fa-solid fa-location-dot"></i>
                    園區導覽
                </a>
            </button>
            <button type="button" class="btn btn-outline-light w-100 border-0">
                <a class="text-dark text-decoration-none<?= $pageName == 'ab-list' ? 'active' : '' ?>" href="tentroom_list.php">
                    <i class="fa-solid fa-campground"></i>
                    訂房系統
                </a>
            </button>
            <button type="button" class="btn btn-outline-light w-100 border-0">
                <a class="text-dark text-decoration-none <?= $pageName == 'ab-list' ? 'active' : '' ?>" href="recipes_list.php">
                    <i class="fa-solid fa-utensils"></i>
                    食譜教學
                </a>
            </button>
            <button type="button" class="btn btn-outline-light w-100 border-0">
                <a class="text-dark text-decoration-none <?= $pageName == 'ab-list' ? 'active' : '' ?>" href="activities_list.php">
                    <i class="fa-solid fa-person-hiking"></i>
                    活動加購
                </a>
            </button>
            <button type="button" class="btn btn-outline-light w-100 border-0">
                <a class="text-dark text-decoration-none <?= $pageName == 'p-list' ? 'active' : '' ?>" href="p_list.php">
                    <i class="fa-solid fa-basket-shopping"></i>
                    商品列表
                </a>
            </button>
            <button type="button" class="btn btn-outline-light w-100 border-0">
                <a class="text-dark text-decoration-none <?= $pageName == 'p-list' ? 'active' : '' ?>" href="p_list.php">
                    <i class="fa-solid fa-scissors"></i>
                    客製商品
                </a>
            </button>
            <button type="button" class="btn btn-outline-light w-100 border-0">
                <a class="text-dark text-decoration-none <?= $pageName == 'p-list' ? 'active' : '' ?>" href="p_list.php">
                    <i class="fa-solid fa-cart-arrow-down"></i>
                    訂購列表
                </a>
            </button>

        </ul>
    </div>