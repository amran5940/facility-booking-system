<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <title>Sistem Tempahan Fasiliti - Admin</title>
    <link rel="icon" href="/images/kedah-coat.svg">
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
                <i class="fas fa-user-shield"></i>
                <?= lang('App.admin_panel') ?>
            </h5>
        </div>
        <ul class="nav flex-column px-2">
            <!-- Main navigation links -->
            <li class="nav-item">
                <a class="nav-link" href="/admin/agencies">
                    <i class="fas fa-building"></i>
                    <span><?= lang('App.agencies') ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/facilities">
                    <i class="fas fa-map-marker-alt"></i>
                    <span><?= lang('App.facilities') ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/dashboard">
                    <i class="fas fa-chart-line"></i>
                    <span><?= lang('App.dashboard') ?></span>
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
                <a class="nav-link" href="/admin/users">
                    <i class="fas fa-users"></i>
                    <span>Pengguna</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/bookings">
                    <i class="fas fa-calendar-check"></i>
                    <span><?= lang('App.bookings') ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/change-password">
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
                <span class="brand-logo">Sistem Tempahan Fasiliti</span>
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
    </script>
</body>
</html>