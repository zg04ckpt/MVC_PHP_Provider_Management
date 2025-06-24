<?php 

require_once 'BaseModel.php';
require_once __DIR__ . '/../dtos/PaginatedDto.php';
require_once __DIR__ . '/../dtos/ServiceCreateDto.php';
require_once __DIR__ . '/../dtos/ServiceSearchDto.php';
require_once __DIR__ . '/../dtos/ServiceDetailDto.php';
require_once __DIR__ . '/../dtos/ServiceListItemDto.php';
require_once __DIR__ . '/../dtos/ServiceUpdateDto.php';

class ServiceModel extends BaseModel {

    public function create(ServiceCreateDto $data) {
        $stmt = $this->db->prepare("
            INSERT INTO services
            SET name = ?, des = ?, status = ?, unit = ?, created_date = NOW(), updated_date = NOW()
        ");
        return $stmt->execute([
            $data->name, 
            $data->des, 
            ServiceStatus::Unsigned->value,
            $data->unit
        ]);
    }

    public function checkNameExists($name): bool {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM services 
            WHERE name = ?
        ");
        $stmt->execute([$name]);
        return $stmt->fetchColumn() > 0;
    }

    public function getAsListItem(ServiceSearchDto $data): PaginatedDto {
        $sql = "SELECT * FROM services ";
        $filter = "WHERE 1=1 ";
        $params = [];
        if (!empty($data->key)) {
            $filter .= " AND (name LIKE ? OR id = ?)";
            $params[] = '%' . $data->key . '%';
            $params[] = $data->key;
        }
        if (!empty($data->status)) {
            $filter .= " AND status = ?";
            $params[] = $data->status->value;
        }

        $count_stmt = $this->db->prepare('SELECT COUNT(*) as total FROM services ' . $filter);
        $count_stmt->execute($params);
        $totalItems = $count_stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $limit = (int) $data->size;
        $offset = (int) (($data->page - 1) * $data->size);
        $filter .= " LIMIT $limit OFFSET $offset";
        $stmt = $this->db->prepare($sql . $filter);
        $stmt->execute($params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $items = array_map(function($e): ServiceListItemDto {
            $item = new ServiceListItemDto();
            $item->id = $e['id'];
            $item->name = $e['name'];
            $item->des = $e['des'];
            $item->status = $e['status'];
            $item->unit = $e['unit'];
            return $item; 
        }, $results);

        return new PaginatedDto(
            $data->page, 
            $data->size, 
            $totalItems, 
            $items
        );
    }

    public function getDetail($id) {
        $stmt = $this->db->prepare("
            SELECT 
                s.id AS id, 
                s.name AS name, 
                s.des AS `desc`, 
                s.unit AS unit, 
                s.status AS status, 
                s.created_date AS created_date, 
                s.updated_date AS updated_date, 
                ps.provide_price AS price,
                ps.currency AS currency,
                p.id AS provider_id,
                p.name AS provider_name
            FROM services s
            LEFT JOIN provide_services ps ON s.id = ps.service_id
            LEFT JOIN providers p ON p.id = ps.provider_id 
            WHERE s.id = ?
        ");
        $stmt->execute([$id]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$res) {
            throw new Exception("Dịch vụ không tồn tại");
        }
        return new ServiceDetailDto($res);
    }

    public function delete($id) {
        $checkContract = $this->db->prepare("
            SELECT id FROM contracts WHERE services_id = ?
        ");
        $checkContract->execute([$id]);
        if ($checkContract->rowCount() > 0) {
            throw new Exception(message: "Vui lòng hủy hợp đồng dịch vụ trước khi xóa dịch vụ.");
        }
        $delete = $this->db->prepare("
            DELETE FROM services WHERE id = ?
        ");
        $delete->execute([$id]);
        if ($delete->rowCount() == 0) {
            throw new Exception("Xóa không thành công");
        }
    }

    public function update($id, ServiceUpdateDto $data) {
        $getService = $this->db->prepare("
            SELECT id FROM services WHERE id = ?
        ");
        $getService->execute([$id]);
        $service = $getService->fetch(PDO::FETCH_ASSOC);
        if (empty($service)) {
            throw new Exception(message: "Dịch vụ không tồn tại.");
        }

        $update = $this->db->prepare("
            UPDATE services
            SET name = ?, des = ?, unit = ?
            WHERE id = ?
        ");
        $update->execute([$data->name, $data->desc, $data->unit, $id]);
        if ($update->rowCount() == 0) {
            throw new Exception("Cập nhật thất bại");
        }
    }
}