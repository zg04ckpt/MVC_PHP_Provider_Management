<div class="d-flex mb-3">
    <a href="/manage/provider/create" class="btn border-color-1 flex-shrink-0  me-2" type="submit">
        <i class="fa-solid fa-plus me-1"></i>
        Thêm nhà cung cấp
    </a>
</div>

<!-- Searching & Filtering -->
<div class="d-flex mb-3">
    <div class="d-flex">
        <input id="keyInp" class="form-control me-2" onchange="key = this.value" type="search" placeholder="Mã/Tên nhà cung cấp">
        <button class="btn bg-color-1 text-white flex-shrink-0" onclick="search()">Tìm kiếm</button>
        <button class="btn bg-color-4 color-2 border-color-1 ms-2 flex-shrink-0"
            onclick="reset()">Làm mới</button>
    </div>

    <!-- Key tag -->
    <span id="keyTag" class="d-flex align-items-center bg-white px-3 rounded-2 shadow-sm h-auto w-auto p-0 ms-2">
        <label class="text-secondary">Từ khóa tìm kiếm: "<b class="fst-italic">Hữu hạn</b>"</label>
        <i class="fa-solid fa-xmark ms-2 h5 clickable mb-0" onclick="resetKey()"></i>
    </span>

    <div class="flex-fill"></div>
    <select name="" id="servicesSelect" class="form-select w-auto me-2" onchange="search()">
        <option value="">Tất cả dịch vụ</option>
    </select>
    <select name="" id="providerStatus" class="form-select w-auto" onchange="search()">
        <option value="">Tất cả trạng thái</option>
        <option value="active">Đang hợp tác</option>
        <option value="inactive">Chưa / Đã ngừng hợp tác</option>
    </select>
</div>

<div class="card card-body p-2 pt-1 shadow-sm">
    <table id="list-providers" class="table table-hover">
        <thead>
            <tr>
                <th style="width: 30px;"><input type="checkbox" class="form-check-input"></th>
                <th style="width: 50px;">STT</th>
                <th>Logo</th>
                <th>Mã</th>
                <th>Tên</th>
                <th>Trạng thái</th>
                <th>Website</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>

    <!-- Pagination -->
    <nav id="paginationView" class="d-flex justify-content-center">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link"><i class="fa-solid fa-chevron-left"></i></a>
            </li>
            <li class="page-item num active">
                <a class="page-link " href="#">1</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#"><i class="fa-solid fa-chevron-right"></i></a>
            </li>
        </ul>
    </nav>
</div>

<script>
    let providers = [];

    $(document).ready(() => {
        search();
        // load dịch vụ
        showLoading();
        $.ajax({
            url: '/manage/service/list?page=1&size=100',
            method: 'GET', 
            success: res => {
                res.data.items.forEach(e => {
                    $('#servicesSelect').append(`
                        <option value="${e.id}">${e.name}</option>
                    `)
                })
            },
            error: err => {
                showToast(err.responseJSON.message);
            },
            complete: () => hideLoading()
        });
    });

    function search() {
        const key = $('#keyInp').val() ?? null;
        const status = $('#providerStatus').val();
        const serviceId = $('#servicesSelect').val();
        const page = $('.pagination li.active a').text();
        const size = 10;
        showLoading();
        $.ajax({
            url: '/manage/provider/list',
            method: 'GET',
            data: {
                key, status, page, size, serviceId
            }, 
            success: res => {
                providers = [];
                res.data.items.forEach(e => providers.push(e));
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
        const list = $('#list-providers tbody');
        list.empty();
        providers.forEach((e, i) => {
            list.append(`
                <tr>
                    <td><input type="checkbox" class="form-check-input"></td>
                    <td>${i+1}</td>
                    <td>
                        <img src="${e.logo_url}" alt="" width="50" height="50" 
                            class="object-fit-contain border border-1 rounded-2">
                    </td>
                    <td><b>${e.id}</b><i class="fa-regular fa-copy ms-1 text-secondary clickable" title="Sao chép"></i></td>
                    <td>${e.name}</td>
                    <td>${e.status == 'active'? 'Đang hợp tác':'Chưa / Đã ngừng hợp tác'}</td>
                    <td>
                        <a href="${e.website_url}" class="btn btn-sm btn-outline-secondary">Xem <i class="fa-solid fa-globe"></i></a>
                    </td>
                    <td>
                        <div class="d-flex ">
                            <a href="/manage/provider/detail?id=${e.id}" class="link-info">Xem chi tiết</a>
                            <div class="mx-1">|</div>
                            <a href="/manage/provider/update?id=${e.id}" class="link-secondary">Cập nhật</a>
                        </div>
                    </td>
                </tr>
            `);
        });

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
                <li class="page-item num ${i == page? 'active':''}">
                    <a class="page-link " href="#">${i}</a>
                </li>
            `);
        }
        paginationView.append(`
            <li class="page-item">
                <a class="page-link" href="#"><i class="fa-solid fa-chevron-right"></i></a>
            </li>
        `);

        $('.pagination li.num').on('click', function(e) {
            e.preventDefault();
            $('.pagination li.num').removeClass('active');
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
        $('#providerStatus').val('');
        $('#servicesSelect').val('');
        search();
    }
</script>