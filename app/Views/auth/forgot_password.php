<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Laluan - Sistem Tempahan Fasiliti</title>
    <link rel="icon" href="/images/kedah-coat.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --soft-green-gradient: linear-gradient(135deg, #a8edec 0%, #fed6e3 100%);
            --card-shadow: 0 10px 30px rgba(0,0,0,0.1);
            --card-shadow-hover: 0 20px 40px rgba(0,0,0,0.15);
            
            /* Typography Scale */
            --fs-body: 0.875rem;
            --fs-small: 0.8125rem;
            --fs-input: 0.875rem;
            --fs-h1: 1.25rem;
            --fs-h2: 1.125rem;
            --fs-h3: 1rem;
            --lh-tight: 1.3;
            --lh-normal: 1.5;
            --lh-relaxed: 1.6;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            margin: 0;
            font-size: var(--fs-body);
            line-height: var(--lh-normal);
        }
        
        h1, .h1 { font-size: var(--fs-h1); line-height: var(--lh-tight); font-weight: 600; }
        h2, .h2 { font-size: var(--fs-h2); line-height: var(--lh-tight); font-weight: 600; }
        h3, .h3 { font-size: var(--fs-h3); line-height: var(--lh-tight); font-weight: 600; }
        
        .small, small { font-size: var(--fs-small); }
        
        .btn { font-size: var(--fs-input); line-height: 1.2; }
        input, select, textarea, .form-control { font-size: var(--fs-input); line-height: 1.4; }
        label, .form-label { font-size: var(--fs-small); font-weight: 500; }

        .navbar-custom {
            background: var(--primary-gradient) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
        }

        .forgot-section {
            padding: 120px 0 80px;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .forgot-card {
            background: white;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            max-width: 500px;
            margin: 0 auto;
            transition: all 0.3s ease;
        }

        .forgot-card:hover {
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-5px);
        }

        .forgot-header {
            background: var(--soft-green-gradient);
            color: #2c3e50;
            padding: 2.5rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .forgot-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }

        .forgot-header h2 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .forgot-header p {
            font-size: 1rem;
            margin-bottom: 0;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .forgot-body {
            padding: 2.5rem;
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-floating > label {
            padding: 1rem 0.75rem;
            font-weight: 500;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 1rem 3rem 1rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            min-height: 50px;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .input-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 5;
        }

        .btn-reset {
            background: var(--primary-gradient);
            border: none;
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            min-height: 50px;
            width: 100%;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .back-to-login {
            text-align: center;
            margin-top: 1.5rem;
        }

        .back-to-login a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .back-to-login a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
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

        @media (max-width: 576px) {
            .forgot-section {
                padding: 100px 1rem 40px;
            }

            .forgot-header {
                padding: 2rem 1.5rem;
            }

            .forgot-header h2 {
                font-size: 1.8rem;
            }

            .forgot-body {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand text-white fw-bold" href="/">
                <i class="fas fa-calendar-check me-2"></i>Sistem Tempahan Fasiliti
            </a>

            <div class="d-flex ms-auto">
                <span class="text-white">Sistem Tempahan Fasiliti</span>
            </div>
        </div>
    </nav>

    <!-- Forgot Password Section -->
    <section class="forgot-section">
        <div class="container">
            <div class="forgot-card fade-in-up">
                <div class="forgot-header">
                    <h2 class="mb-0"><i class="fas fa-key me-2"></i>Lupa Kata Laluan</h2>
                    <p class="mb-0 mt-2 opacity-75">Masukkan emel anda untuk menerima pautan tetapan semula</p>
                </div>
                <div class="forgot-body">
                    <?php if (session()->has('error')): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i><?= session('error') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->has('success')): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i><?= session('success') ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="/forgot-password">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="nama@contoh.com" required>
                            <label for="email"><i class="fas fa-envelope me-2"></i>Emel</label>
                            <i class="fas fa-envelope input-icon"></i>
                        </div>

                        <button type="submit" class="btn btn-primary btn-reset">
                            <i class="fas fa-paper-plane me-2"></i>Hantar Pautan Tetapan Semula
                        </button>

                        <div class="back-to-login">
                            <a href="/login">
                                <i class="fas fa-arrow-left me-1"></i>Kembali ke Log Masuk
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-focus on email field
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('email').focus();
        });
    </script>
</body>
</html>