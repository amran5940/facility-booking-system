<?= $this->extend('admin_layout') ?>

<?= $this->section('content') ?>
<style>
    .edit-manager-header {
        background: var(--primary-gradient);
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 15px 35px rgba(52, 152, 219, 0.3);
        position: relative;
        overflow: hidden;
    }

    .edit-manager-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .edit-manager-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .edit-manager-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
        position: relative;
        z-index: 1;
    }

    .form-card {
        background: white;
        border-radius: 15px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.05);
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }

    .form-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-select:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }

    .btn-submit {
        background: var(--primary-gradient);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(52, 152, 219, 0.4);
    }

    .btn-cancel {
        background: #6c757d;
        border: none;
        border-radius: 10px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        color: white;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }

    .fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .edit-manager-header {
            padding: 2rem 1.5rem;
        }

        .edit-manager-header h1 {
            font-size: 2rem;
        }

        .form-card {
            padding: 1.5rem;
        }
    }
</style>

<!-- Header Section -->
<div class="edit-manager-header fade-in-up">
    <h1><i class="fas fa-user-edit me-3"></i>Edit Pengurus</h1>
    <p>Kemaskini maklumat pengurus</p>
</div>

<!-- Edit Form -->
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="form-card fade-in-up">
            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Ralat Pengesahan:</h6>
                    <ul class="mb-0">
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i><?= esc(session('error')) ?>
                </div>
            <?php endif; ?>

            <form action="/admin/managers/<?= $manager['id'] ?>/update" method="post">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="full_name" class="form-label">
                        <i class="fas fa-user me-2"></i>Nama Penuh
                    </label>
                    <input type="text" class="form-control" id="full_name" name="full_name"
                           value="<?= esc($manager['full_name']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope me-2"></i>Emel
                    </label>
                    <input type="email" class="form-control" id="email" name="email"
                           value="<?= esc($manager['email']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">
                        <i class="fas fa-phone me-2"></i>Telefon
                    </label>
                    <input type="text" class="form-control" id="phone" name="phone"
                           value="<?= esc($manager['phone'] ?? '') ?>" placeholder="Contoh: +60123456789">
                </div>

                <div class="form-group">
                    <label for="agency_id" class="form-label">
                        <i class="fas fa-building me-2"></i>Agensi
                    </label>
                    <select class="form-select" id="agency_id" name="agency_id">
                        <option value="">Tidak Ditugaskan</option>
                        <?php foreach ($agencies as $agency): ?>
                            <option value="<?= $agency['id'] ?>"
                                    <?= ($manager['agency_id'] == $agency['id']) ? 'selected' : '' ?>>
                                <?= esc($agency['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">
                        <i class="fas fa-toggle-on me-2"></i>Status
                    </label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="active" <?= ($manager['status'] === 'active') ? 'selected' : '' ?>>Aktif</option>
                        <option value="inactive" <?= ($manager['status'] === 'inactive') ? 'selected' : '' ?>>Tidak Aktif</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="/admin/managers" class="btn-cancel">
                        <i class="fas fa-arrow-left me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>