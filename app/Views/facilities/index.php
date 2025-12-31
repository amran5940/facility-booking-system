<?php
$user = $user ?? session('user');
$layout = ($user['role'] === 'manager') ? 'manager_layout' : 'layout';
?>
<?= $this->extend($layout) ?>
<?= $this->section('content') ?>

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --danger-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --card-shadow: 0 10px 30px rgba(0,0,0,0.1);
        --card-shadow-hover: 0 20px 40px rgba(0,0,0,0.15);
    }


    .facilities-header {
        background: var(--primary-gradient);
        border-radius: 25px;
        padding: 3rem 2rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }

    .facilities-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 400px;
        height: 400px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        animation: pulse 4s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.3; }
    }

    .facilities-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .facilities-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
        position: relative;
        z-index: 2;
    }

    .action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-add-facility {
        background: var(--success-gradient);
        color: white;
        padding: 0.875rem 2rem;
        border-radius: 15px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        box-shadow: 0 10px 25px rgba(17, 153, 142, 0.3);
        transition: all 0.3s ease;
        border: none;
    }

    .btn-add-facility:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(17, 153, 142, 0.4);
        color: white;
    }

    .search-box {
        position: relative;
        flex: 1;
        max-width: 400px;
    }

    .search-box input {
        width: 100%;
        padding: 0.875rem 1.25rem 0.875rem 3rem;
        border: 2px solid #e9ecef;
        border-radius: 15px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .search-box input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        outline: none;
    }

    .search-box i {
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        color: #667eea;
    }

    .facilities-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .facility-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0,0,0,0.05);
        position: relative;
    }

    .facility-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--card-shadow-hover);
    }

    .facility-card-header {
        background: var(--primary-gradient);
        padding: 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .facility-card-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .facility-icon {
        width: 58px;
        height: 58px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        margin-bottom: 0.75rem;
        backdrop-filter: blur(10px);
        position: relative;
        z-index: 2;
    }

    .facility-name {
        font-size: 1.35rem;
        font-weight: 700;
        margin-bottom: 0.35rem;
        position: relative;
        z-index: 2;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .facility-category {
        display: inline-block;
        background: rgba(255,255,255,0.25);
        padding: 0.375rem 0.875rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        position: relative;
        z-index: 2;
        backdrop-filter: blur(10px);
    }

    .facility-card-body {
        padding: 1.25rem;
    }

    .facility-info {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .info-item i {
        width: 35px;
        height: 35px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #667eea;
        flex-shrink: 0;
    }

    .info-item strong {
        color: #2c3e50;
        font-weight: 600;
    }

    .facility-description {
        color: #6c757d;
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .facility-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-active {
        background: var(--success-gradient);
        color: white;
        box-shadow: 0 5px 15px rgba(17, 153, 142, 0.3);
    }

    .status-inactive {
        background: var(--danger-gradient);
        color: white;
        box-shadow: 0 5px 15px rgba(250, 112, 154, 0.3);
    }

    .facility-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.5rem;
        padding-top: 1.5rem;
        border-top: 2px solid #f8f9fa;
    }

    .facility-actions .btn-delete {
        grid-column: 1 / -1;
    }

    .btn-action {
        padding: 0.75rem 1rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        text-align: center;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-edit {
        background: var(--warning-gradient);
        color: white;
        box-shadow: 0 5px 15px rgba(240, 147, 251, 0.3);
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(240, 147, 251, 0.4);
        color: white;
    }

    .btn-delete {
        background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
        color: white;
        box-shadow: 0 5px 15px rgba(245, 87, 108, 0.3);
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(245, 87, 108, 0.4);
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
    }

    .empty-state i {
        font-size: 5rem;
        color: #e9ecef;
        margin-bottom: 1.5rem;
    }

    .empty-state h3 {
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #adb5bd;
        margin-bottom: 2rem;
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

    .stagger-animation > * {
        opacity: 0;
        animation: fadeInUp 0.6s ease-out forwards;
    }

    .agency-toggle {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .agency-toggle .form-check-input {
        width: 2.5rem;
        height: 1.25rem;
        border-radius: 1.25rem;
        background: #e9ecef;
        border: none;
        transition: all 0.3s ease;
    }

    .agency-toggle .form-check-input:checked {
        background: var(--primary-gradient);
    }

    .agency-toggle .form-check-input:focus {
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .agency-toggle .form-check-label {
        font-weight: 600;
        color: #495057;
        cursor: pointer;
    }

    .agency-toggle small {
        color: #6c757d;
        font-size: 0.85rem;
    }

    @media (max-width: 768px) {
        .facilities-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .facilities-header {
            padding: 2rem 1.5rem;
        }

        .facilities-header h1 {
            font-size: 2rem;
        }

        .action-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .search-box {
            max-width: 100%;
        }
    }

    /* Collapsible Sections */
    .facilities-section {
        margin-bottom: 3rem;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: white;
        border-radius: 15px;
        padding: 1.5rem 2rem;
        margin-bottom: 1rem;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.05);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .section-header:hover {
        transform: translateY(-2px);
        box-shadow: var(--card-shadow-hover);
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .facility-count {
        background: var(--primary-gradient);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-left: 0.5rem;
    }

    .btn-toggle {
        background: none;
        border: none;
        color: #667eea;
        font-size: 1.25rem;
        padding: 0.5rem;
        border-radius: 10px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
    }

    .btn-toggle:hover {
        background: rgba(102, 126, 234, 0.1);
        transform: scale(1.1);
    }

    .btn-toggle.collapsed .fas {
        transform: rotate(180deg);
    }

    .section-content {
        overflow: hidden;
        transition: all 0.3s ease;
        max-height: 5000px;
        opacity: 1;
    }

    .section-content.collapsed {
        max-height: 0;
        opacity: 0;
        margin-top: 0;
    }

    .facility-agency {
        background: rgba(255, 193, 7, 0.1);
        color: #856404;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-top: 0.5rem;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
</style>

<div class="container">
    <!-- Header Section -->
    <div class="facilities-header fade-in-up">
        <?php if ($user['role'] === 'manager'): ?>
            <h1><i class="fas fa-building me-3"></i>Pengurusan Fasiliti</h1>
            <p>Urus dan pantau semua fasiliti agensi anda</p>
        <?php else: ?>
            <h1><i class="fas fa-search me-3"></i>Semua Fasiliti</h1>
            <p>Cari dan tempah fasiliti yang tersedia</p>
        <?php endif; ?>
    </div>

    <!-- Action Bar -->
    <div class="action-bar fade-in-up">
        <?php if ($user['role'] === 'manager'): ?>
            <a href="/manager/facilities/create" class="btn-add-facility">
                <i class="fas fa-plus-circle"></i>
                Tambah Fasiliti Baharu
            </a>
        <?php endif; ?>
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Cari fasiliti...">
        </div>
    </div>

    <?php if ($user['role'] === 'user'): ?>
    <!-- Agency Facilities Toggle -->
    <div class="agency-toggle fade-in-up">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="showAgencyFacilities" checked>
            <label class="form-check-label" for="showAgencyFacilities">
                <i class="fas fa-building me-1"></i>
                Tunjukkan Fasiliti Agensi
            </label>
        </div>
        <small class="text-muted">Sembunyikan/tunjukkan fasiliti yang disediakan oleh agensi</small>
    </div>
    <?php endif; ?>
    <?php if (session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show fade-in-up" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if (session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show fade-in-up" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?= session('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Facilities Display -->
    <?php if (empty($facilities)): ?>
        <div class="empty-state fade-in-up">
            <i class="fas fa-building"></i>
            <h3>Tiada Fasiliti</h3>
            <p>
                <?php if ($user['role'] === 'manager'): ?>
                    Anda belum mempunyai sebarang fasiliti. Tambah fasiliti baharu untuk bermula.
                <?php else: ?>
                    Tiada fasiliti tersedia buat masa ini.
                <?php endif; ?>
            </p>
            <?php if ($user['role'] === 'manager'): ?>
                <a href="/manager/facilities/create" class="btn-add-facility">
                    <i class="fas fa-plus-circle"></i>
                    Tambah Fasiliti Pertama
                </a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <?php if ($user['role'] === 'user'): ?>
            <?php
            // Group facilities by type for users
            $publicFacilities = [];
            $agencyFacilities = [];
            foreach ($facilities as $facility) {
                if ($facility['facility_type'] === 'public') {
                    $publicFacilities[] = $facility;
                } else {
                    $agencyFacilities[] = $facility;
                }
            }
            ?>

            <!-- Public Facilities Section (Collapsible) -->
            <?php if (!empty($publicFacilities)): ?>
            <div class="facilities-section fade-in-up">
                <div class="section-header" onclick="toggleSection('public-section')">
                    <h2 class="section-title">
                        <i class="fas fa-globe me-2"></i>
                        Fasiliti Awam
                        <span class="facility-count">(<?= count($publicFacilities) ?> fasiliti)</span>
                    </h2>
                    <button class="btn-toggle" id="public-toggle-btn">
                        <i class="fas fa-chevron-up"></i>
                    </button>
                </div>
                <div class="section-content" id="public-section">
                    <div class="facilities-grid stagger-animation">
                        <?php foreach ($publicFacilities as $facility): ?>
                            <div class="facility-card" data-facility-name="<?= strtolower(esc($facility['name'])) ?>" data-facility-category="<?= strtolower(esc($facility['category_name'])) ?>" data-facility-type="public">
                                <div class="facility-card-header">
                                    <?php if ($facility['primary_image']): ?>
                                        <div style="position: relative;">
                                            <img src="/images/facility/<?= $facility['primary_image']['id'] ?>" alt="<?= esc($facility['name']) ?>" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 1rem; cursor: pointer;" onclick="viewFacilityImages(<?= $facility['id'] ?>, '<?= esc($facility['name']) ?>')">
                                            <?php if ($facility['image_count'] > 1): ?>
                                            <div style="position: absolute; bottom: 1rem; right: 1rem; background: rgba(0,0,0,0.7); color: white; padding: 0.5rem 0.75rem; border-radius: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer;" onclick="viewFacilityImages(<?= $facility['id'] ?>, '<?= esc($facility['name']) ?>')">
                                                +<?= $facility['image_count'] - 1 ?> <i class="fas fa-images"></i>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="facility-icon">
                                            <i class="fas fa-building"></i>
                                        </div>
                                    <?php endif; ?>
                                    <h3 class="facility-name"><?= esc($facility['name']) ?></h3>
                                    <span class="facility-category">
                                        <i class="fas fa-tag me-1"></i>
                                        <?= esc($facility['category_name']) ?>
                                    </span>
                                </div>

                                <div class="facility-card-body">
                                    <div class="facility-info">
                                        <div class="info-item">
                                            <i class="fas fa-info-circle"></i>
                                            <span><strong>Jenis:</strong> <?= esc($facility['type']) ?></span>
                                        </div>
                                        <div class="info-item">
                                            <i class="fas fa-users"></i>
                                            <span><strong>Kapasiti:</strong> <?= esc($facility['capacity']) ?> orang</span>
                                        </div>
                                        <div class="info-item">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span><strong>Lokasi:</strong> <?= esc($facility['location'] ?: 'Tiada maklumat') ?></span>
                                        </div>
                                    </div>

                                    <?php if ($facility['description']): ?>
                                        <div class="facility-description">
                                            <i class="fas fa-quote-left me-2" style="color: #667eea;"></i>
                                            <?= esc($facility['description']) ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="facility-status status-active">
                                        <i class="fas fa-check-circle"></i>
                                        Aktif
                                    </div>

                                    <div class="facility-actions">
                                        <a href="/user/bookings/create/<?= $facility['id'] ?>" class="btn-action btn-edit">
                                            <i class="fas fa-calendar-plus"></i>
                                            Tempah Sekarang
                                        </a>
                                        <button class="btn-action btn-delete" onclick="viewFacilityImages(<?= $facility['id'] ?>, '<?= esc($facility['name']) ?>')">
                                            <i class="fas fa-images"></i>
                                            Lihat Gambar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Agency Facilities Section (Collapsible) -->
            <?php if (!empty($agencyFacilities)): ?>
            <div class="facilities-section fade-in-up">
                <div class="section-header" onclick="toggleSection('agency-section')">
                    <h2 class="section-title">
                        <i class="fas fa-building me-2"></i>
                        Fasiliti Agensi
                        <span class="facility-count">(<?= count($agencyFacilities) ?> fasiliti)</span>
                    </h2>
                    <button class="btn-toggle" id="agency-toggle-btn">
                        <i class="fas fa-chevron-up"></i>
                    </button>
                </div>
                <div class="section-content" id="agency-section">
                    <div class="facilities-grid stagger-animation">
                        <?php foreach ($agencyFacilities as $facility): ?>
                            <div class="facility-card" data-facility-name="<?= strtolower(esc($facility['name'])) ?>" data-facility-category="<?= strtolower(esc($facility['category_name'])) ?>" data-facility-type="agency">
                                <div class="facility-card-header">
                                    <?php if ($facility['primary_image']): ?>
                                        <div style="position: relative;">
                                            <img src="/images/facility/<?= $facility['primary_image']['id'] ?>" alt="<?= esc($facility['name']) ?>" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 1rem; cursor: pointer;" onclick="viewFacilityImages(<?= $facility['id'] ?>, '<?= esc($facility['name']) ?>')">
                                            <?php if ($facility['image_count'] > 1): ?>
                                            <div style="position: absolute; bottom: 1rem; right: 1rem; background: rgba(0,0,0,0.7); color: white; padding: 0.5rem 0.75rem; border-radius: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer;" onclick="viewFacilityImages(<?= $facility['id'] ?>, '<?= esc($facility['name']) ?>')">
                                                +<?= $facility['image_count'] - 1 ?> <i class="fas fa-images"></i>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="facility-icon">
                                            <i class="fas fa-building"></i>
                                        </div>
                                    <?php endif; ?>
                                    <h3 class="facility-name"><?= esc($facility['name']) ?></h3>
                                    <span class="facility-category">
                                        <i class="fas fa-tag me-1"></i>
                                        <?= esc($facility['category_name']) ?>
                                    </span>
                                    <?php if (isset($facility['agency_name']) && $facility['agency_name']): ?>
                                    <span class="facility-agency">
                                        <i class="fas fa-university me-1"></i>
                                        <?= esc($facility['agency_name']) ?>
                                    </span>
                                    <?php endif; ?>
                                </div>

                                <div class="facility-card-body">
                                    <div class="facility-info">
                                        <div class="info-item">
                                            <i class="fas fa-info-circle"></i>
                                            <span><strong>Jenis:</strong> <?= esc($facility['type']) ?></span>
                                        </div>
                                        <div class="info-item">
                                            <i class="fas fa-users"></i>
                                            <span><strong>Kapasiti:</strong> <?= esc($facility['capacity']) ?> orang</span>
                                        </div>
                                        <div class="info-item">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span><strong>Lokasi:</strong> <?= esc($facility['location'] ?: 'Tiada maklumat') ?></span>
                                        </div>
                                    </div>

                                    <?php if ($facility['description']): ?>
                                        <div class="facility-description">
                                            <i class="fas fa-quote-left me-2" style="color: #667eea;"></i>
                                            <?= esc($facility['description']) ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="facility-status status-active">
                                        <i class="fas fa-check-circle"></i>
                                        Aktif
                                    </div>

                                    <div class="facility-actions">
                                        <a href="/user/bookings/create/<?= $facility['id'] ?>" class="btn-action btn-edit">
                                            <i class="fas fa-calendar-plus"></i>
                                            Tempah Sekarang
                                        </a>
                                        <button class="btn-action btn-delete" onclick="viewFacilityImages(<?= $facility['id'] ?>, '<?= esc($facility['name']) ?>')">
                                            <i class="fas fa-images"></i>
                                            Lihat Gambar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php else: ?>
            <!-- Manager View: Single Grid -->
            <div class="facilities-grid stagger-animation" id="facilitiesGrid">
                <?php foreach ($facilities as $facility): ?>
                    <div class="facility-card" data-facility-name="<?= strtolower(esc($facility['name'])) ?>" data-facility-category="<?= strtolower(esc($facility['category_name'])) ?>" data-facility-type="<?= esc($facility['facility_type']) ?>">
                        <div class="facility-card-header">
                            <?php if ($facility['primary_image']): ?>
                                <div style="position: relative;">
                                    <img src="/images/facility/<?= $facility['primary_image']['id'] ?>" alt="<?= esc($facility['name']) ?>" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 1rem; cursor: pointer;" onclick="viewFacilityImages(<?= $facility['id'] ?>, '<?= esc($facility['name']) ?>')">
                                    <?php if ($facility['image_count'] > 1): ?>
                                    <div style="position: absolute; bottom: 1rem; right: 1rem; background: rgba(0,0,0,0.7); color: white; padding: 0.5rem 0.75rem; border-radius: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer;" onclick="viewFacilityImages(<?= $facility['id'] ?>, '<?= esc($facility['name']) ?>')">
                                        +<?= $facility['image_count'] - 1 ?> <i class="fas fa-images"></i>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="facility-icon">
                                    <i class="fas fa-building"></i>
                                </div>
                            <?php endif; ?>
                            <h3 class="facility-name"><?= esc($facility['name']) ?></h3>
                            <span class="facility-category">
                                <i class="fas fa-tag me-1"></i>
                                <?= esc($facility['category_name']) ?>
                            </span>
                        </div>

                        <div class="facility-card-body">
                            <div class="facility-info">
                                <div class="info-item">
                                    <i class="fas fa-info-circle"></i>
                                    <span><strong>Jenis:</strong> <?= esc($facility['type']) ?></span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-users"></i>
                                    <span><strong>Kapasiti:</strong> <?= esc($facility['capacity']) ?> orang</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span><strong>Lokasi:</strong> <?= esc($facility['location'] ?: 'Tiada maklumat') ?></span>
                                </div>
                            </div>

                            <?php if ($facility['description']): ?>
                                <div class="facility-description">
                                    <i class="fas fa-quote-left me-2" style="color: #667eea;"></i>
                                    <?= esc($facility['description']) ?>
                                </div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <span class="facility-status status-<?= strtolower($facility['status']) ?>">
                                    <i class="fas fa-circle" style="font-size: 0.5rem;"></i>
                                    <?= esc($facility['status']) ?>
                                </span>
                            </div>

                            <div class="facility-actions">
                                <a href="/manager/facilities/<?= $facility['id'] ?>/edit" class="btn-action btn-edit" style="text-decoration: none; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <button type="button" class="btn-action" onclick="openCalendarModal(<?= $facility['id'] ?>, '<?= esc($facility['name'], 'js') ?>')" style="background: var(--info-gradient); color: white; box-shadow: 0 5px 15px rgba(79, 172, 254, 0.3);">
                                    <i class="fas fa-calendar-alt"></i>
                                    Kalendar
                                </button>
                                <form method="post" action="/manager/facilities/<?= $facility['id'] ?>/delete" class="d-inline flex-fill" onsubmit="return confirm('Adakah anda pasti mahu memadam fasiliti ini?')">
                                    <button type="submit" class="btn-action btn-delete w-100">
                                        <i class="fas fa-trash"></i>
                                        Padam
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<!-- Calendar Modal -->
<div class="modal fade" id="calendarModal" tabindex="-1" aria-labelledby="calendarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
            <div class="modal-header" style="background: var(--info-gradient); color: white; border-radius: 20px 20px 0 0; padding: 2rem;">
                <h5 class="modal-title" id="calendarModalLabel" style="font-weight: 700; font-size: 1.5rem;">
                    <i class="fas fa-calendar-alt me-2"></i>Kalendar Tempahan - <span id="facilityNameTitle"></span>
                </h5>
                <div class="d-flex gap-2">
                    <button id="blockToggleBtn" type="button" class="btn btn-light" onclick="toggleBlockMode()" style="border-radius: 10px; font-weight: 600;">
                        <i class="fas fa-ban me-2"></i>Tempah Tarikh (Block)
                    </button>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <span style="display:inline-block;width:14px;height:14px;border-radius:4px;background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);"></span>
                        <small class="text-muted">Tarikh ditempah</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span style="display:inline-block;width:14px;height:14px;border-radius:4px;background: linear-gradient(135deg, #ff4757 0%, #ff6b81 100%);"></span>
                        <small class="text-muted">Tarikh di-block</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span style="display:inline-block;width:14px;height:14px;border-radius:4px;background: #f8f9fa;border:1px solid #e9ecef;"></span>
                        <small class="text-muted">Kekal tersedia</small>
                    </div>
                </div>
                <div id="yearCalendar"></div>
                <div id="yearBlockPanel" class="mt-4" style="background: #fef6f6; border: 1px solid #ffe3e8; border-radius: 14px; padding: 1rem 1.25rem; display: none;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="small text-muted">Tarikh dipilih untuk di-block:</div>
                            <div id="yearBlockDates" style="font-weight: 600; color: #f5576c; min-height: 24px;">Tiada pilihan</div>
                        </div>
                        <div class="text-end">
                            <div class="small text-muted">Jumlah hari:</div>
                            <div id="yearBlockCount" style="font-weight: 700; color: #f5576c; font-size: 1.1rem;">0</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="year_block_reason" class="form-label mb-1" style="font-weight: 600; color: #2c3e50;">Sebab (pilihan)</label>
                        <textarea id="year_block_reason" class="form-control" rows="2" placeholder="Cth: Penyelenggaraan, acara khas" style="border-radius: 10px; border: 1px solid #ffd6de;"></textarea>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="small text-muted">Klik tarikh dalam kalendar untuk tambah/buang. Tarikh ditempah/di-block tidak boleh dipilih.</div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary" style="border-radius: 10px;" onclick="resetYearBlockSelection()">
                                <i class="fas fa-undo me-1"></i>Reset
                            </button>
                            <button type="button" class="btn btn-danger" style="border-radius: 10px; background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%); border: none;" onclick="submitYearBlock()">
                                <i class="fas fa-ban me-1"></i>Block Tarikh Terpilih
                            </button>
                        </div>
                    </div>
                    <input type="hidden" id="year_block_facility_id">
                    <input type="hidden" id="year_blocked_dates">
                    <div id="blockedDatesList" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Block Dates Modal -->
<div class="modal fade" id="blockDatesModal" tabindex="-1" aria-labelledby="blockDatesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
            <div class="modal-header" style="background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%); color: white; border-radius: 20px 20px 0 0; padding: 2rem;">
                <h5 class="modal-title" id="blockDatesModalLabel" style="font-weight: 700; font-size: 1.5rem;">
                    <i class="fas fa-ban me-2"></i>Tempah Tarikh (Block Dates)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="blockDatesForm" method="post">
                <input type="hidden" id="block_facility_id" name="facility_id">
                <div class="modal-body" style="padding: 2rem;">
                    <div class="alert alert-info" style="border-radius: 12px; border-left: 4px solid #4facfe;">
                        <i class="fas fa-info-circle me-2"></i>
                        Pilih tarikh untuk di-block supaya pengguna tidak boleh membuat tempahan pada tarikh tersebut.
                    </div>
                    
                    <div id="blockCalendarPicker" style="margin: 1.5rem 0;"></div>
                    
                    <!-- Selected Dates Display -->
                    <div id="blockDatesInfo" class="mt-3 p-3" style="background: rgba(245, 87, 108, 0.08); border-radius: 10px; border-left: 4px solid #f5576c; display: none;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <small style="color: #666; display: block; margin-bottom: 0.5rem;">Tarikh-Tarikh Di-Block:</small>
                                <div id="blockDatesList" style="color: #f5576c; font-weight: 600;"></div>
                            </div>

                            <div style="text-align: right;">
                                <small style="color: #666; display: block; margin-bottom: 0.5rem;">Jumlah Hari:</small>
                                <strong id="totalBlockDays" style="color: #f5576c; font-size: 1.25rem;">0</strong>
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" id="blocked_dates" name="blocked_dates" value="[]">
                    
                    <div class="mb-3 mt-3">
                        <label for="block_reason" class="form-label" style="font-weight: 600; color: #2c3e50;">
                            <i class="fas fa-comment me-2" style="color: #f5576c;"></i>Sebab (Pilihan)
                        </label>
                        <textarea class="form-control" id="block_reason" name="reason" rows="3" placeholder="Cth: Penyelenggaraan, Cuti Umum, Acara Khas..." style="border: 2px solid #e9ecef; border-radius: 12px; padding: 0.875rem;"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 1.5rem 2rem; border-top: 2px solid #f8f9fa;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 12px; padding: 0.75rem 1.5rem; font-weight: 600;">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-danger" style="background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%); border: none; border-radius: 12px; padding: 0.75rem 1.5rem; font-weight: 600; box-shadow: 0 5px 15px rgba(245, 87, 108, 0.3);">
                        <i class="fas fa-ban me-2"></i>Block Tarikh
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .year-calendar {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
    }

    .month-calendar {
        background: white;
        border-radius: 12px;
        padding: 1rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .month-calendar:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .month-header {
        text-align: center;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e9ecef;
    }

    .calendar-weekdays-mini {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 0.25rem;
        margin-bottom: 0.5rem;
    }

    .weekday-mini {
        text-align: center;
        font-size: 0.7rem;
        font-weight: 600;
        color: #667eea;
        padding: 0.25rem;
    }

    .calendar-days-mini {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 0.25rem;
    }

    .day-mini {
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .day-mini.empty {
        background: transparent;
    }

    .day-mini.normal {
        background: #f8f9fa;
        color: #6c757d;
    }

    .day-mini.today {
        background: rgba(102, 126, 234, 0.2);
        color: #667eea;
        font-weight: 700;
        border: 2px solid #667eea;
    }

    .day-mini.booked {
        background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
        color: white;
        font-weight: 600;
    }

    .day-mini.blocked {
        background: linear-gradient(135deg, #ff4757 0%, #ff6b81 100%);
        color: white;
        font-weight: 700;
        position: relative;
    }

    .day-mini.blocked::after {
        content: '🚫';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 12px;
        opacity: 0.5;
    }

    .day-mini.selected-block {
        background: linear-gradient(135deg, #ff9f43 0%, #ff6f61 100%);
        color: white;
        font-weight: 700;
        border: 2px solid #ff9f43;
        box-shadow: 0 4px 12px rgba(255, 159, 67, 0.35);
    }

    @media (max-width: 1200px) {
        .year-calendar {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .year-calendar {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
    }

    @media (max-width: 576px) {
        .year-calendar {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
// Search functionality
document.getElementById('searchInput')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('.facility-card');
    
    cards.forEach(card => {
        const name = card.dataset.facilityName;
        const category = card.dataset.facilityCategory;
        
        if (name.includes(searchTerm) || category.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});

// Open calendar modal
let currentCalendarYear;
let currentFacilityBookings;
let selectedYearBlockDates = [];
let blockModeActive = false;
let blockedDatesByDate = {};
let blockedDatesList = [];

function openCalendarModal(facilityId, facilityName) {
    currentBlockFacilityId = facilityId; // Store for block dates modal
    document.getElementById('facilityNameTitle').textContent = facilityName;
    currentCalendarYear = new Date().getFullYear();
    selectedYearBlockDates = [];
    document.getElementById('year_block_facility_id').value = facilityId;
    blockModeActive = false;
    updateBlockToggleButton();
    updateYearBlockPanelVisibility();
    updateYearBlockPanel();
    
    refreshBookingsAndUI(true);
}

function refreshBookingsAndUI(showModal = false) {
    if (!currentBlockFacilityId) return;
    fetch('/manager/facilities/' + currentBlockFacilityId + '/bookings')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Ensure data has correct structure
            if (data.error) {
                console.error('API error:', data.error, data.message);
                currentFacilityBookings = { bookings: [], blocked_dates: [] };
            } else {
                currentFacilityBookings = data;
            }
            generateYearCalendar(currentFacilityBookings, currentCalendarYear);
            updateYearBlockPanel();
            renderBlockedDatesList();
            if (showModal) {
                const calendarModalEl = document.getElementById('calendarModal');
                if (!calendarModalEl) {
                    console.error('calendarModal element not found');
                    return;
                }
                const modal = bootstrap.Modal.getInstance(calendarModalEl) || new bootstrap.Modal(calendarModalEl, { backdrop: true });
                modal.show();
            }
        })
        .catch(error => {
            console.error('Error fetching bookings:', error);
            currentFacilityBookings = { bookings: [], blocked_dates: [] };
            generateYearCalendar({ bookings: [], blocked_dates: [] }, currentCalendarYear);
            updateYearBlockPanel();
            renderBlockedDatesList();
        });
}

function changeCalendarYear(direction) {
    currentCalendarYear += direction;
    generateYearCalendar(currentFacilityBookings, currentCalendarYear);
    updateYearBlockPanel();
}

function toggleBlockMode() {
    blockModeActive = !blockModeActive;
    if (!blockModeActive) {
        selectedYearBlockDates = [];
    }
    updateBlockToggleButton();
    updateYearBlockPanelVisibility();
    generateYearCalendar(currentFacilityBookings, currentCalendarYear);
    updateYearBlockPanel();
}

function updateYearBlockPanelVisibility() {
    const panel = document.getElementById('yearBlockPanel');
    if (!panel) return;
    panel.style.display = blockModeActive ? 'block' : 'none';
}

function updateBlockToggleButton() {
    const btn = document.getElementById('blockToggleBtn');
    if (!btn) return;
    if (blockModeActive) {
        btn.classList.remove('btn-light');
        btn.classList.add('btn-danger');
        btn.innerHTML = '<i class="fas fa-ban me-2"></i>Mode Block: AKTIF';
    } else {
        btn.classList.remove('btn-danger');
        btn.classList.add('btn-light');
        btn.innerHTML = '<i class="fas fa-ban me-2"></i>Tempah Tarikh (Block)';
    }
}

// Generate year calendar
function generateYearCalendar(data, year) {
    const container = document.getElementById('yearCalendar');
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const normalizeDateStr = (s) => (s || '').split(' ')[0];
    const parseDate = (dateStr) => new Date(normalizeDateStr(dateStr) + 'T00:00:00');
    const formatLocalDate = (d) => {
        const y = d.getFullYear();
        const m = String(d.getMonth() + 1).padStart(2, '0');
        const day = String(d.getDate()).padStart(2, '0');
        return `${y}-${m}-${day}`;
    };
    
    // Extract bookings and blocked dates
    const bookings = (data && data.bookings) ? data.bookings : [];
    const blockedDates = (data && data.blocked_dates) ? data.blocked_dates : [];
    blockedDatesList = blockedDates;
    blockedDatesByDate = {};
    
    // Convert bookings and blocked dates to date strings
    const bookedDates = new Set();
    bookings.forEach(booking => {
        const start = parseDate(booking.start_date);
        const end = parseDate(booking.end_date);
        for (let d = new Date(start); d <= end; d.setDate(d.getDate() + 1)) {
            bookedDates.add(formatLocalDate(d));
        }
    });
    
    const blockedDatesSet = new Set();
    blockedDates.forEach(blocked => {
        const key = normalizeDateStr(blocked.blocked_date);
        blockedDatesSet.add(key);
        blockedDatesByDate[key] = blocked;
    });
    
    // Debug log
    console.log('Booked dates:', Array.from(bookedDates));
    console.log('Blocked dates:', Array.from(blockedDatesSet));
    
    // Year navigation
    let html = '<div class="d-flex justify-content-between align-items-center mb-3">';
    html += '<button onclick="changeCalendarYear(-1)" class="btn btn-outline-primary" style="border-radius: 10px; font-weight: 600;">';
    html += '<i class="fas fa-chevron-left me-2"></i>Tahun Sebelumnya</button>';
    html += `<h4 style="margin: 0; font-weight: 700; color: #667eea;">Tahun ${year}</h4>`;
    html += '<button onclick="changeCalendarYear(1)" class="btn btn-outline-primary" style="border-radius: 10px; font-weight: 600;">';
    html += 'Tahun Seterusnya<i class="fas fa-chevron-right ms-2"></i></button>';
    html += '</div>';
    
    html += '<div class="year-calendar">';
    
    const monthNames = ['Januari', 'Februari', 'Mac', 'April', 'Mei', 'Jun', 
                        'Julai', 'Ogos', 'September', 'Oktober', 'November', 'Disember'];
    const weekdayNames = ['A', 'I', 'S', 'R', 'K', 'J', 'S'];
    
    for (let month = 0; month < 12; month++) {
        html += '<div class="month-calendar">';
        html += `<div class="month-header">${monthNames[month]} ${year}</div>`;
        
        // Weekday headers
        html += '<div class="calendar-weekdays-mini">';
        weekdayNames.forEach(day => {
            html += `<div class="weekday-mini">${day}</div>`;
        });
        html += '</div>';
        
        // Days
        html += '<div class="calendar-days-mini">';
        
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        
        // Empty cells before first day
        for (let i = 0; i < firstDay.getDay(); i++) {
            html += '<div class="day-mini empty"></div>';
        }
        
        // Days of month
        for (let day = 1; day <= lastDay.getDate(); day++) {
            const dayDate = new Date(year, month, day);
            const dateStr = formatLocalDate(dayDate);
            const isToday = dayDate.getTime() === today.getTime();
            const isBooked = bookedDates.has(dateStr);
            const isBlocked = blockedDatesSet.has(dateStr);
            const isPast = dayDate < today;
            const isSelectable = !isBooked && !isBlocked && !isPast;
            const isSelectedForBlock = selectedYearBlockDates.includes(dateStr);
            
            let classes = 'day-mini';
            if (isBlocked) {
                classes += ' blocked';
            } else if (isBooked) {
                classes += ' booked';
            } else if (isSelectable && isSelectedForBlock) {
                classes += ' selected-block';
            } else if (isToday) {
                classes += ' today';
            } else {
                classes += ' normal';
            }
            
            const clickAttr = isSelectable
                ? `onclick="toggleYearBlockDate('${dateStr}')"`
                : (blockModeActive && isBlocked ? `onclick="openBlockedEdit('${dateStr}')"` : '');
            html += `<div class="${classes}" ${clickAttr} data-date="${dateStr}">${day}</div>`;
        }
        
        html += '</div></div>';
    }
    
    html += '</div>';
    container.innerHTML = html;

    // Sync block panel after render
    updateYearBlockPanel();
    renderBlockedDatesList();
}

// Year calendar blocking actions
function toggleYearBlockDate(dateStr) {
    // Only allow date selection when block mode is active
    if (!blockModeActive) {
        return;
    }
    
    const idx = selectedYearBlockDates.indexOf(dateStr);
    if (idx > -1) {
        selectedYearBlockDates.splice(idx, 1);
    } else {
        selectedYearBlockDates.push(dateStr);
    }
    selectedYearBlockDates.sort();
    generateYearCalendar(currentFacilityBookings, currentCalendarYear);
    updateYearBlockPanel();
}

// Open edit modal for an already blocked date
function openBlockedEdit(dateStr) {
    if (!blockModeActive) return;

    const info = blockedDatesByDate[dateStr] || {};
    // Prefill existing block form with the clicked blocked date
    selectedYearBlockDates = [dateStr];
    const reasonInput = document.getElementById('year_block_reason');
    if (reasonInput) {
        reasonInput.value = info.reason || '';
    }
    updateYearBlockPanel();
    updateYearBlockPanelVisibility();
}

// Render list of blocked dates with edit/delete actions
function renderBlockedDatesList() {
    const listContainer = document.getElementById('blockedDatesList');
    if (!listContainer) return;

    if (!blockedDatesList || blockedDatesList.length === 0) {
        listContainer.innerHTML = '<div class="text-muted">Tiada tarikh di-block.</div>';
        return;
    }

    const items = blockedDatesList
        .slice()
        .sort((a, b) => new Date(a.blocked_date) - new Date(b.blocked_date))
        .map(item => {
            const dateStr = (item.blocked_date || '').split(' ')[0];
            const reason = item.reason || '-';
            return `
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                        <div style="font-weight: 700; color: #ff4757;">${dateStr}</div>
                        <div class="text-muted small">${reason}</div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editBlockedFromList('${dateStr}')">
                            <i class="fas fa-edit me-1"></i>Edit
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteBlockedDate('${dateStr}')">
                            <i class="fas fa-trash me-1"></i>Padam
                        </button>
                    </div>
                </div>`;
        });

    listContainer.innerHTML = `
        <div class="mt-3 p-3" style="background: #fff7f7; border: 1px solid #ffe3e8; border-radius: 12px;">
            <div style="font-weight: 700; color: #2c3e50;" class="mb-2">Senarai tarikh di-block</div>
            ${items.join('')}
        </div>`;
}

function editBlockedFromList(dateStr) {
    blockModeActive = true;
    updateBlockToggleButton();
    selectedYearBlockDates = [dateStr];
    const info = blockedDatesByDate[dateStr] || {};
    const reasonInput = document.getElementById('year_block_reason');
    if (reasonInput) {
        reasonInput.value = info.reason || '';
    }
    updateYearBlockPanel();
    updateYearBlockPanelVisibility();
}

function deleteBlockedDate(dateStr) {
    const formData = new FormData();
    formData.append('facility_id', currentBlockFacilityId || document.getElementById('year_block_facility_id').value);
    formData.append('action', 'delete');
    formData.append('blocked_date', dateStr);

    fetch('/manager/facilities/block-dates', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: formData
    })
    .then(res => res.json())
    .then(res => {
        if (!res.success) {
            alert(res.message || 'Gagal memadam tarikh');
            return;
        }
        refreshBookingsAndUI(true);
    })
    .catch(() => alert('Ralat sambungan. Cuba lagi.'));
}

function resetYearBlockSelection() {
    selectedYearBlockDates = [];
    generateYearCalendar(currentFacilityBookings, currentCalendarYear);
    updateYearBlockPanel();
}

function updateYearBlockPanel() {
    const listEl = document.getElementById('yearBlockDates');
    const countEl = document.getElementById('yearBlockCount');
    const hiddenDates = document.getElementById('year_blocked_dates');
    const facilityInput = document.getElementById('year_block_facility_id');

    if (!listEl || !countEl || !hiddenDates || !facilityInput) return;

    hiddenDates.value = JSON.stringify(selectedYearBlockDates);
    facilityInput.value = currentBlockFacilityId || facilityInput.value;

    if (selectedYearBlockDates.length === 0) {
        listEl.textContent = 'Tiada pilihan';
        countEl.textContent = '0';
        return;
    }

    const readable = selectedYearBlockDates.map(dateStr => {
        const d = new Date(dateStr + 'T00:00:00');
        return d.toLocaleDateString('ms-MY', { day: 'numeric', month: 'short', year: 'numeric' });
    });

    listEl.textContent = readable.join(', ');
    countEl.textContent = selectedYearBlockDates.length.toString();
}

function submitYearBlock() {
    if (!blockModeActive) {
        alert('Aktifkan mode block dahulu.');
        return;
    }

    if (!selectedYearBlockDates.length) {
        alert('Sila pilih sekurang-kurangnya satu tarikh untuk di-block dari kalendar tahun.');
        return;
    }

    const reason = document.getElementById('year_block_reason')?.value || '';

    const formData = new FormData();
    formData.append('facility_id', currentBlockFacilityId);
    formData.append('blocked_dates', JSON.stringify(selectedYearBlockDates));
    formData.append('reason', reason);

    fetch('/manager/facilities/block-dates', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: formData
    })
    .then(res => res.json())
    .then(res => {
        if (!res.success) {
            alert(res.message || 'Ralat memproses block tarikh');
            return;
        }
        // Refresh bookings data to update calendar and list without closing modal
        refreshBookingsAndUI(true);
        alert(res.message || 'Berjaya');
    })
    .catch(() => alert('Ralat sambungan. Cuba lagi.'));
}

// Block dates functionality
let currentBlockFacilityId;
let selectedBlockDates = [];

function openBlockDatesModal() {
    const facilityName = document.getElementById('facilityNameTitle').textContent;
    currentBlockFacilityId = currentBlockFacilityId || document.querySelector('.facility-card').dataset.facilityId;
    document.getElementById('block_facility_id').value = currentBlockFacilityId;
    
    selectedBlockDates = [];
    generateBlockCalendar();
    
    const modal = new bootstrap.Modal(document.getElementById('blockDatesModal'));
    modal.show();
}

function generateBlockCalendar() {
    const container = document.getElementById('blockCalendarPicker');
    const now = new Date();
    const currentMonth = now.getMonth();
    const currentYear = now.getFullYear();
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    // Use current facility data to disable booked/blocked dates
    const bookingsData = (currentFacilityBookings && currentFacilityBookings.bookings) ? currentFacilityBookings.bookings : [];
    const blockedData = (currentFacilityBookings && currentFacilityBookings.blocked_dates) ? currentFacilityBookings.blocked_dates : [];
    const normalizeDateStr = (s) => (s || '').split(' ')[0];
    const parseDate = (dateStr) => new Date(normalizeDateStr(dateStr) + 'T00:00:00');
    const bookedDatesSet = new Set();
    bookingsData.forEach(booking => {
        const start = parseDate(booking.start_date);
        const end = parseDate(booking.end_date);
        for (let d = new Date(start); d <= end; d.setDate(d.getDate() + 1)) {
            bookedDatesSet.add(d.toISOString().split('T')[0]);
        }
    });
    const blockedDatesSet = new Set(blockedData.map(b => normalizeDateStr(b.blocked_date)));

    let html = '<div style="background: white; border: 2px solid #e9ecef; border-radius: 15px; padding: 1rem; box-shadow: 0 10px 30px rgba(245, 87, 108, 0.1);">';
    
    // Generate current month
    const date = new Date(currentYear, currentMonth, 1);
    const month = date.toLocaleDateString('ms-MY', { month: 'long', year: 'numeric' });
    
    html += `<div class="calendar-month">
        <div class="calendar-header" style="text-align: center; margin-bottom: 0.75rem; font-weight: 600; color: #f5576c; font-size: 0.95rem;">${month}</div>
        <div class="calendar-weekdays" style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 0.3rem; margin-bottom: 0.5rem;">
            <div style="text-align: center; font-weight: 600; color: #f5576c; font-size: 0.7rem; padding: 0.25rem;">Ahad</div>
            <div style="text-align: center; font-weight: 600; color: #f5576c; font-size: 0.7rem; padding: 0.25rem;">Isnin</div>
            <div style="text-align: center; font-weight: 600; color: #f5576c; font-size: 0.7rem; padding: 0.25rem;">Selasa</div>
            <div style="text-align: center; font-weight: 600; color: #f5576c; font-size: 0.7rem; padding: 0.25rem;">Rabu</div>
            <div style="text-align: center; font-weight: 600; color: #f5576c; font-size: 0.7rem; padding: 0.25rem;">Khamis</div>
            <div style="text-align: center; font-weight: 600; color: #f5576c; font-size: 0.7rem; padding: 0.25rem;">Jumaat</div>
            <div style="text-align: center; font-weight: 600; color: #f5576c; font-size: 0.7rem; padding: 0.25rem;">Sabtu</div>
        </div>
        <div class="calendar-days" style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 0.3rem;">`;

    // Get first and last day of month
    const firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
    const lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
    
    // Add empty cells before first day
    for (let i = 0; i < firstDay.getDay(); i++) {
        html += '<div style="aspect-ratio: 1; display: flex; align-items: center; justify-content: center;"></div>';
    }

    // Add days of month
    for (let day = 1; day <= lastDay.getDate(); day++) {
        const dayDate = new Date(date.getFullYear(), date.getMonth(), day);
        const dateStr = formatLocalDate(dayDate);
        const isToday = dayDate.getTime() === today.getTime();
        const isPast = dayDate < today;
        const isBooked = bookedDatesSet.has(dateStr);
        const isBlocked = blockedDatesSet.has(dateStr);
        const isSelected = selectedBlockDates.includes(dateStr);

        let style = 'aspect-ratio: 1; display: flex; align-items: center; justify-content: center; border-radius: 6px; cursor: pointer; border: 2px solid transparent; transition: all 0.2s ease; font-weight: 500; color: #2c3e50; user-select: none; font-size: 0.85rem;';
        let extra = '';

        if (isPast) {
            style += ' background: #f8f9fa; color: #ccc; cursor: not-allowed;';
        } else if (isBooked) {
            style += ' background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%); color: white; cursor: not-allowed; font-weight: 700;';
            extra = ' title="Tarikh telah ditempah"';
        } else if (isBlocked) {
            style += ' background: linear-gradient(135deg, #ff4757 0%, #ff6b81 100%); color: white; cursor: not-allowed; font-weight: 700; position: relative;';
            extra = ' title="Tarikh sudah di-block"';
        } else if (isSelected) {
            style += ' background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%); color: white; border-color: #f5576c; box-shadow: 0 5px 15px rgba(245, 87, 108, 0.3); font-weight: 600;';
        } else {
            style += ' background: white; border: 2px solid #e9ecef;';
            if (isToday) {
                style += ' background: rgba(245, 87, 108, 0.1); color: #f5576c; font-weight: 700; border-color: #f5576c;';
            }
        }

        const onclick = (isPast || isBooked || isBlocked) ? '' : `onclick="toggleBlockDate('${dateStr}')"`;
        html += `<div ${onclick}${extra} style="${style}">${day}</div>`;
    }

    html += '</div></div></div>';
    container.innerHTML = html;
    updateBlockDisplay();
}

function toggleBlockDate(dateStr) {
    const index = selectedBlockDates.indexOf(dateStr);
    if (index > -1) {
        selectedBlockDates.splice(index, 1);
    } else {
        selectedBlockDates.push(dateStr);
    }
    selectedBlockDates.sort();
    document.getElementById('blocked_dates').value = JSON.stringify(selectedBlockDates);
    generateBlockCalendar();
}

function updateBlockDisplay() {
    const blockDatesInfo = document.getElementById('blockDatesInfo');
    const blockDatesList = document.getElementById('blockDatesList');
    const totalBlockDays = document.getElementById('totalBlockDays');
    
    if (selectedBlockDates.length === 0) {
        blockDatesInfo.style.display = 'none';
        return;
    }

    blockDatesInfo.style.display = 'block';
    const dateStrings = selectedBlockDates.map(dateStr => {
        const date = new Date(dateStr + 'T00:00:00');
        return date.toLocaleDateString('ms-MY', { day: 'numeric', month: 'short', year: 'numeric' });
    });

    blockDatesList.innerHTML = dateStrings.join(', ');
    totalBlockDays.textContent = selectedBlockDates.length;
}

// Handle block dates form submission
document.getElementById('blockDatesForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (selectedBlockDates.length === 0) {
        alert('Sila pilih sekurang-kurangnya satu tarikh untuk di-block');
        return false;
    }
    
    // Submit the form
    this.submit();
});

// Function to view all facility images in modal
function viewFacilityImages(facilityId, facilityName) {
    fetch(`/manager/facilities/${facilityId}/images`)
        .then(res => res.json())
        .then(data => {
            if (data.images && data.images.length > 0) {
                let imagesHtml = '<div class="d-flex gap-3" style="overflow-x: auto; padding: 1rem 0;">';
                data.images.forEach(img => {
                    imagesHtml += `
                        <div style="flex-shrink: 0;">
                            <img src="/images/facility/${img.id}" alt="Facility Image" style="width: 250px; height: 200px; object-fit: cover; border-radius: 8px; border: ${img.is_primary ? '3px solid #667eea' : 'none'}">
                            ${img.is_primary ? '<div style="text-align: center; margin-top: 0.5rem; font-weight: 600; color: #667eea;"><i class="fas fa-star me-1"></i>Utama</div>' : ''}
                        </div>
                    `;
                });
                imagesHtml += '</div>';
                
                Swal.fire({
                    title: `Gambar - ${facilityName}`,
                    html: imagesHtml,
                    width: '90%',
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#667eea'
                });
            } else {
                Swal.fire('Tiada Gambar', 'Fasiliti ini belum mempunyai gambar.', 'info');
            }
        });
}

// Section Toggle Functionality
function toggleSection(sectionId) {
    const section = document.getElementById(sectionId);
    const toggleBtn = document.getElementById(sectionId.replace('-section', '-toggle-btn'));
    
    if (section && toggleBtn) {
        const isCollapsed = section.classList.contains('collapsed');
        
        if (isCollapsed) {
            // Expand section
            section.classList.remove('collapsed');
            toggleBtn.classList.remove('collapsed');
            toggleBtn.innerHTML = '<i class="fas fa-chevron-up"></i>';
        } else {
            // Collapse section
            section.classList.add('collapsed');
            toggleBtn.classList.add('collapsed');
            toggleBtn.innerHTML = '<i class="fas fa-chevron-down"></i>';
        }
    }
}

// Agency Facilities Toggle Functionality
document.addEventListener('DOMContentLoaded', function() {
    const agencyToggle = document.getElementById('showAgencyFacilities');
    if (agencyToggle) {
        agencyToggle.addEventListener('change', function() {
            const showAgency = this.checked;
            const facilityCards = document.querySelectorAll('.facility-card');
            
            facilityCards.forEach(card => {
                const facilityType = card.getAttribute('data-facility-type');
                if (facilityType === 'agency') {
                    card.style.display = showAgency ? 'block' : 'none';
                }
            });
            
            // Update toggle label
            const toggleLabel = document.querySelector('.form-check-label');
            if (toggleLabel) {
                toggleLabel.innerHTML = showAgency ? 
                    '<i class="fas fa-building me-2"></i>Tunjuk Fasiliti Agensi' : 
                    '<i class="fas fa-building me-2"></i>Sembunyi Fasiliti Agensi';
            }
        });
    }
});
</script>

<?= $this->endSection() ?>