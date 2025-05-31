<?php

require_once 'BaseDto.php';

class ProviderSearchDto extends BaseDto {
    public ?string $key = null;
    public ?int $serviceId = null; 
    public ?ProviderStatus $status = null; 
    public int $page = 1; 
    public int $size = 10;

    public function __construct(array $data) {
        $this->key = $this->validateOptional($data, 'key');
        $this->serviceId = isset($data['serviceId']) ? (int)$data['serviceId'] : null;
        $this->status = ProviderStatus::tryFrom($this->validateOptional($data, 'status'));
        $this->page = isset($data['page']) && $data['page'] > 0 ? (int)$data['page'] : 1;
        $this->size = isset($data['size']) && $data['size'] > 0 ? (int)$data['size'] : 10;
    }

    private function validateOptional(array $data, string $key): ?string {
        return isset($data[$key]) && !empty(trim($data[$key])) ? (string)$data[$key] : null;
    }
}