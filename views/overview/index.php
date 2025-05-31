<!-- Start Content -->
<!-- Basic -->
<h5>Thông tin chung</h5>
<div class="d-flex flex-row">

    <div class="card px-3 py-2 me-3 shadow-sm">
        <div class="d-flex flex-column">
            <h5 class="mb-0" style="width: fit-content;">NCC đang hợp tác</h5>
            <hr class="my-2">
            <h3 class="fw-bolder mb-0 text-center">
                <?php echo htmlspecialchars($data['active_provider'] . '/' . $data['total_provider']) ?></h3>
        </div>
    </div>

    <div class="card px-3 py-2 me-3 shadow-sm">
        <div class="d-flex flex-column">
            <h5 class="mb-0" style="width: fit-content;">Dịch vụ đang hoạt động</h5>
            <hr class="my-2">
            <h3 class="fw-bolder mb-0 text-center"><?php echo htmlspecialchars($data['signed_service'] . '/' . $data['total_service']) ?></h3>
        </div>
    </div>

    <div class="card px-3 py-2 me-3 shadow-sm">
        <div class="d-flex flex-column">
            <h5 class="mb-0" style="width: fit-content;">Hợp đồng sắp hết hạn</h5>
            <hr class="my-2">
            <h3 class="fw-bolder mb-0 text-center">
                <?php echo htmlspecialchars($data['expire_contract']) ?></h3>
        </div>
    </div>

    <div class="card px-3 py-2 me-3 shadow-sm">
        <div class="d-flex flex-column">
            <h5 class="mb-0" style="width: fit-content;">Hóa đơn chưa thanh toán</h5>
            <hr class="my-2">
            <h3 class="fw-bolder mb-0 text-center">
                <?php echo htmlspecialchars($data['wait_pay_order']) ?></h3>
        </div>
    </div>
</div>

<h5 class="mt-3">Thống kê chi phí phát sinh</h5>
<div class="row g-3">
    <div class="col-lg-4">
        <select id="time_range" class="form-select w-auto mb-2 " onchange="updateTimeRangeSelect()">
            <option value="cur_mon">Tháng hiện tại</option>
            <option value="cur_yea">Năm hiện tại</option>
            <option value="custome">Tùy chọn</option>
        </select>
        <div id="custom_time" class="d-flex flex-column d-none">
            <div class="d-flex mb-2">
                <input type="date" class="start form-control me-2">
                <input type="date" class="end form-control">
            </div>
        </div>
        <button class="btn btn-sm btn-outline-dark form-control" onclick="get_overview()">Thống kê</button>
        <label id="curTime" for="" class="mt-2 mb-1"></label>
        <div  class="card p-3 mb-2">
            <div class="d-flex flex-row align-items-center mb-2">
                <label class="flex-fill">Chi phí phát sinh:</label>
                <h4 id="total" class="fw-bolder mb-0">123.000.312</h4>
                <div class="ms-1 text-secondary">VNĐ</div>
            </div>
            <div class="d-flex flex-row align-items-center mb-2">
                <label class="flex-fill">Đã thanh toán:</label>
                <h4 id="paid" class="fw-bolder mb-0">100.000.312</h4>
                <div class="ms-1 text-secondary">VNĐ</div>
            </div>
            <div class="d-flex flex-row align-items-center mb-2">
                <label class="flex-fill">Còn nợ:</label>
                <h4 id="unpaid" class="fw-bolder mb-0">23.000.000</h4>
                <div class="ms-1 text-secondary">VNĐ</div>
            </div>
        </div>
        <label for="">Độ biến động chi phí so với cùng kì</label>
        <div class="card p-3 mt-2">
            <div id="total_change" class="d-flex flex-row align-items-center mb-2">
                <label class="flex-fill">Chi phí phát sinh:</label>
                <i class="fa-solid fa-arrow-up text-danger fs-4 mx-1"></i>
                <h4  class="fw-bolder mb-0">32%</h4>
            </div>
            <div id="paid_change" class="d-flex flex-row align-items-center mb-2">
                <label class="flex-fill">Đã thanh toán:</label>
                <i class="fa-solid fa-arrow-up text-danger fs-4 mx-1"></i>
                <h4  class="fw-bolder mb-0">32%</h4>
            </div>
            <div id="unpaid_change" class="d-flex flex-row align-items-center mb-2">
                <label class="flex-fill">Còn nợ:</label>
                <i class="fa-solid fa-arrow-up text-danger fs-4 mx-1"></i>
                <h4  class="fw-bolder mb-0">32%</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card card-body">
            <h5 class="text-center">Biểu đồ chi phí 12 tháng vừa qua</h5>
            <canvas id="expenseChart"></canvas>
        </div>
    </div>
</div>
<!-- End Content -->

