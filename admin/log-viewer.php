<?php
/**
 * Admin Log Viewer
 *
 * Professional web interface for viewing and managing admin logs
 *
 * Features:
 * - Authentication required
 * - View all log files
 * - Filter by log level
 * - Search functionality
 * - Download logs
 * - Clear logs
 * - Auto-refresh
 * - Statistics dashboard
 */

session_start();

// Authentication
$LOG_VIEWER_PASSWORD = 'admin123'; // Change this!

if (!isset($_SESSION['log_viewer_authenticated'])) {
    if (isset($_POST['password'])) {
        if ($_POST['password'] === $LOG_VIEWER_PASSWORD) {
            $_SESSION['log_viewer_authenticated'] = true;
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $loginError = 'Hatalı şifre!';
        }
    }

    if (!isset($_SESSION['log_viewer_authenticated'])) {
        ?>
        <!DOCTYPE html>
        <html lang="tr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Admin Log Viewer - Giriş</title>
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    min-height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                .login-box {
                    background: #fff;
                    padding: 40px;
                    border-radius: 15px;
                    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
                    max-width: 400px;
                    width: 100%;
                    animation: slideIn 0.5s ease;
                }
                @keyframes slideIn {
                    from { opacity: 0; transform: translateY(-30px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                h2 {
                    text-align: center;
                    margin-bottom: 30px;
                    color: #667eea;
                    font-size: 28px;
                }
                .lock-icon {
                    text-align: center;
                    font-size: 60px;
                    margin-bottom: 20px;
                    color: #667eea;
                }
                .form-group {
                    margin-bottom: 20px;
                }
                label {
                    display: block;
                    margin-bottom: 8px;
                    color: #333;
                    font-weight: 600;
                }
                input[type="password"] {
                    width: 100%;
                    padding: 12px 15px;
                    border: 2px solid #e0e0e0;
                    border-radius: 8px;
                    font-size: 16px;
                    transition: all 0.3s;
                }
                input[type="password"]:focus {
                    outline: none;
                    border-color: #667eea;
                    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
                }
                button {
                    width: 100%;
                    padding: 14px;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    color: #fff;
                    border: none;
                    border-radius: 8px;
                    font-size: 16px;
                    font-weight: 600;
                    cursor: pointer;
                    transition: transform 0.2s;
                }
                button:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
                }
                .error {
                    background: #fee;
                    color: #c33;
                    padding: 12px;
                    border-radius: 8px;
                    margin-bottom: 20px;
                    text-align: center;
                    border-left: 4px solid #c33;
                }
            </style>
        </head>
        <body>
            <div class="login-box">
                <div class="lock-icon">🔒</div>
                <h2>Admin Log Viewer</h2>
                <?php if (isset($loginError)): ?>
                    <div class="error"><?= $loginError ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="form-group">
                        <label>Şifre</label>
                        <input type="password" name="password" required autofocus>
                    </div>
                    <button type="submit">Giriş Yap</button>
                </form>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
}

// Logout
if (isset($_GET['logout'])) {
    unset($_SESSION['log_viewer_authenticated']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Include logger
require_once __DIR__ . '/core/Logger.php';
$logger = new Logger(__DIR__ . '/logs');

// Handle actions
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'download':
            if (isset($_GET['file'])) {
                $file = __DIR__ . '/logs/' . basename($_GET['file']);
                if (file_exists($file)) {
                    header('Content-Type: text/plain');
                    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
                    readfile($file);
                    exit;
                }
            }
            break;

        case 'clear':
            if (isset($_GET['file'])) {
                $file = __DIR__ . '/logs/' . basename($_GET['file']);
                if (file_exists($file) && unlink($file)) {
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;
                }
            }
            break;
    }
}

// Get log files
$logFiles = $logger->getLogFiles();

// Get current log file
$currentFile = isset($_GET['file']) ? basename($_GET['file']) : ($logFiles[0]['name'] ?? '');
$currentFilePath = __DIR__ . '/logs/' . $currentFile;

// Get filter level
$filterLevel = $_GET['level'] ?? 'ALL';

// Get search query
$searchQuery = $_GET['search'] ?? '';

// Read current log file
$logContent = '';
$logLines = [];
if (file_exists($currentFilePath)) {
    $logContent = file_get_contents($currentFilePath);
    $logLines = explode("\n", $logContent);
    $logLines = array_filter($logLines); // Remove empty lines

    // Filter by level
    if ($filterLevel !== 'ALL') {
        $logLines = array_filter($logLines, function($line) use ($filterLevel) {
            return strpos($line, "[{$filterLevel}]") !== false;
        });
    }

    // Filter by search query
    if ($searchQuery) {
        $logLines = array_filter($logLines, function($line) use ($searchQuery) {
            return stripos($line, $searchQuery) !== false;
        });
    }

    $logLines = array_reverse($logLines); // Newest first
}

// Calculate statistics
$stats = [
    'total_files' => count($logFiles),
    'total_size' => 0,
    'error_count' => 0,
    'warning_count' => 0
];

foreach ($logFiles as $file) {
    $stats['total_size'] += $file['size'];
}

if ($logContent) {
    $stats['error_count'] = substr_count($logContent, '[ERROR]');
    $stats['warning_count'] = substr_count($logContent, '[WARNING]');
}

function formatBytes($bytes) {
    $units = ['B', 'KB', 'MB', 'GB'];
    for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
        $bytes /= 1024;
    }
    return round($bytes, 2) . ' ' . $units[$i];
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Log Viewer</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Monaco', 'Courier New', monospace;
            background: #1e1e1e;
            color: #d4d4d4;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
        }

        .header h1 {
            color: #fff;
            font-size: 32px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-icon {
            font-size: 40px;
        }

        .header p {
            color: rgba(255,255,255,0.9);
            font-size: 14px;
        }

        .logout-btn {
            float: right;
            padding: 10px 20px;
            background: rgba(255,255,255,0.2);
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .logout-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #252526;
            padding: 25px;
            border-radius: 12px;
            border-left: 4px solid;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        .stat-card.files { border-color: #4ec9b0; }
        .stat-card.size { border-color: #569cd6; }
        .stat-card.errors { border-color: #f48771; }
        .stat-card.warnings { border-color: #dcdcaa; }

        .stat-label {
            font-size: 12px;
            color: #858585;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: bold;
            color: #fff;
        }

        .controls {
            background: #252526;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        .control-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .control-group {
            flex: 1;
            min-width: 200px;
        }

        .control-group label {
            display: block;
            margin-bottom: 8px;
            color: #858585;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        select, input[type="text"] {
            width: 100%;
            padding: 12px 15px;
            background: #1e1e1e;
            border: 1px solid #3c3c3c;
            border-radius: 8px;
            color: #d4d4d4;
            font-size: 14px;
            font-family: inherit;
        }

        select:focus, input[type="text"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .btn {
            padding: 12px 24px;
            background: #667eea;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-danger {
            background: #f48771;
        }

        .btn-danger:hover {
            background: #e36f5b;
        }

        .log-viewer {
            background: #1e1e1e;
            border: 1px solid #3c3c3c;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        .log-header {
            background: #252526;
            padding: 20px;
            border-bottom: 1px solid #3c3c3c;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .log-header h3 {
            color: #4ec9b0;
            font-size: 18px;
        }

        .log-actions {
            display: flex;
            gap: 10px;
        }

        .log-actions a {
            padding: 8px 16px;
            background: #333;
            color: #d4d4d4;
            text-decoration: none;
            border-radius: 6px;
            font-size: 12px;
            transition: all 0.3s;
        }

        .log-actions a:hover {
            background: #444;
        }

        .log-content {
            padding: 20px;
            max-height: 600px;
            overflow-y: auto;
            font-size: 13px;
            line-height: 1.8;
        }

        .log-line {
            padding: 8px 12px;
            margin-bottom: 5px;
            border-radius: 6px;
            background: #252526;
            border-left: 3px solid transparent;
            word-wrap: break-word;
        }

        .log-line.EMERGENCY { border-left-color: #ff0000; background: rgba(255, 0, 0, 0.1); }
        .log-line.ALERT { border-left-color: #ff4500; background: rgba(255, 69, 0, 0.1); }
        .log-line.CRITICAL { border-left-color: #ff6347; background: rgba(255, 99, 71, 0.1); }
        .log-line.ERROR { border-left-color: #f48771; background: rgba(244, 135, 113, 0.1); }
        .log-line.WARNING { border-left-color: #dcdcaa; background: rgba(220, 220, 170, 0.1); }
        .log-line.NOTICE { border-left-color: #569cd6; background: rgba(86, 156, 214, 0.1); }
        .log-line.INFO { border-left-color: #4ec9b0; background: rgba(78, 201, 176, 0.1); }
        .log-line.DEBUG { border-left-color: #858585; background: rgba(133, 133, 133, 0.1); }

        .log-timestamp { color: #858585; }
        .log-level { font-weight: bold; }
        .log-level.EMERGENCY { color: #ff0000; }
        .log-level.ALERT { color: #ff4500; }
        .log-level.CRITICAL { color: #ff6347; }
        .log-level.ERROR { color: #f48771; }
        .log-level.WARNING { color: #dcdcaa; }
        .log-level.NOTICE { color: #569cd6; }
        .log-level.INFO { color: #4ec9b0; }
        .log-level.DEBUG { color: #858585; }

        .highlight {
            background: #ff0;
            color: #000;
            padding: 2px 4px;
            border-radius: 3px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #858585;
        }

        .empty-state-icon {
            font-size: 80px;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        @media (max-width: 768px) {
            .control-row {
                flex-direction: column;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="?logout=1" class="logout-btn">🚪 Çıkış</a>
            <h1><span class="header-icon">📊</span> Admin Log Viewer</h1>
            <p>Profesyonel log izleme ve yönetim sistemi</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card files">
                <div class="stat-label">Toplam Log Dosyası</div>
                <div class="stat-value"><?= $stats['total_files'] ?></div>
            </div>
            <div class="stat-card size">
                <div class="stat-label">Toplam Boyut</div>
                <div class="stat-value"><?= formatBytes($stats['total_size']) ?></div>
            </div>
            <div class="stat-card errors">
                <div class="stat-label">Hata Sayısı</div>
                <div class="stat-value"><?= $stats['error_count'] ?></div>
            </div>
            <div class="stat-card warnings">
                <div class="stat-label">Uyarı Sayısı</div>
                <div class="stat-value"><?= $stats['warning_count'] ?></div>
            </div>
        </div>

        <div class="controls">
            <form method="GET">
                <div class="control-row">
                    <div class="control-group">
                        <label>Log Dosyası</label>
                        <select name="file" onchange="this.form.submit()">
                            <?php foreach ($logFiles as $file): ?>
                                <option value="<?= $file['name'] ?>" <?= $file['name'] === $currentFile ? 'selected' : '' ?>>
                                    <?= $file['name'] ?> (<?= $file['size_formatted'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="control-group">
                        <label>Log Seviyesi</label>
                        <select name="level" onchange="this.form.submit()">
                            <option value="ALL" <?= $filterLevel === 'ALL' ? 'selected' : '' ?>>Tümü</option>
                            <option value="EMERGENCY" <?= $filterLevel === 'EMERGENCY' ? 'selected' : '' ?>>EMERGENCY</option>
                            <option value="ALERT" <?= $filterLevel === 'ALERT' ? 'selected' : '' ?>>ALERT</option>
                            <option value="CRITICAL" <?= $filterLevel === 'CRITICAL' ? 'selected' : '' ?>>CRITICAL</option>
                            <option value="ERROR" <?= $filterLevel === 'ERROR' ? 'selected' : '' ?>>ERROR</option>
                            <option value="WARNING" <?= $filterLevel === 'WARNING' ? 'selected' : '' ?>>WARNING</option>
                            <option value="NOTICE" <?= $filterLevel === 'NOTICE' ? 'selected' : '' ?>>NOTICE</option>
                            <option value="INFO" <?= $filterLevel === 'INFO' ? 'selected' : '' ?>>INFO</option>
                            <option value="DEBUG" <?= $filterLevel === 'DEBUG' ? 'selected' : '' ?>>DEBUG</option>
                        </select>
                    </div>

                    <div class="control-group">
                        <label>Ara</label>
                        <input type="text" name="search" value="<?= htmlspecialchars($searchQuery) ?>" placeholder="Log içeriğinde ara...">
                    </div>

                    <div class="control-group" style="display: flex; align-items: flex-end;">
                        <button type="submit" class="btn">🔍 Filtrele</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="log-viewer">
            <div class="log-header">
                <h3><?= $currentFile ?></h3>
                <div class="log-actions">
                    <a href="?file=<?= $currentFile ?>&level=<?= $filterLevel ?>&search=<?= urlencode($searchQuery) ?>">🔄 Yenile</a>
                    <a href="?action=download&file=<?= $currentFile ?>">⬇️ İndir</a>
                    <a href="?action=clear&file=<?= $currentFile ?>" onclick="return confirm('Bu log dosyasını silmek istediğinizden emin misiniz?')">🗑️ Temizle</a>
                </div>
            </div>

            <div class="log-content">
                <?php if (empty($logLines)): ?>
                    <div class="empty-state">
                        <div class="empty-state-icon">📭</div>
                        <h3>Log kaydı bulunamadı</h3>
                        <p>Bu dosyada gösterilecek log kaydı yok.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($logLines as $line): ?>
                        <?php
                        // Extract log level
                        preg_match('/\[(EMERGENCY|ALERT|CRITICAL|ERROR|WARNING|NOTICE|INFO|DEBUG)\]/', $line, $matches);
                        $lineLevel = $matches[1] ?? '';

                        // Highlight search query
                        if ($searchQuery) {
                            $line = preg_replace(
                                '/(' . preg_quote($searchQuery, '/') . ')/i',
                                '<span class="highlight">$1</span>',
                                $line
                            );
                        }
                        ?>
                        <div class="log-line <?= $lineLevel ?>">
                            <?= $line ?>
                        </div>
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
    </script>
</body>
</html>
