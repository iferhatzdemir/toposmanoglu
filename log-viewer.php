<?php
/**
 * Professional Log Viewer
 * Beautiful web interface for viewing application logs
 */

session_start();

// Security check - only allow admin access
if (empty($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Simple authentication
    if (isset($_POST['password']) && $_POST['password'] === 'admin123') {
        $_SESSION['admin'] = true;
        header('Location: log-viewer.php');
        exit;
    }

    // Show login form
    ?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Log Viewer - Login</title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
            }
            .login-box {
                background: white;
                padding: 40px;
                border-radius: 20px;
                box-shadow: 0 20px 60px rgba(0,0,0,0.3);
                width: 400px;
            }
            .login-box h2 {
                color: #2c3e50;
                margin-bottom: 30px;
                text-align: center;
            }
            .login-box input {
                width: 100%;
                padding: 15px;
                border: 2px solid #e8e8e8;
                border-radius: 10px;
                font-size: 15px;
                margin-bottom: 20px;
            }
            .login-box button {
                width: 100%;
                padding: 15px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border: none;
                border-radius: 10px;
                font-size: 16px;
                font-weight: 600;
                cursor: pointer;
            }
            .login-box button:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            }
        </style>
    </head>
    <body>
        <div class="login-box">
            <h2>🔒 Log Viewer</h2>
            <form method="post">
                <input type="password" name="password" placeholder="Şifre girin" required autofocus>
                <button type="submit">Giriş Yap</button>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Load logger
require_once __DIR__ . '/core/Logger.php';
$logger = new Logger(__DIR__ . '/logs/');

// Handle actions
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'download':
            if (isset($_GET['file'])) {
                $file = basename($_GET['file']);
                $filePath = __DIR__ . '/logs/' . $file;
                if (file_exists($filePath)) {
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="' . $file . '"');
                    readfile($filePath);
                    exit;
                }
            }
            break;

        case 'clear':
            if (isset($_GET['file'])) {
                $file = basename($_GET['file']);
                $filePath = __DIR__ . '/logs/' . $file;
                if (file_exists($filePath)) {
                    file_put_contents($filePath, '');
                    header('Location: log-viewer.php?success=cleared');
                    exit;
                }
            }
            break;

        case 'logout':
            session_destroy();
            header('Location: log-viewer.php');
            exit;
    }
}

// Get log files and stats
$logFiles = $logger->getLogFiles();
$stats = $logger->getStats();

// Get current log file
$currentFile = $_GET['file'] ?? basename($logFiles[0] ?? 'app_' . date('Y-m-d') . '.log');
$logLines = $logger->readLog($currentFile, 500);

// Filter by level
$filterLevel = $_GET['level'] ?? 'ALL';
if ($filterLevel !== 'ALL') {
    $logLines = array_filter($logLines, function($line) use ($filterLevel) {
        return strpos($line, "[{$filterLevel}") !== false;
    });
}

