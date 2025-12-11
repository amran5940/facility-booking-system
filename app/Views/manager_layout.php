<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Tempahan Aset - Pengurus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --manager-gradient: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            --sidebar-bg: linear-gradient(180deg, #667eea 0%, #764ba2 50%, #667eea 100%);
            --card-shadow: 0 10px 30px rgba(0,0,0,0.1);
            --card-shadow-hover: 0 20px 40px rgba(0,0,0,0.15);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .sidebar {
            min-height: 100vh;
            background: var(--sidebar-bg);
            color: white;
            box-shadow: 5px 0 15px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.75rem 1.5rem;
            margin: 0.25rem 0.5rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .sidebar .nav-link:hover {
            color: white;
            background: rgba(255,255,255,0.1);
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .sidebar .nav-link.active {
            color: white;
            background: var(--success-gradient);
            box-shadow: 0 5px 15px rgba(240, 147, 251, 0.3);
        }

        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }

        .main-content {
            margin-left: 0;
            min-height: 100vh;
        }

        @media (min-width: 768px) {
            .main-content {
                margin-left: 280px;
            }
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: -280px;
            width: 280px;
            z-index: 1000;
            transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar.show {
            left: 0;
        }

        @media (min-width: 768px) {
            .sidebar {
                left: 0;
            }
        }

        .top-navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0,0,0,0.1);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-left: 0;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        @media (min-width: 768px) {
            .top-navbar {
                margin-left: 280px;
            }
        }

        .content-wrapper {
            padding: 2rem;
            max-width: 100%;
        }

        .brand-logo {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--success-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .sidebar-header {
            padding: 2rem 1.5rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 1rem;
        }

        .sidebar-header h5 {
            font-weight: 700;
            margin-bottom: 0;
            font-size: 1.25rem;
        }

        .sidebar-header i {
            color: #f093fb;
            margin-right: 0.5rem;
        }

        /* Custom scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }

        /* Mobile menu button */
        .mobile-menu-btn {
            background: var(--success-gradient);
            border: none;
            border-radius: 10px;
            padding: 0.5rem;
            color: white;
            box-shadow: 0 4px 15px rgba(240, 147, 251, 0.3);
            transition: all 0.3s ease;
        }

        .mobile-menu-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(240, 147, 251, 0.4);
        }

        /* Alert styles */
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
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h5>
                <i class="fas fa-user-tie"></i>
                Panel Pengurus
            </h5>
        </div>
        <ul class="nav flex-column px-2">
            <li class="nav-item">
                <a class="nav-link" href="/manager">
                    <i class="fas fa-chart-line"></i>
                    <span>Papan Pemuka</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/manager/facilities">
                    <i class="fas fa-building"></i>
                    <span>Fasiliti</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/manager/bookings">
                    <i class="fas fa-calendar-check"></i>
                    <span>Tempahan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    <i class="fas fa-key"></i>
                    <span>Tukar Kata Laluan</span>
                </a>
            </li>
            <li class="nav-item mt-auto">
                <a class="nav-link text-danger" href="/logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Log Keluar</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main content -->
    <div class="main-content">
        <!-- Top navbar -->
        <nav class="navbar navbar-expand-lg navbar-light top-navbar">
            <div class="container-fluid">
                <button class="btn mobile-menu-btn d-md-none me-3" type="button" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="brand-logo">Sistem Tempahan Aset</span>
                <div class="d-flex align-items-center">
                    <div class="user-avatar me-2">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="d-none d-md-block">
                        <small class="text-muted d-block">Selamat datang</small>
                        <strong><?= session('user')['full_name'] ?? 'Pengurus' ?></strong>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page content -->
        <div class="content-wrapper">
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }

        // Set active menu item
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.sidebar .nav-link');

            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });

            // Add smooth scrolling
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Change Password Modal Functionality
        const changePasswordForm = document.getElementById('changePasswordForm');
        const changePasswordBtn = document.getElementById('changePasswordBtn');
        const changePasswordAlert = document.getElementById('changePasswordAlert');
        const changePasswordModal = new bootstrap.Modal(document.getElementById('changePasswordModal'));

        if (changePasswordForm) {
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
                    this.style.borderColor = '#eceff3';
                    this.style.boxShadow = 'none';
                });
            });
        }
    </script>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">
                <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 20px 20px 0 0; border-bottom: none; padding: 2rem;">
                    <h5 class="modal-title" id="changePasswordModalLabel">
                        <i class="fas fa-key me-2"></i>Tukar Kata Laluan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 2rem;">
                    <div id="changePasswordAlert"></div>
                    <form id="changePasswordForm">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <div class="mb-3">
                            <label for="current_password" class="form-label" style="font-weight: 600; color: #0b0c0f;">
                                <i class="fas fa-lock me-2" style="color: #667eea;"></i>Kata Laluan Semasa
                            </label>
                            <input type="password" class="form-control" id="current_password" name="current_password" 
                                   style="border: 2px solid #eceff3; border-radius: 12px; padding: 0.875rem 1rem; transition: all 0.3s ease;" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label" style="font-weight: 600; color: #0b0c0f;">
                                <i class="fas fa-lock-open me-2" style="color: #f093fb;"></i>Kata Laluan Baharu
                            </label>
                            <input type="password" class="form-control" id="new_password" name="new_password" 
                                   style="border: 2px solid #eceff3; border-radius: 12px; padding: 0.875rem 1rem; transition: all 0.3s ease;" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label" style="font-weight: 600; color: #0b0c0f;">
                                <i class="fas fa-check-circle me-2" style="color: #764ba2;"></i>Sahkan Kata Laluan Baharu
                            </label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                   style="border: 2px solid #eceff3; border-radius: 12px; padding: 0.875rem 1rem; transition: all 0.3s ease;" required>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg me-2" id="changePasswordBtn" 
                                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 25px; padding: 0.75rem 2rem; box-shadow: 0 10px 24px rgba(102, 126, 234, 0.35); transition: all 0.3s ease; font-weight: 600;">
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
</body>
</html>