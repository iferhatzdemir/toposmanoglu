<?php
/**
 * Professional Logger Class for Admin Panel
 *
 * Features:
 * - 8 log levels (EMERGENCY, ALERT, CRITICAL, ERROR, WARNING, NOTICE, INFO, DEBUG)
 * - Automatic file rotation (10MB max, keeps 7 files)
 * - Context support for structured logging
 * - Statistics and analytics
 * - Auto-cleanup of old logs
 *
 * @author Claude Code
 * @version 2.0
 */

class Logger {
    // Log levels (PSR-3 compatible)
    const EMERGENCY = 'EMERGENCY'; // System is unusable
    const ALERT     = 'ALERT';     // Action must be taken immediately
    const CRITICAL  = 'CRITICAL';  // Critical conditions
    const ERROR     = 'ERROR';     // Error conditions
    const WARNING   = 'WARNING';   // Warning conditions
    const NOTICE    = 'NOTICE';    // Normal but significant condition
    const INFO      = 'INFO';      // Informational messages
    const DEBUG     = 'DEBUG';     // Debug-level messages

    // Log level priorities (for filtering)
    private $levels = [
        'EMERGENCY' => 800,
        'ALERT'     => 700,
        'CRITICAL'  => 600,
        'ERROR'     => 500,
        'WARNING'   => 400,
        'NOTICE'    => 300,
        'INFO'      => 200,
        'DEBUG'     => 100,
    ];

    private $logDir;
    private $logFile;
    private $maxFileSize = 10485760; // 10MB in bytes
    private $maxRotatedFiles = 7;
    private $minLogLevel = 'DEBUG'; // Minimum level to log

    /**
     * Constructor
     *
     * @param string $logDir Directory to store log files
     * @param string $minLogLevel Minimum log level to record
     */
    public function __construct($logDir = null, $minLogLevel = 'DEBUG') {
        if ($logDir === null) {
            $logDir = __DIR__ . '/../logs';
        }

        $this->logDir = rtrim($logDir, '/\\');
        $this->minLogLevel = $minLogLevel;

        // Create log directory if it doesn't exist
        if (!is_dir($this->logDir)) {
            mkdir($this->logDir, 0755, true);
        }

        // Set current log file with date
        $this->logFile = $this->logDir . '/admin_' . date('Y-m-d') . '.log';

        // Create .htaccess to protect log directory
        $this->protectLogDirectory();
    }

    /**
     * Protect log directory from web access
     */
    private function protectLogDirectory() {
        $htaccessFile = $this->logDir . '/.htaccess';
        if (!file_exists($htaccessFile)) {
            $content = "Order Deny,Allow\nDeny from all";
            file_put_contents($htaccessFile, $content);
        }
    }

    /**
     * Check if log level should be logged
     */
    private function shouldLog($level) {
        if (!isset($this->levels[$level])) {
            return false;
        }
        return $this->levels[$level] >= $this->levels[$this->minLogLevel];
    }

    /**
     * Main logging method
     *
     * @param string $level Log level
     * @param string $message Log message
     * @param array $context Additional context data
     * @return bool Success status
     */
    public function log($level, $message, $context = []) {
        if (!$this->shouldLog($level)) {
            return true; // Don't log but return success
        }

        $formattedMessage = $this->formatMessage($level, $message, $context);

        // Check if rotation is needed
        $this->rotateLog();

        // Write to log file
        return $this->writeLog($formattedMessage);
    }

    /**
     * Format log message
     */
    private function formatMessage($level, $message, $context = []) {
        $timestamp = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'CLI';
        $user = $_SESSION['admin_kullanici_adi'] ?? 'guest';

        $formatted = sprintf(
            "[%s] [%s] [IP: %s] [User: %s] %s",
            $timestamp,
            str_pad($level, 9, ' ', STR_PAD_RIGHT),
            $ip,
            $user,
            $message
        );

        // Add context if provided
        if (!empty($context)) {
            $contextJson = json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            $formatted .= " | Context: " . $contextJson;
        }

        // Add memory usage
        $formatted .= sprintf(" | Memory: %s", $this->formatBytes(memory_get_usage(true)));

        return $formatted . PHP_EOL;
    }

    /**
     * Write log to file
     */
    private function writeLog($message) {
        return file_put_contents($this->logFile, $message, FILE_APPEND | LOCK_EX) !== false;
    }

    /**
     * Rotate log file if needed
     */
    private function rotateLog() {
        if (!file_exists($this->logFile)) {
            return;
        }

        if (filesize($this->logFile) < $this->maxFileSize) {
            return;
        }

        // Rotate existing backup files
        for ($i = $this->maxRotatedFiles - 1; $i >= 1; $i--) {
            $oldFile = $this->logFile . '.' . $i;
            $newFile = $this->logFile . '.' . ($i + 1);

            if (file_exists($oldFile)) {
                if (file_exists($newFile)) {
                    unlink($newFile);
                }
                rename($oldFile, $newFile);
            }
        }

        // Rotate current log file
        $backupFile = $this->logFile . '.1';
        if (file_exists($backupFile)) {
            unlink($backupFile);
        }
        rename($this->logFile, $backupFile);
    }

