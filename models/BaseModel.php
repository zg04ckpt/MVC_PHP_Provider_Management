<?php

require_once 'database/database.php';

class BaseModel {
    protected $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }
}