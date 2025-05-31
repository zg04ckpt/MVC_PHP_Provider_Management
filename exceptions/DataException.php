<?php 

class DataException extends Exception {
    public $data;
    
    public function __construct($message, $data = [], $code = 0) {
        $this->data = $data;
        parent::__construct($message, $code);
    }
}