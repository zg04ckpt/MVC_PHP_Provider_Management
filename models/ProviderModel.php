<?php 

require_once 'BaseModel.php';
require_once __DIR__ . '/../dtos/ProviderCreateDto.php';
require_once __DIR__ . '/../dtos/ProviderListItemDto.php';
require_once __DIR__ . '/../dtos/ProviderSearchDto.php';
require_once __DIR__ . '/../dtos/PaginatedDto.php';
require_once __DIR__ . '/../enums/ProviderStatus.php';

class ProviderModel extends BaseModel {
    public function create(ProviderCreateDto $data) {
        // save file
        $uploadDir = 'public/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $logo_url = $uploadDir . uniqid() . '.' . pathinfo($data->logo['name'], PATHINFO_EXTENSION);
        if (!move_uploaded_file($data->logo['tmp_name'], $logo_url)) {
            throw new Exception("Lưu logo file thất bại." . $logo_url);
        }
        $banner_url = $uploadDir . uniqid() . '.' . pathinfo($data->banner['name'], PATHINFO_EXTENSION);
        if (!move_uploaded_file($data->banner['tmp_name'], $banner_url)) {
            throw new Exception("Lưu banner file thất bại.");
        }
        $logo_url = '/' . $logo_url;
        $banner_url = '/' . $banner_url;
        $stmt = $this->db->prepare("
            INSERT INTO providers(
                name, logo_url, banner_url, tax_code, des, address, email, phone, 
                created_date, updated_date, website_url, reputation, pay_account_number, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data->name, $logo_url, $banner_url, $data->tax_code, $data->des,
            $data->address, $data->email, $data->phone,
            $data->website_url, 0, $data->pay_account_number, ProviderStatus::Inactive->value
        ]);
        if ($stmt->rowCount() == 0) {
            throw new Exception("Tạo nhà cung cấp mới thất bại.");
        }
        $providerId = $this->db->lastInsertId();

        // add provide service
        $sql = "INSERT INTO provide_services (service_id, provider_id, provide_price, currency) VALUES ";
        $params = [];
        foreach ($data->services as $s) {
            $sql = $sql . " (?, ?, ?, ?), ";
            $params[] = $s->id;
            $params[] = $providerId;
            $params[] = $s->provide_price;
            $params[] = $s->currency;
        }
        $sql = rtrim($sql, ', ');
        // throw new Exception($sql);
        $stmt1 = $this->db->prepare($sql);
        $stmt1->execute($params);
        if ($stmt1->rowCount() == 0) {
            throw new Exception("Thêm dịch vụ nhà cung cấp mới thất bại.");
        }
    }

