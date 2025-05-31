<?php session_start() ?>
<!-- Start NavBar -->
<nav class="navbar shadow-sm py-0 fixed-top navbar-expand-lg bg-body-tertiary" style="z-index: 99; ">
    <!-- Show when small -->
    <!-- <div class="d-md-none container-fluid bg-white">
        <a class="navbar-brand" href="#">
            <img src="../assets/logo.png" alt="Bootstrap" width="30" height="30">
            Quản lý NCC
        </a>
        <button class="navbar-toggler m-2" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item mb-2">
                    <a href="index.html" class="nav-link" aria-current="page">
                        <i class="fa-solid fa-chart-simple" width="24"></i>
                        Thống kê
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="provider.html" class="nav-link">
                        <i class="fa-solid fa-truck" width="24"></i>
                        Nhà cung cấp
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="service.html" class="nav-link" aria-current="page">
                        <i class="fa-solid fa-list" width="24"></i>
                        Dịch vụ
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="invoice.html" class="nav-link">
                        <i class="fa-solid fa-file" width="24"></i>
                        Hóa đơn dịch vụ
                    </a>
                </li>
            </ul>
            <form class="d-flex mb-3" role="search">
                <input class="form-control me-2" type="search" placeholder="Tên nhà cung cấp">
                <button class="btn bg-color-1 text-white flex-shrink-0" type="submit">Tìm kiếm</button>
            </form>
        </div>
    </div> -->

    <!-- Show when large -->
    <div class="d-none d-md-flex py-2 align-items-center w-100" style="padding-left: 280px;">
        <h3 class="color-2 ps-3 mb-0">
            <?php 
                if (str_starts_with($_SERVER['REQUEST_URI'], '/manage/provider')) {
                    echo 'Nhà cung cấp dịch vụ';
                } else if (str_starts_with($_SERVER['REQUEST_URI'], '/manage/service')) {
                    echo 'Dịch vụ';
                } else if (str_starts_with($_SERVER['REQUEST_URI'], '/manage/order')) {
                    echo 'Hóa đơn dịch vụ';
                } else {
                    echo 'Thống kê tổng quan';
                }
            ?>
        </h3>
        <div class="flex-fill"></div>

        <!-- Avatar -->
        <div class="dropdown me-3">
            <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle"
                data-bs-toggle="dropdown">
                <img src="../public/images/logo.png" alt="" width="32" height="32" class="me-2 rounded-circle border-color-1 me-2">
                <strong class="color-1"><?php echo $_SESSION['username'] ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Đăng xuất</a></li>
            </ul>
        </div>
    </div>  

    <!-- Loading -->
    <div id="loading" class="position-absolute top-100 start-0 w-100 loading">
        <div class="item"></div>
    </div>
</nav>
<!-- End NavBar -->
<script>
    $(document).ready(() => {
        hideLoading();
    })
</script>