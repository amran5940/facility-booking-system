<?= $this->extend('manager_layout') ?>

<?= $this->section('content') ?>
<style>
    :root {
        --primary: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        --success: linear-gradient(135deg, #14b8a6 0%, #2dd4bf 100%);
        --warning: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
        --danger: linear-gradient(135deg, #e11d48 0%, #f43f5e 100%);
        --info: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    }

    .stats-card {
        background: var(--primary);
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 30px rgba(30, 58, 138, 0.25);
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(30, 58, 138, 0.35);
    }

    .stats-card.success {
        background: var(--success);
        box-shadow: 0 10px 30px rgba(20, 184, 166, 0.25);
    }

    .stats-card.success:hover {
        box-shadow: 0 20px 40px rgba(20, 184, 166, 0.35);
    }

    .stats-card.info {
        background: var(--info);
        box-shadow: 0 10px 30px rgba(99, 102, 241, 0.25);
    }

    .stats-card.info:hover {
        box-shadow: 0 20px 40px rgba(99, 102, 241, 0.35);
    }

    .stats-card.warning {
        background: var(--warning);
        box-shadow: 0 10px 30px rgba(245, 158, 11, 0.25);
    }

    .stats-card.warning:hover {
        box-shadow: 0 20px 40px rgba(245, 158, 11, 0.35);
    }

    .stats-card .card-body {
        padding: 2rem;
        color: white;
        position: relative;
        z-index: 2;
    }

    .stats-card .stat-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 3rem;
        opacity: 0.3;
    }

    .stats-card .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .stats-card .stat-title {
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
        opacity: 0.9;
    }

    .stats-card .stat-subtitle {
        font-size: 0.75rem;
        opacity: 0.8;
    }

    .chart-card {
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .chart-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .chart-card .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid rgba(0,0,0,0.1);
        padding: 1.5rem;
    }

    .chart-card .card-header h5 {
        margin: 0;
        font-weight: 600;
        color: #2c3e50;
    }

    .agency-card {
        background: var(--primary);
        border-radius: 20px;
        border: none;
        color: white;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(30, 58, 138, 0.25);
    }

    .agency-card .card-body {
        padding: 2rem;
    }

    .quick-actions-card {
        background: var(--info);
        border-radius: 20px;
        border: none;
        color: white;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(99, 102, 241, 0.25);
    }

    .quick-actions-card .card-body {
        padding: 2rem;
    }

    .quick-actions-card .btn {
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
        border-radius: 25px;
        padding: 0.75rem 1.5rem;
        margin: 0.25rem;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .quick-actions-card .btn:hover {
        background: rgba(255,255,255,0.3);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .welcome-section {
        background: var(--primary);
        border-radius: 20px;
        padding: 2rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(30, 58, 138, 0.25);
    }

    .welcome-section h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .welcome-section p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
    }

    .table-modern {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .table-modern thead th {
        background: var(--primary);
        color: white;
        border: none;
        padding: 1rem;
        font-weight: 600;
    }

    .table-modern tbody tr {
        transition: all 0.3s ease;
    }

    .table-modern tbody tr:hover {
        background: rgba(30, 58, 138, 0.05);
        transform: scale(1.01);
    }

    .badge-modern {
        border-radius: 20px;
        padding: 0.5rem 1rem;
        font-weight: 500;
    }

    .unassign-btn {
        background: var(--danger);
        border: none;
        border-radius: 25px;
        padding: 0.5rem 1rem;
        color: white;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(225, 29, 72, 0.25);
    }

    .unassign-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(225, 29, 72, 0.35);
    }

    .assign-btn {
        background: var(--warning);
        border: none;
        border-radius: 20px;
        padding: 0.4rem 0.8rem;
        color: #111217;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(245, 158, 11, 0.25);
    }

    .assign-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(245, 158, 11, 0.35);
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

    .fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

    .stagger-animation > * {
        animation: fadeInUp 0.6s ease-out;
    }

    .stagger-animation > *:nth-child(1) { animation-delay: 0.1s; }
    .stagger-animation > *:nth-child(2) { animation-delay: 0.2s; }
    .stagger-animation > *:nth-child(3) { animation-delay: 0.3s; }
    .stagger-animation > *:nth-child(4) { animation-delay: 0.4s; }
</style>

<!-- Welcome Section -->
<div class="welcome-section fade-in-up">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <h1><i class="fas fa-user-tie me-3"></i>Papan Pemuka Pengurus</h1>
            <p>Kawal dan urus fasiliti serta tempahan untuk agensi anda dengan mudah.</p>
        </div>
        <div class="col-lg-4 text-end">
            <i class="fas fa-building" style="font-size: 4rem; opacity: 0.3;"></i>
        </div>
    </div>
</div>

<?php if ($agency): ?>
    <!-- Agency Info Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="agency-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h4 class="mb-1"><i class="fas fa-building me-2"></i>Agensi: <?= esc($agency['name']) ?></h4>
                            <p class="mb-0 opacity-75">Anda bertanggungjawab untuk mengurus fasiliti dan tempahan agensi ini.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <!-- No Agency Warning -->
    <div class="alert alert-warning fade-in-up" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Tiada Agensi Ditugaskan:</strong> Anda belum ditugaskan kepada mana-mana agensi. Sila hubungi admin untuk penugasan.
    </div>
<?php endif; ?>

<!-- Statistics Cards -->
<div class="row mb-4 stagger-animation">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div class="stat-title">Jumlah Fasiliti</div>
                <div class="stat-number"><?= number_format($total_facilities) ?></div>
                <div class="stat-subtitle">Aktif: <?= $active_facilities ?> | Tidak Aktif: <?= $inactive_facilities ?></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card success">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-title">Jumlah Tempahan</div>
                <div class="stat-number"><?= number_format($total_bookings) ?></div>
                <div class="stat-subtitle">Menunggu: <?= $pending_bookings ?> | Diluluskan: <?= $approved_bookings ?></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card info">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="fas fa-percentage"></i>
                </div>
                <div class="stat-title">Kadar Kelulusan</div>
                <div class="stat-number"><?= number_format($total_bookings > 0 ? ($approved_bookings / $total_bookings) * 100 : 0, 1) ?>%</div>
                <div class="stat-subtitle">Daripada semua tempahan</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card warning">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-title">Kadar Fasiliti Aktif</div>
                <div class="stat-number"><?= number_format($total_facilities > 0 ? ($active_facilities / $total_facilities) * 100 : 0, 1) ?>%</div>
                <div class="stat-subtitle">Fasiliti tersedia</div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Bookings & User Assignment -->
<div class="row mb-4">
    <div class="col-lg-8 mb-4">
        <div class="card chart-card">
            <div class="card-header">
                <h5><i class="fas fa-clock me-2"></i>Tempahan Terkini (7 Hari)</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_bookings)): ?>
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-user me-1"></i>Pengguna</th>
                                    <th><i class="fas fa-building me-1"></i>Fasiliti</th>
                                    <th><i class="fas fa-calendar me-1"></i>Tarikh Mula</th>
                                    <th><i class="fas fa-calendar me-1"></i>Tarikh Tamat</th>
                                    <th><i class="fas fa-info-circle me-1"></i>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($recent_bookings, 0, 5) as $booking): ?>
                                    <tr>
                                        <td><strong><?= esc($booking['user_name']) ?></strong></td>
                                        <td><?= esc($booking['facility_name']) ?></td>
                                        <td><?= esc(date('d/m/Y', strtotime($booking['start_date']))) ?></td>
                                        <td><?= esc(date('d/m/Y', strtotime($booking['end_date']))) ?></td>
                                        <td>
                                            <span class="badge badge-modern bg-<?= $booking['status'] === 'approved' ? 'success' : ($booking['status'] === 'rejected' ? 'danger' : 'warning') ?>">
                                                <i class="fas fa-<?= $booking['status'] === 'approved' ? 'check' : ($booking['status'] === 'rejected' ? 'times' : 'clock') ?> me-1"></i>
                                                <?= esc(ucfirst($booking['status'])) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (count($recent_bookings) > 5): ?>
                        <div class="text-center mt-3">
                            <a href="/manager/bookings" class="btn btn-outline-primary">
                                <i class="fas fa-eye me-2"></i>Lihat Semua Tempahan
                            </a>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Tiada tempahan terkini</h5>
                        <p class="text-muted">Tempahan terkini akan dipaparkan di sini</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card chart-card">
            <div class="card-header">
                <h5><i class="fas fa-users me-2"></i>Tugaskan Pengguna</h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">Pilih pengguna awam untuk ditugaskan kepada agensi ini.</p>
                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-sm">
                        <thead style="position: sticky; top: 0; background: white; z-index: 1;">
                            <tr>
                                <th>Pengguna</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($public_users as $user): ?>
                                <tr>
                                    <td>
                                        <div>
                                            <strong><?= esc($user['email']) ?></strong><br>
                                            <small class="text-muted"><?= esc($user['full_name']) ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <form method="post" action="/manager/assign-user/<?= $user['id'] ?>" class="d-inline" onsubmit="return confirm('Adakah anda pasti mahu tugaskan pengguna ini kepada agensi?')">
                                            <button type="submit" class="assign-btn">
                                                <i class="fas fa-plus me-1"></i>Tugaskan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (empty($public_users)): ?>
                    <div class="text-center py-3">
                        <i class="fas fa-users-slash fa-2x text-muted mb-2"></i>
                        <p class="text-muted small">Tiada pengguna awam tersedia untuk ditugaskan.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card quick-actions-card">
            <div class="card-body">
                <h5 class="mb-3"><i class="fas fa-bolt me-2"></i>Tindakan Pantas</h5>
                <div class="d-flex flex-wrap justify-content-center">
                    <a href="/manager/facilities/create" class="btn">
                        <i class="fas fa-plus me-2"></i>Tambah Fasiliti
                    </a>
                    <a href="/manager/facilities" class="btn">
                        <i class="fas fa-building me-2"></i>Urus Fasiliti
                    </a>
                    <a href="/manager/bookings" class="btn">
                        <i class="fas fa-calendar-check me-2"></i>Urus Tempahan
                    </a>
                    <a href="/manager/bookings?status=pending" class="btn">
                        <i class="fas fa-clock me-2"></i>Lulus Tempahan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Add animation on page load
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.stats-card, .chart-card, .agency-card, .quick-actions-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>

<?= $this->endSection() ?>