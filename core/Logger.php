<?php
/**
 * Professional Logger Class
 * Advanced logging system with multiple levels, file rotation, and monitoring
 *
 * @author Claude Code
 * @version 1.0.0
 */

class Logger
{
    // Log Levels
    const EMERGENCY = 'EMERGENCY'; // System is unusable
    const ALERT     = 'ALERT';     // Action must be taken immediately
    const CRITICAL  = 'CRITICAL';  // Critical conditions
    const ERROR     = 'ERROR';     // Error conditions
    const WARNING   = 'WARNING';   // Warning conditions
    const NOTICE    = 'NOTICE';    // Normal but significant
    const INFO      = 'INFO';      // Informational messages
    const DEBUG     = 'DEBUG';     // Debug-level messages

    private $logPath;
    private $logFile;
    private $maxFileSize = 10485760; // 10MB
    private $maxFiles = 5;
    private $enabled = true;
    private $logLevel = self::DEBUG;

    /**
     * Constructor
     */
    public function __construct($logPath = null)
    {
        if ($logPath === null) {
            $this->logPath = __DIR__ . '/../logs/';
        } else {
            $this->logPath = rtrim($logPath, '/') . '/';
        }

        // Create logs directory if not exists
        if (!is_dir($this->logPath)) {
            mkdir($this->logPath, 0755, true);
        }

        // Set default log file
        $this->logFile = 'app_' . date('Y-m-d') . '.log';
    }

    /**
     * Log message with level
     */
    public function log($level, $message, $context = [])
    {
        if (!$this->enabled) {
            return false;
        }

        // Check log level
        if (!$this->shouldLog($level)) {
            return false;
        }

        // Format message
        $formattedMessage = $this->formatMessage($level, $message, $context);

        // Rotate log if needed
        $this->rotateLog();

        // Write to file
        return $this->writeLog($formattedMessage);
    }

    /**
     * Emergency: system is unusable
     */
    public function emergency($message, $context = [])
    {
        return $this->log(self::EMERGENCY, $message, $context);
    }

    /**
     * Alert: action must be taken immediately
     */
    public function alert($message, $context = [])
    {
        return $this->log(self::ALERT, $message, $context);
    }

    /**
     * Critical: critical conditions
     */
    public function critical($message, $context = [])
    {
        return $this->log(self::CRITICAL, $message, $context);
    }

    /**
     * Error: error conditions
     */
    public function error($message, $context = [])
    {
        return $this->log(self::ERROR, $message, $context);
    }

    /**
     * Warning: warning conditions
     */
    public function warning($message, $context = [])
    {
        return $this->log(self::WARNING, $message, $context);
    }

    /**
     * Notice: normal but significant
     */
    public function notice($message, $context = [])
    {
        return $this->log(self::NOTICE, $message, $context);
    }

    /**
     * Info: informational messages
     */
    public function info($message, $context = [])
    {
        return $this->log(self::INFO, $message, $context);
    }

    /**
     * Debug: debug-level messages
     */
    public function debug($message, $context = [])
    {
        return $this->log(self::DEBUG, $message, $context);
    }

    /**
     * Log user activity
     */
    public function logActivity($action, $details = [])
    {
        $context = array_merge([
            'user_id' => $_SESSION['uyeID'] ?? 'guest',
            'ip' => $this->getClientIP(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
        ], $details);

        return $this->info("USER_ACTIVITY: {$action}", $context);
    }

    /**
     * Log database query
     */
    public function logQuery($query, $params = [], $executionTime = null)
    {
        $context = [
            'query' => $query,
            'params' => $params,
            'execution_time' => $executionTime
        ];

        return $this->debug("DATABASE_QUERY", $context);
    }

    /**
     * Log API request
     */
    public function logApiRequest($endpoint, $method, $statusCode, $responseTime = null)
    {
        $context = [
            'endpoint' => $endpoint,
            'method' => $method,
            'status_code' => $statusCode,
            'response_time' => $responseTime,
            'ip' => $this->getClientIP()
        ];

        return $this->info("API_REQUEST", $context);
    }

    /**
     * Log exception
     */
    public function logException($exception)
    {
        $context = [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString()
        ];

        return $this->error("EXCEPTION: " . get_class($exception), $context);
    }

    /**
     * Format log message
     */
    private function formatMessage($level, $message, $context)
    {
        $timestamp = date('Y-m-d H:i:s');
        $levelPadded = str_pad($level, 10, ' ', STR_PAD_RIGHT);

        // Get caller information
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 4);
        $caller = $backtrace[3] ?? $backtrace[2] ?? [];
        $file = isset($caller['file']) ? basename($caller['file']) : 'unknown';
        $line = $caller['line'] ?? '0';

        // Build log entry
        $logEntry = "[{$timestamp}] [{$levelPadded}] [{$file}:{$line}] {$message}";

        // Add context if present
        if (!empty($context)) {
            $logEntry .= ' | Context: ' . json_encode($context, JSON_UNESCAPED_UNICODE);
        }

        return $logEntry;
    }

