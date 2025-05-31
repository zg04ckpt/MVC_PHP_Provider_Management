
<!-- Start Sidebar -->
<div class="d-none d-md-flex top-0 flex-column vh-100 position-fixed flex-shrink-0 p-3 bg-color-1 text-white" style="width: 280px; z-index: 100;">
    <a href="/" class="d-flex align-items-center text-light mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <img src="../public/images/logo.png" alt="Bootstrap" class="bg-white rounded-pill" width="40" height="40">
        <span class="fs-4 ms-3">Quản lý NCC</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto ">
        <li class="nav-item mb-2">
            <a href="/manage/overview" class="nav-link text-light <?php if (str_starts_with($_SERVER['REQUEST_URI'], '/manage/overview')) echo 'active' ?>">
                <i class="fa-solid fa-chart-simple" width="24"></i>
                Thống kê
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="/manage/provider" class="nav-link text-light <?php if (str_starts_with($_SERVER['REQUEST_URI'], '/manage/provider')) echo 'active' ?>"">
                <i class="fa-solid fa-truck" width="24"></i>
                Nhà cung cấp
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="/manage/service" class="nav-link text-light <?php if (str_starts_with($_SERVER['REQUEST_URI'], '/manage/service')) echo 'active' ?>"">
                <i class="fa-solid fa-list" width="24"></i>
                Dịch vụ
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="/manage/order" class="nav-link text-light <?php if (str_starts_with($_SERVER['REQUEST_URI'], '/manage/order')) echo 'active' ?>"">
                <i class="fa-solid fa-file" width="24"></i>
                Hóa đơn dịch vụ
            </a>
        </li>
    </ul>
    </div>
<!-- End Sidebar -->