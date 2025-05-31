<?php 

require_once 'BaseDto.php';

class ProviderAddContractDto extends BaseDto {
    public $signed_date;
    public $expire_date;
    public $contract_file;
    public $provider_id;
    public $service_ids = [];

    public function __construct(array $data, array $files) {
        $this->provider_id = $this->validateRequired($data, 'provider_id', 'Mã nhà cung cấp');
        $this->signed_date = $this->validateRequired($data, 'signed_date', 'Ngày kí');
        $this->expire_date = $this->validateRequired($data, 'expire_date', 'Ngày hết hạn');
        $this->contract_file = $this->validateFileUpload($files, 'contract_file', 'File hợp đồng');
        if (!isset($data['service_ids']) || 
            !is_array($data['service_ids']) || 
            count($data['service_ids']) == 0) {
            throw new Exception("Danh sách service_ids không được rỗng.");
        }
        foreach ($data['service_ids'] as $id) {
            $this->service_ids[] = $id;
        }
    }
}