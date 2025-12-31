<?= $this->extend('admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-key me-2"></i>Tukar Kata Laluan Pengguna
                    </h4>
                    <p class="text-muted mb-0">Pengguna: <strong><?= esc($user['full_name']) ?> (<?= esc($user['email']) ?>)</strong></p>
                </div>
                <div class="card-body">
                    <?php if (session()->has('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?= session('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->has('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i><?= session('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="/admin/users/<?= $user['id'] ?>/change-password" method="POST">
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">
                                        <i class="fas fa-lock me-1"></i>Kata Laluan Baharu <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" required
                                           minlength="8" placeholder="Minimum 8 aksara">
                                    <small class="text-muted">Kata laluan baharu untuk pengguna ini</small>
                                </div>

                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">
                                        <i class="fas fa-lock me-1"></i>Sahkan Kata Laluan <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required
                                           minlength="8" placeholder="Ulang kata laluan baharu">
                                    <small class="text-muted">Ulang kata laluan baharu untuk pengesahan</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-info-circle me-1"></i>Nota Penting</h6>
                                    <ul class="mb-0">
                                        <li>Kata laluan mesti sekurang-kurangnya 8 aksara</li>
                                        <li>Pastikan kata laluan baharu selamat</li>
                                        <li>Pengguna akan dimaklumkan untuk menukar kata laluan selepas log masuk</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Tukar Kata Laluan
                            </button>
                            <a href="/admin/users" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Password confirmation validation
document.getElementById('confirm_password').addEventListener('input', function() {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = this.value;
    
    if (newPassword !== confirmPassword) {
        this.setCustomValidity('Kata laluan tidak sepadan');
    } else {
        this.setCustomValidity('');
    }
});
</script>
<?= $this->endSection() ?>