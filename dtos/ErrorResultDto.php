<?php 

class ErrorResultDto {
    public $message;

    public function __construct($message) {
        $this->message = $message;
    }
}