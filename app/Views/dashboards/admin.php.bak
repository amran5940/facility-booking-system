<?= $this->extend('admin_layout') ?>

<?= $this->section('content') ?>
<style>
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(102, 126, 234, 0.4);
    }

    .stats-card.success {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        box-shadow: 0 10px 30px rgba(245, 87, 108, 0.3);
    }

    .stats-card.success:hover {
        box-shadow: 0 20px 40px rgba(245, 87, 108, 0.4);
    }

    .stats-card.info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        box-shadow: 0 10px 30px rgba(79, 172, 254, 0.3);
    }

    .stats-card.info:hover {
        box-shadow: 0 20px 40px rgba(79, 172, 254, 0.4);
    }

    .stats-card.warning {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        box-shadow: 0 10px 30px rgba(67, 233, 123, 0.3);
    }

    .stats-card.warning:hover {
        box-shadow: 0 20px 40px rgba(67, 233, 123, 0.4);
    }

    .stats-card .card-body {
        padding: 2.25rem;
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
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .stats-card .stat-title {
        font-size: 0.95rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
        opacity: 0.9;
    }

    .stats-card .stat-subtitle {
        font-size: 0.8rem;
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
        padding: 1.75rem;
    }

    .chart-card .card-header h5 {
        margin: 0;
        font-weight: 600;
        color: #2c3e50;
        font-size: 1.1rem;
    }

    .quick-actions-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        border: none;
        color: white;
        overflow: hidden;
    }

    .quick-actions-card .card-body {
        padding: 2.25rem;
    }

    .quick-actions-card .btn {
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
        border-radius: 25px;
        padding: 0.875rem 1.75rem;
        margin: 0.25rem;
        transition: all 0.3s ease;
        font-weight: 500;
        font-size: 0.95rem;
        min-height: 44px;
        line-height: 1.4;
    }

    .quick-actions-card .btn:hover {
        background: rgba(255,255,255,0.3);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .overview-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 20px;
        border: none;
        color: #2c3e50;
        overflow: hidden;
    }

    .overview-card .card-body {
        padding: 2.25rem;
    }

    .overview-metric {
        text-align: center;
        padding: 1rem;
        border-radius: 15px;
        margin: 0.5rem;
        color: white;
    }

    .overview-metric.primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .overview-metric.success {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .overview-metric.info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .overview-metric.warning {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }

    .overview-metric h4 {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .overview-metric small {
        opacity: 0.8;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .welcome-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 2.25rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .welcome-section h1 {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .welcome-section p {
        font-size: 1rem;
        opacity: 0.9;
        line-height: 1.5;
    }
        opacity: 0.9;
        margin-bottom: 0;
    }

    .progress-custom {
        height: 8px;
        border-radius: 4px;
        background: rgba(255,255,255,0.2);
    }

    .progress-custom .progress-bar {
        background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
        border-radius: 4px;
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
            <h1><i class="fas fa-chart-line me-3"></i><?= lang('App.admin_dashboard') ?></h1>
            <p>Kawal dan pantau sistem tempahan fasiliti dengan mudah. Dapatkan gambaran keseluruhan prestasi sistem anda.</p>
        </div>
        <div class="col-lg-4 text-end">
            <i class="fas fa-crown" style="font-size: 4rem; opacity: 0.3;"></i>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4 stagger-animation">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-title"><?= lang('App.total_users') ?></div>
                <div class="stat-number"><?= number_format($total_users) ?></div>
                <div class="stat-subtitle">Pengguna Berdaftar</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card success">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div class="stat-title"><?= lang('App.total_agencies') ?></div>
                <div class="stat-number"><?= number_format($total_agencies) ?></div>
                <div class="stat-subtitle">Agensi Aktif</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card info">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="stat-title"><?= lang('App.total_managers') ?></div>
                <div class="stat-number"><?= number_format($total_managers) ?></div>
                <div class="stat-subtitle">Ditugaskan: <?= $assigned_managers ?> | Tidak: <?= $unassigned_managers ?></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card warning">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="stat-title"><?= lang('App.total_facilities') ?></div>
                <div class="stat-number"><?= number_format($total_facilities) ?></div>
                <div class="stat-subtitle">Aktif: <?= $active_facilities ?> | Tidak Aktif: <?= $inactive_facilities ?></div>
            </div>
        </div>
    </div>
</div>

<!-- Additional Statistics -->
<div class="row mb-4">
    <div class="col-lg-6 mb-4">
        <div class="card chart-card">
            <div class="card-header">
                <h5><i class="fas fa-chart-pie me-2"></i>Statistik Tempahan</h5>
            </div>
            <div class="card-body">
                <div class="row text-center mb-3">
                    <div class="col-6">
                        <h4 class="text-primary mb-1"><?= number_format($recent_bookings) ?></h4>
                        <small class="text-muted">Tempahan 30 Hari</small>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success mb-1"><?= number_format($recent_bookings / 30, 1) ?></h4>
                        <small class="text-muted">Purata Harian</small>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Kadar Fasiliti Aktif</span>
                        <span class="badge bg-primary"><?= number_format(($total_facilities > 0 ? ($active_facilities / $total_facilities) * 100 : 0), 1) ?>%</span>
                    </div>
                    <div class="progress progress-custom">
                        <div class="progress-bar" style="width: <?= $total_facilities > 0 ? ($active_facilities / $total_facilities) * 100 : 0 ?>%"></div>
                    </div>
                </div>
                <div class="text-center">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Sistem berjalan dengan baik dengan kadar aktiviti yang tinggi
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card chart-card">
            <div class="card-header">
                <h5><i class="fas fa-tags me-2"></i>Taburan Fasiliti Mengikut Kategori</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($facility_stats)): ?>
                    <div class="mb-3">
                        <?php
                        $colors = ['#667eea', '#764ba2', '#f093fb', '#f5576c', '#4facfe', '#00f2fe', '#43e97b', '#38f9d7'];
                        $total = array_sum(array_column($facility_stats, 'count'));
                        ?>
                        <?php foreach ($facility_stats as $index => $stat): ?>
                            <?php
                            $percentage = $total > 0 ? ($stat['count'] / $total) * 100 : 0;
                            $color = $colors[$index % count($colors)];
                            ?>
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="fw-medium"><?= esc($stat['category_name']) ?></span>
                                        <span class="badge" style="background-color: <?= $color ?>; color: white;">
                                            <?= $stat['count'] ?> (<?= number_format($percentage, 1) ?>%)
                                        </span>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar" style="background-color: <?= $color ?>; width: <?= $percentage ?>%"></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Tiada data kategori fasiliti</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- System Overview -->
<div class="row">
    <div class="col-12">
        <div class="card overview-card">
            <div class="card-body">
                <h5 class="mb-4 text-center"><i class="fas fa-chart-bar me-2"></i>Gambaran Sistem</h5>
                <div class="row text-center">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="overview-metric primary">
                            <h4><?= number_format(($total_managers > 0 ? ($assigned_managers / $total_managers) * 100 : 0), 1) ?>%</h4>
                            <small>Kadar Tugasan Pengurus</small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="overview-metric success">
                            <h4><?= number_format(($total_facilities > 0 ? ($active_facilities / $total_facilities) * 100 : 0), 1) ?>%</h4>
                            <small>Kadar Fasiliti Aktif</small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="overview-metric info">
                            <h4><?= number_format($total_facilities / max($total_agencies, 1), 1) ?></h4>
                            <small>Purata Fasiliti per Agensi</small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="overview-metric warning">
                            <h4><?= number_format($recent_bookings / 30, 1) ?></h4>
                            <small>Purata Tempahan Harian</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Add animation on page load
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.stats-card, .chart-card, .quick-actions-card, .overview-card');
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