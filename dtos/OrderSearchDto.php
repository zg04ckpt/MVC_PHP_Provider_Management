<?php 

require_once 'BaseDto.php';
require_once __DIR__ . '/../enums/OrderStatus.php';

class OrderSearchDto extends BaseDto {
    public ?int $id; 
    public $status; 
    public $service_id; 
    public int $page; 
    public int $size; 

    public function __construct(array $data) {
        $this->id = $this->validateOptional($data, 'id');
        $this->service_id = $this->validateOptional($data, 'service_id');
        $this->status = OrderStatus::tryFrom($this->validateOptional($data, 'status'));
        $this->page = isset($data['page']) && $data['page'] > 0 ? (int)$data['page'] : 1;
        $this->size = isset($data['size']) && $data['size'] > 0 ? (int)$data['size'] : 10;
    }

    private function validateOptional(array $data, string $key): ?string {
        return isset($data[$key]) && !empty(trim($data[$key])) ? (string)$data[$key] : null;
    }
}