<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Tempahan Fasiliti</title>
    <link rel="icon" href="/images/kedah-coat.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-yellow: #ffcc00;
            --brand-yellow-dark: #f5b800;
            --brand-black: #0b0c0f;
            --brand-gray: #f5f6f8;
            --brand-line: #e5e7eb;
            --primary-gradient: linear-gradient(135deg, #ffcc00 0%, #ffd84d 100%);
            --success-gradient: linear-gradient(135deg, #2ec8a6 0%, #54dcbf 100%);
            --soft-green-gradient: linear-gradient(135deg, #2ec8a6 0%, #54dcbf 100%);
            --info-gradient: linear-gradient(135deg, #111217 0%, #161821 100%);
            --warning-gradient: linear-gradient(135deg, #ffb347 0%, #ffd36a 100%);
            --danger-gradient: linear-gradient(135deg, #ff6b81 0%, #ff92a3 100%);
            --card-shadow: 0 14px 36px rgba(0, 0, 0, 0.12);
            --card-shadow-hover: 0 18px 46px rgba(0, 0, 0, 0.16);
            --glass: rgba(255,255,255,0.92);
            --glass-border: 1px solid rgba(0,0,0,0.05);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f6f8;
            min-height: 100vh;
            margin: 0;
            font-size: 16px;
            line-height: 1.6;
            color: #111217;
        }

        .navbar-custom {
            background: #fff !important;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
            padding: 0.75rem 0;
            border-bottom: 1px solid #eceff3;
        }

        .hero-section {
            padding: 100px 0 60px;
            color: #111217;
            text-align: left;
            background: linear-gradient(135deg, #fff 0%, #f7f7f7 60%, #fff 100%);
        }

        .flow-section { background: #f9fafb; padding: 60px 0; border-bottom: 1px solid #e5e7eb; }
        .highlights-section { background: #fff; padding: 60px 0; border-bottom: 1px solid #e5e7eb; }
        .stats-section { background: #f9fafb; padding: 60px 0; border-bottom: 1px solid #e5e7eb; }
        .faq-section { background: #fff; padding: 60px 0; border-bottom: 1px solid #e5e7eb; }
        .agencies-section { background: #f9fafb; padding: 60px 0; border-bottom: 1px solid #e5e7eb; }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.8rem;
            line-height: 1.08;
            letter-spacing: -0.35px;
            color: #0b0c0f;
        }

        .hero-subtitle {
            font-size: 1.05rem;
            margin-bottom: 1.2rem;
            opacity: 0.85;
            line-height: 1.55;
            max-width: 640px;
            color: #34373e;
        }

        .kedah-symbols img {
            filter: drop-shadow(0 6px 16px rgba(0,0,0,0.35));
            transition: all 0.35s ease;
            border-radius: 10px;
            background: rgba(255,255,255,0.08);
            padding: 10px;
        }

        .kedah-symbols img:hover {
            transform: scale(1.1);
            filter: drop-shadow(0 8px 16px rgba(0,0,0,0.3)) brightness(1.1);
        }

        .features-section {
            padding: 100px 0;
            background: white;
        }

        .feature-card { background: transparent; border: none; }
        .feature-icon { display: none; }

        .site-footer {
            padding: 64px 0;
            background: radial-gradient(circle at 18% 20%, rgba(64,201,255,0.12), transparent 32%),
                        radial-gradient(circle at 78% 16%, rgba(106,125,255,0.1), transparent 34%),
                        linear-gradient(135deg, #0b1224 0%, #0f172a 100%);
            color: #e5e7eb;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .site-footer a { color: #cce6ff; text-decoration: none; }
        .site-footer a:hover { color: #fff; text-decoration: underline; }
        .site-footer .footer-brand { font-weight: 700; font-size: 1.1rem; }
        .site-footer .footer-meta { color: rgba(226,232,240,0.78); font-size: 0.95rem; }

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

        .stagger-animation {
            animation: fadeInUp 0.6s ease-out;
        }

        .stagger-animation:nth-child(1) { animation-delay: 0.1s; }
        .stagger-animation:nth-child(2) { animation-delay: 0.2s; }
        .stagger-animation:nth-child(3) { animation-delay: 0.3s; }
        .stagger-animation:nth-child(4) { animation-delay: 0.4s; }

        .card:hover {
            transform: translateY(-4px) !important;
            box-shadow: 0 12px 28px rgba(0,0,0,0.08) !important;
        }

        .agency-card {
            cursor: pointer;
            transition: all 0.3s ease;
            background: #fff !important;
            border: 1px solid #eceff3 !important;
            border-radius: 8px;
        }

        .facilities-scroll {
            max-height: 420px;
            overflow-y: auto;
            padding-right: 4px;
        }

        /* Agency cards accordion (no sidebar) */
        .agency-stack { max-width: 980px; margin: 0 auto; }
        .facility-list { margin: 0; padding-left: 0; list-style: none; }
        .facility-list li { padding: 6px 0; border-bottom: 1px solid #eceff3; display: flex; align-items: center; gap: 8px; color: #4b5563; }
        .facility-list li:last-child { border-bottom: none; }

        .agency-card:hover {
            transform: translateY(-4px) !important;
            box-shadow: 0 12px 28px rgba(0,0,0,0.1) !important;
            border: 1px solid #ffd84d !important;
        }

        .agency-card.expanded .toggle-icon {
            transform: rotate(180deg);
        }

        .facility-count {
            font-size: 0.8rem;
            font-weight: 500;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-10px);
            }
        }

        /* Focus states for register modal inputs */
        #registerModal input:focus,
        #registerModal select:focus,
        #registerModal textarea:focus {
            border-color: #22c55e !important;
            box-shadow: 0 0 0 0.2rem rgba(34, 197, 94, 0.25) !important;
        }

        /* New homepage styling */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.9rem;
            background: var(--primary-gradient);
            color: #111217;
            border-radius: 999px;
            font-weight: 700;
            box-shadow: 0 10px 30px rgba(255,204,0,0.35);
        }

        .hero-section {
            position: relative;
            overflow: hidden;
        }

        .hero-highlight {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 0.75rem;
            margin-top: 0.75rem;
        }

        .info-card {
            background: #fff;
            border: 1px solid #eceff3;
            border-radius: 16px;
            padding: 1rem;
            color: #111217;
            box-shadow: 0 10px 24px rgba(0,0,0,0.08);
        }

        .info-grid { display: none; }

        .hero-bullets {
            display: grid;
            gap: 0.55rem;
            margin-top: 0.75rem;
        }

        .bullet-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.55rem 0.8rem;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.16);
            border-radius: 11px;
            color: #e5e7eb;
            font-weight: 500;
            width: fit-content;
            font-size: 0.95rem;
        }

        .step-card, .stat-card, .announcement-card, .faq-card {
            border: 1px solid #eceff3;
            border-radius: 16px;
            box-shadow: 0 10px 22px rgba(0,0,0,0.06);
            transition: all 0.25s ease;
            background: #ffffff;
            color: #0f172a;
        }

        .step-card:hover, .stat-card:hover, .announcement-card:hover, .faq-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--card-shadow-hover);
        }

        .icon-badge {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--primary-gradient);
            color: #fff;
            box-shadow: 0 10px 25px rgba(102,126,234,0.35);
        }

        .badge-soft {
            padding: 0.35rem 0.8rem;
            border-radius: 14px;
            background: #fff7d6;
            color: #8a6b00;
            border: 1px solid #ffe89c;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .section-heading {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .section-heading .icon-badge {
            background: var(--info-gradient);
            box-shadow: 0 10px 25px rgba(0,242,254,0.25);
        }

        .stat-card h6, .step-card h5, .announcement-card h6, .faq-card h6 { color: #0f172a; }
        .card .text-muted { color: #5b6068 !important; }
        .section-heading h3 { color: #0f172a; }

        /* Theme toggle */
        #themeToggle { display: none; }

        /* Daylight theme overrides */
        /* Remove theme toggle overrides; design is light-first */

        body.daylight-theme .hero-section .icon-badge,
        body.daylight-theme .info-card .icon-badge { box-shadow: 0 10px 20px rgba(30,144,255,0.18); }
    </style>
</head>
<body>
    <?php 
        // Safeguard totals for stats display
        $totalAgencies = isset($agencies) ? count($agencies) : 0;
        $totalFacilities = isset($facilitiesByAgency) ? array_sum(array_map('count', $facilitiesByAgency)) : 0;
    ?>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <img src="/images/kedah-coat.svg" alt="Jata Negeri Kedah" style="height: 40px; margin-right: 10px;">Sistem Tempahan Fasiliti
            </a>

            <div class="d-flex ms-auto">
                <button type="button" class="btn btn-outline-dark me-3 px-4 py-2" data-bs-toggle="modal" data-bs-target="#registerModal" style="font-size: 0.95rem; font-weight: 600; min-height: 44px; border-radius: 10px; border-color: #111217;">
                    <i class="fas fa-user-plus me-2"></i>Daftar
                </button>
                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#loginModal" style="font-size: 0.95rem; font-weight: 700; min-height: 44px; background: var(--primary-gradient); border-radius: 10px; border: none; color: #111217; box-shadow: 0 10px 24px rgba(255,204,0,0.35);">
                    <i class="fas fa-sign-in-alt me-2"></i>Log Masuk
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <div class="pill mb-3">
                        <i class="fas fa-shield-alt"></i>
                        Portal Rasmi Kerajaan Kedah
                    </div>
                    <h1 class="hero-title">Tempahan Fasiliti, pantas dan selamat.</h1>
                    <p class="hero-subtitle">Log masuk atau daftar untuk menempah dewan, asrama, kenderaan dan fasiliti kerajaan lain. Pantau status kelulusan dalam satu tempat yang telus.</p>
                    <div class="d-flex flex-wrap gap-3 mb-3">
                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#loginModal" style="background: var(--primary-gradient); color: #111217; font-weight: 700; border-radius: 12px; padding: 0.75rem 1.6rem; border: none; box-shadow: 0 12px 28px rgba(255,204,0,0.35);">
                            <i class="fas fa-sign-in-alt me-2"></i>Log Masuk
                        </button>
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#registerModal" style="border-radius: 12px; padding: 0.75rem 1.6rem; font-weight: 700; border: 1.5px solid #111217;">
                            <i class="fas fa-user-plus me-2"></i>Daftar
                        </button>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge-soft"><i class="fas fa-landmark me-1"></i><?= $totalAgencies ?> agensi</span>
                        <span class="badge-soft"><i class="fas fa-warehouse me-1"></i><?= $totalFacilities ?> fasiliti</span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="info-card" style="padding: 1.5rem; border-radius: 18px; border: 2px solid #e5e7eb;">
                        <div class="d-flex align-items-start mb-3">
                            <div class="icon-badge me-3" style="background: var(--primary-gradient); color: #111217;"><i class="fas fa-check-circle"></i></div>
                            <div>
                                <div class="fw-bold">Aliran tempahan yang jelas</div>
                                <small class="text-muted">Pilih tarikh, hantar permohonan, dan jejak kelulusan terus dalam portal.</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-start">
                            <div class="icon-badge me-3" style="background: var(--success-gradient); color: #0b0c0f;"><i class="fas fa-calendar-check"></i></div>
                            <div>
                                <div class="fw-bold">Ketersediaan masa nyata</div>
                                <small class="text-muted">Lihat slot tersedia sebelum membuat tempahan.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Access Icons -->
    <section class="py-4" style="background: #f5f6f8; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb;">
        <div class="container text-center">
            <div class="row g-3 justify-content-center">
                <div class="col-6 col-md-3">
                    <button class="btn btn-link p-3 d-flex flex-column align-items-center text-decoration-none" data-bs-toggle="modal" data-bs-target="#flowModal" style="color: #111217;">
                        <div class="icon-badge mb-2" style="background: var(--primary-gradient); width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-route fa-lg"></i></div>
                        <small class="fw-semibold">Proses Tempahan</small>
                    </button>
                </div>
                <div class="col-6 col-md-3">
                    <button class="btn btn-link p-3 d-flex flex-column align-items-center text-decoration-none" data-bs-toggle="modal" data-bs-target="#highlightsModal" style="color: #111217;">
                        <div class="icon-badge mb-2" style="background: var(--warning-gradient); width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-star fa-lg"></i></div>
                        <small class="fw-semibold">Sorotan Fasiliti</small>
                    </button>
                </div>
                <div class="col-6 col-md-3">
                    <button class="btn btn-link p-3 d-flex flex-column align-items-center text-decoration-none" data-bs-toggle="modal" data-bs-target="#statsModal" style="color: #111217;">
                        <div class="icon-badge mb-2" style="background: var(--success-gradient); width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-chart-line fa-lg"></i></div>
                        <small class="fw-semibold">Ringkasan</small>
                    </button>
                </div>
                <div class="col-6 col-md-3">
                    <button class="btn btn-link p-3 d-flex flex-column align-items-center text-decoration-none" data-bs-toggle="modal" data-bs-target="#faqModal" style="color: #111217;">
                        <div class="icon-badge mb-2" style="background: var(--info-gradient); width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-question-circle fa-lg"></i></div>
                        <small class="fw-semibold">FAQ</small>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Agencies and Facilities Section (accordion) -->
    <section class="py-5" style="background: #fff;">
        <div class="container agency-stack text-center">
            <div class="mb-4">
                <h2 class="fw-bold mb-1" style="color: #0b0c0f;">Agensi & Fasiliti Sedia ada</h2>
                <p class="text-muted mb-0">Buka satu agensi pada satu masa dan semak senarai fasiliti</p>
            </div>

            <?php if (!empty($agencies)): ?>
            <div class="d-flex flex-column gap-3 align-items-center">
                <?php foreach ($agencies as $agency): ?>
                <div class="card border-0 shadow-sm w-100 agency-card" data-agency-id="<?= $agency['id'] ?>" style="max-width: 920px; border-radius: 16px; overflow: hidden; cursor: pointer;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-2">
                            <div class="d-flex align-items-center gap-3 text-start">
                                <div class="icon-badge" style="background: var(--primary-gradient); color: #111217;"><i class="fas fa-landmark"></i></div>
                                <div>
                                    <h4 class="card-title fw-bold mb-1" style="color: inherit; margin-bottom: 0;"> <?= esc($agency['name']) ?> </h4>
                                    <p class="card-text text-muted mb-0"> <?= esc($agency['description'] ?? 'Agensi kerajaan yang menyediakan pelbagai fasiliti') ?> </p>
                                </div>
                            </div>
                            <?php if (!empty($facilitiesByAgency[$agency['id']])): ?>
                            <div class="d-flex align-items-center">
                                <span class="facility-count badge me-2" style="background: var(--info-gradient); color: white; border-radius: 15px; padding: 0.35rem 0.9rem;">
                                    <i class="fas fa-map-marker-alt me-1"></i><?= count($facilitiesByAgency[$agency['id']]) ?> Fasiliti
                                </span>
                                <i class="fas fa-chevron-down toggle-icon" style="color: var(--primary-gradient); transition: transform 0.3s ease;"></i>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Facilities under this agency (list only) -->
                <?php if (!empty($facilitiesByAgency[$agency['id']])): ?>
                <div class="facilities-section" id="facilities-<?= $agency['id'] ?>" style="display: none; width: 100%; max-width: 920px;">
                    <div class="card border-0 shadow-sm" style="border-radius: 14px; background: #fff; border: 1px solid #eceff3;">
                        <div class="card-body p-3 text-start">
                            <ul class="facility-list mb-0">
                                <?php foreach ($facilitiesByAgency[$agency['id']] as $facility): ?>
                                <li>
                                    <i class="fas fa-circle" style="font-size: 0.5rem; color: #22c55e;"></i>
                                    <span class="fw-semibold"><?= esc($facility['name']) ?></span>
                                    <span class="text-muted">&middot; <?= esc($facility['capacity'] ?? 'N/A') ?> kapasiti</span>
                                    <?php if (!empty($facility['description'])): ?>
                                    <span class="text-muted">&middot; <?= esc($facility['description']) ?></span>
                                    <?php endif; ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="text-muted small" style="max-width: 920px;">Tiada fasiliti tersedia untuk agensi ini buat masa ini.</div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="text-center py-4">
                <i class="fas fa-info-circle fa-2x text-muted mb-2"></i>
                <div class="text-muted">Tiada Agensi Tersedia</div>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-md-6">
                    <div class="footer-brand d-flex align-items-center mb-2">
                        <img src="/images/kedah-coat.svg" alt="Jata Negeri Kedah" style="height: 32px; margin-right: 10px;">
                        Sistem Tempahan Fasiliti
                    </div>
                    <div class="footer-meta">Portal rasmi untuk menempah aset dan fasiliti kerajaan Kedah dengan mudah dan telus.</div>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="mb-2">
                        <a href="#">Dasar Privasi</a> · <a href="#">Terma Penggunaan</a> · <a href="#">Hubungi</a>
                    </div>
                    <small class="footer-meta">© <?php echo date('Y'); ?> Kerajaan Negeri Kedah. Semua hak cipta terpelihara.</small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Page-level Alerts -->
    <?php if (session()->has('error')): ?>
        <div class="position-fixed bottom-0 start-50 translate-middle-x mb-4" style="z-index: 9999; width: 90%; max-width: 500px;">
            <div class="alert alert-danger alert-dismissible fade show" style="border-radius: 14px; border: 1px solid #f5c6cb; box-shadow: 0 10px 28px rgba(249,40,45,0.25);" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><strong>Ralat:</strong> <?= session('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>
    <?php if (session()->has('success')): ?>
        <div class="position-fixed bottom-0 start-50 translate-middle-x mb-4" style="z-index: 9999; width: 90%; max-width: 500px;">
            <div class="alert alert-success alert-dismissible fade show" style="border-radius: 14px; border: 1px solid #c3e6cb; box-shadow: 0 10px 28px rgba(40,167,69,0.25);" role="alert">
                <i class="fas fa-check-circle me-2"></i><strong>Berjaya:</strong> <?= session('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
                <div class="modal-header" style="background: linear-gradient(135deg, #6b8e23 0%, #7fa63a 100%); color: white; border-radius: 15px 15px 0 0; border-bottom: none;">
                    <h5 class="modal-title fw-bold" id="loginModalLabel">
                        <i class="fas fa-sign-in-alt me-2"></i>Log Masuk
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <?php if (session()->has('login_error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i><?= session('login_error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <form method="post" action="/login">
                        <div class="mb-3">
                            <label for="modalEmail" class="form-label fw-semibold">
                                <i class="fas fa-envelope me-2"></i>Emel
                            </label>
                            <input type="email" class="form-control" id="modalEmail" name="email" placeholder="Masukkan emel anda" required style="border-radius: 10px; border: 2px solid #e9ecef;">
                        </div>
                        <div class="mb-3">
                            <label for="modalPassword" class="form-label fw-semibold">
                                <i class="fas fa-lock me-2"></i>Kata Laluan
                            </label>
                            <input type="password" class="form-control" id="modalPassword" name="password" placeholder="Masukkan kata laluan" required style="border-radius: 10px; border: 2px solid #e9ecef;">
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-lg" style="background: linear-gradient(135deg, #6b8e23 0%, #7fa63a 100%); border: none; border-radius: 10px; color: white; font-weight: 600; padding: 0.75rem; box-shadow: 0 8px 20px rgba(107,142,35,0.35);">
                                <i class="fas fa-sign-in-alt me-2"></i>Log Masuk
                            </button>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <small class="text-muted">Belum ada akaun? <a href="#" class="text-decoration-none fw-semibold" style="color: var(--info-gradient);" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">Daftar sekarang</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
                <div class="modal-header" style="background: var(--soft-green-gradient); color: white; border-radius: 15px 15px 0 0; border-bottom: none;">
                    <h5 class="modal-title fw-bold" id="registerModalLabel">
                        <i class="fas fa-user-plus me-2"></i>Pendaftaran Akaun Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" style="max-height: 70vh; overflow-y: auto;">
                    <form method="post" action="/register">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="modalRegEmail" class="form-label fw-semibold">
                                        <i class="fas fa-envelope me-2"></i>Emel
                                    </label>
                                    <input type="email" class="form-control" id="modalRegEmail" name="email" placeholder="Masukkan emel anda" required style="border-radius: 10px; border: 2px solid #e9ecef;">
                                </div>
                                <div class="mb-3">
                                    <label for="modalRegPassword" class="form-label fw-semibold">
                                        <i class="fas fa-lock me-2"></i>Kata Laluan
                                    </label>
                                    <input type="password" class="form-control" id="modalRegPassword" name="password" placeholder="Minimum 8 aksara" required style="border-radius: 10px; border: 2px solid #e9ecef;">
                                </div>
                                <div class="mb-3">
                                    <label for="modalRegFullName" class="form-label fw-semibold">
                                        <i class="fas fa-user me-2"></i>Nama Penuh
                                    </label>
                                    <input type="text" class="form-control" id="modalRegFullName" name="full_name" placeholder="Masukkan nama penuh" required style="border-radius: 10px; border: 2px solid #e9ecef;">
                                </div>
                                <div class="mb-3">
                                    <label for="modalRegPhone" class="form-label fw-semibold">
                                        <i class="fas fa-phone me-2"></i>Nombor Telefon
                                    </label>
                                    <input type="tel" class="form-control" id="modalRegPhone" name="phone" placeholder="Contoh: 012-3456789" style="border-radius: 10px; border: 2px solid #e9ecef;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="modalRegDob" class="form-label fw-semibold">
                                        <i class="fas fa-calendar me-2"></i>Tarikh Lahir
                                    </label>
                                    <input type="text" class="form-control" id="modalRegDob" name="date_of_birth" placeholder="dd/mm/yyyy" style="border-radius: 10px; border: 2px solid #e9ecef;">
                                </div>
                                <div class="mb-3">
                                    <label for="modalRegGender" class="form-label fw-semibold">
                                        <i class="fas fa-venus-mars me-2"></i>Jantina
                                    </label>
                                    <select class="form-control" id="modalRegGender" name="gender" style="border-radius: 10px; border: 2px solid #e9ecef;">
                                        <option value="">Pilih Jantina</option>
                                        <option value="male">Lelaki</option>
                                        <option value="female">Perempuan</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="modalRegAddress" class="form-label fw-semibold">
                                        <i class="fas fa-map-marker-alt me-2"></i>Alamat
                                    </label>
                                    <textarea class="form-control" id="modalRegAddress" name="address" rows="3" placeholder="Masukkan alamat lengkap" style="border-radius: 10px; border: 2px solid #e9ecef;"></textarea>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="user_type" value="public">
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-lg" style="background: var(--soft-green-gradient); border: none; border-radius: 10px; color: white; font-weight: 600; padding: 0.75rem;">
                                <i class="fas fa-user-plus me-2"></i>Daftar Akaun
                            </button>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <small class="text-muted">Sudah ada akaun? <a href="#" class="text-decoration-none fw-semibold" style="color: var(--soft-green-gradient);" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Log masuk sekarang</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle agency card clicks to toggle facilities
            const agencyCards = document.querySelectorAll('.agency-card');
            
            agencyCards.forEach(card => {
                card.addEventListener('click', function() {
                    const agencyId = this.getAttribute('data-agency-id');
                    const facilitiesSection = document.getElementById('facilities-' + agencyId);
                    const toggleIcon = this.querySelector('.toggle-icon');
                    
                    if (facilitiesSection) {
                        if (facilitiesSection.style.display === 'none' || facilitiesSection.style.display === '') {
                            // Hide all other facilities sections first
                            const allFacilitiesSections = document.querySelectorAll('[id^="facilities-"]');
                            const allAgencyCards = document.querySelectorAll('.agency-card');
                            
                            allFacilitiesSections.forEach(section => {
                                if (section.id !== 'facilities-' + agencyId && section.style.display !== 'none') {
                                    section.style.animation = 'fadeOut 0.3s ease-out';
                                    setTimeout(() => {
                                        section.style.display = 'none';
                                    }, 250);
                                }
                            });
                            

                        // Sidebar show/hide facilities list
                        const sidebarToggles = document.querySelectorAll('.sidebar-agency');
                        sidebarToggles.forEach(sidebar => {
                            const toggle = sidebar.querySelector('.sidebar-toggle');
                            const chevron = sidebar.querySelector('.chevron i');
                            const facilitiesList = sidebar.querySelector('.sidebar-facilities');
                            if (!toggle || !facilitiesList) return;
                            toggle.addEventListener('click', function() {
                                const isHidden = facilitiesList.style.display === 'none' || facilitiesList.style.display === '';
                                facilitiesList.style.display = isHidden ? 'block' : 'none';
                                if (chevron) {
                                    chevron.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
                                }
                            });
                        });
                            allAgencyCards.forEach(card => {
                                if (card !== this) {
                                    const cardIcon = card.querySelector('.toggle-icon');
                                    card.classList.remove('expanded');
                                    if (cardIcon) {
                                        cardIcon.style.transform = 'rotate(0deg)';
                                    }
                                }
                            });
                            
                            // Show current facilities
                            facilitiesSection.style.display = 'block';
                            facilitiesSection.style.animation = 'fadeIn 0.3s ease-in';
                            this.classList.add('expanded');
                            if (toggleIcon) {
                                toggleIcon.style.transform = 'rotate(180deg)';
                            }
                        } else {
                            // Hide current facilities
                            facilitiesSection.style.animation = 'fadeOut 0.3s ease-out';
                            setTimeout(() => {
                                facilitiesSection.style.display = 'none';
                            }, 250);
                            this.classList.remove('expanded');
                            if (toggleIcon) {
                                toggleIcon.style.transform = 'rotate(0deg)';
                            }
                        }
                    }
                });
            });

            // Show login modal if there's a login error
            <?php if (session()->has('login_error')): ?>
                const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModal.show();
                // Auto-hide the error alert after 5 seconds
                setTimeout(() => {
                    const alert = document.querySelector('#loginModal .alert');
                    if (alert) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                }, 5000);
            <?php endif; ?>
        });
    </script>

    <!-- Flow Modal -->
    <div class="modal fade" id="flowModal" tabindex="-1" aria-labelledby="flowModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: var(--card-shadow);">
                <div class="modal-header" style="background: var(--primary-gradient); color: white; border-radius: 15px 15px 0 0; border-bottom: none;">
                    <h5 class="modal-title" id="flowModalLabel">
                        <i class="fas fa-route me-2"></i>Bagaimana Proses Tempahan Berjalan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <small class="text-muted d-block mb-4">Tiga langkah ringkas untuk membuat tempahan</small>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="card step-card h-100 p-3">
                                <div class="icon-badge mb-3"><i class="fas fa-search"></i></div>
                                <h5 class="fw-bold">1. Cari & Pilih</h5>
                                <p class="text-muted mb-0">Pilih fasiliti mengikut kategori, agensi atau kapasiti yang sesuai dengan keperluan anda.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card step-card h-100 p-3">
                                <div class="icon-badge mb-3" style="background: var(--info-gradient);"><i class="fas fa-calendar-plus"></i></div>
                                <h5 class="fw-bold">2. Mohon Tempahan</h5>
                                <p class="text-muted mb-0">Hantar permohonan dengan tarikh, masa, dan keperluan. Anda boleh jejak status secara langsung.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card step-card h-100 p-3">
                                <div class="icon-badge mb-3" style="background: var(--success-gradient);"><i class="fas fa-check-circle"></i></div>
                                <h5 class="fw-bold">3. Kelulusan & Hadir</h5>
                                <p class="text-muted mb-0">Terima notifikasi kelulusan, dan hadir mengikut slot yang disahkan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Highlights Modal -->
    <div class="modal fade" id="highlightsModal" tabindex="-1" aria-labelledby="highlightsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: var(--card-shadow);">
                <div class="modal-header" style="background: var(--warning-gradient); color: white; border-radius: 15px 15px 0 0; border-bottom: none;">
                    <h5 class="modal-title" id="highlightsModalLabel">
                        <i class="fas fa-star me-2"></i>Sorotan Fasiliti Popular
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <small class="text-muted d-block mb-4">Kategori yang paling kerap ditempah</small>
                    <div class="row g-3">
                        <div class="col-sm-6 col-lg-4">
                            <div class="card stat-card h-100 p-3 text-center">
                                <div class="icon-badge mb-2" style="background: var(--primary-gradient);"><i class="fas fa-building"></i></div>
                                <h6 class="fw-bold mb-1">Dewan & Auditorium</h6>
                                <small class="text-muted">Mesyuarat, seminar, majlis</small>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="card stat-card h-100 p-3 text-center">
                                <div class="icon-badge mb-2" style="background: var(--success-gradient);"><i class="fas fa-bed"></i></div>
                                <h6 class="fw-bold mb-1">Asrama & Penginapan</h6>
                                <small class="text-muted">Program berkumpulan & kursus</small>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="card stat-card h-100 p-3 text-center">
                                <div class="icon-badge mb-2" style="background: var(--info-gradient);"><i class="fas fa-basketball-ball"></i></div>
                                <h6 class="fw-bold mb-1">Gelanggang & Sukan</h6>
                                <small class="text-muted">Aktiviti riadah & kejohanan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Modal -->
    <div class="modal fade" id="statsModal" tabindex="-1" aria-labelledby="statsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: var(--card-shadow);">
                <div class="modal-header" style="background: var(--success-gradient); color: white; border-radius: 15px 15px 0 0; border-bottom: none;">
                    <h5 class="modal-title" id="statsModalLabel">
                        <i class="fas fa-chart-line me-2"></i>Ringkasan Pantas
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <small class="text-muted d-block mb-4">Gambaran semasa fasiliti</small>
                    <div class="row g-4">
                        <div class="col-lg-7">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="card stat-card h-100 p-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <div class="badge-soft mb-2">Agensi Berdaftar</div>
                                                <h3 class="fw-bold mb-0"><?= $totalAgencies ?></h3>
                                                <small class="text-muted">Menyediakan fasiliti kepada rakyat</small>
                                            </div>
                                            <div class="icon-badge" style="background: var(--primary-gradient);"><i class="fas fa-landmark"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card stat-card h-100 p-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <div class="badge-soft mb-2">Fasiliti Aktif</div>
                                                <h3 class="fw-bold mb-0"><?= $totalFacilities ?></h3>
                                                <small class="text-muted">Sedia ditempah oleh pengguna</small>
                                            </div>
                                            <div class="icon-badge" style="background: var(--info-gradient);"><i class="fas fa-warehouse"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card stat-card h-100 p-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <div class="badge-soft mb-2">Sokongan</div>
                                                <h3 class="fw-bold mb-0">24/7</h3>
                                                <small class="text-muted">Bantuan melalui portal & e-mel</small>
                                            </div>
                                            <div class="icon-badge" style="background: var(--danger-gradient);"><i class="fas fa-headset"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                        </div>
                        <div class="col-lg-5">
                            <div class="card announcement-card p-3 mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="icon-badge me-3" style="background: var(--primary-gradient);"><i class="fas fa-tools"></i></div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Penyelenggaraan Sistem</h6>
                                        <small class="text-muted">Slot penyelenggaraan dijadualkan hujung minggu ini. Tempahan masih boleh dibuat sebelum 11:00 malam.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card announcement-card p-3">
                                <div class="d-flex align-items-start">
                                    <div class="icon-badge me-3" style="background: var(--success-gradient);"><i class="fas fa-bolt"></i></div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Fasiliti Baharu Ditambah</h6>
                                        <small class="text-muted">Gelanggang serbaguna dan bilik seminar baharu kini dibuka untuk tempahan.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Modal -->
    <div class="modal fade" id="faqModal" tabindex="-1" aria-labelledby="faqModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: var(--card-shadow);">
                <div class="modal-header" style="background: var(--info-gradient); color: white; border-radius: 15px 15px 0 0; border-bottom: none;">
                    <h5 class="modal-title" id="faqModalLabel">
                        <i class="fas fa-question-circle me-2"></i>Soalan Lazim
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <small class="text-muted d-block mb-4">Maklumat pantas untuk pelawat baru</small>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="card faq-card h-100 p-3">
                                <h6 class="fw-bold">Perlu akaun untuk menempah?</h6>
                                <p class="text-muted mb-0">Ya, sila daftar akaun terlebih dahulu untuk menghantar permohonan tempahan.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card faq-card h-100 p-3">
                                <h6 class="fw-bold">Bila saya terima kelulusan?</h6>
                                <p class="text-muted mb-0">Notifikasi dihantar sebaik agensi memproses permohonan. Jejak status di papan pemuka.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card faq-card h-100 p-3">
                                <h6 class="fw-bold">Siapa yang boleh dihubungi?</h6>
                                <p class="text-muted mb-0">Gunakan pautan sokongan dalam portal atau hubungi agensi yang menyenaraikan fasiliti tersebut.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>