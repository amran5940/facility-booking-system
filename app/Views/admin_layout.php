<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <title>Sistem Tempahan Aset - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            --quest-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --light-green-gradient: linear-gradient(135deg, #a8e6cf 0%, #dcedc8 100%);
            --light-indigo-gradient: linear-gradient(135deg, #a8c0ff 0%, #c1cefe 100%);
            --success-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --danger-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --dark-gradient: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            --sidebar-bg: linear-gradient(180deg, #2c3e50 0%, #34495e 50%, #2c3e50 100%);
            --card-shadow: 0 10px 30px rgba(0,0,0,0.1);
            --card-shadow-hover: 0 20px 40px rgba(0,0,0,0.15);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
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
            background: var(--primary-gradient);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
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
            background: var(--primary-gradient);
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
            color: #667eea;
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
            background: var(--primary-gradient);
            border: none;
            border-radius: 10px;
            padding: 0.5rem;
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
        }

        .mobile-menu-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h5>
                <i class="fas fa-crown"></i>
                <?= lang('App.admin_panel') ?>
            </h5>
        </div>
        <ul class="nav flex-column px-2">
            <li class="nav-item">
                <a class="nav-link" href="/admin">
                    <i class="fas fa-chart-line"></i>
                    <span><?= lang('App.dashboard') ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/agencies">
                    <i class="fas fa-building"></i>
                    <span><?= lang('App.agencies') ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/facility-categories">
                    <i class="fas fa-tags"></i>
                    <span>Kategori</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/managers">
                    <i class="fas fa-user-tie"></i>
                    <span><?= lang('App.managers') ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/facilities">
                    <i class="fas fa-map-marker-alt"></i>
                    <span><?= lang('App.facilities') ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/bookings">
                    <i class="fas fa-calendar-check"></i>
                    <span><?= lang('App.bookings') ?></span>
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
                    <span><?= lang('App.logout') ?></span>
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
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="d-none d-md-block">
                        <small class="text-muted d-block">Selamat datang</small>
                        <strong><?= session('user')['full_name'] ?? 'Admin' ?></strong>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page content -->
        <div class="content-wrapper">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: var(--card-shadow);">
                <div class="modal-header" style="background: var(--quest-gradient); color: white; border-radius: 15px 15px 0 0; border-bottom: none;">
                    <h5 class="modal-title" id="changePasswordModalLabel">
                        <i class="fas fa-key me-2"></i>Tukar Kata Laluan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="changePasswordAlert" style="display: none;"></div>
                    <form id="changePasswordForm">
                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-semibold">
                                <i class="fas fa-lock me-1"></i>Kata Laluan Semasa
                            </label>
                            <input type="password" class="form-control form-control-lg" id="current_password" name="current_password" required style="border-radius: 10px; border: 2px solid #e9ecef;">
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label fw-semibold">
                                <i class="fas fa-lock me-1"></i>Kata Laluan Baharu
                            </label>
                            <input type="password" class="form-control form-control-lg" id="new_password" name="new_password" required style="border-radius: 10px; border: 2px solid #e9ecef;">
                            <div class="form-text">Kata laluan mesti sekurang-kurangnya 8 aksara</div>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label fw-semibold">
                                <i class="fas fa-lock me-1"></i>Sahkan Kata Laluan Baharu
                            </label>
                            <input type="password" class="form-control form-control-lg" id="confirm_password" name="confirm_password" required style="border-radius: 10px; border: 2px solid #e9ecef;">
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-secondary btn-lg me-2" data-bs-dismiss="modal" style="border-radius: 25px; padding: 0.5rem 1.5rem;">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="button" class="btn btn-primary btn-lg" id="changePasswordBtn" style="background: var(--quest-gradient); border: none; border-radius: 25px; padding: 0.5rem 1.5rem;">
                        <i class="fas fa-save me-1"></i>Tukar Kata Laluan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        // Add loading animation
        window.addEventListener('load', function() {
            document.body.classList.add('loaded');
        });

        // Change Password Modal Functionality
        document.getElementById('changePasswordBtn').addEventListener('click', function() {
            const form = document.getElementById('changePasswordForm');
            const formData = new FormData(form);
            const alertDiv = document.getElementById('changePasswordAlert');

            // Clear previous alerts
            alertDiv.style.display = 'none';
            alertDiv.className = 'alert';

            // Basic client-side validation
            const newPassword = formData.get('new_password');
            const confirmPassword = formData.get('confirm_password');

            if (newPassword !== confirmPassword) {
                alertDiv.className = 'alert alert-danger';
                alertDiv.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Kata laluan baharu tidak sepadan';
                alertDiv.style.display = 'block';
                return;
            }

            if (newPassword.length < 8) {
                alertDiv.className = 'alert alert-danger';
                alertDiv.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Kata laluan baharu mesti sekurang-kurangnya 8 aksara';
                alertDiv.style.display = 'block';
                return;
            }

            // Show loading state
            const btn = document.getElementById('changePasswordBtn');
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Memproses...';
            btn.disabled = true;

            // Submit form via AJAX
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            formData.append('csrf_test_name', csrfToken);

            fetch('/change-password', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alertDiv.className = 'alert alert-success';
                    alertDiv.innerHTML = '<i class="fas fa-check-circle me-2"></i>' + data.message;
                    alertDiv.style.display = 'block';

                    // Reset form and close modal after success
                    setTimeout(() => {
                        form.reset();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('changePasswordModal'));
                        modal.hide();
                    }, 2000);
                } else {
                    alertDiv.className = 'alert alert-danger';
                    alertDiv.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>' + data.message;
                    alertDiv.style.display = 'block';
                }
            })
            .catch(error => {
                alertDiv.className = 'alert alert-danger';
                alertDiv.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Ralat berlaku. Sila cuba lagi.';
                alertDiv.style.display = 'block';
                console.error('Error:', error);
            })
            .finally(() => {
                // Reset button state
                btn.innerHTML = originalHtml;
                btn.disabled = false;
            });
        });

        // Reset form when modal is closed
        document.getElementById('changePasswordModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('changePasswordForm').reset();
            document.getElementById('changePasswordAlert').style.display = 'none';
        });
    </script>
</body>
</html>