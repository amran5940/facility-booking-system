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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #ffcc00 0%, #ffd84d 100%);
            --success-gradient: linear-gradient(135deg, #2ec8a6 0%, #54dcbf 100%);
            --user-gradient: linear-gradient(135deg, #f1fbf6 0%, #f1fbf6 100%);
            --navbar-bg: #ffffff;
            
            /* Typography Scale */
            --fs-body: 0.875rem;    /* 14px */
            --fs-small: 0.8125rem;  /* 13px */
            --fs-input: 0.875rem;   /* 14px */
            --fs-h1: 1.25rem;       /* 20px */
            --fs-h2: 1.125rem;      /* 18px */
            --fs-h3: 1rem;          /* 16px */
            --lh-tight: 1.3;
            --lh-normal: 1.5;
            --lh-relaxed: 1.6;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f1fbf6;
            min-height: 100vh;
            color: #0b0c0f;
            font-size: var(--fs-body);
            line-height: var(--lh-normal);
        }
        
        h1, .h1 { font-size: var(--fs-h1); line-height: var(--lh-tight); font-weight: 600; }
        h2, .h2 { font-size: var(--fs-h2); line-height: var(--lh-tight); font-weight: 600; }
        h3, .h3 { font-size: var(--fs-h3); line-height: var(--lh-tight); font-weight: 600; }
        
        .small, small { font-size: var(--fs-small); }
        
        .btn { font-size: var(--fs-input); line-height: 1.2; padding: 0.5rem 1rem; }
        .btn-sm { font-size: var(--fs-small); padding: 0.4rem 0.8rem; }
        .btn-lg { font-size: var(--fs-body); padding: 0.6rem 1.2rem; }
        
        input, select, textarea, .form-control, .form-select {
            font-size: var(--fs-input);
            line-height: 1.4;
        }
        
        label, .form-label { font-size: var(--fs-small); font-weight: 500; }
        
        .table { font-size: var(--fs-small); }
        .table th { font-size: var(--fs-input); font-weight: 600; }
        .table td { line-height: 1.5; }
        
        .card-title { font-size: var(--fs-h3); font-weight: 600; }
        .card-text { font-size: var(--fs-body); line-height: var(--lh-relaxed); }

        .navbar-custom {
            background: var(--navbar-bg) !important;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            border-bottom: 1px solid #eceff3;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
        }

        body {
            padding-top: 76px;
        }

        .navbar-custom .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            color: #0b0c0f;
            letter-spacing: -0.2px;
        }

        .navbar-custom .navbar-nav .nav-link {
            color: #1f2937 !important;
            font-weight: 500;
            transition: all 0.25s ease;
            border-radius: 18px;
            padding: 0.5rem 0.9rem;
            margin: 0 0.2rem;
        }

        .navbar-custom .navbar-nav .nav-link:hover {
            color: #0b0c0f !important;
            background: rgba(255,204,0,0.18);
            transform: translateY(-1px);
        }

        .user-info {
            background: #f9fafb;
            border-radius: 12px;
            padding: 0.5rem 1rem;
            color: #0b0c0f;
            font-weight: 600;
            border: 1px solid #eceff3;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0b0c0f;
            font-weight: 700;
            margin-right: 0.5rem;
        }

        .container { max-width: 1200px; }

        .alert {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
        }

        .btn-custom {
            border-radius: 25px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }

        .card-modern {
            border-radius: 18px;
            border: 1px solid #eceff3;
            box-shadow: 0 12px 28px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            overflow: hidden;
            background: #ffffff;
        }

        .card-modern:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 32px rgba(0,0,0,0.12);
        }

        .facility-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0.03) 100%);
            border-radius: 15px;
            border: 1px solid rgba(255,255,255,0.08);
            transition: all 0.3s ease;
            overflow: hidden;
            color: #e5e7eb;
        }

        .facility-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.22);
            border-color: rgba(255,255,255,0.14);
        }

        .facility-card .card-body { padding: 1.5rem; }

        .facility-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0b1224;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 6px 16px rgba(58,167,255,0.28);
        }

        .table-modern {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .table-modern thead th {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 1rem;
            font-weight: 600;
        }

        .table-modern tbody tr {
            transition: all 0.3s ease;
        }

        .table-modern tbody tr:hover {
            background: rgba(30, 144, 255, 0.05);
        }

        .book-btn {
            background: var(--success-gradient);
            border: none;
            border-radius: 20px;
            padding: 0.5rem 1.5rem;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .book-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 144, 255, 0.25);
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

        .site-footer {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            color: #e2e8f0;
            padding: 3rem 0 2rem;
            margin-top: 4rem;
            border-top: 4px solid #ffcc00;
        }

        .site-footer a { color: #cce6ff; text-decoration: none; }
        .site-footer a:hover { color: #fff; text-decoration: underline; }
        .site-footer .footer-brand { font-weight: 700; font-size: 1.1rem; }
        .site-footer .footer-meta { color: rgba(226,232,240,0.78); font-size: 0.95rem; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="/images/kedah-coat.svg" alt="Jata Negeri Kedah" style="height: 32px; margin-right: 10px;">Sistem Tempahan Fasiliti
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/user"><i class="fas fa-tachometer-alt me-1"></i>Papan Pemuka</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/user/bookings"><i class="fas fa-calendar me-1"></i>Tempahan Saya</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <div class="user-info d-flex align-items-center">
                            <div class="user-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="d-none d-md-block">
                                <small class="d-block opacity-75">Selamat datang</small>
                                <strong class="mb-0"><?= session('user')['full_name'] ?? 'Pengguna' ?></strong>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="fas fa-key me-1"></i>Tukar Kata Laluan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">
                            <i class="fas fa-sign-out-alt me-1"></i>Log Keluar
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if (session()->has('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= session('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <?= session('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

    </script>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">
                <div class="modal-header" style="background: linear-gradient(135deg, #ffcc00 0%, #ffd84d 100%); color: #0b0c0f; border-radius: 20px 20px 0 0; border-bottom: none; padding: 2rem;">
                    <h5 class="modal-title" id="changePasswordModalLabel">
                        <i class="fas fa-key me-2"></i>Tukar Kata Laluan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 2rem;">
                    <div id="changePasswordAlert"></div>
                    <form id="changePasswordForm">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <div class="mb-3">
                            <label for="current_password" class="form-label" style="font-weight: 600; color: #0b0c0f;">
                                <i class="fas fa-lock me-2" style="color: #ffcc00;"></i>Kata Laluan Semasa
                            </label>
                            <input type="password" class="form-control" id="current_password" name="current_password" 
                                   style="border: 2px solid #eceff3; border-radius: 12px; padding: 0.875rem 1rem; transition: all 0.3s ease;" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label" style="font-weight: 600; color: #0b0c0f;">
                                <i class="fas fa-lock-open me-2" style="color: #14b8a6;"></i>Kata Laluan Baharu
                            </label>
                            <input type="password" class="form-control" id="new_password" name="new_password" 
                                   style="border: 2px solid #eceff3; border-radius: 12px; padding: 0.875rem 1rem; transition: all 0.3s ease;" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label" style="font-weight: 600; color: #0b0c0f;">
                                <i class="fas fa-check-circle me-2" style="color: #6366f1;"></i>Sahkan Kata Laluan Baharu
                            </label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                   style="border: 2px solid #eceff3; border-radius: 12px; padding: 0.875rem 1rem; transition: all 0.3s ease;" required>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg me-2" id="changePasswordBtn" 
                                    style="background: linear-gradient(135deg, #ffcc00 0%, #ffd84d 100%); color: #0b0c0f; border: none; border-radius: 25px; padding: 0.75rem 2rem; box-shadow: 0 10px 24px rgba(255,204,0,0.35); transition: all 0.3s ease; font-weight: 600;">
                                <i class="fas fa-save me-2"></i>Tukar Kata Laluan
                            </button>
                            <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal" 
                                    style="border-radius: 25px; padding: 0.75rem 2rem;">
                                <i class="fas fa-times me-2"></i>Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add animation on page load
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.facility-card, .card-modern');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Change Password Modal Functionality
            const changePasswordForm = document.getElementById('changePasswordForm');
            const changePasswordBtn = document.getElementById('changePasswordBtn');
            const changePasswordAlert = document.getElementById('changePasswordAlert');
            const changePasswordModal = new bootstrap.Modal(document.getElementById('changePasswordModal'));

            changePasswordForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                // Client-side validation
                const newPassword = document.getElementById('new_password').value;
                const confirmPassword = document.getElementById('confirm_password').value;
                
                if (newPassword !== confirmPassword) {
                    changePasswordAlert.innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>Kata laluan baharu tidak sepadan
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    `;
                    return;
                }
                
                if (newPassword.length < 8) {
                    changePasswordAlert.innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>Kata laluan baharu mesti sekurang-kurangnya 8 aksara
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    `;
                    return;
                }
                
                const formData = new FormData(this);
                
                // Show loading state
                changePasswordBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menghantar...';
                changePasswordBtn.disabled = true;
                
                try {
                    const response = await fetch('/change-password', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        changePasswordAlert.innerHTML = `
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>${result.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        `;
                        changePasswordForm.reset();
                        setTimeout(() => {
                            changePasswordModal.hide();
                        }, 2000);
                    } else {
                        changePasswordAlert.innerHTML = `
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>${result.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        `;
                    }
                } catch (error) {
                    console.error('Change password error:', error);
                    changePasswordAlert.innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>Ralat sistem. Sila cuba lagi.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    `;
                } finally {
                    changePasswordBtn.innerHTML = '<i class="fas fa-save me-2"></i>Tukar Kata Laluan';
                    changePasswordBtn.disabled = false;
                }
            });

            // Reset form when modal is hidden
            document.getElementById('changePasswordModal').addEventListener('hidden.bs.modal', function() {
                changePasswordForm.reset();
                changePasswordAlert.innerHTML = '';
            });

            // Add focus effects to inputs
            const inputs = changePasswordForm.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.style.borderColor = '#667eea';
                    this.style.boxShadow = '0 0 0 0.2rem rgba(102, 126, 234, 0.25)';
                });
                
                input.addEventListener('blur', function() {
                    this.style.borderColor = '#e9ecef';
                    this.style.boxShadow = 'none';
                });
            });
        });
    </script>
</body>
</html>