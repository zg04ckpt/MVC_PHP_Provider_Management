<?php

require_once 'BaseController.php';

require_once __DIR__ . '/../dtos/ProviderCreateDto.php';
require_once __DIR__ . '/../dtos/ProviderUpdateDto.php';
require_once __DIR__ . '/../dtos/ProviderAddContractDto.php';

class ProviderController extends BaseController {
    private $model;

    public function __construct() {
        $this->loadModels("ProviderModel");
        $this->model = new ProviderModel();
    }

    public function index() {
        $this->layout_view('provider/index', isClient: false);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->layout_view('provider/create', isClient: false);
            return;
        }
        
        try {
            $data = new ProviderCreateDto($_POST, $_FILES);
            $this->model->create($data);
            $this->return_success("Tạo mới thành công");
        } catch (Exception $ex) {
            $this->return_failure($ex->getMessage());
            return;
        }
    }

    public function update() {
        $id = $_REQUEST['id'];
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $provider = $this->model->getById($id);
            if (!$provider) {
                $this->return_failure("Nhà cung cấp không tồn tại.");
                return;
            }
            
            $services = $this->model->getServicesByProviderId($id);
            $this->layout_view('provider/update', ['provider' => $provider, 'services' => $services], isClient: false);
            return;
        }

        $data = new ProviderUpdateDto($id, $_POST, $_FILES);
        $this->model->update($data);
        $this->return_success("Cập nhật nhà cung cấp thành công");
    }

    public function delete() {
        $id = $_REQUEST['id'];
        $provider = $this->model->getById($id);
        if (!$provider) {
            throw new Exception("Nhà cung cấp không tồn tại.");
        }

        $logo_url = preg_replace('@^/@', '', $provider['logo_url']);
        if (!unlink($logo_url)) {
            throw new Exception("Không thể xóa file logo");
        }

        $banner_url = preg_replace('@^/@', '', $provider['banner_url']);
        if (!unlink($banner_url)) {
            throw new Exception("Không thể xóa file banner");
        }

        $this->model->delete($id);
        $this->return_success("Xóa nhà cung cấp thành công");
    }

    public function list() {
        $data = new ProviderSearchDto($_REQUEST);
        if (empty($data->page)) {
            $this->return_failure("page trống");
            return;
        }
        if (empty($data->size)) {
            $this->return_failure("size trống");
            return;
        }

        $this->return_success(null, $this->model->getAsListItem($data));
    }

    public function detail() {
        $provider = $this->model->getById($_REQUEST['id']);
        if (!$provider) {
            throw new Exception("Nhà cung cấp không tồn tại.");
        }
        $services = $this->model->getServicesByProviderId($_REQUEST['id']);
        $this->layout_view('provider/detail', params: [
            'provider' => $provider,
            'services' => $services,
        ], isClient: false);
    }

    public function add_contract() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->layout_view('provider/add_contract', isClient: false);
            return;
        }
        $data = new ProviderAddContractDto($_POST, $_FILES);
        $this->model->addContract($data);
        $this->return_success("Thêm hợp đồng thành công");
    }

    public function cancel_contract() {
        $this->model->deleteContract($_REQUEST['id']);
        $this->return_success("Xóa hợp đồng thành công");
    }

    public function get_services() {
        $services = $this->model->getServicesByProviderId($_REQUEST['id']);
        $this->return_success(null, $services);
    }

    public function get_contract() {
        $id = $_REQUEST['id'];
        $data = $this->model->getContract($id);
        $this->return_success(null, $data);
    }

    public function top_provider() {
        $this->loadModels('ServiceModel');
        $serviceModel = new ServiceModel();
        $id = $_REQUEST['service_id'];
        $data = $serviceModel->getDetail($id);
        $this->layout_view('provider/top_provider', (array) $data, isClient: false);
    }

    public function get_top_3_data() {
        $id = $_REQUEST['service_id'];
        $data = $this->model->getTop3Provider($id);
        $this->return_success(null, $data);
    }
}