<script>
    let start_date, end_date;

    function updateTimeRangeSelect() {
        const opt = $('#time_range').val();
        const today = new Date();
        if (opt == 'cur_mon') {
            start_date = new Date(today.getFullYear(), today.getMonth(), 1);
            end_date = new Date();
            $('#custom_time').addClass('d-none');
        } else if (opt == 'cur_yea') {
            start_date = new Date(today.getFullYear(), 0, 1);
            end_date = new Date();
            $('#custom_time').addClass('d-none');
        } else {
            $('#custom_time').removeClass('d-none');
        }
        start_date.setHours(0, 0, 0, 0);
        end_date.setHours(23, 59, 59, 999);
    }

    $(document).ready(() => {
        // analysis
        $('#custom_time .start').on('change', function(e) {
            start_date = new Date(this.value);
            if (!isNaN(start_date)) start_date.setHours(0, 0, 0, 0);
        });
        $('#custom_time .end').on('change', function(e) {
            end_date = new Date(this.value);
            if (!isNaN(end_date)) end_date.setHours(23, 59, 59, 999);
        });
        const today = new Date();
        start_date = new Date(today.getFullYear(), today.getMonth(), 1);
        end_date = new Date();
        start_date.setHours(0, 0, 0, 0);
        end_date.setHours(23, 59, 59, 999);
        get_overview();

        // chart
        $.ajax({
            url: '/manage/overview/amount_each_12_mon_over',
            method: 'GET',
            contentType: 'json',
            success: res => {
                update_chart(
                    res.data.map(e => e.month_year), 
                    res.data.map(e => e.total_cost)
                );
            },
            error: res => {
                console.log(res.responseJSON.message);
            },
            complete: () => hideLoading()
        });
    });

    function update_chart(labels, data) {
        const ctx = document.getElementById('expenseChart').getContext('2d');
        new Chart(ctx, {
            data: {
                labels: labels,
                datasets: [
                    {
                        type: 'bar', // Biểu đồ cột
                        label: 'Chi phí (triệu đồng)',
                        data: data,
                        backgroundColor: 'rgba(75, 192, 192, 0.5)', // Màu cột
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        type: 'line', // Biểu đồ đường
                        label: 'Xu hướng chi phí',
                        data: data,
                        borderColor: 'rgba(255, 99, 132, 1)', // Màu đường
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: false,
                        tension: 0.1 // Độ cong của đường
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Chi phí (triệu đồng)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tháng'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });
    }

    function get_overview() {
        showLoading();
        $.ajax({
            url: '/manage/overview/amount_by_duration',
            method: 'GET',
            data: {
                start_date: formatDate(start_date), 
                end_date: formatDate(end_date)
            },
            contentType: 'json',
            success: res => {
                $('#total').text(Number(res.data.total).toLocaleString('vn'));
                $('#paid').text(Number(res.data.paid).toLocaleString('vn'));
                $('#unpaid').text(Number(res.data.unpaid).toLocaleString('vn'));
                $('#total_change h4').text(res.data.growth_rate_total + '%');
                $('#paid_change h4').text(res.data.growth_rate_paid + '%');
                $('#unpaid_change h4').text(res.data.growth_rate_unpaid + '%');

                $('#total_change i').removeClass();
                if (res.data.growth_rate_total > 0) {
                    $('#total_change i').addClass('fa-solid fa-arrow-up text-danger fs-4 mx-1');
                } else if (res.data.growth_rate_total < 0) {
                    $('#total_change i').addClass('fa-solid fa-arrow-down text-success fs-4 mx-1');
                } else {
                    $('#total_change i').addClass('d-none');
                }

                $('#paid_change i').removeClass();
                if (res.data.growth_rate_paid > 0) {
                    $('#paid_change i').addClass('fa-solid fa-arrow-down text-success fs-4 mx-1');
                } else if (res.data.growth_rate_paid < 0) {
                    $('#paid_change i').addClass('fa-solid fa-arrow-up text-danger fs-4 mx-1');
                } else {
                    $('#paid_change i').addClass('d-none');
                }

                $('#unpaid_change i').removeClass();
                if (res.data.growth_rate_unpaid > 0) {
                    $('#unpaid_change i').addClass('fa-solid fa-arrow-up text-danger fs-4 mx-1');
                } else if (res.data.growth_rate_unpaid < 0) {
                    $('#unpaid_change i').addClass('fa-solid fa-arrow-down text-success fs-4 mx-1');
                } else {
                    $('#unpaid_change i').addClass('d-none');
                }

                $('#curTime').text(`Từ ${start_date.getMonth()+1}/${start_date.getFullYear()} đến ${end_date.getMonth()+1}/${end_date.getFullYear()}`);
            },
            error: res => {
                console.log(res.responseJSON.message);
            },
            complete: () => hideLoading()
        });
    }

    const formatDate = (date) => {
        if (!date || isNaN(date)) return '';
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    };
</script>