    /**
     * Format bytes to human readable
     */
    private function formatBytes($bytes, $precision = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    // PSR-3 compatible methods

    /**
     * System is unusable
     */
    public function emergency($message, $context = []) {
        return $this->log(self::EMERGENCY, $message, $context);
    }

    /**
     * Action must be taken immediately
     */
    public function alert($message, $context = []) {
        return $this->log(self::ALERT, $message, $context);
    }

    /**
     * Critical conditions
     */
    public function critical($message, $context = []) {
        return $this->log(self::CRITICAL, $message, $context);
    }

    /**
     * Runtime errors that do not require immediate action
     */
    public function error($message, $context = []) {
        return $this->log(self::ERROR, $message, $context);
    }

    /**
     * Exceptional occurrences that are not errors
     */
    public function warning($message, $context = []) {
        return $this->log(self::WARNING, $message, $context);
    }

    /**
     * Normal but significant events
     */
    public function notice($message, $context = []) {
        return $this->log(self::NOTICE, $message, $context);
    }

    /**
     * Interesting events
     */
    public function info($message, $context = []) {
        return $this->log(self::INFO, $message, $context);
    }

    /**
     * Detailed debug information
     */
    public function debug($message, $context = []) {
        return $this->log(self::DEBUG, $message, $context);
    }

    // Additional utility methods

    /**
     * Log admin activity
     */
    public function logActivity($action, $details = []) {
        $user = $_SESSION['admin_kullanici_adi'] ?? 'guest';
        $message = sprintf("Admin Activity: %s by %s", $action, $user);
        return $this->info($message, $details);
    }

    /**
     * Log database queries
     */
    public function logQuery($query, $executionTime = null, $error = null) {
        $context = ['query' => $query];

        if ($executionTime !== null) {
            $context['execution_time'] = $executionTime . 'ms';
        }

        if ($error !== null) {
            $context['error'] = $error;
            return $this->error("Database Query Failed", $context);
        }

        return $this->debug("Database Query Executed", $context);
    }

    /**
     * Log API requests
     */
    public function logApiRequest($endpoint, $method, $responseCode, $responseTime = null) {
        $context = [
            'endpoint' => $endpoint,
            'method' => $method,
            'response_code' => $responseCode
        ];

        if ($responseTime !== null) {
            $context['response_time'] = $responseTime . 'ms';
        }

        $level = ($responseCode >= 400) ? self::ERROR : self::INFO;
        return $this->log($level, "API Request: {$method} {$endpoint}", $context);
    }

    /**
     * Log exceptions
     */
    public function logException($exception) {
        $context = [
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString()
        ];

        return $this->error(
            "Exception: " . $exception->getMessage(),
            $context
        );
    }

    /**
     * Get log statistics
     */
    public function getStats($logFile = null) {
        if ($logFile === null) {
            $logFile = $this->logFile;
        }

        if (!file_exists($logFile)) {
            return null;
        }

        $stats = [
            'file' => basename($logFile),
            'size' => filesize($logFile),
            'size_formatted' => $this->formatBytes(filesize($logFile)),
            'modified' => date('Y-m-d H:i:s', filemtime($logFile)),
            'levels' => []
        ];

        // Count log levels
        $content = file_get_contents($logFile);
        foreach ($this->levels as $level => $priority) {
            $count = substr_count($content, "[{$level}]");
            if ($count > 0) {
                $stats['levels'][$level] = $count;
            }
        }

        return $stats;
    }

    /**
     * Get all log files
     */
    public function getLogFiles() {
        $files = glob($this->logDir . '/admin_*.log*');
        $logFiles = [];

        foreach ($files as $file) {
            $logFiles[] = [
                'path' => $file,
                'name' => basename($file),
                'size' => filesize($file),
                'size_formatted' => $this->formatBytes(filesize($file)),
                'modified' => filemtime($file),
                'modified_formatted' => date('Y-m-d H:i:s', filemtime($file))
            ];
        }

        // Sort by modified time (newest first)
        usort($logFiles, function($a, $b) {
            return $b['modified'] - $a['modified'];
        });

        return $logFiles;
    }

    /**
     * Clear old logs
     */
    public function clearOldLogs($daysOld = 30) {
        $files = glob($this->logDir . '/admin_*.log*');
        $threshold = time() - ($daysOld * 86400);
        $deleted = 0;

        foreach ($files as $file) {
            if (filemtime($file) < $threshold) {
                if (unlink($file)) {
                    $deleted++;
                }
            }
        }

        return $deleted;
    }

    /**
     * Clear specific log file
     */
    public function clearLog($logFile = null) {
        if ($logFile === null) {
            $logFile = $this->logFile;
        }

        if (file_exists($logFile)) {
            return unlink($logFile);
        }

        return false;
    }
}
