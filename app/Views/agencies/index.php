<?= $this->extend('admin_layout') ?>

<?= $this->section('content') ?>
<style>
    .agencies-header {
        background: var(--primary-gradient);
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }

    .agencies-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .agencies-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .agencies-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
        position: relative;
        z-index: 1;
    }

    .action-buttons-section {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .btn-action-group {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .btn-action-group .btn {
        flex: 1;
        min-width: 160px;
        justify-content: center;
        padding: 0.75rem 1.25rem;
        font-size: 0.9rem;
    }

    .btn-modern {
        background: var(--primary-gradient);
        border: none;
        border-radius: 12px;
        padding: 0.875rem 1.5rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-modern-success {
        background: var(--success-gradient);
        box-shadow: 0 4px 15px rgba(240, 147, 251, 0.3);
    }

    .btn-modern-success:hover {
        box-shadow: 0 8px 25px rgba(240, 147, 251, 0.4);
    }

    .agency-card {
        background: white;
        border-radius: 15px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .agency-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-shadow-hover);
    }

    .agency-header {
        background: var(--info-gradient);
        color: white;
        padding: 1.5rem;
        position: relative;
    }

    .agency-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .agency-header h5 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
        position: relative;
        z-index: 1;
    }

    .agency-status {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        position: relative;
        z-index: 1;
    }

    .status-active {
        background: rgba(255,255,255,0.2);
        color: white;
    }

    .status-inactive {
        background: rgba(255,255,255,0.3);
        color: white;
    }

    .agency-body {
        padding: 1.5rem;
    }

    .manager-info {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .manager-info h6 {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        font-weight: 600;
    }

    .manager-name {
        font-weight: 600;
        color: #2c3e50;
    }

    .agency-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-icon-label {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.5rem 0.875rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-icon-label i {
        font-size: 0.75rem;
    }

    .btn-icon-label small {
        font-size: 0.7rem;
        opacity: 0.9;
    }

    .btn-edit {
        background: var(--warning-gradient);
        color: white;
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        color: white;
        transform: translateY(-1px);
    }

    .btn-delete {
        background: var(--danger-gradient);
        color: white;
    }

    .btn-delete:hover {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
        transform: translateY(-1px);
    }

    .btn-assign {
        background: var(--primary-gradient);
        color: white;
    }

    .btn-assign:hover {
        background: linear-gradient(135deg, #5dade2 0%, #3498db 100%);
        color: white;
        transform: translateY(-1px);
    }

    .btn-unassign {
        background: var(--dark-gradient);
        color: white;
    }

    .btn-unassign:hover {
        background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%);
        color: white;
        transform: translateY(-1px);
    }

    .manager-select {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        font-size: 0.85rem;
        background: white;
        min-width: 180px;
        transition: border-color 0.3s ease;
        margin-bottom: 0.5rem;
    }

    .manager-select:focus {
        border-color: #3498db;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }

    .assignment-form {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        width: 100%;
    }

    .alert-modern {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.25rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin-bottom: 1.5rem;
    }

    .create-manager-section {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-top: 1rem;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .form-modern .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .form-modern .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .form-modern .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
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
        .agencies-header {
            padding: 2rem 1.5rem;
        }

        .agencies-header h1 {
            font-size: 2rem;
        }

        .btn-action-group {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-action-group .btn {
            flex: none;
            min-width: unset;
            width: 100%;
        }

        .agency-actions {
            gap: 0.75rem;
        }

        .action-row {
            flex-direction: column;
            gap: 0.75rem;
        }

        .manager-assignment-section {
            padding: 0.75rem;
        }

        .manager-select {
            min-width: 100%;
            margin-bottom: 0.5rem;
        }

        .btn-icon-label {
            justify-content: center;
            min-width: 120px;
        }

        .assignment-form {
            flex-direction: column;
            align-items: stretch;
        }

        .assignment-form .manager-select {
            margin-bottom: 0.5rem;
        }
    }
    }
</style>
<div class="agencies-header fade-in-up">
    <h1><i class="fas fa-building me-3"></i>Pengurusan Agensi</h1>
    <p>Kelola semua agensi dan pengurus dalam sistem tempahan fasiliti</p>
</div>

<!-- Action Buttons Section -->
<div class="action-buttons-section fade-in-up">
    <div class="btn-action-group">
        <a href="/admin/agencies/create" class="btn btn-modern">
            <i class="fas fa-plus-circle"></i>
            <span>Tambah Agensi Baharu</span>
        </a>
        <button class="btn btn-modern-success" type="button" data-bs-toggle="collapse" data-bs-target="#createManager" aria-expanded="false" aria-controls="createManager">
            <i class="fas fa-user-tie"></i>
            <span>Daftar Pengurus Baharu</span>
        </button>
    </div>
</div>

<!-- Alerts -->
<?php if (session('success')): ?>
    <div class="alert alert-success alert-modern fade-in-up">
        <i class="fas fa-check-circle me-2"></i><?= session('success') ?>
    </div>
<?php endif; ?>
<?php if (session('error')): ?>
    <div class="alert alert-danger alert-modern fade-in-up">
        <i class="fas fa-exclamation-triangle me-2"></i><?= session('error') ?>
    </div>
<?php endif; ?>

<!-- Create Manager Collapse Section -->
<div class="collapse fade-in-up" id="createManager">
    <div class="create-manager-section">
        <h5 class="mb-4"><i class="fas fa-user-plus me-2"></i>Daftar Pengurus Baharu</h5>
        <form method="post" action="/admin/managers" class="form-modern">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Emel</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Kata Laluan</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="full_name" class="form-label">Nama Penuh</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="agency_id" class="form-label">Tugaskan kepada Agensi</label>
                    <select class="form-control" id="agency_id" name="agency_id">
                        <option value="">Tiada Agensi</option>
                        <?php foreach ($agencies as $agency): ?>
                            <option value="<?= $agency['id'] ?>"><?= esc($agency['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-modern-success">
                <i class="fas fa-user-check me-2"></i>Cipta Pengurus
            </button>
        </form>
    </div>
</div>

<!-- Agencies Grid -->
<div class="row">
    <?php foreach ($agencies as $agency): ?>
        <?php
        $assignedManager = null;
        foreach ($managers as $mgr) {
            if ($mgr['agency_id'] == $agency['id']) {
                $assignedManager = $mgr;
                break;
            }
        }
        ?>
        <div class="col-lg-6 col-xl-4 fade-in-up">
            <div class="agency-card">
                <div class="agency-header">
                    <h5><i class="fas fa-building me-2"></i><?= esc($agency['name']) ?></h5>
                    <span class="agency-status status-<?= strtolower($agency['status']) ?>">
                        <?= esc($agency['status']) ?>
                    </span>
                </div>
                <div class="agency-body">
                    <div class="manager-info">
                        <h6><i class="fas fa-user-tie me-1"></i>Pengurus</h6>
                        <div class="manager-name">
                            <?= $assignedManager ? esc($assignedManager['full_name']) : '<em class="text-muted">Tidak ditugaskan</em>' ?>
                        </div>
                    </div>

                    <div class="agency-actions">
                        <!-- Basic Actions Row -->
                        <div class="action-row">
                            <a href="/admin/agencies/<?= $agency['id'] ?>/edit" class="btn-icon-label btn-edit">
                                <i class="fas fa-edit"></i>
                                <small>Edit</small>
                            </a>

                            <form method="post" action="/admin/agencies/<?= $agency['id'] ?>/delete" class="d-inline" onsubmit="return confirm('Adakah anda pasti mahu memadam agensi ini?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn-icon-label btn-delete">
                                    <i class="fas fa-trash"></i>
                                    <small>Padam</small>
                                </button>
                            </form>
                        </div>

                        <!-- Manager Assignment Section -->
                        <div class="manager-assignment-section">
                            <div class="action-row">
                                <?php if ($assignedManager): ?>
                                    <!-- Show unassign option when manager is assigned -->
                                    <form method="post" action="/admin/agencies/<?= $agency['id'] ?>/unassign" class="d-inline" onsubmit="return confirm('Adakah anda pasti mahu menarik tugasan pengurus ini?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn-icon-label btn-unassign">
                                            <i class="fas fa-user-minus"></i>
                                            <small>Tarik</small>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <!-- Show assignment form when no manager is assigned -->
                                    <form method="post" action="/admin/agencies/<?= $agency['id'] ?>/assign" class="d-inline assignment-form">
                                        <?= csrf_field() ?>
                                        <select name="manager_id" class="manager-select">
                                            <option value="">Pilih Pengurus</option>
                                            <?php foreach ($managers as $manager): ?>
                                                <option value="<?= $manager['id'] ?>" <?= $manager['agency_id'] == $agency['id'] ? 'selected' : '' ?>>
                                                    <?= esc($manager['full_name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="btn-icon-label btn-assign">
                                            <i class="fas fa-user-plus"></i>
                                            <small>Tugaskan</small>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>