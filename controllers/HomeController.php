<?php

require_once 'BaseController.php';

class HomeController extends BaseController {
    private $userModel;
    public function __construct() {
        $this->loadModels('UserModel');
        $this->userModel = new UserModel();
    }

    public function index() {
        $this->layout_view('home/index', isClient: true);
    }
}