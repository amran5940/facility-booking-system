<?= $this->extend('admin_layout') ?>

<?= $this->section('content') ?>
<style>
    .managers-header {
        background: var(--primary-gradient);
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 15px 35px rgba(52, 152, 219, 0.3);
        position: relative;
        overflow: hidden;
    }

    .managers-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .managers-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .managers-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
        position: relative;
        z-index: 1;
    }

    .manager-card {
        background: white;
        border-radius: 15px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .manager-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-shadow-hover);
    }

    .manager-header {
        background: var(--primary-gradient);
        color: white;
        padding: 1.5rem;
        position: relative;
    }

    .manager-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .manager-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 600;
        margin-right: 1rem;
        position: relative;
        z-index: 1;
    }

    .manager-info h5 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
        position: relative;
        z-index: 1;
    }

    .manager-email {
        opacity: 0.9;
        font-size: 0.9rem;
        position: relative;
        z-index: 1;
    }

    .manager-body {
        padding: 1.5rem;
    }

    .manager-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .detail-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-item i {
        color: #6c757d;
        width: 16px;
    }

    .detail-item span {
        font-size: 0.9rem;
        color: #495057;
    }

    .manager-status {
        display: inline-block;
        padding: 0.375rem 0.875rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        text-transform: uppercase;
    }

    .status-active {
        background: var(--success-gradient);
        color: white;
    }

    .status-inactive {
        background: var(--secondary-gradient);
        color: white;
    }

    .agency-badge {
        background: var(--info-gradient);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-block;
        margin-top: 0.5rem;
    }

    .manager-actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .manager-actions .btn {
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.875rem;
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
        .managers-header {
            padding: 2rem 1.5rem;
        }

        .managers-header h1 {
            font-size: 2rem;
        }

        .manager-details {
            grid-template-columns: 1fr;
        }

        .manager-header {
            padding: 1rem;
        }

        .manager-avatar {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }
    }
</style>

<!-- Header Section -->
<div class="managers-header fade-in-up">
    <h1><i class="fas fa-users-cog me-3"></i>Pengurus</h1>
    <p>Kelola dan pantau semua pengurus dalam sistem</p>
</div>

<!-- Messages -->
<?php if (session()->has('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><?= esc(session('success')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->has('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i><?= esc(session('error')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Managers Grid -->
<div class="row">
    <?php foreach ($managers as $manager): ?>
        <div class="col-lg-6 col-xl-4 fade-in-up">
            <div class="manager-card">
                <div class="manager-header">
                    <div class="d-flex align-items-center">
                        <div class="manager-avatar">
                            <?= strtoupper(substr($manager['full_name'], 0, 1)) ?>
                        </div>
                        <div class="manager-info">
                            <h5><?= esc($manager['full_name']) ?></h5>
                            <div class="manager-email"><?= esc($manager['email']) ?></div>
                        </div>
                    </div>
                </div>

                <div class="manager-body">
                    <div class="manager-details">
                        <div class="detail-item">
                            <i class="fas fa-envelope"></i>
                            <span><strong>Emel:</strong> <?= esc($manager['email']) ?></span>
                        </div>

                        <div class="detail-item">
                            <i class="fas fa-building"></i>
                            <span><strong>Agensi:</strong>
                                <?php if ($manager['agency_id']): ?>
                                    <?php
                                    $agencyModel = new \App\Models\AgencyModel();
                                    $agency = $agencyModel->find($manager['agency_id']);
                                    echo esc($agency['name'] ?? 'Tidak Diketahui');
                                    ?>
                                <?php else: ?>
                                    Tidak Ditugaskan
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="manager-status status-<?= strtolower($manager['status']) ?>">
                                <?= esc($manager['status'] === 'active' ? 'Aktif' : 'Tidak Aktif') ?>
                            </span>
                            <?php if ($manager['agency_id']): ?>
                                <?php
                                $agencyModel = new \App\Models\AgencyModel();
                                $agency = $agencyModel->find($manager['agency_id']);
                                ?>
                                <div class="agency-badge mt-1">
                                    <i class="fas fa-tag me-1"></i>
                                    <?= esc($agency['name'] ?? 'Tidak Diketahui') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="manager-actions">
                            <a href="/admin/managers/<?= $manager['id'] ?>/edit" class="btn btn-sm btn-outline-primary me-2" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <?php if (!$manager['agency_id']): ?>
                                <form action="/admin/managers/<?= $manager['id'] ?>/delete" method="post" class="d-inline"
                                      onsubmit="return confirm('Adakah anda pasti mahu memadam pengurus ini?')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            <?php else: ?>
                                <button type="button" class="btn btn-sm btn-outline-secondary" disabled title="Pengurus perlu dinyah tugaskan daripada agensi terlebih dahulu">
                                    <i class="fas fa-trash"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>