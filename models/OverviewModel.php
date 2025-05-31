<?php 

require_once 'BaseModel.php';
require_once __DIR__ . '/../enums/OrderStatus.php';

class OverviewModel extends BaseModel {
    public function get_overview(): array {
        $data = [];

        $stmt = $this->db->prepare("SELECT COUNT(id) as total FROM providers");
        $stmt->execute();
        $data['total_provider'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        $stmt = $this->db->prepare("SELECT COUNT(id) as total FROM providers WHERE status = ?");
        $stmt->execute(['active']);
        $data['active_provider'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $stmt = $this->db->prepare("SELECT COUNT(id) as total FROM services");
        $stmt->execute();
        $data['total_service'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        $stmt = $this->db->prepare("SELECT COUNT(id) as total FROM services WHERE status = ?");
        $stmt->execute(['signed']);
        $data['signed_service'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $stmt = $this->db->prepare("SELECT COUNT(id) as total FROM contracts
            WHERE expire_date <= DATE_ADD(NOW(), INTERVAL 1 DAY)
            ORDER BY expire_date ASC;");
        $stmt->execute();
        $data['expire_contract'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $stmt = $this->db->prepare("SELECT COUNT(id) as total FROM orders WHERE status = ?");
        $stmt->execute(['wait_pay']);
        $data['wait_pay_order'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        return $data;
    }

    public function analysis_amount($start_date, $end_date) {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    
        $data = [
            'total' => 0,
            'paid' => 0,
            'unpaid' => 0,
            'previous_total' => 0,
            'previous_paid' => 0,
            'previous_unpaid' => 0,
            'growth_rate_total' => 0,
            'growth_rate_paid' => 0,
            'growth_rate_unpaid' => 0
        ];

        // Khoảng thời gian đang xét
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);
        $stmt = $this->db->prepare("SELECT price * quantity as total, status FROM orders 
                                    WHERE created_date >= ? AND created_date <= ?");
        $stmt->execute([
            $start->format('Y-m-d H:i:s'), 
            $end->format('Y-m-d H:i:s')
        ]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($orders as $o) {
            $data['total'] += $o['total'];
            if ($o['status'] == OrderStatus::Paid->value) {
                $data['paid'] += $o['total'];
            }
        }
        $data['unpaid'] = $data['total'] - $data['paid'];

        // Khoảng thời gian so sánh
        $previous_end = clone $start;
        $previous_end->sub(new DateInterval('PT1S'));
        $previous_start = clone $previous_end;

        // temp
        $previous_start->modify('first day of this month'); 

        // Truy vấn khoảng trước
        $stmt = $this->db->prepare("SELECT price * quantity as total, status FROM orders 
                                    WHERE created_date >= ? AND created_date <= ?");
        $stmt->execute([
            $previous_start->format('Y-m-d H:i:s'),
            $previous_end->format('Y-m-d H:i:s')
        ]);
        $previous_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // throw new Exception($previous_start->format('Y-m-d H:i:s'));
        $data['s'] = $previous_start->format('Y-m-d H:i:s');
        $data['e'] = $previous_end->format('Y-m-d H:i:s');

        // Tính toán cho khoảng trước
        foreach ($previous_orders as $o) {
            $data['previous_total'] += $o['total'];
            if ($o['status'] == OrderStatus::Paid->value) {
                $data['previous_paid'] += $o['total'];
            }
        }
        $data['previous_unpaid'] = $data['previous_total'] - $data['previous_paid'];

        // Tính phần trăm tăng (dương) hoặc giảm (âm)
        if ($data['previous_total'] > 0) {
            $data['growth_rate_total'] = round((($data['total'] - $data['previous_total']) / $data['previous_total']) * 100, 2);
        } else if ($data['total'] > 0) {
            $data['growth_rate_total'] = 100;
        }

        if ($data['previous_paid'] > 0) {
            $data['growth_rate_paid'] = round((($data['paid'] - $data['previous_paid']) / $data['previous_paid']) * 100, 2);
        } else if ($data['paid'] > 0) {
            $data['growth_rate_paid'] = 100;
        }

        if ($data['previous_unpaid'] > 0) {
            $data['growth_rate_unpaid'] = round((($data['unpaid'] - $data['previous_unpaid']) / $data['previous_unpaid']) * 100, 2);
        } else if ($data['unpaid'] > 0) {
            $data['growth_rate_unpaid'] = 100;
        }

        return $data;
    }

    public function analysis_amount_12_mon_over() {
        $sql = "SELECT 
                    DATE_FORMAT(created_date, '%m/%Y') AS month_year,
                    SUM(price * quantity * (1 + vat)) / 1000000 AS total_cost
                FROM orders
                WHERE created_date BETWEEN 
                    DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 12 MONTH) 
                    AND CURDATE()
                GROUP BY DATE_FORMAT(created_date, '%m/%Y')
                ORDER BY MIN(created_date);";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTopSuppliersMaxTime() {
        $stmt = $this->db->prepare("SELECT 
                p.id AS provider_id,
                p.name AS provider_name,
                p.logo_url,
                SUM(DATEDIFF(c.expire_date, c.signed_date)) AS total_collaboration_days,
                COUNT(o.id) AS transaction_count,
                COALESCE(SUM(o.price * o.quantity * (1 + o.vat)), 0) AS total_cost
            FROM providers p
            INNER JOIN contracts c ON p.id = c.provider_id
            LEFT JOIN orders o ON p.id = o.provider_id
            GROUP BY p.id, p.name, p.logo_url
            ORDER BY total_collaboration_days DESC
            LIMIT 3
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRandom10Pro() {
        $stmt = $this->db->prepare("SELECT 
                id AS provider_id,
                name AS provider_name,
                logo_url,
                COALESCE(des, 'Không có mô tả') AS des
            FROM providers
            ORDER BY RAND()
            LIMIT 12;
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}