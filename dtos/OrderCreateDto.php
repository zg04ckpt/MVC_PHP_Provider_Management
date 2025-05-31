<?php 

require_once 'BaseDto.php';
require_once __DIR__ . '/../enums/OrderStatus.php';

class OrderCreateDto extends BaseDto {
    public $name;
    public $des;
    public $status;
    public $provide_deadline;
    public $vat;
    public $user_id;
    public $provider_id;
    public $service_id;
    public $currency;
    public $price;
    public $quantity;

    public function __construct(array $data) {
        $this->name = $this->validateRequired($data, 'name', 'Tên đơn hàng dịch vụ');
        $this->des = $data['des'];
        $this->status = OrderStatus::Wait;
        $this->provide_deadline = $this->validateRequired($data, 'provide_deadline', 'Hạn cung cấp');
        $this->vat = 0.1;
        $this->provider_id = $this->validateRequired($data, 'provider_id', 'Nhà cung cấp');
        $this->service_id = $this->validateRequired($data, 'service_id', 'Dịch vụ');
        $this->price = $this->validateRequired($data, 'price', 'Giá');
        $this->currency = $this->validateRequired($data, 'currency', 'Đơn vị tiền');
        $this->quantity = $this->validateRequired($data, 'quantity', 'Số lượng');
        if ($this->quantity == 0) {
            throw new Exception("Số lượng phải lớn hơn 0");
        }
    }
}