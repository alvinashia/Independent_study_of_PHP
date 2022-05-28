<?php
if (!isset($pageName)) {
    $pageName = '';
}
?>
<style>
    .navbar .navbar-nav .nav-link.active {
        background-color: #6e6e6e;
        color: white;
        font-weight: 800;
        border-radius: 5px;
        /* 設定當按下去之後會呈現什麼顏色 */
    }
</style>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <!-- 一般 Nav bar 是放LOGO -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'index' ? 'active' : '' ?>" href="index_.php">Home</a>
                        <!-- 指到index_.php這個鏈接 -->
                        <!-- <?= $pageName == 'index' ? 'active' : '' ?> 這邊是決定要不要輸出active的三元運算子，是的話就是輸出active，沒有的話就是空字串 -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'ab-list' ? 'active' : '' ?>" href="ab-list.php">ab-list</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'ab-add' ? 'active' : '' ?>" href="ab-add.php">新增通訊錄</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
</div>