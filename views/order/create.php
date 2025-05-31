<h4>Thêm hóa đơn thanh toán</h4>

<div class="d-flex mb-3">
    <a onclick="window.history.back()" class="btn border-color-1 flex-shrink-0  me-2" type="submit">
        <i class="fa-solid fa-arrow-left me-1"></i>
        Quay lại
    </a>
</div>

<form method="post">
    <div class="card card-body px-3 shadow-sm">
        <h5 class="text-center mb-3 fw-bold">Hóa đơn dịch vụ</h5>
        <div class="row g-3">
            <div class="col-6">
                <!-- Sell -->
                <label class="mb-1">Tên hóa đơn</label>
                <input id="inpName" name="name" type="text" class="form-control" value="">
                <!-- Sell -->
                <label class="mb-1 mt-2">Mô tả</label>
                <input id="inpDes" name="des" type="text" class="form-control" value="">
                <!-- Expire Date -->
                <label class="mb-1 mt-2">Hạn cung cấp</label>
                <input id="inpProvideService" name="provide_deadline" type="date" class="form-control">
                <!-- Sell -->
                <label class="mb-1 mt-2">Tên nhà cung cấp</label>
                <input id="inpProviderName" type="text" class="form-control" value="" disabled>
                <input id="inpProviderId" name="provider_id" type="hidden" value="">
                <!-- Service Type -->
                <label class="mb-1 mt-2">Tên dịch vụ</label>
                <input id="inpServiceName" type="text" class="form-control" value="" disabled>
                <input id="inpServiceId" name="service_id" type="hidden">
            </div>
            <div class="col-6">
                <!-- Price -->
                <label class="mb-1">Đơn giá</label>
                <input id="inpPrice" type="text" class="form-control" value="" disabled>
                <!-- Unit -->
                <label class="mb-1 mt-2">Đơn vị tính</label>
                <input id="inpUnit" type="text" class="form-control" value="" disabled>
                <!-- Currency -->
                <label class="mb-1 mt-2">Đơn vị tiền</label>
                <input id="inpCurrency" type="text" class="form-control" value="" disabled>
                <!-- Quantity -->
                <label class="mb-1 mt-2">Số lượng</label>
                <input id="inpQuantity" name="quantity" type="number" class="form-control" value="0" onchange="updateTotal()">
                <!-- Quantity -->
                <label class="mb-1 mt-2">VAT</label>
                <input id="inpVat" type="text" class="form-control" value="10%" disabled>
                <!-- Quantity -->
                <label class="mb-1 mt-2">Tổng tiền</label>
                <input id="inpTotal" type="text" class="form-control" value="0" disabled>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <button class="btn bg-color-1 text-white flex-shrink-0" type="submit">
                <i class="fa-solid fa-floppy-disk me-1"></i>
                Thêm mới
            </button>
        </div>
    </div>
</form>

<script>
    let price = 0;
    let currency = '';
    $(document).ready(() => {
        // get info
        const url = new URL(window.location.href);
        const params = new URLSearchParams(url.search);
        const serviceId = params.get('service_id');
        showLoading();
        $.ajax({
            url: '/manage/service/detail_data?service_id=' + serviceId,
            method: 'GET',
            success: res => {
                $('#inpProviderName').val(res.data.provider_name);
                $('#inpProviderId').val(res.data.provider_id);
                $('#inpServiceName').val(res.data.name);
                $('#inpServiceId').val(res.data.id);
                $('#inpUnit').val(res.data.unit);
                $('#inpCurrency').val(res.data.currency);
                $('#inpPrice').val(Number(res.data.price).toLocaleString('vn')); 
                price = res.data.price;
                currency = res.data.currency;
            },
            error: res => {

            },
            complete: () => hideLoading()
        })
    
        // change form action
        $('form').on('submit', function(e) {
            e.preventDefault();
            showLoading();
            const formData = new FormData(this);
            formData.append('price', price);
            formData.append('currency', currency);
            $.ajax({
                url: '/manage/order/create',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    showToast(res.message , 'success');
                    setTimeout(() => {
                        window.location.href = '/manage/order';
                    }, 1000);
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

    function updateTotal() {
        $('#inpTotal').val((price * Number($('#inpQuantity').val())).toLocaleString('vn'));
    }
</script>