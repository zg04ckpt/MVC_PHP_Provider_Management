<?php 

class ServiceCreateDto {
    public string $name;
    public string $des;
    public string $status;
    public string $unit;

    public function __construct(array $data) {
        $this->name = $data['name'] ?? '';
        $this->des = $data['des'] ?? '';
        $this->unit = $data['unit'] ?? '';
        // $this->status = $data['status'] ?? 'unsigned';
    }
}