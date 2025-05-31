<h4>Thêm thông tin hợp đồng</h4>

<div class="d-flex mb-2">
    <a href="#" onclick="window.history.back()" class="btn border-color-1 flex-shrink-0  me-2" type="submit">
        <i class="fa-solid fa-arrow-left me-1"></i>
        Quay lại
    </a>
</div>

<div class="row g-3">
    <div class="col-12">
        <div class="card card-body">
            <h5 class="text-center mb-3 fw-bold">Thông tin cơ bản</h5>
            <form method="post" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-md-6">
                        <!-- Name -->
                        <label class="mb-1">Ngày kí</label>
                        <input name="signed_date" type="date" class="form-control">

                        <!-- Expire Date -->
                        <label class="mb-1 mt-2">Ngày hến hạn</label>
                        <input name="expire_date" type="date" class="form-control">

                        <!-- Contract File -->
                        <label class="mb-1 mt-2">File hợp đồng</label>
                        <input name="contract_file" type="file" class="form-control" accept=".pdf">
                    </div>

                    <div class="col-md-6">
                        <!-- Service -->
                        <label class="mb-1">Chọn dịch vụ</label>
                        <div id="serviceSection">
                            <div class="d-flex align-items-center mb-2">
                                <select id="serviceSelect" class="form-select me-2">
                                </select>
                                <button type="button" class="btn btn-outline-primary ms-2" onclick="addService()">Thêm</button>
                            </div>
                            <div id="addedServices" class="mt-2">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <button class="btn bg-color-1 text-white flex-shrink-0" type="submit">
                        <i class="fa-solid fa-floppy-disk me-1"></i>
                        Lưu hợp đồng
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    const services = {};
    const selectedServiceIds = [];

    $(document).ready(() => {
        // init service
        showLoading();
        const url = new URL(window.location.href);
        const params = new URLSearchParams(url.search);
        const id = params.get('id');
        $.ajax({
            url: '/manage/provider/get_services?id=' + id,
            method: 'GET',
            success: res => {
                res.data.forEach(e => {
                    services[`${e.service_id}`] = {
                        id: e.service_id,
                        name: e.name,
                        unit: e.unit,
                        price: e.provide_price,
                        currency: e.currency,
                    };
                });
                updateServiceSelect();
            },
            error: res => {
                showToast(res.responseJSON.message);
            },
            complete: () => hideLoading()
        });

        // change form action
        $('form').on('submit', function(e) {
            showLoading();
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('provider_id', id);
            selectedServiceIds.forEach((e, i) => {
                formData.append(`service_ids[${i}]`, e);
            });

            $.ajax({
                url: '/manage/provider/add_contract',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    showToast(res.message , 'success');
                    setTimeout(() => window.history.back(), 1000);
                },
                error: function(res) {
                    showToast(res.responseJSON?.message || 'Có lỗi xảy ra!', 'error');
                },
                complete: function() {
                    hideLoading();
                }
            })
        });
    });

    function updateServiceSelect() {
        $('#serviceSelect').empty();
        $('#serviceSelect').append(`
            <option value="">Chọn dịch vụ</option>
        `);
        Object.keys(services).forEach(k => {
            if (!selectedServiceIds.includes(k)) {
                $('#serviceSelect').append(`
                    <option value="${services[k].id}">${services[k].name}</option>
                `);
            };
        });
    }

    function updateSelectedServices() {
        $('#addedServices').empty();
        $('#services').empty();
        selectedServiceIds.forEach(k => {
            $('#addedServices').append(`
                <div class="d-flex justify-content-between align-items-center border p-2 mb-2 rounded">
                    <span>${services[k].name} [${services[k].price} ${services[k].currency} / ${services[k].unit}]</span>
                    <i class="fa-solid fa-xmark fs-4" onclick="removeService(${k})"></i>
                </div>
            `);
        });
    }

    function addService() {
        const id = $('#serviceSelect').val();
        if (!id) {
            showToast('Vui lòng chọn dịch vụ');
            return;
        }

        selectedServiceIds.push(id);

        updateServiceSelect();
        updateSelectedServices();
        $('#serviceSelect').val('');
        $('#servicePrice').val('');
    }

    function removeService(id) {
        selectedServiceIds.pop(id);
        updateSelectedServices();
        updateServiceSelect();
    }
</script>