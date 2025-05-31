<?php

require_once 'BaseDto.php';

class ProviderUpdateDto extends BaseDto {
    public int $id;
    public ?string $name = null;
    public ?array $logo = null;
    public ?array $banner = null;
    public ?string $tax_code = null;
    public ?string $des = null;
    public ?string $email = null;
    public ?string $address = null;
    public ?string $phone = null;
    public ?string $website_url = null;
    public ?string $pay_account_number = null;
    public array $services = [];

    public function __construct(int $id, array $data, array $files) {
        $this->id = $id;
        $this->name = $this->validateOptional($data, 'name');
        $this->tax_code = $this->validateOptional($data, 'tax_code');
        $this->des = $this->validateOptional($data, 'des');
        $this->email = $this->validateOptional($data, 'email');
        $this->address = $this->validateOptional($data, 'address');
        $this->phone = $this->validateOptional($data, 'phone');
        $this->website_url = $this->validateOptional($data, 'website_url');
        $this->pay_account_number = $this->validateOptional($data, 'pay_account_number');

        // Kiểm tra file nếu được upload
        $this->logo = $this->validateOptionalFile($files, 'logo');
        $this->banner = $this->validateOptionalFile($files, 'banner');

        // Xử lý danh sách dịch vụ
        $data['services'] = json_decode($data['services'], true);
        foreach ($data['services'] as $s) {
            $this->services[] = new ProvideServiceDto($s);
        }
    }

    private function validateOptional(array $data, string $key): ?string {
        return isset($data[$key]) && !empty(trim($data[$key])) ? (string)$data[$key] : null;
    }

    private function validateOptionalFile(array $files, string $key): ?array {
        return isset($files[$key]) && is_array($files[$key]) && !empty($files[$key]['name']) ? $files[$key] : null;
    }
}