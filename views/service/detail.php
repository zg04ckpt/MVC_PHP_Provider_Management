<h4>Thông tin chi tiết về dịch vụ</h4>

<div class="d-flex mb-2">
    <a href="/manage/service" class="btn border-color-1 flex-shrink-0  me-2" type="submit">
        <i class="fa-solid fa-arrow-left me-1"></i>
        Quay lại
    </a>
    <a onclick="deleteService()" class="btn border-color-1 flex-shrink-0  me-2" type="submit">
        <i class="fa-solid fa-trash me-1"></i>
        Xóa dịch vụ
    </a>
    <?php if ($status == 'unsigned'): ?>
        <a href="/manage/provider/top_provider?service_id=<?php echo htmlspecialchars($id) ?>" class="btn border-color-1 flex-shrink-0  me-2" type="submit">
            <i class="fas fa-search me-1"></i>
            Gợi ý tìm nhà cung cấp
        </a>
    <?php endif?>
    <?php if ($status == 'signed'): ?>
        <a href="/manage/provider/detail?id=<?php echo htmlspecialchars($id) ?>" class="btn border-color-1 flex-shrink-0  me-2" type="submit">
            <i class="fa-solid fa-eye me-1"></i>
            Xem nhà cung cấp
        </a>
        <a href="/manage/order/create?service_id=<?php echo htmlspecialchars($id) ?>" class="btn border-color-1 flex-shrink-0  me-2" type="submit">
            <i class="fa-solid fa-plus me-1"></i>
            Thêm đơn hàng dịch vụ
        </a>
    <?php endif?>
    
    <!-- <a href="service.html" class="btn border-color-1 flex-shrink-0  me-2" type="submit">
        <i class="fa-solid fa-eye me-1"></i>
        Xem lịch sử thanh toán
    </a> -->
    <!-- <a href="service.html" class="btn border-color-1 flex-shrink-0  me-2" type="submit">
        <i class="fa-solid fa-chart-simple me-1"></i>
        Thống kê dịch vụ
    </a> -->
</div>

<div class="card card-body">
    <h5 class="text-center mb-3 fw-bold">Thông tin cơ bản</h5>

    <form action="" method="post">
        <div class="row g-3">

            <div class="col-md-4">
                <div class="d-flex mb-2">
                    <div>Mã dịch vụ</div>
                    <div class="flex-fill"></div>
                    <b><?php echo $id ?></b>
                    <i class="fa-regular fa-copy ms-1 h5 clickable"></i>
                </div>
                <div class="d-flex mb-2">
                    <div>Tạo mới</div>
                    <div class="flex-fill"></div>
                    <b><?php echo $created_date->format('H:m:s d/m/Y') ?></b>
                </div>
                <div class="d-flex mb-2">
                    <div>Cập nhật</div>
                    <div class="flex-fill"></div>
                    <b><?php echo $updated_date->format('H:m:s d/m/Y') ?></b>
                </div>
                <div class="d-flex mb-2">
                    <div>Trạng thái</div>
                    <div class="flex-fill"></div>
                    <b><?php echo ($status == 'signed'? 'Đang kí hợp đồng':'Chưa kí hợp đồng') ?></b>
                </div>
                <div class="d-flex mb-2">
                    <div>Nhà cung cấp</div>
                    <div class="flex-fill"></div>
                    <b><?php echo $provider_name ?? '--' ?></b>
                </div>
                <div class="d-flex mb-2">
                    <div>Mã nhà cung cấp</div>
                    <div class="flex-fill"></div>
                    <b><?php echo $provider_id ?? '--' ?></b>
                </div>
                <div class="d-flex mb-2">
                    <div>Giá cung cấp</div>
                    <div class="flex-fill"></div>
                    <b><?php echo $price ?? '--' ?></b>
                </div>
            </div>

            <div class="col-md-8">
                <!-- Name -->
                <label for="inpName" class="mb-1">Tên</label>
                <input id="inpName" name="name" value="<?php echo $name ?>" type="text" class="form-control" placeholder="Nhập tên của dịch vụ">
                
                <label for="inpDesc" class="mb-1 mt-2">Mô tả</label>
                <textarea id="inpDesc" name="desc" class="form-control text-start" placeholder="Nhập tên của dịch vụ"><?php echo $desc ?></textarea>
                
                <label class="mb-1 mt-2">Đơn vị chi phí</label>
                <input id="inpUnit" value="<?php echo $unit ?>" type="text" class="form-control" placeholder="Nhập tên của dịch vụ">
                
                <div class="d-flex justify-content-center mt-3">
                    <a class="btn bg-color-1 text-white flex-shrink-0" onclick="updateService()">
                        <i class="fa-solid fa-floppy-disk me-1"></i>
                        Lưu thay đổi
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function deleteService() {
        showConfirmModal("Xác nhận xóa dịch vụ này?", () => {
            showLoading();
            const url = new URL(window.location.href);
            const params = new URLSearchParams(url.search);
            const serviceId = params.get('id');
            $.ajax({
                url: '/manage/service/delete?id=' + serviceId,
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

    let backup = {
        'name': '<?php echo $name ?>',
        'desc': '<?php echo $desc ?>',
        'unit': '<?php echo $unit ?>',
    }
    console.log(backup);
    
    function updateService() {
        showConfirmModal("Xác nhận cập nhật dịch vụ này?", () => {
            showLoading();
            const url = new URL(window.location.href);
            const params = new URLSearchParams(url.search);
            const serviceId = params.get('id');
            $.ajax({
                url: '/manage/service/update?id=' + serviceId,
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    'name': $('#inpName').val(),
                    'desc': $('#inpDesc').val(),
                    'unit': $('#inpUnit').val(),
                }),
                success: res => {
                    showToast(res.message, 'success');
                    backup = {
                        'name': $('#inpName').val(),
                        'desc': $('#inpDesc').text(),
                        'unit': $('#inpUnit').val(),
                    }
                },
                error: res => {
                    showToast(res.responseJSON.message, 'error');
                    $('#inpName').val(backup['name']);
                    $('#inpDesc').val(backup['desc']);
                    $('#inpUnit').val(backup['unit']);
                },
                complete: () => hideLoading()
            });
        });
    }
</script>