
<div class="position-relative">
    <img src="<?php echo htmlspecialchars($provider['banner_url'] ?? '', ENT_QUOTES, 'UTF-8') ?>" height="300" alt="Banner" style="width: 100%; object-fit: cover;">
    <!-- Các nút -->
    <div class="d-flex position-absolute start-0 bottom-0 mb-2 ms-2" style="z-index: 2;">
        <a href="/manage/provider" class="btn border-color-1 bg-white shadow-sm flex-shrink-0 me-2">
            <i class="fa-solid fa-arrow-left me-1"></i>
            Quay lại
        </a>
        <a href="/manage/provider/update?id=<?php echo htmlspecialchars($provider['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>" class="btn border-color-1 bg-white shadow-sm flex-shrink-0 me-2">
            <i class="fa-solid fa-file-pen me-1"></i>
            Cập nhật thông tin
        </a>
        <!-- <a href="#" class="btn border-color-1 bg-white shadow-sm flex-shrink-0 me-2">
            <i class="fa-solid fa-chart-simple me-1"></i>
            So sánh
        </a>
        <a href="#" class="btn border-color-1 bg-white shadow-sm flex-shrink-0 me-2">
            <i class="fa-solid fa-eye me-1"></i>
            Xem hóa đơn thanh toán
        </a> -->
        <a href="/manage/provider/add_contract?id=<?php echo htmlspecialchars($provider['id'])?> " class="btn border-color-1 bg-white shadow-sm flex-shrink-0 me-2">
            <i class="fa-solid fa-plus me-1"></i>
            Thêm hợp đồng
        </a>
    </div>
</div>

