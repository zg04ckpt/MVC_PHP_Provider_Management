
<div class="card card-body p-2 mb-3 shadow-sm">
    <div class="d-flex align-items-center ps-2 justify-content-between">
        <div class="d-flex align-items-center col">
            <label class="fs-5">Tổng chi phí </label>
            <h3 class="mb-0 d-flex me-3"><b id="lbTotal" class="mx-2">123.330.256</b> <div class="text-secondary fs-6">VNĐ</div></h3>
        </div>
        <div class="d-flex align-items-center col">
            <label class="fs-5">Đã thanh toán </label>
            <h3 class="mb-0 d-flex me-3"><b id="lbPaid" class="mx-2 text-success">123.330.256</b> <div class="text-secondary fs-6">VNĐ</div></h3>
        </div>
        <div class="d-flex align-items-center col">
            <label class="fs-5">Còn nợ </label>
            <h3 class="mb-0 d-flex me-3"><b id="lbUnpaid" class="mx-2 text-danger">0</b> <div class="text-secondary fs-6">VNĐ</div></h3>
        </div>
    </div>
</div>

<!-- Searching & Filtering -->
<div class="d-flex mb-3">
    <div class="d-flex">
        <input id="keyInp" class="form-control me-2" onchange="key = this.value" type="search" placeholder="Mã đơn hàng">
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
    <select id="orderStatus" class="form-select w-auto" onchange="search()">
        <option value="">Tất cả trạng thái</option>
        <option value="wait">Chờ cung cấp</option>
        <option value="wait_pay">Chờ thanh toán</option>
        <option value="paid">Đã thanh toán</option>
    </select>
</div>

<div class="card card-body p-2 pt-1 shadow-sm">
    <table id="list-order" class="table table-hover">
        <thead>
            <tr>
                <th style="width: 30px;"><input type="checkbox" class="form-check-input"></th>
                <th style="width: 30px;">ID</th>
                <th>Tên dịch vụ</th>
                <th style="width: 140px;">Ngày phát sinh</th>
                <th style="width: 140px;">Tổng tiền</th>
                <th style="width: 80px;">Đơn vị</th>
                <th style="width: 160px;">Trạng thái</th>
                <th style="width: 200px;">Hành động</th>
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
    let orders = [];

    $(document).ready(() => {
        search();
        // load đơn hàng
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
        const id = $('#keyInp').val() ?? null;
        const status = $('#orderStatus').val();
        const service_id = $('#servicesSelect').val();
        const page = $('.pagination li.active a').text();
        const size = 10;
        showLoading();
        $.ajax({
            url: '/manage/order/list',
            method: 'GET',
            dataType: 'JSON',
            data: {
                id, status, page, size, service_id
            }, 
            success: res => {
                orders = [];
                res.data.items.forEach(e => orders.push(e));
                updateUI(res.data.page, res.data.items, res.data.totalPages);
            },
            error: err => {
                console.log(err);
                
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

        // Update summary
        let sum = 0, paid = 0;
        orders.forEach(e => {
            sum += e.total;
            if (e.status == 'paid') {
                paid += e.total;
            }
        });
        $('#lbTotal').text(sum.toLocaleString('vn'));
        $('#lbPaid').text(paid.toLocaleString('vn'));
        $('#lbUnpaid').text((sum - paid).toLocaleString('vn'));

        // Update list
        const list = $('#list-order tbody');
        list.empty();
        orders.forEach((e, i) => {
            list.append(`
                <tr onclick="window.location.href = '/manage/order/detail?id=${e.id}'">
                    <td><input type="checkbox" class="form-check-input"></td>
                    <td>#${e.id}</td>
                    <td>${e.service_name}</td>
                    <td>${e.created_date}</td>
                    <td>${Number(e.total).toLocaleString('vn')}</td>
                    <td>${e.currency}</td>
                    <td >
                        <div class="status-tag-${e.status == 'wait' ? 'none': e.status == 'wait_pay' ? 'error':'success'}">
                            ${e.status == 'wait' ? 'Chờ cung cấp': e.status == 'wait_pay' ? 'Chờ thanh toán':'Đã thanh toán'}
                        </div>
                    </td>
                    <td class=" py-2">
                        
                        <a href='/manage/order/pay?id=${e.id}' class="btn btn-sm btn-outline-dark ${e.status == 'wait_pay'? "":'d-none'}">
                            <i class="far fa-money-bill-alt text-warning"></i>
                            Thanh toán ngay
                        </a>
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
            $('html, body').animate({ scrollTop: 0 }, 'smooth');
        });
    }

    const resetKey = () => {
        $('#keyInp').val('');
        search();
    }

    const reset = () => {
        $('#keyInp').val('');
        $('#orderStatus').val('');
        $('#servicesSelect').val('');
        search();
    }
</script>