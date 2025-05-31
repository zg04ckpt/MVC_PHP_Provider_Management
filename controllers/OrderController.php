<?php

require_once 'BaseController.php';
require_once __DIR__ . '/../dtos/OrderCreateDto.php';
require_once __DIR__ . '/../dtos/OrderSearchDto.php';
require_once __DIR__ . '/../enums/OrderStatus.php';

class OrderController extends BaseController {
    private $model;

    public function __construct() {
        $this->loadModels("OrderModel");
        $this->model = new OrderModel();
    }

    public function index() {
        $this->layout_view(path: 'order/index', isClient: false);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->layout_view('order/create', isClient: false);
        }
        session_start();
        $data = new OrderCreateDto($_POST);
        $this->model->create($data);
        $this->return_success("Tạo mới thành công");
    }

    public function list() {
        $data = new OrderSearchDto($_REQUEST);
        $this->return_success(null, $this->model->getOrderAsListItem($data));
    }

    public function pay() {
        $id = $_REQUEST['id'];
        $order = $this->model->getById($id);
        if (empty($order)) {
            throw new Exception("Đơn hàng không tồn tại");
        }
        if ($order['status'] != OrderStatus::WaitPay->value) {
            throw new Exception("Trạng thái đơn hàng không hợp lệ");
        }

        $vnp_TxnRef = $order['id'];
        $vnp_Amount = $order['price'] * $order['quantity'];
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $vnp_Returnurl = 'http://localhost:8000/manage/order/pay_result';

        require_once __DIR__ . '/../config/vnpay.php';
    }

    public function pay_result() {
        //http://localhost:8000/manage/order/pay_result?vnp_Amount=1900000000&vnp_BankCode=NCB&vnp_BankTranNo=VNP14990416&vnp_CardType=ATM&vnp_OrderInfo=Thanh+toan+hoa+don+%23109&vnp_PayDate=20250530203837&vnp_ResponseCode=00&vnp_TmnCode=RU9YEDPU&vnp_TransactionNo=14990416&vnp_TransactionStatus=00&vnp_TxnRef=109&vnp_SecureHash=fd8741486d5c359e62d265a6521c0a98e77e1f1bdcd5bff6aaac9cecf450d590eb0fe18d657ed3f52d7f1468f3d4f9577d4f7ce9e0173e976f5e6d597da1540d
        $id = $_REQUEST['vnp_TxnRef'];
        $this->model->updateStatus($id, OrderStatus::Paid);
        $this->view('order/pay_success', [
            'amount' => ((int) $_REQUEST['vnp_Amount'])/100,
            'currency' => 'VNĐ',
            'order_id' => $id
        ]);
    }

    public function detail() {
        $id = $_REQUEST['id'];
        $order = $this->model->getById($id);
        if (empty($order)) {
            throw new Exception("Đơn hàng không tồn tại");
        }
        $total = ($order['price'] * $order['quantity']) * 0.9;

        $this->loadModels("ProviderModel");
        $providerModel = new ProviderModel();
        $provider = $providerModel->getById($order['provider_id']);
        if (empty($provider)) {
            throw new Exception("Nhà cung cấp của đơn hàng không tồn tại");
        }

        $this->layout_view(path: 'order/detail', isClient: false, params: [
            'order' => $order,
            'provider' => $provider,
            'total' => $total,
            'total_spell' => $this->money_spell($total)
        ]);
    }

    private function money_spell($number) {
        if ($number == 0) {
            return 'Không đồng';
        }

        $units = ['', 'nghìn', 'triệu', 'tỷ'];
        $digits = ['không', 'một', 'hai', 'ba', 'bốn', 'năm', 'sáu', 'bảy', 'tám', 'chín'];
        $tens = ['', 'mười', 'hai mươi', 'ba mươi', 'bốn mươi', 'năm mươi', 'sáu mươi', 'bảy mươi', 'tám mươi', 'chín mươi'];
        $teens = ['mười', 'mười một', 'mười hai', 'mười ba', 'mười bốn', 'mười lăm', 'mười sáu', 'mười bảy', 'mười tám', 'mười chín'];

        $number = abs((int)$number);
        $result = '';
        $unitIndex = 0;

        while ($number > 0) {
            $chunk = $number % 1000; 
            if ($chunk > 0) {
                $chunkText = '';
                $hundreds = floor($chunk / 100);
                $tensAndUnits = $chunk % 100;

                if ($hundreds > 0) {
                    $chunkText .= $digits[$hundreds] . ' trăm';
                }

                if ($tensAndUnits > 0) {
                    if ($chunkText !== '') {
                        $chunkText .= ' ';
                    }
                    if ($tensAndUnits < 10) {
                        $chunkText .= $digits[$tensAndUnits];
                    } elseif ($tensAndUnits < 20) {
                        $chunkText .= $teens[$tensAndUnits - 10];
                    } else {
                        $tensDigit = floor($tensAndUnits / 10);
                        $unitDigit = $tensAndUnits % 10;
                        $chunkText .= $tens[$tensDigit];
                        if ($unitDigit > 0) {
                            $chunkText .= ' ' . ($unitDigit == 5 && $tensDigit > 1 ? 'lăm' : ($unitDigit == 1 ? 'mốt' : $digits[$unitDigit]));
                        }
                    }
                }

                if ($chunkText !== '') {
                    $chunkText .= ' ' . $units[$unitIndex];
                    $result = $chunkText . ($result ? ' ' . $result : '');
                }
            }

            $number = floor($number / 1000);
            $unitIndex++;
        }

        return ucfirst(trim($result)) . ' đồng';
    }
}