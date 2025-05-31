<h4 class="text-center mb-4">KẾT QUẢ GỢI Ý NHÀ CUNG CẤP</h4>

<div class="d-flex justify-content-start mb-4">
    <a href="/manage/service" class="btn btn-outline-primary flex-shrink-0">
        <i class="fa-solid fa-arrow-left me-2"></i>Quay lại
    </a>
</div>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <h5 class="text-center mb-4 fw-bold">Thông tin dịch vụ</h5>
                <div class="d-flex justify-content-between mb-3">
                    <span>Tên dịch vụ</span>
                    <b><?php echo htmlspecialchars($name); ?></b>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Mã dịch vụ</span>
                    <div>
                        <b><?php echo htmlspecialchars($id); ?></b>
                        <i class="fa-regular fa-copy ms-2 clickable" onclick="navigator.clipboard.writeText('<?php echo htmlspecialchars($id); ?>')"></i>
                    </div>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Mô tả</span>
                    <b><?php echo htmlspecialchars($desc); ?></b>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Trạng thái</span>
                    <b><?php echo ($status == 'signed' ? 'Đang kí hợp đồng' : 'Chưa kí hợp đồng'); ?></b>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Đơn vị tính</span>
                    <b><?php echo htmlspecialchars($unit); ?></b>
                </div>
            </div>
        </div>
    </div>

    <h4 class="text-center my-4 fw-bold">Nhà cung cấp tốt nhất</h4>
    <div id="list" class="row justify-content-center g-4">
        
    </div>
</div>

<script>
$(document).ready(() => {
    const serviceId = '<?php echo htmlspecialchars($id); ?>';
    $.ajax({
        url: `/manage/provider/get_top_3_data/?service_id=${serviceId}`,
        method: 'GET',
        success: response => {
            const list = $('#list');
            list.empty();

            response.data.forEach((supplier, index) => {
                const rank = index + 1;
                const rankClass = `rank-${rank}`;
                list.append(`
                    <div class="col-md-4">
                        <div class="card shadow-sm position-relative">
                            <div class="rank-badge ${rankClass}">${rank}</div>
                            <div class="card-body provider-info px-3">
                                <div class="d-flex justify-content-center mt-4">
                                    <img src="${supplier.logo_url}" width="150" height="150"/>
                                </div>
                                <h6 class="card-title fw-bold text-center">${supplier.provider_name}</h6>
                                <div class="d-flex mb-2">
                                    <div>Giá trung bình</div>
                                    <div class="flex-fill"></div>
                                    <b>${parseInt(supplier.avg_price).toLocaleString()}</b>
                                </div>
                                <div class="d-flex mb-2">
                                    <div>Độ uy tín</div>
                                    <div class="flex-fill"></div>
                                    <b>${(supplier.reliability_score * 100).toFixed(1)}%</b>
                                </div>
                                <div class="d-flex mb-2">
                                    <div>Đơn trễ</div>
                                    <div class="flex-fill"></div>
                                    <b>${supplier.late_orders}</b>
                                </div>
                                <div class="d-flex mb-2">
                                    <div>Kinh nghiệm hợp tác</div>
                                    <div class="flex-fill"></div>
                                    <b>${supplier.partnership_months} tháng</b>
                                </div>
                                <div class="d-flex mb-2">
                                    <div>Tổng chi phí</div>
                                    <div class="flex-fill"></div>
                                    <b>${parseInt(supplier.total_exchange_cost).toLocaleString()}</b>
                                </div>
                                <div class="d-flex mb-2">
                                    <div>Tổng giao dịch</div>
                                    <div class="flex-fill"></div>
                                    <b>${supplier.transaction_count}</b>
                                </div>
                                <div class="d-flex mb-2">
                                    <div>Điểm đánh giá</div>
                                    <div class="flex-fill"></div>
                                    <b>${parseFloat(supplier.score).toFixed(2)}</b>
                                </div>
                                
                                <div class="d-flex justify-content-center mt-4">
                                    <a href="/manage/provider/detail?id=${supplier.provider_id}" class="btn btn-outline-primary">
                                        <i class="fa-solid fa-eye me-2"></i>Xem thông tin
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
            });

            $('html, body').animate({ scrollTop: 0 }, 'smooth');
        },
        error: function() {
            $('#list').html('<div class="col-12 text-center text-danger">Lỗi khi lấy dữ liệu nhà cung cấp!</div>');
        }
    });

    $(document).on('click', '.btn-test-payout', function() {
        const providerId = $(this).data('provider-id');
        const bankAccount = $(this).data('bank-account');
        alert(`Chuyển hướng đến VNPay Sandbox để thử thanh toán cho nhà cung cấp ID: ${providerId}, tài khoản: ${bankAccount || 'N/A'}`);
        window.open('https://sandbox.vnpay.vn/merchant', '_blank');
    });
});
</script>

<style>

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    img {
        border-radius: 50%;
        object-fit: cover;
    }

    .rank-badge {
        position: absolute;
        top: -15px;
        left: -15px;
        width: 60px;
        height: 60px;
        line-height: 40px;
        text-align: center;
        border-radius: 50%;
        color: white;
        font-weight: bold;
        font-size: 32px;
        align-items: center;
        align-content: center;
    }

    .rank-1 {
        background-color: #ffd700; /* Vàng */
    }

    .rank-2 {
        background-color: #c0c0c0; /* Bạc */
    }

    .rank-3 {
        background-color: #cd7f32; /* Đồng */
    }
</style>
