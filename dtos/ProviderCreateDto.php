<?php 

require_once 'BaseDto.php';

class ProviderCreateDto extends BaseDto {
    public $name;
    public $logo;
    public $banner;
    public $tax_code;
    public $des;
    public $email;
    public $address;
    public $phone;
    public $website_url;
    public $pay_account_number;
    public array $services = [];

    public function __construct(array $data, array $files) {
        $this->name = $this->validateRequired($data, 'name', 'Tên nhà cung cấp');
        $this->tax_code = $this->validateRequired($data, 'tax_code', 'Mã số thuế');
        $this->des = $this->validateRequired($data, 'des', 'Mô tả');
        $this->email = $this->validateRequired($data, 'email', 'Email');
        $this->address = $this->validateRequired($data, 'address', 'Địa chỉ');
        $this->phone = $this->validateRequired($data, 'phone', 'Số liên hệ');
        $this->website_url = $this->validateRequired($data, 'website_url', 'Đường dẫn website');
        $this->pay_account_number = $this->validateRequired($data, 'pay_account_number', 'Số tài khoản');

        $this->logo = $this->validateFileUpload($files, 'logo', 'Ảnh đại diện');
        $this->banner = $this->validateFileUpload($files, 'banner', 'Ảnh bìa');

        // $this->name = $data['name'] ?? throw new Exception("Vui lòng điền tên.");
        // $this->logo = $files['logo'] ?? throw new Exception("Thiếu file logo.");
        // $this->banner = $files['banner'] ?? throw new Exception("Thiếu file banner.");
        // $this->tax_code = $data['tax_code'] ?? throw new Exception("Thiếu mã số thuế.");
        // $this->des = $data['des'] ?? throw new Exception("Thiếu mô tả.");
        // $this->email = $data['email'] ?? throw new Exception("Thiếu email.");
        // $this->email = $data['address'] ?? throw new Exception("Thiếu địa chỉ.");
        // $this->phone = $data['phone'] ?? throw new Exception("Thiếu số liên hệ.");
        // $this->website_url = $data['website_url'] ?? throw new Exception("Thiếu đường dẫn website.");
        // $this->pay_account_number = $data['pay_account_number'] ?? throw new Exception("Thiếu số tài khoản.");
        
        $data['services'] = json_decode($data['services'], true);
        foreach ($data['services'] as $s) {
            $this->services[] = new ProvideServiceDto($s);
        }
    }
}

class ProvideServiceDto extends BaseDto {
    public $id;
    public $provide_price;
    public $currency;
    public function __construct(array $data) {
        $this->id = $this->validateRequired($data, 'id', 'ID dịch vụ');
        $this->provide_price = $this->validateRequired($data, 'provide_price', 'Giá dịch vụ');
        $this->currency = $this->validateRequired($data, 'currency', 'Đơn vị giá');
    }
}