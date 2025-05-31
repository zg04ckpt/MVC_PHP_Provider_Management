<!-- Action -->
<div class="d-flex mb-3">
    <a href="/manage/service/create" class="btn me-2 bg-color-4 color-2 border-color-1 flex-shrink-0" type="submit">
        <i class="fa-solid fa-plus"></i>
        Thêm dịch vụ mới
    </a>
</div>

<!-- Searching -->
<div class="d-flex mb-3">
    <div class="d-flex">
        <input id="keyInp" class="form-control me-2" type="search" placeholder="Mã/Tên dịch vụ">
        <button class="btn bg-color-1 text-white flex-shrink-0" onclick="search();">Tìm kiếm</button>
        <button class="btn bg-color-4 color-2 border-color-1 ms-2 flex-shrink-0"
            onclick="reset()">Làm mới</button>
    </div>

    <!-- Key tag -->
    <span id="keyTag" class="d-flex align-items-center bg-white px-3 rounded-2 shadow-sm h-auto w-auto p-0 ms-2">
        <label class="text-secondary">Từ khóa tìm kiếm: "<b class="fst-italic">Hữu hạn</b>"</label>
        <i class="fa-solid fa-xmark ms-2 h5 clickable mb-0" onclick="resetKey()"></i>
    </span>
</div>

<div class="card card-body pt-1">
    <!-- Tab -->
    <ul id="tab" class="nav tab nav-underline text-light">
        <li class="nav-item">
            <a class="nav-link text-secondary active">Tất cả</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-secondary " >Đã kí hợp đồng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-secondary" >Chưa kí hợp đồng</a>
        </li>
    </ul>

    <!-- Services -->
    <div id="listService" class="row g-3 mt-2">

        <!-- <div class="col-6">
            <div class="d-flex border-color-1 rounded-2 service-item p-2">
                <div class="d-flex flex-column ms-2 w-100">
                    <h5 class="fw-bolder">Dịch vụ điện nước</h5>
                    <div class="d-flex">
                        <div class="text-secondary">Mã dịch vụ:</div>
                        <b class="ms-1">SE123456</b>
                        <i class="fa-regular fa-copy ms-1 clickable"></i>
                    </div>
                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae excepturi sint consequatur. Ut reiciendis cupiditate eveniet architecto corporis assumenda quos maxime sit earum eligendi, aliquid molestiae voluptate alias commodi obcaecati!</p>
                    <div class="d-flex align-items-center">
                        <b class="color-2 text-secondary fst-italic">
                            Chưa kí hợp đồng
                        </b>
                        <div class="flex-fill"></div>
                        <a href="service-detail.html" class="link-secondary text-decoration-none flex-shrink-0">Xem chi tiết <i class="fa-solid fa-circle-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="d-flex border-info border-2 border rounded-2 service-item p-2">
                <div class="d-flex flex-column ms-2 w-100">
                    <h5 class="fw-bolder">Dịch vụ điện nước</h5>
                    <div class="d-flex">
                        <div class="text-secondary">Mã dịch vụ:</div>
                        <b class="ms-1">SE123456</b>
                        <i class="fa-regular fa-copy ms-1 clickable"></i>
                    </div>
                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae excepturi sint consequatur. Ut reiciendis cupiditate eveniet architecto corporis assumenda quos maxime sit earum eligendi, aliquid molestiae voluptate alias commodi obcaecati!</p>
                    <div class="d-flex align-items-center">
                        <b class="color-2 text-success fst-italic">
                            <i class="fa-solid fa-circle-check"></i> Đã kí hợp đồng
                        </b>
                        <div class="flex-fill"></div>
                        <a href="service-detail.html" class="link-info text-decoration-none flex-shrink-0">Xem chi tiết <i class="fa-solid fa-circle-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div> -->

    </div>

    <!-- Pagination -->
    <nav id="paginationView" class="d-flex justify-content-center mt-3">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link"><i class="fa-solid fa-chevron-left"></i></a>
            </li>
            <li class="page-item active">
                <a class="page-link" href="#">1</a>
            </li>
        </ul>
    </nav>
</div>
<!-- End Content -->

