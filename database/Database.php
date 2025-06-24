<?php

class Database {
    private $host = 'localhost';
    private $port = 3306;
    private $db_name = 'bt3php1';
    private $username = 'root';
    private $password = 'admin';
    private $conn;

    public function getConnection(): PDO  {
        $this->conn = null;
        $connection_string = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name};charset=utf8";
        try {
            $this->conn = new PDO(
                $connection_string,
                $this->username,
                $this->password
            );
            // Ném ngoại lệ nếu lỗi khi truy vấn
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Trả về mảng kết hợp
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo "Lỗi kết nối: " . $exception->getMessage();
        }
        return $this->conn;
    }
}