<?php 

require_once __DIR__ . '/../enums/ServiceStatus.php';

class ServiceDetailDto {
    public $id;
    public $name;
    public $desc;
    public $status;
    public $price;
    public $unit;
    public $currency;
    public $created_date;
    public $updated_date;
    public $provider_id;
    public $provider_name;

    public function __construct(mixed $data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->desc = $data['desc'];
        $this->status = $data['status'];
        $this->unit = $data['unit'];
        $this->currency = $data['currency'];
        $this->created_date = new DateTime($data['created_date']);
        $this->updated_date = new DateTime($data['updated_date']);
        $this->provider_id = $data['provider_id'];
        $this->provider_name = $data['provider_name'];
        $this->price = $data['price'];
    }
}