<?= $this->extend('admin_layout') ?>

<?= $this->section('content') ?>
<style>
    .create-user-header {
        background: var(--primary-gradient);
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }

    .create-user-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .create-user-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .create-user-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
        position: relative;
        z-index: 1;
    }

    .form-container {
        background: white;
        border-radius: 15px;
        padding: 2.5rem;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #e9ecef;
    }

    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .section-title {
        color: var(--primary-color);
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        color: var(--primary-color);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.875rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .form-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.875rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .form-check {
        margin-bottom: 1rem;
    }

    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .form-check-label {
        font-weight: 500;
        color: #495057;
    }

    .btn-submit {
        background: var(--primary-gradient);
        border: none;
        border-radius: 12px;
        padding: 1rem 2rem;
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #5dade2 0%, #3498db 100%);
        color: white;
        transform: translateY(-1px);
    }

    .btn-cancel {
        background: #6c757d;
        border: none;
        border-radius: 12px;
        padding: 1rem 2rem;
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        margin-left: 1rem;
    }

    .btn-cancel:hover {
        background: #5a6268;
        color: white;
        transform: translateY(-1px);
    }

    .password-strength {
        margin-top: 0.5rem;
        font-size: 0.875rem;
    }

    .password-strength.weak {
        color: #dc3545;
    }

    .password-strength.medium {
        color: #ffc107;
    }

    .password-strength.strong {
        color: #28a745;
    }

    .input-group-text {
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-right: none;
        color: #6c757d;
    }

    .input-group .form-control {
        border-left: none;
    }

    .input-group .form-control:focus {
        border-left: none;
    }

    @media (max-width: 768px) {
        .create-user-header {
            padding: 2rem 1.5rem;
        }

        .create-user-header h1 {
            font-size: 2rem;
        }

        .form-container {
            padding: 2rem 1.5rem;
        }

        .btn-submit, .btn-cancel {
            width: 100%;
            margin-left: 0;
            margin-top: 1rem;
        }
    }
</style>

<!-- Header Section -->
<div class="create-user-header fade-in-up">
    <h1><i class="fas fa-user-plus me-3"></i>Tambah Pengguna Baharu</h1>
    <p>Cipta akaun pengguna baharu untuk sistem tempahan fasiliti</p>
</div>

<!-- Form Container -->
<div class="form-container fade-in-up">
    <form action="/admin/users/store" method="post" id="createUserForm">
        <?= csrf_field() ?>

        <!-- Personal Information Section -->
        <div class="form-section">
            <h3 class="section-title">
                <i class="fas fa-user"></i>
                Maklumat Peribadi
            </h3>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="full_name" class="form-label">Nama Penuh *</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" value="<?= old('full_name') ?>" required>
                        <?php if (isset($validation) && $validation->hasError('full_name')): ?>
                            <div class="text-danger mt-1">
                                <i class="fas fa-exclamation-circle"></i> <?= $validation->getError('full_name') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email" class="form-label">Emel *</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
                        <?php if (isset($validation) && $validation->hasError('email')): ?>
                            <div class="text-danger mt-1">
                                <i class="fas fa-exclamation-circle"></i> <?= $validation->getError('email') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone" class="form-label">Nombor Telefon</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="<?= old('phone') ?>" placeholder="Contoh: 0123456789">
                        <?php if (isset($validation) && $validation->hasError('phone')): ?>
                            <div class="text-danger mt-1">
                                <i class="fas fa-exclamation-circle"></i> <?= $validation->getError('phone') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="user_type" class="form-label">Jenis Pengguna *</label>
                        <select class="form-select" id="user_type" name="user_type" required>
                            <option value="">Pilih jenis pengguna</option>
                            <option value="public" <?= old('user_type') === 'public' ? 'selected' : '' ?>>Orang Awam</option>
                            <option value="agency" <?= old('user_type') === 'agency' ? 'selected' : '' ?>>Agensi</option>
                        </select>
                        <?php if (isset($validation) && $validation->hasError('user_type')): ?>
                            <div class="text-danger mt-1">
                                <i class="fas fa-exclamation-circle"></i> <?= $validation->getError('user_type') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Information Section -->
        <div class="form-section">
            <h3 class="section-title">
                <i class="fas fa-lock"></i>
                Maklumat Akaun
            </h3>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password" class="form-label">Kata Laluan *</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="password-strength" id="passwordStrength"></div>
                        <?php if (isset($validation) && $validation->hasError('password')): ?>
                            <div class="text-danger mt-1">
                                <i class="fas fa-exclamation-circle"></i> <?= $validation->getError('password') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password_confirm" class="form-label">Sahkan Kata Laluan *</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                        </div>
                        <?php if (isset($validation) && $validation->hasError('password_confirm')): ?>
                            <div class="text-danger mt-1">
                                <i class="fas fa-exclamation-circle"></i> <?= $validation->getError('password_confirm') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="role" class="form-label">Peranan *</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="">Pilih peranan</option>
                            <option value="user" <?= old('role') === 'user' ? 'selected' : '' ?>>Pengguna</option>
                            <option value="manager" <?= old('role') === 'manager' ? 'selected' : '' ?>>Pengurus</option>
                            <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                        <?php if (isset($validation) && $validation->hasError('role')): ?>
                            <div class="text-danger mt-1">
                                <i class="fas fa-exclamation-circle"></i> <?= $validation->getError('role') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Status Akaun</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="approved" name="approved" value="1" <?= old('approved') ? 'checked' : '' ?>>
                            <label class="form-check-label" for="approved">
                                Luluskan akaun ini secara automatik
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="d-flex justify-content-end">
            <a href="/admin/users" class="btn btn-cancel">
                <i class="fas fa-times me-2"></i>Batal
            </a>
            <button type="submit" class="btn btn-submit">
                <i class="fas fa-save me-2"></i>Cipta Pengguna
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirm');
    const passwordStrength = document.getElementById('passwordStrength');

    passwordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;
        let feedback = [];

        if (password.length >= 8) strength++;
        else feedback.push('sekurang-kurangnya 8 aksara');

        if (/[a-z]/.test(password)) strength++;
        else feedback.push('huruf kecil');

        if (/[A-Z]/.test(password)) strength++;
        else feedback.push('huruf besar');

        if (/[0-9]/.test(password)) strength++;
        else feedback.push('nombor');

        if (/[^A-Za-z0-9]/.test(password)) strength++;
        else feedback.push('simbol khas');

        passwordStrength.className = 'password-strength';
        if (strength < 3) {
            passwordStrength.classList.add('weak');
            passwordStrength.textContent = 'Kata laluan lemah: ' + feedback.join(', ');
        } else if (strength < 4) {
            passwordStrength.classList.add('medium');
            passwordStrength.textContent = 'Kata laluan sederhana';
        } else {
            passwordStrength.classList.add('strong');
            passwordStrength.textContent = 'Kata laluan kuat';
        }
    });

    // Password confirmation validation
    passwordConfirmInput.addEventListener('input', function() {
        if (this.value !== passwordInput.value) {
            this.setCustomValidity('Kata laluan tidak sepadan');
        } else {
            this.setCustomValidity('');
        }
    });
});
</script>

<?= $this->endSection() ?>