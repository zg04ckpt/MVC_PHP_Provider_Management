<?php

require_once 'BaseController.php';

class AuthController extends BaseController {
    private $userModel;

    public function __construct() {
        $this->loadModels('UserModel');
        $this->userModel = new UserModel();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view('auth/login');
            return;
        }

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // validation
        $errors = [];
        if (empty($username)) {
            $errors['username'] = 'Vui lòng nhập tên đăng nhập.';
        }
        if (empty($password)) {
            $errors['password'] = 'Vui lòng nhập mật khẩu.';
        }
        if (!empty($errors)) {
            $this->view('auth/login', [
                'errors' => $errors,
                'username' => $username
            ]);
            return;
        }

        // login
        if ($this->userModel->checkLogin($username, $password)) {
            session_start();
            $_SESSION['username'] = $this->userModel->username;
            $_SESSION['id'] = $this->userModel->id;
            $_SESSION['role'] = $this->userModel->role;
            header("Location: /manage");
            // $this->layout_view('service/index', isClient: false);
        } else {
            $this->view('auth/login', [
                'errors' => $errors,
                'username' => $username,
                'message' => 'Đăng nhập thất bại, vui lòng thử lại'
            ]);
        }
    }
}