<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>404 Page Not Found</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f1fbf6;
            color: #0b0c0f;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .error-container {
            width: 100%;
            max-width: 600px;
        }

        .error-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #eceff3;
            padding: 40px 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .error-icon {
            font-size: 64px;
            color: #ffcc00;
            margin-bottom: 20px;
            display: block;
        }

        .error-title {
            font-size: 28px;
            font-weight: 600;
            color: #0b0c0f;
            margin-bottom: 10px;
        }

        .error-message {
            font-size: 16px;
            color: #6c757d;
            margin-bottom: 30px;
            line-height: 1.5;
        }

        .error-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ffcc00 0%, #ffd84d 100%);
            color: #0b0c0f;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #ffd84d 0%, #ffcc00 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 204, 0, 0.3);
        }

        .btn-secondary {
            background: #f8f9fa;
            color: #6c757d;
            border: 1px solid #dee2e6;
        }

        .btn-secondary:hover {
            background: #e9ecef;
            color: #495057;
        }

        @media (max-width: 480px) {
            .error-card {
                padding: 30px 20px;
            }

            .error-icon {
                font-size: 48px;
            }

            .error-title {
                font-size: 24px;
            }

            .error-actions {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-card">
            <i class="fas fa-exclamation-triangle error-icon"></i>
            <h1 class="error-title">404 - Halaman Tidak Dijumpai</h1>
            <p class="error-message">
                Halaman yang anda cari tidak wujud atau telah dipindahkan.
            </p>
            <div class="error-actions">
                <a href="/" class="btn btn-primary">
                    <i class="fas fa-home"></i>
                    Kembali ke Halaman Utama
                </a>
                <a href="javascript:history.back()" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>
</body>
</html>