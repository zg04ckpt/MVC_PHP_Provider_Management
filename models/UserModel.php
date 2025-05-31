<?php 

require_once 'BaseModel.php';

class UserModel extends BaseModel {
    public $id;
    public $username;
    public $password;
    public $email;
    public $role;

    public function checkLogin($username, $password) {
        $stmt = $this->db->prepare("
            SELECT * FROM users
            WHERE username = ?
            LIMIT 1
        ");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            $this->id = $user['id'];
            $this->username = $user['username'];
            $this->password = $user['password'];
            $this->email = $user['email'];
            $this->role = $user['role'];
            return true;
        }
        return false;
    }
}