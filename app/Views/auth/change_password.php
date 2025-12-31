<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tukar Kata Laluan - Sistem Tempahan Fasiliti</title>
    <link rel="icon" href="/images/kedah-coat.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
            font-size: var(--fs-body);
            line-height: var(--lh-normal);
        }
        
        h1, .h1 { font-size: var(--fs-h1); line-height: var(--lh-tight); font-weight: 600; }
        h2, .h2 { font-size: var(--fs-h2); line-height: var(--lh-tight); font-weight: 600; }
        h3, .h3 { font-size: var(--fs-h3); line-height: var(--lh-tight); font-weight: 600; }
        h4, .h4 { font-size: var(--fs-h3); line-height: var(--lh-tight); font-weight: 600; }
        
        .small, small { font-size: var(--fs-small); }
        
        .btn { font-size: var(--fs-input); line-height: 1.2; }
        input, select, textarea, .form-control { font-size: var(--fs-input); line-height: 1.4; }
        label, .form-label { font-size: var(--fs-small); font-weight: 500; }

        .change-password-container {
            max-width: 500px;
            width: 100%;
        }

        .change-password-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            overflow: hidden;
        }

        .card-header {
            background: var(--primary-gradient);
            color: white;
            text-align: center;
            padding: 2rem;
            border: none;
        }

        .card-header h4 {
            margin: 0;
            font-weight: 700;
            font-size: var(--fs-h1);
        }

        .card-header p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
            font-size: var(--fs-small);
        }

        .card-body {
            padding: 2rem;
        }

        .form-label {
            font-weight: 600;
            color: #0b0c0f;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 2px solid #eceff3;
            border-radius: 12px;
            padding: 0.875rem 1rem;
            transition: all 0.3s ease;
            font-size: var(--fs-input);
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .input-group-text {
            background: #f8f9fa;
            border: 2px solid #eceff3;
            border-right: none;
            color: #667eea;
        }

        .form-control:focus + .input-group-text,
        .input-group-text:focus {
            border-color: #667eea;
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 25px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            font-size: var(--fs-input);
            transition: all 0.3s ease;
            box-shadow: 0 10px 24px rgba(102, 126, 234, 0.35);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            border-radius: 25px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border: 2px solid #6c757d;
        }

        .alert {
            border-radius: 12px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .text-muted {
            font-size: var(--fs-small);
        }

        .back-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="change-password-container">
        <div class="change-password-card">
            <div class="card-header">
                <h4><i class="fas fa-key me-2"></i>Tukar Kata Laluan</h4>
                <p>Kemas kini kata laluan akaun anda untuk keselamatan yang lebih baik</p>
            </div>
            <div class="card-body">
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

                <form action="/change-password" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="current_password" class="form-label">
                            <i class="fas fa-lock me-1"></i>Kata Laluan Semasa
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                            <span class="input-group-text">
                                <i class="fas fa-eye" id="toggleCurrentPassword"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">
                            <i class="fas fa-lock-open me-1"></i>Kata Laluan Baharu
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="new_password" name="new_password" required minlength="8">
                            <span class="input-group-text">
                                <i class="fas fa-eye" id="toggleNewPassword"></i>
                            </span>
                        </div>
                        <small class="form-text text-muted">Kata laluan mesti sekurang-kurangnya 8 aksara</small>
                    </div>

                    <div class="mb-4">
                        <label for="confirm_password" class="form-label">
                            <i class="fas fa-check-circle me-1"></i>Sahkan Kata Laluan Baharu
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required minlength="8">
                            <span class="input-group-text">
                                <i class="fas fa-eye" id="toggleConfirmPassword"></i>
                            </span>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Tukar Kata Laluan
                        </button>
                        <a href="javascript:history.back()" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Password visibility toggles
        document.getElementById('toggleCurrentPassword').addEventListener('click', function() {
            const input = document.getElementById('current_password');
            const icon = this;
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
            }
        });

        document.getElementById('toggleNewPassword').addEventListener('click', function() {
            const input = document.getElementById('new_password');
            const icon = this;
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
            }
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const input = document.getElementById('confirm_password');
            const icon = this;
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
            }
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>