<?php 

require_once 'BaseDto.php';
require_once __DIR__ . '/../enums/OrderStatus.php';

class OrderListItemDto extends BaseDto {
    public $id;
    public $name;
    public $service_name;
    public $service_id;
    public $created_date;
    public $total;
    public $currency;
    public $status;

    public function __construct(array $data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->service_name = $data['service_name'];
        $this->service_id = $data['service_id'];
        $this->created_date = new DateTime($data['created_date'])->format('d-m-Y');
        $this->total = $data['price'] * $data['quantity'];
        $this->currency = $data['currency'];
        $this->status = OrderStatus::from($data['status'])->value;
    }
}