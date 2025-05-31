<h4>Tạo mới nhà cung cấp</h4>

<div class="d-flex mb-2">
    <a href="/manage/provider" class="btn border-color-1 flex-shrink-0  me-2" onclick="window.history.back()">
        <i class="fa-solid fa-arrow-left me-1"></i>
        Quay lại
    </a>
</div>

<form method="POST" action="<?php echo htmlspecialchars('/manage/provider/create') ?>" enctype="multipart/form-data">
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card card-body">
                <div class="d-flex flex-column align-items-center">
                    <h6>Ảnh đại diện</h6>
                    <img id="imgLogo" src="/public/images/default.jpg" alt="" 
                        class="object-fit-cover border-danger border-3 rounded-1" width="200" height="200">
                    <input id="inplogo" name="logo" type="file" hidden accept=".PNG, .JPG"/>
                    <a class="btn btn-outline-dark mt-3" onclick="uploadFile('inplogo','imgLogo')">
                        Thay đổi ảnh
                    </a>
                </div>
            </div>
        </div>
    
        <div class="col-md-9">
            <div class="card card-body">
                <div class="d-flex flex-column align-items-center">
                    <h6>Ảnh bìa</h6>
                    <img id="imgBanner" src="/public/images/default.jpg" alt="" 
                        class="object-fit-cover border-danger border-3 rounded-1 w-100" height="200">
                    <input id="inpBanner" name="banner" type="file" hidden accept=".PNG, .JPG"/>
                    <a class="btn btn-outline-dark mt-3" onclick="uploadFile('inpBanner','imgBanner')">Thay đổi ảnh</a>
                </div>
            </div>
        </div>
    
        <div class="col-12">
            <div class="card card-body">
                <h5 class="text-center mb-3 fw-bold">Thông tin cơ bản</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <!-- Name -->
                        <label for="inpName" class="mb-1">Tên nhà cung cấp</label>
                        <input id="inpName" name="name" type="text" class="form-control" placeholder="Nhập tên của nhà cung cấp">
                    
                        <!-- Tài khoản -->
                        <label class="mb-1 mt-2">Số tài khoản ngân hàng</label>
                        <input id="inpAccNum" name="pay_account_number" type="text" class="form-control" placeholder="Nhập số tài khoản ngân hàng">

                        <!-- Tax code -->
                        <label class="mb-1 mt-2">Mã số thuế</label>
                        <input id="inpTax" name="tax_code" type="text" class="form-control" placeholder="Nhập mã số thuế">
                        
                        <!-- Address -->
                        <label class="mb-1 mt-2">Địa chỉ</label>
                        <input id="inpAddress" name="address" type="text" class="form-control" placeholder="Nhập địa chỉ">
                    
                        <!-- Service -->
                        <div id="serviceSection">
                            <label class="mb-1 mt-2 w-100">Dịch vụ cung cấp</label>
                            <div class="d-flex align-items-center mb-2">
                                <select id="serviceSelect" class="form-select me-2">
                                    
                                </select>
                                <input type="number" id="servicePrice" class="form-control w-50" placeholder="Nhập giá" min="0">
                                <button type="button" class="btn btn-outline-primary ms-2" onclick="addService()">Thêm</button>
                            </div>
                            <div id="addedServices" class="mt-2">
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Desc -->
                        <label class="mb-1">Mô tả</label>
                        <textarea name="des" class="form-control" placeholder="Nhập mô tả"></textarea>

                        <!-- Contact -->
                        <label class="mb-1 mt-2">Liên hệ</label>
                        <input name="phone" type="number" class="form-control" placeholder="Nhập số điện thoại liên hệ">

                        <!-- Email -->
                        <label class="mb-1 mt-2">Email</label>
                        <input name="email" type="email" class="form-control" placeholder="Nhập email">
                        
                        <!-- Website -->
                        <label class="mb-1 mt-2">Website</label>
                        <input name="website_url" type="text" class="form-control" placeholder="Nhập đường dẫn trang chủ">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="services"></div>
    <div class="d-flex justify-content-center mt-3">
        <button class="btn bg-color-1 text-white flex-shrink-0" type="submit">
            <i class="fa-solid fa-floppy-disk me-1"></i>
            Tạo mới
        </button>
    </div>
</form>

<script>
    const services = {};
    const selectedServices = {};

    $(document).ready(() => {
        // init service
        showLoading();
        $.ajax({
            url: '/manage/service/list?page=1&size=100',
            method: 'GET',
            success: res => {
                res.data.items.forEach(e => {
                    services[`${e.id}`] = {
                        id: e.id,
                        name: e.name,
                        unit: e.unit
                    };
                });
                updateServiceSelect();
            },
            error: res => {
                showToast(res.responseJSON.message);
            },
            complete: () => hideLoading()
        });

        // Xử lý gửi form qua AJAX
        $('form').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            formData.append('services', JSON.stringify(Object.values(selectedServices)));

            showLoading();
            $.ajax({
                url: '/manage/provider/create',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    showToast(res.message , 'success');
                    window.location.href = '/manage/provider';
                },
                error: function(res) {
                    showToast(res.responseJSON?.message || 'Có lỗi xảy ra!', 'error');
                },
                complete: function() {
                    hideLoading();
                }
            });
        });
    });

    function createNewProvider() {
        const data = {
            name: $('#inpName'),
            name: $('#inpAccNum'),
            name: $('#inpTax'),
            name: $('#inpAddress'),
            services: Object.values(selectedServices),
            des: $('#inpDesc'),
            des: $('#inpContact'),
            des: $('#inpEmail'),
            des: $('#inpWebUrl'),
        };
    }

    function updateServiceSelect() {
        $('#serviceSelect').empty();
        $('#serviceSelect').append(`
            <option value="">Chọn dịch vụ</option>
        `);
        Object.keys(services).forEach(k => {
            if (!(k in selectedServices)) {
                $('#serviceSelect').append(`
                    <option value="${services[k].id}">${services[k].name}</option>
                `);
            };
        });
    }

    function updateSelectedServices() {
        $('#addedServices').empty();
        $('#services').empty();
        Object.keys(selectedServices).forEach((k, i) => {
            $('#addedServices').append(`
                <div class="d-flex justify-content-between align-items-center border p-2 mb-2 rounded">
                    <span>${services[k].name} [${selectedServices[k].provide_price} ${selectedServices[k].currency} / ${services[k].unit}]</span>
                    <i class="fa-solid fa-xmark fs-4" onclick="removeService(${k})"></i>
                </div>
            `);
            $('#services').append(`
                <input type="hidden" name="services[${i}].id" value="${k}">
                <input type="hidden" name="services[${i}].provide_price" value="${selectedServices[k].provide_price}">
                <input type="hidden" name="services[${i}].currency" value="${selectedServices[k].currency}">
            `);
        });
    }

    function addService() {
        const id = $('#serviceSelect').val();
        const price = $('#servicePrice').val();

        if (!id || !price) {
            showToast('Vui lòng chọn dịch vụ và nhập giá');
            return;
        }

        selectedServices[id] = {
            id: id,
            provide_price: price,
            currency: 'VNĐ'
        }
        updateServiceSelect();
        updateSelectedServices();
        $('#serviceSelect').val('');
        $('#servicePrice').val('');
    }

    function removeService(id) {
        console.log(selectedServices);
        delete selectedServices[id];
        console.log(selectedServices);
        updateSelectedServices();
        updateServiceSelect();
    }
</script>