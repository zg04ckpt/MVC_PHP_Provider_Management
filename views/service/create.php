<h4>Thêm dịch vụ mới</h4>

<div class="card card-body">
    <form action="<?php echo htmlspecialchars('/manage/service/create') ?>" method="POST">
        <div class="row g-3">
            <!-- Name -->
            <div class="col-md-8">
                <label for="name" class="mb-1">Tên</label>
                <input type="text" name="name" 
                    class="form-control <?= !empty($errors['name']) ? 'is-invalid' : '' ?>" 
                    placeholder="Nhập tên của dịch vụ" value="<?= $name ?? '' ?>">
                <div class="invalid-feedback"><?= $errors['name'] ?? '' ?></div>
            </div>

            <!-- Desc -->
            <div class="col-md-8">
                <label for="des" class="mb-1">Mô tả</label>
                <textarea name="des" 
                    class="form-control <?= !empty($errors['des']) ? 'is-invalid' : '' ?>" 
                    placeholder="Nhập mô tả của dịch vụ"><?= $des ?? '' ?></textarea>
                <div class="invalid-feedback"><?= $errors['des'] ?? '' ?></div>
            </div>

            <!-- Unit -->
            <div class="col-md-8">
                <label for="unit" class="mb-1">Đơn vị dịch vụ</label>
                <input type="text" name="unit" 
                    class="form-control <?= !empty($errors['unit']) ? 'is-invalid' : '' ?>" 
                    placeholder="Nhập đơn vị tính giá của dịch vụ" value="<?= $unit ?? '' ?>">
                <div class="invalid-feedback"><?= $errors['unit'] ?? '' ?></div>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-3">
            <a href="/manage/service" class="btn border-color-1 flex-shrink-0  me-2">
                <i class="fa-solid fa-arrow-left me-1"></i>
                Quay lại
            </a>
            <button class="btn bg-color-1 text-white flex-shrink-0" type="submit">
                <i class="fa-solid fa-floppy-disk me-1"></i>
                Lưu mới
            </button>
        </div>

    </form>
</div>