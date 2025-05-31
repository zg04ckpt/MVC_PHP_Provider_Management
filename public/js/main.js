const providersData = [
    {id: 'viettel', name: 'Tập đoàn Công nghiệp - Viễn thông Quân đội (Viettel)', desc: 'Viettel là tập đoàn viễn thông và công nghệ lớn nhất Việt Nam, thành lập năm 1989, trụ sở tại Hà Nội, thuộc Bộ Quốc phòng. Công ty cung cấp dịch vụ viễn thông, CNTT, chuyển đổi số, và hoạt động tại 11 quốc gia, phục vụ hơn 270 triệu khách hàng. Viettel có giá trị thương hiệu viễn thông cao nhất Đông Nam Á (8.9 tỷ USD).'},
    {id: 'vingroup', name: 'Công ty Cổ phần Vingroup', desc: 'Vingroup, thành lập năm 1993 bởi ông Phạm Nhật Vượng, là tập đoàn đa ngành lớn nhất Việt Nam, trụ sở tại Hà Nội. Công ty hoạt động trong bất động sản (Vinhomes, Vincom), bán lẻ (VinMart), y tế (Vinmec), giáo dục (Vinschool), du lịch (Vinpearl), và nông nghiệp (VinEco). Vingroup dẫn đầu thị trường bất động sản và bán lẻ.'},
    {id: 'fpt', name: 'Công ty Cổ phần FPT', desc: 'FPT, thành lập năm 1988, là tập đoàn công nghệ thông tin hàng đầu Việt Nam, trụ sở tại Hà Nội. Công ty cung cấp dịch vụ phần mềm, viễn thông, giáo dục, và đã mở rộng sang châu Âu, Mỹ, Úc. FPT nổi tiếng với các sản phẩm AI và chuyển đổi số.'},
    {id: 'vnpt', name: 'Tập đoàn Bưu chính Viễn thông Việt Nam (VNPT)', desc: 'VNPT là tập đoàn nhà nước trong lĩnh vực bưu chính, viễn thông và hạ tầng số, thành lập năm 2006, trụ sở tại Hà Nội. Là công ty mẹ của Vinaphone, VNPT cung cấp dịch vụ mạng di động, internet, và giải pháp CNTT, với mục tiêu trở thành trung tâm số châu Á vào 2030.'},
    {id: 'tgdd', name: 'Công ty Cổ phần Đầu tư Thế Giới Di Động', desc: 'Thành lập năm 2004, Thế Giới Di Động là nhà bán lẻ số 1 Việt Nam, trụ sở tại TP.HCM. Công ty vận hành chuỗi cửa hàng Thế Giới Di Động và Điện Máy Xanh, cung cấp điện thoại, laptop, thiết bị gia dụng, với hơn 500 siêu thị trên 63 tỉnh thành.'},
    {id: 'evn', name: 'Tập đoàn Điện lực Việt Nam (EVN)', desc: 'EVN là tập đoàn nhà nước lớn nhất trong lĩnh vực điện lực, thành lập năm 1954, trụ sở tại Hà Nội. Công ty sản xuất, truyền tải, phân phối điện năng, và quản lý các dự án điện. EVN có 3 tổng công ty phát điện và 5 tổng công ty điện lực.'},
    {id: 'petrolimex', name: 'Tập đoàn Xăng dầu Việt Nam (Petrolimex)', desc: 'Petrolimex, thành lập năm 1956, là tập đoàn nhà nước dẫn đầu thị trường xăng dầu Việt Nam, trụ sở tại Hà Nội. Công ty kinh doanh xăng dầu, lọc hóa dầu, và đầu tư đa ngành, đảm bảo cung cấp nhiên liệu phục vụ phát triển kinh tế.'},
    {id: 'vinacomin', name: 'Tập đoàn Công nghiệp Than - Khoáng sản Việt Nam (Vinacomin)', desc: 'Vinacomin, thành lập năm 2005, là tập đoàn nhà nước lớn nhất trong khai thác than, trụ sở tại Hà Nội. Công ty sở hữu 20 mỏ than hầm lò và 30 mỏ lộ thiên, với công suất 47-50 triệu tấn/năm, phục vụ năng lượng và công nghiệp.'},
    {id: 'saokim', name: 'Công ty Cổ phần Sao Kim Branding', desc: 'Sao Kim Branding, thành lập năm 2010, là công ty thiết kế logo và nhận diện thương hiệu hàng đầu, trụ sở tại Hà Nội và TP.HCM. Công ty đã phục vụ hơn 10,000 khách hàng, từ doanh nghiệp nhỏ đến tập đoàn lớn.'},
    {id: 'hawaco', name: 'Công ty TNHH Một Thành viên Nước sạch Hà Nội (Hanoi Water Limited Company)', desc: 'Hawaco là đơn vị cung cấp nước sạch lớn nhất Hà Nội, thành lập từ năm 1959 (tiền thân là Nhà máy nước Hà Nội do người Pháp xây dựng). Công ty thuộc sở hữu nhà nước, trụ sở tại 44 Đường Yên Phụ, Ba Đình, Hà Nội. Hawaco đảm nhiệm cung cấp nước sạch cho các quận nội thành (Ba Đình, Hai Bà Trưng, Đống Đa, Cầu Giấy, Tây Hồ, Bắc Từ Liêm, Long Biên) và một số khu vực ngoại thành như Thanh Trì, Hoài Đức, Thường Tín.'},
    {id: 'ssi', name: 'Công ty Cổ phần Chứng khoán SSI', desc: 'SSI, thành lập năm 1999, là công ty chứng khoán hàng đầu Việt Nam, trụ sở tại TP.HCM. Công ty cung cấp dịch vụ giao dịch chứng khoán, tư vấn đầu tư, và có đối tác lớn như Vietinbank, Vinamilk. SSI nằm trong top 50 thương hiệu giá trị nhất Việt Nam.'},
    {id: 'vndirect', name: 'Công ty Cổ phần Chứng khoán VNDIRECT', desc: 'VNDIRECT, thành lập năm 2006, là một trong bốn công ty chứng khoán lớn nhất Việt Nam, trụ sở tại Hà Nội. Công ty cung cấp nền tảng giao dịch hiện đại, phí thấp (0.15%), và dịch vụ tư vấn đầu tư, thu hút nhiều nhà đầu tư.'},
];