<!-- Content -->
<div class="row g-3 mt-1">
    <div class="col-md-6">
        <div class="card card-body border-color-3 shadow-sm p-0 overflow-hidden">
            <h6 class="text-center bg-color-3 mb-0 py-2 text-white">Thông tin cơ bản</h6>
            <div class="p-3">
                <!-- Name -->
                <div class="d-flex my-1">
                    <i class="fa-solid fa-house me-2 h6 text-secondary"></i>
                    <h6 class="flex-fill flex-shrink-0 text-secondary">Tên </h6>
                    <h6><b class=""><?php echo $provider['name'] ?></b></h6>
                </div>
                <!-- ID -->
                <div class="d-flex align-items-center my-1">
                    <i class="fa-solid fa-circle-info text-secondary h6 me-2"></i>
                    <h6 class="flex-fill text-secondary">Mã định danh</h6>
                    <h6><b>#<?php echo $provider['id'] ?></b></h6>
                    <i class="fa-regular fa-copy h4 ms-2 clickable"></i>
                </div>
                <!-- Email -->
                <div class="d-flex align-items-center my-1">
                    <i class="fa-solid fa-coins text-secondary h6 me-2"></i>
                    <h6 class="flex-fill text-secondary">Mã số thuế</h6>
                    <h6><b><?php echo $provider['tax_code'] ?></b></h6>
                </div>
                <!-- Status -->
                <div class="d-flex align-items-center my-1">
                    <i class="fa-solid fa-power-off text-secondary h6 me-2"></i>
                    <h6 class="flex-fill text-secondary">Trạng thái</h6>
                    <h6><b class="fst-italic">
                        <?php echo ($provider['status'] == ProviderStatus::Active? 'Đang hợp tác':'Chưa / Ngừng hợp tác') ?>
                    </b></h6>
                </div>
                <!-- Address -->
                <div class="d-flex my-1">
                    <i class="fa-solid fa-location-dot me-1 px-1 h6 text-secondary"></i>
                    <h6 class="flex-fill text-secondary">Địa chỉ</h6>
                    <h6><b><?php echo $provider['address'] ?></b></h6>
                </div>
                <!-- Contact -->
                <div class="d-flex align-items-center my-1">
                    <i class="fa-solid fa-phone h6 me-2 text-secondary"></i>
                    <h6 class="flex-fill text-secondary" >Liên hệ</h6>
                    <h6><b><?php echo $provider['phone'] ?></b></h6>
                </div>
                <!-- Email -->
                <div class="d-flex align-items-center my-1">
                    <i class="fa-solid fa-envelope h6 text-secondary me-2"></i>
                    <h6 class="flex-fill text-secondary">Email</h6>
                    <h6><b><?php echo $provider['email'] ?></b></h6>
                </div>
                <!-- Website -->
                <div class="d-flex align-items-center my-1">
                    <i class="fa-solid fa-globe h6 text-secondary me-2"></i>
                    <h6 class="flex-fill text-secondary">Website</h6>
                    <h6><b><a href="<?php echo $provider['website_url'] ?>">Xem</a></b></h6>
                </div>
                <!-- Serivces -->
                <div class="d-flex align-items-center my-1">
                    <i class="fa-solid fa-layer-group text-secondary h6 me-2"></i>
                    <h6 class="flex-fill text-secondary">Các dịch vụ cung cấp</h6>
                </div>
                <?php
                    if (!empty($services)) {
                        foreach ($services as $s) {
                            $id = htmlspecialchars($s['service_id'] ?? '', ENT_QUOTES, 'UTF-8');
                            $name = htmlspecialchars($s['name'] ?? '', ENT_QUOTES, 'UTF-8');
                            ?>
                            <div class="d-flex align-items-center my-1">
                                <i class="fa-regular fa-copy h5 me-2 clickable"></i>
                                <h6 class="text-secondary">#<?php echo $id; ?></h6>
                                <div class="flex-fill"></div>
                                <h6><b><?php echo $name; ?></b></h6>
                            </div>  
                            <?php
                        }
                    } else {
                        echo '<p>Không có dịch vụ nào được cung cấp.</p>';
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-bod shadow-sm mb-3 p-0 overflow-hidden bg-secondary">
            <div class="d-flex justify-content-center">
                <img src="<?php echo $provider['logo_url'] ?>" alt="" 
                    class="object-fit-cover shadow-sm border-black" width="200" height="200">
            </div>
        </div>
        <div id="contract">
            
        </div>
    </div>
</div>

<script>
    $(document).ready(() => {
        const url = new URL(window.location.href);
        const params = new URLSearchParams(url.search);
        const id = params.get('id');
        $.ajax({
            url: '/manage/provider/get_contract?id=' + id,
            method: 'GET',
            success: res => {
                $('#contract').append(`
                    <!-- Contract -->
                    <div class="card card-bod shadow-sm mt-3 mb-3 pb-2 p-0 overflow-hidden px-3">
                        <h6 class="text-center py-2 mb-0">THÔNG TIN HỢP ĐỒNG</h6>
                        <!-- ID -->
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-circle-info text-secondary h6 me-2"></i>
                            <h6 class="flex-fill text-secondary">Mã hợp đồng</h6>
                            <h6><b>#${res.data.id}</b></h6>
                            <i class="fa-regular fa-copy h4 ms-2 clickable"></i>
                        </div>
                        <!-- SignedDate -->
                        <div class="d-flex align-items-center my-1">
                            <i class="fa-solid fa-calendar text-secondary h6 me-2"></i>
                            <h6 class="flex-fill text-secondary">Ngày kí</h6>
                            <h6><b>${res.data.signed_date}</b></h6>
                        </div>
                        <!-- ExpireDate -->
                        <div class="d-flex align-items-center my-1">
                            <i class="fa-solid fa-calendar text-secondary h6 me-2"></i>
                            <h6 class="flex-fill text-secondary">Ngày hết hạn</h6>
                            <h6><b>${res.data.expire_date}</b></h6>
                        </div>
                        <!-- ExpireDate -->
                        <div class="d-flex align-items-center my-1">
                            <i class="fa-solid fa-calendar text-secondary h6 me-2"></i>
                            <h6 class="flex-fill text-secondary">Số lượng dịch vụ</h6>
                            <h6><b>${res.data.services_count}</b></h6>
                        </div>
                        <div class="d-flex justify-content-center mb-2">
                            <button class="btn btn-outline-dark rounded-0 me-2" onclick="window.open('${res.data.contract_url}', '_blank');">Xem chi file hợp đồng</button>
                            <button class="btn btn-outline-dark rounded-0 me-2" onclick=(cancelContract(${res.data.id}));">Hủy hợp đồng</button>
                            <a href='${res.data.contract_url}' download class="btn btn-outline-dark rounded-0">Tải xuống hợp đồng</a>
                        </div>
                    </div>
                `);
            },
            error: res => {
                showToast(res.responseJSON.message);
            },
            complete: () => hideLoading()
        });
    });

    function cancelContract(id) {
        showConfirmModal("Xác nhận hủy hợp đồng?", () => {
            showLoading();
            $.ajax({
                url: '/manage/provider/cancel_contract?id=' + id,
                method: 'DELETE',
                dataType: 'json',
                success: res => {
                    window.location.href = `/manage/service?message=${res.message}&message_type=success`;
                },
                error: res => {
                    showToast(res.responseJSON.message, 'error');
                },
                complete: () => hideLoading()
            });
        });
    }
</script>
