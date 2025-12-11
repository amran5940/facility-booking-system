<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($title) ?></title>

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

        h1 {
            font-size: 32px;
            font-weight: 700;
            color: #0b0c0f;
            margin-bottom: 12px;
            line-height: 1.3;
        }

        .error-message {
            font-size: 16px;
            color: #4a5568;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 24px;
            border-radius: 8px;
            border: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ffcc00 0%, #ffd84d 100%);
            color: #0b0c0f;
            box-shadow: 0 10px 24px rgba(255, 204, 0, 0.35);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 32px rgba(255, 204, 0, 0.45);
        }

        .btn-secondary {
            background: white;
            color: #0b0c0f;
            border: 2px solid #eceff3;
        }

        .btn-secondary:hover {
            border-color: #ffcc00;
            background: #fffef5;
        }

        .debug-section {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #eceff3;
            text-align: left;
        }

        .debug-section h2 {
            font-size: 16px;
            font-weight: 700;
            color: #0b0c0f;
            margin-bottom: 16px;
        }

        .debug-item {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 8px;
            border-left: 3px solid #ffcc00;
        }

        .debug-item strong {
            color: #0b0c0f;
            display: block;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .debug-item span {
            color: #4a5568;
            font-size: 13px;
            word-break: break-all;
            font-family: 'Courier New', monospace;
        }

        .backtrace {
            background: #f8f9fa;
            padding: 16px;
            border-radius: 6px;
            overflow-x: auto;
            margin-top: 12px;
            border: 1px solid #eceff3;
        }

        .backtrace-item {
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #eceff3;
            font-size: 12px;
            font-family: 'Courier New', monospace;
        }

        .backtrace-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .backtrace-item strong {
            color: #ffcc00;
        }

        .backtrace-item span {
            color: #4a5568;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-card">
            <i class="fas fa-exclamation-circle error-icon"></i>
            <h1><?= esc($title) ?></h1>
            <p class="error-message"><?= esc($message) ?></p>

            <div class="action-buttons">
                <a href="/" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i>Go Home
                </a>
                <a href="javascript:history.back()" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Go Back
                </a>
            </div>

            <?php if (ENVIRONMENT !== 'production') : ?>
                <div class="debug-section">
                    <h2><i class="fas fa-bug me-2" style="color: #ffcc00;"></i>Exception Details</h2>

                    <div class="debug-item">
                        <strong>Exception Type:</strong>
                        <span><?= esc(get_class($exception)) ?></span>
                    </div>

                    <div class="debug-item">
                        <strong>Message:</strong>
                        <span><?= esc($exception->getMessage()) ?></span>
                    </div>

                    <div class="debug-item">
                        <strong>File:</strong>
                        <span><?= esc($exception->getFile()) ?></span>
                    </div>

                    <div class="debug-item">
                        <strong>Line Number:</strong>
                        <span><?= esc($exception->getLine()) ?></span>
                    </div>

                    <?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === true) : ?>
                        <h2 style="margin-top: 24px;"><i class="fas fa-code-branch me-2" style="color: #ffcc00;"></i>Backtrace</h2>
                        <div class="backtrace">
                            <?php foreach ($exception->getTrace() as $idx => $error) : ?>
                                <div class="backtrace-item">
                                    <strong>#<?= $idx ?>:</strong>
                                    <br>
                                    <span><strong>File:</strong> <?= esc($error['file'] ?? 'unknown') ?></span>
                                    <br>
                                    <span><strong>Line:</strong> <?= esc($error['line'] ?? 'unknown') ?></span>
                                    <br>
                                    <span><strong>Function:</strong> <?= esc($error['function'] ?? 'unknown') ?></span>
                                </div>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                </div>
            <?php endif ?>
        </div>
    </div>
</body>
</html></content>
<parameter name="filePath">c:\xampp\htdocs\am\app\Views\errors\html\error_exception.php