const showProviderDetail = (id) => {
    $('#provider-detail .name').text(providersData.find(e => e.id == id).name);
    $('#provider-detail .desc').text(providersData.find(e => e.id == id).desc);
    $('#provider-detail').removeClass('d-none');
};

const closeProviderDetail = () => {
    $('#provider-detail').addClass('d-none');
};

const scrollToBegin = () => {
    $('html, body').animate({
        scrollTop: 0
    }, 900);
}

$(document).ready(() => {
    // Scroll
    $("header a[href^='#']").on('click', function(event) {
        if (this.hash !== "") {
            event.preventDefault();
            var hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top - 60
            }, 900);
        }
    });
});

function showToast(mess, type='info', delay=2000) {
    Toastify({
        text: mess,
        className: type,
        delay: delay,
    }).showToast();

    // const toastEl = document.getElementById('mess');
    // if (toastEl) {
    //     toastEl.classList.remove('info', 'success', 'error');
    //     toastEl.classList.add(type);

    //     const toast = new bootstrap.Toast(toastEl, {
    //         delay: delay,
    //         autohide: true
    //     });
    //     $('#mess .toast-body').text(mess);
    //     toast.show();
    // }
}

function showLoading() {
    $('#loading').show()
}
function hideLoading() {
    $('#loading').hide()
}

function showConfirmModal(message, callback) {
    $('#confirmMessage').text(message);
    const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
    modal.show();
    $('#confirmButton').off('click').on('click', function() {
        callback(); // Gọi hàm callback khi xác nhận
        modal.hide();
    });
}

function uploadFile(fileInputId, imgTagId) {
    $(`#${fileInputId}`).on('change', e => {
        const file = e.target.files[0];
        const fileReader = new FileReader();
        fileReader.onload = rr => $(`#${imgTagId}`).attr('src', rr.target.result);
        fileReader.readAsDataURL(file);
    })
    $(`#${fileInputId}`).click();
}