    /**
     * Write log to file
     */
    private function writeLog($message)
    {
        $filePath = $this->logPath . $this->logFile;

        // Add newline
        $message .= PHP_EOL;

        // Write to file
        return file_put_contents($filePath, $message, FILE_APPEND | LOCK_EX) !== false;
    }

    /**
     * Rotate log files if size exceeds limit
     */
    private function rotateLog()
    {
        $filePath = $this->logPath . $this->logFile;

        if (!file_exists($filePath)) {
            return;
        }

        $fileSize = filesize($filePath);

        if ($fileSize >= $this->maxFileSize) {
            // Rename old files
            for ($i = $this->maxFiles - 1; $i > 0; $i--) {
                $oldFile = $this->logPath . $this->logFile . '.' . $i;
                $newFile = $this->logPath . $this->logFile . '.' . ($i + 1);

                if (file_exists($oldFile)) {
                    if ($i == $this->maxFiles - 1) {
                        unlink($oldFile); // Delete oldest
                    } else {
                        rename($oldFile, $newFile);
                    }
                }
            }

            // Rename current to .1
            rename($filePath, $filePath . '.1');
        }
    }

    /**
     * Check if message should be logged based on level
     */
    private function shouldLog($level)
    {
        $levels = [
            self::DEBUG     => 0,
            self::INFO      => 1,
            self::NOTICE    => 2,
            self::WARNING   => 3,
            self::ERROR     => 4,
            self::CRITICAL  => 5,
            self::ALERT     => 6,
            self::EMERGENCY => 7
        ];

        $currentLevel = $levels[$this->logLevel] ?? 0;
        $messageLevel = $levels[$level] ?? 0;

        return $messageLevel >= $currentLevel;
    }

    /**
     * Get client IP address
     */
    private function getClientIP()
    {
        $ip = 'UNKNOWN';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    /**
     * Set log level
     */
    public function setLogLevel($level)
    {
        $this->logLevel = $level;
    }

    /**
     * Enable/Disable logging
     */
    public function setEnabled($enabled)
    {
        $this->enabled = (bool)$enabled;
    }

    /**
     * Set max file size for rotation
     */
    public function setMaxFileSize($bytes)
    {
        $this->maxFileSize = (int)$bytes;
    }

    /**
     * Set max number of rotated files
     */
    public function setMaxFiles($count)
    {
        $this->maxFiles = (int)$count;
    }

    /**
     * Get all log files
     */
    public function getLogFiles()
    {
        $files = glob($this->logPath . '*.log*');

        // Sort by modification time (newest first)
        usort($files, function($a, $b) {
            return filemtime($b) - filemtime($a);
        });

        return $files;
    }

    /**
     * Read log file
     */
    public function readLog($filename, $lines = 100)
    {
        $filePath = $this->logPath . $filename;

        if (!file_exists($filePath)) {
            return [];
        }

        $content = file($filePath);
        return array_slice(array_reverse($content), 0, $lines);
    }

    /**
     * Clear old logs (older than X days)
     */
    public function clearOldLogs($days = 30)
    {
        $files = $this->getLogFiles();
        $cutoff = time() - ($days * 86400);
        $deleted = 0;

        foreach ($files as $file) {
            if (filemtime($file) < $cutoff) {
                unlink($file);
                $deleted++;
            }
        }

        return $deleted;
    }

    /**
     * Get log statistics
     */
    public function getStats()
    {
        $files = $this->getLogFiles();
        $totalSize = 0;
        $logCounts = [];

        foreach ($files as $file) {
            $totalSize += filesize($file);

            // Count log levels
            $content = file_get_contents($file);
            preg_match_all('/\[(ERROR|WARNING|INFO|DEBUG|CRITICAL|ALERT|EMERGENCY|NOTICE)\]/', $content, $matches);

            foreach ($matches[1] as $level) {
                $logCounts[$level] = ($logCounts[$level] ?? 0) + 1;
            }
        }

        return [
            'total_files' => count($files),
            'total_size' => $totalSize,
            'total_size_mb' => round($totalSize / 1048576, 2),
            'log_counts' => $logCounts
        ];
    }
}
