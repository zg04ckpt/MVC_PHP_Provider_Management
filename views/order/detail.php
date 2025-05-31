<h4>Chi tiết hóa đơn thanh toán</h4>

<div class="d-flex mb-3">
    <a href="/manage/order" class="btn border-color-1 flex-shrink-0  me-2" type="submit">
        <i class="fa-solid fa-arrow-left me-1"></i>
        Quay lại
    </a>
    <a href="/manage/provider/detail?id=<?php echo htmlspecialchars($order['provider_id']) ?>" class="btn border-color-1 flex-shrink-0  me-2" type="submit">
        <i class="fa-solid fa-eye me-1"></i>
        Xem thông tin nhà cung cấp
    </a>
    <a href="/manage/service/detail?id=<?php echo htmlspecialchars($order['service_id']) ?>" class="btn border-color-1 flex-shrink-0  me-2" type="submit">
        <i class="fa-solid fa-eye me-1"></i>
        Xem thông tin dịch vụ
    </a>
</div>

<div class="card card-body px-3 shadow-sm">
    <h5 class="text-center mb-3 ">HÓA ĐƠN DỊCH VỤ</h5>
    <div class="row g-3">
        <div class="col-6">
            <!-- Id -->
            <div class="d-flex mb-2">
                <label class="flex-fill">Tên hóa đơn</label>
                <h6><b>#<?php echo htmlspecialchars($order['name']) ?></b></h6>
            </div>
            <!-- Id -->
            <div class="d-flex mb-2">
                <label class="flex-fill">Mã hóa đơn</label>
                <h6><b>#<?php echo htmlspecialchars($order['id']) ?></b></h6>
                <i class="fa-regular fa-copy h5 ms-2 clickable"></i>
            </div>
            <!-- Status -->
            <div class="d-flex mb-2">
                <label class="flex-fill">Trạng thái thanh toán</label>
                <h6><b><?php 
                    if ($order['status'] == 'wait') {
                        echo 'Chưa cung cấp';
                    } else if ($order['status'] == 'wait_pay') {
                        echo 'Chờ thanh toán';
                    } else {
                        echo 'Đã thanh toán';
                    }
                ?></b></h6>
            </div>
            <!-- Pay Date -->
            <div class="d-flex mb-2">
                <label class="flex-fill">Thời điểm thanh toán</label>
                <h6><b><?php echo htmlspecialchars(new DateTime($order['paid_date'])->format('H:m d/m/Y')) ?></b></h6>
            </div>
            <!-- quantity -->
            <div class="d-flex mb-2">
                <label class="flex-fill">Số lượng</label>
                <h6><b><?php echo htmlspecialchars($order['quantity']) ?></b></h6>
            </div>
            <!-- Unit -->
            <div class="d-flex mb-2">
                <label class="flex-fill">Đơn vị tính</label>
                <h6><b><?php echo htmlspecialchars($order['unit']) ?></b></h6>
            </div>
            <!-- Price -->
            <div class="d-flex mb-2">
                <label class="mb-1 flex-fill">Đơn giá</label>
                <h6><b><?php echo number_format($order['price'], 0, ',', '.') ?></b></h6>
            </div>
            <!-- TotalPrice -->
            <div class="d-flex mb-2">
                <label class="flex-fill">VAT (10%)</label>
                <h6><b>10%</b></h6>
            </div>
            <!-- TotalPrice -->
            <div class="d-flex mb-2">
                <label class="flex-fill">Tổng thanh toán</label>
                <h6><b><?php echo number_format($total, 0, ',', '.') ?></b></h6>
            </div>
            <!-- PriceUnit -->
            <div class="d-flex mb-2">
                <label class="flex-fill">Đơn vị tiền</label>
                <h6><b><?php echo htmlspecialchars($order['currency']) ?></b></h6>
            </div>
            <!-- TotalPrice -->
            <div class="d-flex mb-2">
                <label class="flex-fill">Bằng chữ</label>
                <h6 class="ms-3"><b><?php echo htmlspecialchars($total_spell) ?></b></h6>
            </div>
        </div>
        <div class="col-6">
            <!-- Seller -->
            <div class="d-flex mb-2">
                <label class="flex-fill">Đơn vị bán</label>
                <h6><b><?php echo htmlspecialchars($provider['name']) ?></b></h6>
            </div>
            <div class="d-flex mb-2">
                <label class="flex-fill">Mã số thuế</label>
                <h6><b><?php echo htmlspecialchars($provider['tax_code']) ?></b></h6>
            </div>
            <div class="d-flex mb-2">
                <label class="flex-fill">Địa chỉ</label>
                <h6><b><?php echo htmlspecialchars($provider['address']) ?></b></h6>
            </div>
            <div class="d-flex mb-2">
                <label class="flex-fill">Liên hệ</label>
                <h6><b><?php echo htmlspecialchars($provider['phone']) ?></b></h6>
            </div>
            <hr>
            <!-- Buyer -->
            <div class="d-flex mb-2">
                <label class="flex-fill">Đơn vị mua</label>
                <h6><b>Trường Đại học Thanh Hải</b></h6>
            </div>
            <div class="d-flex mb-2">
                <label class="flex-fill">Mã số thuế</label>
                <h6><b>0502345678</b></h6>
            </div>
            <div class="d-flex mb-2">
                <label class="flex-fill">Địa chỉ</label>
                <h6><b>18 Phan Đình Giót, Hà Đông, Hà Nội</b></h6>
            </div>
            <div class="d-flex mb-2">
                <label class="flex-fill">Liên hệ</label>
                <h6><b>0316666888</b></h6>
            </div>
            <hr>
            <!-- Contract Id -->
            <div class="d-flex mb-2">
                <label class="flex-fill">Hợp đồng tham chiếu</label>
                <h6><b>#CON123456</b></h6>
                <i class="fa-regular fa-copy h5 ms-2 clickable"></i>
            </div>
        </div>
    </div>
    <!-- <div class="d-flex justify-content-center mt-3">
        <button class="btn btn-outline-dark rounded-2 me-2">Đã thanh toán</button>
        <a class="btn bg-color-1 text-white flex-shrink-0" type="submit">
            <i class="fa-solid fa-download me-1"></i>
            Tải xuống
        </a>
    </div> -->
</div>