    public function update(ProviderUpdateDto $data) {
        $provider = $this->getById($data->id);
        if (empty($provider)) {
            throw new Exception("Nhà cung cấp không tồn tại.");
        }

        $uploadDir = 'public/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Xử lý file logo (nếu có upload mới)
        $logoUrl = null;
        if (!empty($data->logo['name'])) {
            $extension = strtolower(pathinfo($data->logo['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            if (!in_array($extension, $allowedExtensions)) {
                throw new Exception("Định dạng file logo không hợp lệ.");
            }
            $logoUrl = $uploadDir . uniqid() . '.' . $extension;
            if (!move_uploaded_file($data->logo['tmp_name'], $logoUrl)) {
                throw new Exception("Lưu file logo thất bại.");
            }
            // Xóa
            $logo_url = preg_replace('@^/@', '', $provider['logo_url']);
            if (file_exists($logo_url)) {
                unlink($logo_url);
            }
        }

        // Xử lý file banner (nếu có upload mới)
        $bannerUrl = null;
        if (!empty($data->banner['name'])) {
            $extension = strtolower(pathinfo($data->banner['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            if (!in_array($extension, $allowedExtensions)) {
                throw new Exception("Định dạng file banner không hợp lệ.");
            }
            $bannerUrl = $uploadDir . uniqid() . '.' . $extension;
            if (!move_uploaded_file($data->banner['tmp_name'], $bannerUrl)) {
                throw new Exception("Lưu file banner thất bại.");
            }
            // Xóa
            $banner_url = preg_replace('@^/@', '', $provider['banner_url']);
            if (file_exists($banner_url)) {
                unlink($banner_url);
            }
        }

        // Chuẩn bị câu lệnh SQL động để cập nhật providers
        $fields = [];
        $params = [];
        if ($data->name !== null) {
            $fields[] = 'name = ?';
            $params[] = $data->name;
        }
        if ($logoUrl !== null) {
            $fields[] = 'logo_url = ?';
            $params[] = '/' . $logoUrl;
        }
        if ($bannerUrl !== null) {
            $fields[] = 'banner_url = ?';
            $params[] = '/' .  $bannerUrl;
        }
        if ($data->tax_code !== null) {
            $fields[] = 'tax_code = ?';
            $params[] = $data->tax_code;
        }
        if ($data->des !== null) {
            $fields[] = 'des = ?';
            $params[] = $data->des;
        }
        if ($data->address !== null) {
            $fields[] = 'address = ?';
            $params[] = $data->address;
        }
        if ($data->email !== null) {
            $fields[] = 'email = ?';
            $params[] = $data->email;
        }
        if ($data->phone !== null) {
            $fields[] = 'phone = ?';
            $params[] = $data->phone;
        }
        if ($data->website_url !== null) {
            $fields[] = 'website_url = ?';
            $params[] = $data->website_url;
        }
        if ($data->pay_account_number !== null) {
            $fields[] = 'pay_account_number = ?';
            $params[] = $data->pay_account_number;
        }

        // Luôn cập nhật updated_date
        $fields[] = 'updated_date = NOW()';
        $params[] = $data->id;
        if (empty($fields)) {
            throw new Exception("Không có dữ liệu nào được cập nhật.");
        }
        $sql = "UPDATE providers SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        if ($stmt->rowCount() == 0) {
            throw new Exception("Cập nhật nhà cung cấp thất bại hoặc không có thay đổi.");
        }

        // Xóa tất cả các dịch vụ hiện tại của nhà cung cấp trong provide_services
        $deleteStmt = $this->db->prepare("DELETE FROM provide_services WHERE provider_id = ?");
        $deleteStmt->execute([$data->id]);
        // Thêm lại các dịch vụ mới từ $data->services
        if (!empty($data->services)) {
            $sql = "INSERT INTO provide_services (service_id, provider_id, provide_price, currency) VALUES ";
            $params = [];
            foreach ($data->services as $s) {
                $sql .= " (?, ?, ?, ?), ";
                $params[] = $s->id;
                $params[] = $data->id;
                $params[] = $s->provide_price;
                $params[] = $s->currency;
            }
            $sql = rtrim($sql, ', ');
            $stmt1 = $this->db->prepare($sql);
            $stmt1->execute($params);

            if ($stmt1->rowCount() == 0) {
                throw new Exception("Thêm dịch vụ nhà cung cấp thất bại.");
            }
        }
    }

    public function getServicesByProviderId(int $providerId) {
        $stmt = $this->db->prepare("
            SELECT 
                ps.service_id as service_id, 
                ps.provide_price as provide_price, 
                ps.currency as currency, 
                s.name as name,
                s.unit as unit
            FROM provide_services ps
            JOIN services s ON s.id = ps.service_id
            WHERE ps.provider_id = ?
        ");
        $stmt->execute([$providerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT * FROM providers WHERE id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete(int $id) {
        $this->db->beginTransaction();
        try {
            // Xóa nhà cung cấp trong providers
            $deleteProviderStmt = $this->db->prepare("DELETE FROM providers WHERE id = ?");
            $deleteProviderStmt->execute([$id]);

            if ($deleteProviderStmt->rowCount() == 0) {
                throw new Exception("Không tìm thấy nhà cung cấp để xóa.");
            }

            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Xóa nhà cung cấp thất bại: " . $e->getMessage());
        }
    }

    public function getAsListItem(ProviderSearchDto $data): PaginatedDto {
        $sql = "SELECT DISTINCT p.* FROM providers p ";
        $filter = "WHERE 1=1 ";
        $params = [];

        // Kiểm tra serviceId bằng EXISTS
        if (!empty($data->serviceId)) {
            $filter .= " AND EXISTS (SELECT 1 FROM provide_services ps WHERE ps.provider_id = p.id AND ps.service_id = ?)";
            $params[] = $data->serviceId;
        }

        // Lọc theo id hoặc name
        if (!empty($data->key)) {
            $filter .= " AND (p.name LIKE ? OR p.id = ?)";
            $params[] = '%' . $data->key . '%';
            $params[] = $data->key;
        }

        // Lọc theo status
        if (!empty($data->status)) {
            $filter .= " AND p.status = ?";
            $params[] = $data->status->value;
        }

        // Đếm tổng số bản ghi
        $countStmt = $this->db->prepare("SELECT COUNT(DISTINCT p.id) as total FROM providers p " . $filter);
        $countStmt->execute($params);
        $totalItems = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Phân trang
        $limit = (int) $data->size;
        $offset = (int) (($data->page - 1) * $data->size);
        $filter .= " LIMIT $limit OFFSET $offset";

        // Lấy danh sách bản ghi
        $stmt = $this->db->prepare($sql . $filter);
        $stmt->execute($params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $items = array_map(function($e): ProviderListItemDto {
            $item = new ProviderListItemDto();
            $item->id = $e['id'];
            $item->name = $e['name'];
            $item->logo_url = $e['logo_url'];
            $item->status = ProviderStatus::from($e['status'])->value;
            $item->website_url = $e['website_url'];
            return $item;
        }, $results);

        return new PaginatedDto(
            $data->page,
            $data->size,
            $totalItems,
            $items
        );
    }

    public function addContract(ProviderAddContractDto $data) {
        $check = $this->db->prepare("SELECT id FROM contracts WHERE provider_id = ?");
        $check->execute([$data->provider_id]);
        if ($check->rowCount() > 0) {
            throw new Exception("Tồn tại hợp đồng đang có hiệu lực.");
        }

        $uploadDir = 'public/uploads/contracts/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $contract_url = $uploadDir . uniqid() . '.' . pathinfo($data->contract_file['name'], PATHINFO_EXTENSION);
        if (!move_uploaded_file($data->contract_file['tmp_name'], $contract_url)) {
            throw new Exception("Lưu logo file thất bại.");
        }
        
        // save contract
        $sql = "
            INSERT INTO contracts (
                provider_id, signed_date, expire_date, contract_url
            ) VALUES (?, ?, ?, ?)
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data->provider_id,
            $data->signed_date,
            $data->expire_date,
            '/' . $contract_url
        ]);
        if ($stmt->rowCount() == 0) {
            throw new Exception("Thêm hợp đồng thất bại.");
        }

        // update provide_service
        $contract_id = $this->db->lastInsertId();
        $placeholders = rtrim(str_repeat('?,', count($data->service_ids)), ',');
        $update_sql = "UPDATE provide_services 
            SET contract_id = ? WHERE service_id IN ($placeholders) AND provider_id = ?";
        $update_stmt = $this->db->prepare($update_sql);
        $update_stmt->execute(array_merge([$contract_id], $data->service_ids, [$data->provider_id]));
        if ($update_stmt->rowCount() == 0) {
            throw new Exception("Cập nhật dịch vụ được cung cấp thất bại.");
        }

        // update dịch vụ
        $update_ser_stmt = $this->db->prepare("
            UPDATE services 
            SET status = 'signed' WHERE id IN ($placeholders)
        ");
        $update_ser_stmt->execute($data->service_ids);
        if ($update_ser_stmt->rowCount() == 0) {
            throw new Exception("Cập nhật dịch vụ thất bại.");
        }

        // update provider
        $update_pro_stmt = $this->db->prepare("
            UPDATE providers
            SET status = 'active' WHERE id = ?
        ");
        $update_pro_stmt->execute([$data->provider_id]);
        if ($update_pro_stmt->rowCount() == 0) {
            throw new Exception("Cập nhật nhà cung cấp thất bại.");
        }
    }

    public function deleteContract(int $contract_id) {
        $this->db->beginTransaction();

        try {
            $check = $this->db->prepare("SELECT contract_url, provider_id FROM contracts WHERE id = ?");
            $check->execute([$contract_id]);
            if ($check->rowCount() == 0) {
                throw new Exception("Hợp đồng không tồn tại.");
            }

            $contract = $check->fetch(PDO::FETCH_ASSOC);
            $contract_url = $contract['contract_url'];
            $provider_id = $contract['provider_id'];

            // Lấy danh sách service_ids liên quan đến hợp đồng
            $service_check = $this->db->prepare("SELECT service_id FROM provide_services WHERE contract_id = ?");
            $service_check->execute([$contract_id]);
            $service_ids = $service_check->fetchAll(PDO::FETCH_COLUMN);

            // Xóa hợp đồng khỏi bảng contracts
            $delete_stmt = $this->db->prepare("DELETE FROM contracts WHERE id = ?");
            $delete_stmt->execute([$contract_id]);
            if ($delete_stmt->rowCount() == 0) {
                throw new Exception("Xóa hợp đồng thất bại.");
            }

            // Cập nhật provide_services: đặt contract_id về NULL
            $update_ps_stmt = $this->db->prepare("UPDATE provide_services SET contract_id = NULL WHERE contract_id = ? AND provider_id = ?");
            $update_ps_stmt->execute([$contract_id, $provider_id]);
            if ($service_check->rowCount() > 0 && $update_ps_stmt->rowCount() == 0) {
                throw new Exception("Cập nhật provide_services thất bại.");
            }

            // Cập nhật trạng thái dịch vụ về unsigned (hoặc trạng thái mặc định)
            if (!empty($service_ids)) {
                $placeholders = rtrim(str_repeat('?,', count($service_ids)), ',');
                $update_service_stmt = $this->db->prepare("UPDATE services SET status = 'unsigned' WHERE id IN ($placeholders)");
                $update_service_stmt->execute($service_ids);
                if ($update_service_stmt->rowCount() == 0) {
                    throw new Exception("Cập nhật trạng thái dịch vụ thất bại.");
                }
            }

            // Xóa file hợp đồng khỏi thư mục lưu trữ
            if (file_exists($contract_url)) {
                if (!unlink($contract_url)) {
                    throw new Exception("Xóa file hợp đồng thất bại.");
                }
            }

            // Commit transaction nếu tất cả thành công
            $this->db->commit();
        } catch (Exception $e) {
            // Rollback nếu có lỗi
            $this->db->rollBack();
            throw new Exception("Lỗi khi xóa hợp đồng: " . $e->getMessage());
        }
    }

    public function getContract($id) {
        $stmt = $this->db->prepare("
            SELECT * FROM contracts WHERE provider_id = ?
        ");
        $stmt->execute([$id]);
        $provider = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($provider)) {
            return null;
        }
        $provider['signed_date'] = new DateTime($provider['signed_date'])->format('d/m/Y');
        $provider['expire_date'] = new DateTime($provider['expire_date'])->format('d/m/Y');
        // $provider['contract_url'] = 'http://localhost:5001' . $provider['contract_url'];

        $getServicesCount = $this->db->prepare("
            SELECT * FROM provide_services 
            WHERE provider_id is not null AND provider_id = ?
        ");
        $getServicesCount->execute([$id]);
        $provider['services_count'] = $getServicesCount->rowCount();
        return $provider;
    }

    public function getTop3Provider($service_id) {
        $sql = "SELECT 
            o.provider_id,
            p.logo_url,
            p.name as provider_name,
            o.service_id,
            s.name as service_name,
            AVG(o.price) as avg_price,
            SUM(CASE WHEN o.paid_date <= o.provide_deadline THEN 1 ELSE 0 END) / COUNT(*) as reliability_score,
            SUM(CASE 
                WHEN (o.status = 'paid' AND o.paid_date > o.provide_deadline) 
                OR (o.status = 'wait_pay' AND o.provide_deadline < CURRENT_TIMESTAMP) 
                THEN 1 ELSE 0 END) as late_orders,
            TIMESTAMPDIFF(MONTH, MIN(o.created_date), MAX(o.created_date)) as partnership_months,
            SUM(o.price * o.quantity * (1 + o.vat)) as total_exchange_cost,
            COUNT(*) as transaction_count
            FROM orders o
            JOIN providers p ON o.provider_id = p.id
            JOIN services s ON o.service_id = s.id
            WHERE o.service_id = ?
            GROUP BY o.provider_id, o.service_id;";
        
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$service_id]);
        $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $weights = [
            'price' => 0.25,
            'reliability' => 0.20,
            'late_orders' => 0.15,
            'partnership' => 0.15,
            'exchange_cost' => 0.15,
            'transaction_count' => 0.10
        ];
        $suppliers = $this->normalizeData($suppliers);
        foreach ($suppliers as &$supplier) {
            $supplier['score'] = $this->calculateScore($supplier, $weights);
        }

        usort($suppliers, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });
        $topSuppliers = array_slice($suppliers, 0, 3);
        return $topSuppliers;
    }

    private function normalizeData($suppliers) {
        $prices = array_column($suppliers, 'avg_price');
        $reliabilities = array_column($suppliers, 'reliability_score');
        $lateOrders = array_column($suppliers, 'late_orders');
        $partnerships = array_column($suppliers, 'partnership_months');
        $exchangeCosts = array_column($suppliers, 'total_exchange_cost');
        $transactionCounts = array_column($suppliers, 'transaction_count');

        $maxPrice = max($prices);
        $minPrice = min($prices);
        $maxReliability = max($reliabilities);
        $maxLateOrders = max($lateOrders);
        $minLateOrders = min($lateOrders);
        $maxPartnership = max($partnerships);
        $maxExchangeCost = max($exchangeCosts);
        $maxTransactionCount = max($transactionCounts);

        foreach ($suppliers as &$supplier) {
            $supplier['normalized'] = [
                'price' => ($maxPrice == $minPrice) ? 1 : ($maxPrice - $supplier['avg_price']) / ($maxPrice - $minPrice),
                'reliability' => $supplier['reliability_score'] / $maxReliability,
                'late_orders' => ($maxLateOrders == $minLateOrders) ? 1 : ($maxLateOrders - $supplier['late_orders']) / ($maxLateOrders - $minLateOrders),
                'partnership' => $supplier['partnership_months'] / $maxPartnership,
                'exchange_cost' => $supplier['total_exchange_cost'] / $maxExchangeCost,
                'transaction_count' => $supplier['transaction_count'] / $maxTransactionCount
            ];
        }
        return $suppliers;
    }

    private function calculateScore($supplier, $weights) {
        return (
            $supplier['normalized']['price'] * $weights['price'] +
            $supplier['normalized']['reliability'] * $weights['reliability'] +
            $supplier['normalized']['late_orders'] * $weights['late_orders'] +
            $supplier['normalized']['partnership'] * $weights['partnership'] +
            $supplier['normalized']['exchange_cost'] * $weights['exchange_cost'] +
            $supplier['normalized']['transaction_count'] * $weights['transaction_count']
        );
    }
}