<?php

require_once 'BaseController.php';
require_once __DIR__ . '/../enums/ServiceStatus.php';
require_once __DIR__ . '/../dtos/ServiceCreateDto.php';
require_once __DIR__ . '/../dtos/ServiceSearchDto.php';


class ServiceController extends BaseController {
    private $serviceModel;

    public function __construct() {
        $this->loadModels('ServiceModel');
        $this->serviceModel = new ServiceModel();
    }

    public function index() {
        $this->layout_view('service/index', isClient: false);
    }

    public function detail() {
        $id = $_REQUEST['id'];
        if (empty($id)) {
            throw new Exception("id param cannot be null");
        }
        $data = $this->serviceModel->getDetail($id);
        $this->layout_view('service/detail', params: (array) $data, isClient: false);
    }

    public function detail_data() {
        $id = $_REQUEST['service_id'];
        if (empty($id)) {
            throw new Exception("id param cannot be null");
        }
        $data = $this->serviceModel->getDetail($id);
        $this->return_success(null, $data);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->layout_view('service/create', isClient: false);
            return;
        }

        $data = new ServiceCreateDto($_POST);

        // Checking
        $errors = [];
        if (empty($data->name)) {
            $errors['name'] = "Tên không được bỏ trống";
        }
        if (empty($data->des)) {
            $errors['des'] = "Mô tả không được bỏ trống";
        }
        if (empty($data->unit)) {
            $errors['unit'] = "Mô tả không được bỏ trống";
        }
        if (!empty($errors)) {
            $this->layout_view('service/create', [
                'errors' => $errors,
                'name' => $data->name,
                'des' => $data->des,
            ], isClient: false);
            return;
        }
        if ($this->serviceModel->checkNameExists($data->name)) {
            $this->layout_view('service/create', [
                'name' => $data->name,
                'des' => $data->des,
                'message' => 'Tên đã tồn tại'
            ], isClient: false);
            return;
        }

        // Creating
        if ($this->serviceModel->create($data)) {
            header(header: "Location: /manage/service?message=" . 'Tạo mới thành công');
        } else {
            $this->layout_view('service/create', [
                'name' => $data->name,
                'des' => $data->des,
                'message' => 'Tạo mới thất bại'
            ], isClient: false);
        }
    }

    public function list() {
        $data = new ServiceSearchDto($_REQUEST);
        if (empty($data->page)) {
            $this->return_failure("page trống");
            return;
        }
        if (empty($data->size)) {
            $this->return_failure("size trống");
            return;
        }

        $this->return_success(null, $this->serviceModel->getAsListItem($data));
    }

    public function delete() {
        $id = $_REQUEST['id'];
        if (empty($id)) {
            throw new Exception("ID param cannot be null");
        }
        $this->serviceModel->delete($id);
        $this->return_success("Xóa dịch vụ thành công.");
    }

    public function update() {
        $id = $_REQUEST['id'];
        if (empty($id)) {
            throw new Exception("ID param cannot be null");
        }
        $data = new ServiceUpdateDto($this->get_json());
        if (empty($data->name)) {
            throw new Exception("Tên dịch vụ trống");
        }
        if (empty($data->desc)) {
            throw new Exception("Mô tả dịch vụ trống");
        }
        if (empty($data->unit)) {
            throw new Exception(message: "Đơn vị dịch vụ trống");
        }

        $this->serviceModel->update($id, $data);
        $this->return_success("Cập nhật dịch vụ thành công.");
    }
}