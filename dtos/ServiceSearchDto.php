<?php 

require_once __DIR__ . '/../enums/ServiceStatus.php';

class ServiceSearchDto {
    public $key;
    public $status;
    public $page;
    public $size;

    public function __construct(array $data) {
        $this->key = $data['key'] ?? '';
        $this->page = $data['page'] ?? '';
        $this->size = $data['size'] ?? '';
        $this->status = ServiceStatus::tryFrom($data['status'] ?? '');
    }
}