// Search
$searchQuery = $_GET['search'] ?? '';
if ($searchQuery !== '') {
    $logLines = array_filter($logLines, function($line) use ($searchQuery) {
        return stripos($line, $searchQuery) !== false;
    });
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📊 Log Viewer - Professional Monitoring</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            color: #2c3e50;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
        }
        .header h1 {
            font-size: 28px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .logout-btn {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s;
        }
        .logout-btn:hover {
            background: rgba(255,255,255,0.3);
        }

        /* Container */
        .container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 30px;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }
        .stat-card h3 {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .stat-card .value {
            font-size: 32px;
            font-weight: 700;
            color: #2c3e50;
        }
        .stat-card .icon {
            float: right;
            font-size: 40px;
            opacity: 0.2;
        }

        /* Controls */
        .controls {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }
        .controls-row {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
        }
        .control-group {
            flex: 1;
            min-width: 200px;
        }
        .control-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 8px;
        }
        .control-group select,
        .control-group input {
            width: 100%;
            padding: 10px 15px;
            border: 2px solid #e8e8e8;
            border-radius: 8px;
            font-size: 14px;
        }
        .control-group button {
            width: 100%;
            padding: 10px 20px;
            background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        .control-group button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(118, 167, 19, 0.4);
        }

        /* Log Viewer */
        .log-viewer {
            background: #1e1e1e;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
        }
        .log-header {
            background: #2d2d2d;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #3e3e3e;
        }
        .log-header h3 {
            color: #fff;
            font-size: 16px;
        }
        .log-actions {
            display: flex;
            gap: 10px;
        }
        .log-actions a {
            padding: 8px 15px;
            background: rgba(255,255,255,0.1);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 13px;
            transition: all 0.3s;
        }
        .log-actions a:hover {
            background: rgba(255,255,255,0.2);
        }
        .log-content {
            padding: 20px;
            max-height: 600px;
            overflow-y: auto;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            line-height: 1.6;
        }
        .log-line {
            color: #d4d4d4;
            padding: 5px 0;
            border-bottom: 1px solid #2d2d2d;
        }
        .log-line:hover {
            background: #2d2d2d;
        }

        /* Log Level Colors */
        .log-line:contains('EMERGENCY') { color: #ff0000; font-weight: 700; }
        .log-line:contains('ALERT') { color: #ff4444; font-weight: 700; }
        .log-line:contains('CRITICAL') { color: #ff6b6b; font-weight: 700; }
        .log-line:contains('ERROR') { color: #ff8787; }
        .log-line:contains('WARNING') { color: #ffa500; }
        .log-line:contains('NOTICE') { color: #00bfff; }
        .log-line:contains('INFO') { color: #7cfc00; }
        .log-line:contains('DEBUG') { color: #a9a9a9; }

        .timestamp { color: #6c757d; }
        .level { font-weight: 700; }
        .file-info { color: #4fc3f7; }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        /* Scrollbar */
        .log-content::-webkit-scrollbar {
            width: 10px;
        }
        .log-content::-webkit-scrollbar-track {
            background: #2d2d2d;
        }
        .log-content::-webkit-scrollbar-thumb {
            background: #555;
            border-radius: 5px;
        }
        .log-content::-webkit-scrollbar-thumb:hover {
            background: #777;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 15px;
            }
            .controls-row {
                flex-direction: column;
            }
            .log-content {
                font-size: 11px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <h1><i class="fas fa-chart-line"></i> Log Viewer</h1>
            <a href="?action=logout" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Çıkış
            </a>
        </div>
    </div>

    <!-- Container -->
    <div class="container">
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-file-alt icon"></i>
                <h3>Toplam Dosya</h3>
                <div class="value"><?= $stats['total_files'] ?></div>
            </div>
            <div class="stat-card">
                <i class="fas fa-hdd icon"></i>
                <h3>Toplam Boyut</h3>
                <div class="value"><?= $stats['total_size_mb'] ?> MB</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-exclamation-triangle icon"></i>
                <h3>Error</h3>
                <div class="value"><?= $stats['log_counts']['ERROR'] ?? 0 ?></div>
            </div>
            <div class="stat-card">
                <i class="fas fa-exclamation-circle icon"></i>
                <h3>Warning</h3>
                <div class="value"><?= $stats['log_counts']['WARNING'] ?? 0 ?></div>
            </div>
        </div>

        <!-- Controls -->
        <div class="controls">
            <form method="get" class="controls-row">
                <div class="control-group">
                    <label>Log Dosyası</label>
                    <select name="file" onchange="this.form.submit()">
                        <?php foreach ($logFiles as $file): ?>
                            <?php $fileName = basename($file); ?>
                            <option value="<?= $fileName ?>" <?= $fileName === $currentFile ? 'selected' : '' ?>>
                                <?= $fileName ?> (<?= number_format(filesize($file) / 1024, 2) ?> KB)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="control-group">
                    <label>Seviye Filtrele</label>
                    <select name="level" onchange="this.form.submit()">
                        <option value="ALL">Tümü</option>
                        <option value="EMERGENCY" <?= $filterLevel === 'EMERGENCY' ? 'selected' : '' ?>>Emergency</option>
                        <option value="ALERT" <?= $filterLevel === 'ALERT' ? 'selected' : '' ?>>Alert</option>
                        <option value="CRITICAL" <?= $filterLevel === 'CRITICAL' ? 'selected' : '' ?>>Critical</option>
                        <option value="ERROR" <?= $filterLevel === 'ERROR' ? 'selected' : '' ?>>Error</option>
                        <option value="WARNING" <?= $filterLevel === 'WARNING' ? 'selected' : '' ?>>Warning</option>
                        <option value="NOTICE" <?= $filterLevel === 'NOTICE' ? 'selected' : '' ?>>Notice</option>
                        <option value="INFO" <?= $filterLevel === 'INFO' ? 'selected' : '' ?>>Info</option>
                        <option value="DEBUG" <?= $filterLevel === 'DEBUG' ? 'selected' : '' ?>>Debug</option>
                    </select>
                </div>

                <div class="control-group">
                    <label>Ara</label>
                    <input type="text" name="search" value="<?= htmlspecialchars($searchQuery) ?>" placeholder="Log içeriğinde ara...">
                </div>

                <div class="control-group" style="padding-top: 24px;">
                    <button type="submit"><i class="fas fa-search"></i> Filtrele</button>
                </div>
            </form>
        </div>

        <!-- Log Viewer -->
        <div class="log-viewer">
            <div class="log-header">
                <h3><i class="fas fa-terminal"></i> <?= $currentFile ?></h3>
                <div class="log-actions">
                    <a href="?action=download&file=<?= $currentFile ?>">
                        <i class="fas fa-download"></i> İndir
                    </a>
                    <a href="?action=clear&file=<?= $currentFile ?>" onclick="return confirm('Bu log dosyasını temizlemek istediğinize emin misiniz?')">
                        <i class="fas fa-trash"></i> Temizle
                    </a>
                    <a href="?file=<?= $currentFile ?>" title="Yenile">
                        <i class="fas fa-sync"></i> Yenile
                    </a>
                </div>
            </div>

            <div class="log-content">
                <?php if (empty($logLines)): ?>
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h3>Log bulunamadı</h3>
                        <p>Seçili dosya boş veya filtreye uygun log yok</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($logLines as $line): ?>
                        <div class="log-line"><?= htmlspecialchars(trim($line)) ?></div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Auto-refresh every 10 seconds
        setTimeout(function() {
            location.reload();
        }, 10000);

        // Highlight search terms
        <?php if ($searchQuery !== ''): ?>
        const searchTerm = <?= json_encode($searchQuery) ?>;
        const logLines = document.querySelectorAll('.log-line');
        logLines.forEach(line => {
            const text = line.textContent;
            const regex = new RegExp(searchTerm, 'gi');
            line.innerHTML = text.replace(regex, '<span style="background: yellow; color: black;">$&</span>');
        });
        <?php endif; ?>
    </script>
</body>
</html>