<script>
    $(document).ready(() => {
        search();
        $('#keyTag').addClass('d-none');
        $('#tab .nav-link').on('click', function(e) {
            e.preventDefault();
            $('#tab a').removeClass('active');
            $(this).addClass('active');
            search();
        });
    });

    function search() {
        const key = $('#keyInp').val() ?? null;
        const rawStatus = $('#tab a.active').text();
        const status = rawStatus == 'Đã kí hợp đồng'? 'signed':
                    rawStatus == 'Chưa kí hợp đồng'? 'unsigned': null;
        const page = $('#paginationView li.active a').text();
        const size = 10;
        showLoading();
        $.ajax({
            url: '/manage/service/list',
            method: 'GET',
            data: {
                key, status, page, size
            }, 
            success: res => {
                updateUI(res.data.page, res.data.items, res.data.totalPages);
            },
            error: err => {
                showToast(err.responseJSON.message);
            },
            complete: () => hideLoading()
        });
    }

    function updateUI(page, services, totalPages) {
        // Update search tag
        if ($('#keyInp').val()) {
            $('#keyTag b').text($('#keyInp').val());
            $('#keyTag').removeClass('d-none');
            $('#keyInp').val('');
        } else {
            $('#keyTag').addClass('d-none');
        }

        // Update list
        const serivceView = $('#listService');
        serivceView.empty();
        services.forEach(e => {
        if (e.status == 'unsigned') {
            serivceView.append(`
                <div class="col-6">
                    <div class="d-flex border-color-1 rounded-2 service-item p-2">
                        <div class="d-flex flex-column ms-2 w-100">
                            <h5 class="fw-bolder">${e.name}</h5>
                            <div class="d-flex">
                                <div class="text-secondary">Mã dịch vụ:</div>
                                <b class="ms-1">${e.id}</b>
                                <i class="fa-regular fa-copy ms-1 clickable"></i>
                            </div>
                            <p class="mb-0">${e.des}</p>
                            <div class="d-flex align-items-center">
                                <b class="color-2 text-secondary fst-italic">
                                    Chưa kí hợp đồng
                                </b>
                                <div class="flex-fill"></div>
                                <a href="/manage/service/detail?id=${e.id}" class="link-secondary text-decoration-none flex-shrink-0">Xem chi tiết <i class="fa-solid fa-circle-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        } else {
            serivceView.append(`
                <div class="col-6">
                    <div class="d-flex border-info border-2 border rounded-2 service-item p-2">
                        <div class="d-flex flex-column ms-2 w-100">
                            <h5 class="fw-bolder">${e.name}</h5>
                            <div class="d-flex">
                                <div class="text-secondary">Mã dịch vụ:</div>
                                <b class="ms-1">${e.id}</b>
                                <i class="fa-regular fa-copy ms-1 clickable"></i>
                            </div>
                            <p class="mb-0">${e.des}</p>
                            <div class="d-flex align-items-center">
                                <b class="color-2 text-success fst-italic">
                                    <i class="fa-solid fa-circle-check"></i> Đã kí hợp đồng
                                </b>
                                <div class="flex-fill"></div>
                                <a href="/manage/service/detail?id=${e.id}" class="link-info text-decoration-none flex-shrink-0">Xem chi tiết <i class="fa-solid fa-circle-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        }});

        // Update pagination
        const paginationView = $('#paginationView ul');
        paginationView.empty();
        paginationView.append(`
            <li class="page-item">
                <a class="page-link"><i class="fa-solid fa-chevron-left"></i></a>
            </li>
        `);

        for (let i = 1; i <= totalPages; i++) {
            paginationView.append(`
                <li class="page-item ${i == page? 'active':''}">
                    <a class="page-link " href="#">${i}</a>
                </li>
            `);
        }
        paginationView.append(`
            <li class="page-item">
                <a class="page-link" href="#"><i class="fa-solid fa-chevron-right"></i></a>
            </li>
        `);

        $('.pagination li').on('click', function(e) {
            e.preventDefault();
            $('.pagination li').removeClass('active');
            $(this).addClass('active')
            search();
        });
    }

    const resetKey = () => {
        $('#keyInp').val('');
        search();
    }

    const reset = () => {
        $('#keyInp').val('');
        search();
    }
</script>