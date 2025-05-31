<?php 

require_once 'BaseModel.php';
require_once __DIR__ . '/../dtos/OrderCreateDto.php';
require_once __DIR__ . '/../dtos/OrderListItemDto.php';
require_once __DIR__ . '/../dtos/PaginatedDto.php';
require_once __DIR__ . '/../enums/OrderStatus.php';


class OrderModel extends BaseModel {
    public function create(OrderCreateDto $data) {
        $get_service = $this->db->prepare("SELECT * FROM services WHERE id = ?");
        $get_service->execute([$data->service_id]);
        $service = $get_service->fetch(PDO::FETCH_ASSOC);
        if (empty($service)) {
            throw new Exception("Dịch vụ không tồn tại.");
        }

        $get_provider = $this->db->prepare("SELECT * FROM providers WHERE id = ?");
        $get_provider->execute([$data->provider_id]);
        $provider = $get_provider->fetch(PDO::FETCH_ASSOC);
        if (empty($provider)) {
            throw new Exception("Nhà cung cấp không tồn tại.");
        }

        $create_order = $this->db->prepare(@'INSERT INTO
            orders(`name`,`des`,`status`,`created_date`,`provide_deadline`,
            `paid_date`, `currency`, `vat`,`user_id`,`provider_id`,`service_id`,`price`,`unit`,`quantity`)
            VALUES (?,?,?,NOW(),?,NULL,?,?,?,?,?,?,?,?)
        ');
        $create_order->execute([
            $data->name,
            $data->des,
            $data->status->value,
            $data->provide_deadline,
            $data->currency,
            $data->vat,
            $_SESSION['id'],
            $provider['id'],
            $service['id'],
            $data->price,
            $service['unit'],
            $data->quantity,
        ]);
        if ($create_order->rowCount() == 0) {
            throw new Exception("Tạo đơn hàng thất bại.");
        }
    }
    public function getOrderAsListItem(OrderSearchDto $data): PaginatedDto {
        $sql = "SELECT o.*, p.name AS provider_name, s.name AS service_name 
                FROM orders o 
                LEFT JOIN providers p ON o.provider_id = p.id 
                LEFT JOIN services s ON o.service_id = s.id ";
        $filter = "WHERE 1=1 ";
        $params = [];

        if (!empty($data->id)) {
            $filter .= " AND o.id = ?";
            $params[] = $data->id;
        }

        if (!empty($data->service_id)) {
            $filter .= " AND o.service_id = ?";
            $params[] = $data->service_id;
        }

        // Lọc theo status
        if (!empty($data->status)) {
            $filter .= " AND o.status = ?";
            // throw new Exception($sql . $filter);
            $params[] = $data->status->value;
        }

        $filter .= " ORDER BY created_date DESC ";


        // Lấy tổng số bản ghi
        $count_stmt = $this->db->prepare('SELECT COUNT(*) as total FROM orders o ' . $filter);
        $count_stmt->execute($params);
        $totalItems = $count_stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Thêm phân trang
        $limit = (int) $data->size;
        $offset = (int) (($data->page - 1) * $data->size);
        $filter .= " LIMIT $limit OFFSET $offset";

        // Thực hiện truy vấn chính
        $stmt = $this->db->prepare($sql . $filter);
        $stmt->execute($params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Ánh xạ kết quả thành OrderListItemDto
        $items = array_map(function($e): OrderListItemDto {
            $item = new OrderListItemDto($e);
            return $item;
        }, $results);

        // Trả về PaginatedDto
        return new PaginatedDto(
            $data->page,
            $data->size,
            $totalItems,
            $items
        );
    }

    public function getById($order_id) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$order_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStatus($order_id, OrderStatus $status) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ? AND status = ?");
        $stmt->execute([$order_id, 'wait_pay']);
        if ($stmt->rowCount() == 0) {
            throw new Exception("Đơn hàng không tồn tại hoặc đã được thanh toán");
        }
        
        $stmt = $this->db->prepare("UPDATE orders SET status = ?, paid_date = NOW() WHERE id = ?");
        $stmt->execute([$status->value, $order_id]);
        if ($stmt->rowCount() == 0) {
            throw new Exception("Cập nhật trạng thái đơn hàng thất bại");
        }
    }
}

