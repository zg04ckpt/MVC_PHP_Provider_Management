<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống</title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    
    <!-- Start Login Form -->
    <div class="row">
        <div class="col-sm-8 offset-sm-2 col-md-4 offset-md-4">
            <div class="card card-body mt-5">
                <div class="text-center mb-3">
                    <small class="fw-bold text-secondary">Trường Đại học Hà Đông</small>
                    <h3 class="text-center fw-bold">Hệ thống quản lý nhà cung cấp</h3>
                    <h4 class="my-3">Đăng nhập quản trị</h4>
                </div>
                <form action="<?php echo htmlspecialchars('/auth/login') ?>" method="POST">
                    <label for="username">Tên đăng nhập</label>
                    <input type="text" name="username" 
                        class="mt-1 form-control <?php if (empty($errors['username'])) 'is-invalid' ?>" 
                        placeholder="Nhập tên đăng nhập"
                        value="<?php if (isset($username)) echo $username ?>">
                    <div class="invalid-feedback"><?php if (empty($errors['username'])) echo $errors['username'] ?></div>

                    <label for="password" class="mt-3">Mật khẩu</label>
                    <input type="password" name="password" placeholder="Nhập mật khẩu"
                        class="mt-1 form-control <?php if (empty($error['password'])) 'is-invalid' ?>">
                    <div class="invalid-feedback"><?php if (empty($error['password'])) echo $error['password'] ?></div>
                    
                    <div class="d-flex justify-content-center mt-4">
                        <button class="btn btn-success" type="submit" >Đăng nhập ngay</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Login Form -->
    <?php include_once __DIR__ . '/../partial/toast.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>