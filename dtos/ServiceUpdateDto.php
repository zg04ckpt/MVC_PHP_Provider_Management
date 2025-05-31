<?php 

class ServiceUpdateDto {
    public $name;
    public $desc;
    public $unit;

    public function __construct(array $data) {
        $this->name = $data['name'] ?? '';
        $this->desc = $data['desc'] ?? '';
        $this->unit = $data['unit'] ?? '';
    }
}