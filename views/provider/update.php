<h4>Cập nhật nhà cung cấp</h4>

<div class="d-flex mb-2">
    <a href="#" onclick="window.history.back()" class="btn border-color-1 flex-shrink-0 me-2" onclick="window.history.back()">
        <i class="fa-solid fa-arrow-left me-1"></i>
        Quay lại
    </a>
    <a onclick="deleteProvider()" class="btn border-color-1 flex-shrink-0  me-2" type="submit">
        <i class="fa-solid fa-trash me-1"></i>
        Xóa nhà cung cấp
    </a>
</div>

<form id="providerForm" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($provider['id']); ?>">
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card card-body">
                <div class="d-flex flex-column align-items-center">
                    <h6>Ảnh đại diện</h6>
                    <img id="imgLogo" src="<?php echo htmlspecialchars($provider['logo_url'] ?? '/public/images/default.jpg'); ?>" alt="" 
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
                    <img id="imgBanner" src="<?php echo htmlspecialchars(string: $provider['banner_url'] ?? '/public/images/default.jpg'); ?>" alt="" 
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
                        <input id="inpName" name="name" type="text" class="form-control" placeholder="Nhập tên của dịch vụ"
                            value="<?php echo htmlspecialchars($provider['name']); ?>">
                    
                        <!-- Tài khoản -->
                        <label class="mb-1 mt-2">Số tài khoản ngân hàng</label>
                        <input id="inpAccNum" name="pay_account_number" type="text" class="form-control" placeholder="Nhập số tài khoản ngân hàng"
                            value="<?php echo htmlspecialchars($provider['pay_account_number']); ?>">

                        <!-- Tax code -->
                        <label class="mb-1 mt-2">Mã số thuế</label>
                        <input id="inpTax" name="tax_code" type="text" class="form-control" placeholder="Nhập mã số thuế"
                            value="<?php echo htmlspecialchars($provider['tax_code']); ?>">
                        
                        <!-- Address -->
                        <label class="mb-1 mt-2">Địa chỉ</label>
                        <input id="inpAddress" name="address" type="text" class="form-control" placeholder="Nhập địa chỉ"
                            value="<?php echo htmlspecialchars($provider['address']); ?>">
                    
                        <!-- Service -->
                        <div id="serviceSection">
                            <label class="mb-1 mt-2 w-100">Dịch vụ cung cấp</label>
                            <div class="d-flex align-items-center mb-2">
                                <select id="serviceSelect" class="form-select me-2"></select>
                                <input type="number" id="servicePrice" class="form-control w-50" placeholder="Nhập giá" min="0">
                                <button type="button" class="btn btn-outline-primary ms-2" onclick="addService()">Thêm</button>
                            </div>
                            <div id="addedServices" class="mt-2"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Desc -->
                        <label class="mb-1">Mô tả</label>
                        <textarea name="des" class="form-control" placeholder="Nhập mô tả"><?php echo htmlspecialchars($provider['des']); ?></textarea>

                        <!-- Contact -->
                        <label class="mb-1 mt-2">Liên hệ</label>
                        <input name="phone" type="number" class="form-control" placeholder="Nhập số điện thoại liên hệ"
                            value="<?php echo htmlspecialchars($provider['phone']); ?>">

                        <!-- Email -->
                        <label class="mb-1 mt-2">Email</label>
                        <input name="email" type="email" class="form-control" placeholder="Nhập email"
                            value="<?php echo htmlspecialchars($provider['email']); ?>">
                        
                        <!-- Website -->
                        <label class="mb-1 mt-2">Website</label>
                        <input name="website_url" type="text" class="form-control" placeholder="Nhập đường dẫn trang chủ"
                            value="<?php echo htmlspecialchars($provider['website_url']); ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="services"></div>
    <div class="d-flex justify-content-center mt-3">
        <button class="btn bg-color-1 text-white flex-shrink-0" type="submit">
            <i class="fa-solid fa-floppy-disk me-1"></i>
            Cập nhật
        </button>
    </div>
</form>

<script>
    const services = {};
    const selectedServices = {};

    $(document).ready(() => {
        // Lấy danh sách dịch vụ
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

                // Load danh sách dịch vụ hiện tại của nhà cung cấp
                const providerServices = <?php echo json_encode($services); ?>;
                console.log(providerServices);
                providerServices.forEach(s => {
                    selectedServices[s.service_id] = {
                        id: s.service_id,
                        provide_price: s.provide_price,
                        currency: s.currency
                    };
                });
                updateServiceSelect();
                updateSelectedServices();
            },
            error: res => {
                showToast(res.responseJSON.message);
            },
            complete: () => hideLoading()
        });

        

        // Xử lý gửi form
        $('#providerForm').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            formData.append('services', JSON.stringify(Object.values(selectedServices)));

            showLoading();
            $.ajax({
                url: '/manage/provider/update/<?php echo $provider['id']; ?>',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    showToast(res.message || 'Cập nhật nhà cung cấp thành công!', 'success');
                    setTimeout(() => {
                        window.location.href = '/manage/provider';
                    }, 2000);
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

    function deleteProvider() {
        showConfirmModal("Xác nhận xóa nhà cung cấp này?", () => {
            showLoading();
            const url = new URL(window.location.href);
            const params = new URLSearchParams(url.search);
            const id = params.get('id');
            $.ajax({
                url: '/manage/provider/delete?id=' + id,
                method: 'DELETE',
                dataType: 'json',
                success: res => {
                    window.location.href = `/manage/provider?message=${res.message}&message_type=success`;
                },
                error: res => {
                    showToast(res.responseJSON.message, 'error');
                },
                complete: () => hideLoading()
            });
        });
    }

    function updateServiceSelect() {
        $('#serviceSelect').empty();
        $('#serviceSelect').append(`<option value="">Chọn dịch vụ</option>`);
        Object.keys(services).forEach(k => {
            if (!(k in selectedServices)) {
                $('#serviceSelect').append(`<option value="${services[k].id}">${services[k].name}</option>`);
            }
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
        };
        updateServiceSelect();
        updateSelectedServices();
        $('#serviceSelect').val('');
        $('#servicePrice').val('');
    }

    function removeService(id) {
        delete selectedServices[id];
        updateSelectedServices();
        updateServiceSelect();
    }

    function uploadFile(inputId, imgId) {
        const input = document.getElementById(inputId);
        const img = document.getElementById(imgId);

        input.click();
        input.onchange = function() {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        };
    }
</script>