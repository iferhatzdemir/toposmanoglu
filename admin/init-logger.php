<?php
/**
 * Logger Initialization for Admin Panel
 *
 * This file should be included at the top of admin files to enable logging
 *
 * Usage:
 * require_once __DIR__ . '/init-logger.php';
 *
 * Then use the global $adminLogger variable:
 * $adminLogger->info('Admin logged in');
 * $adminLogger->error('Failed to update product');
 */

// Include Logger class
require_once __DIR__ . '/core/Logger.php';

// Determine log level based on environment
$logLevel = 'DEBUG'; // Default for development

// You can change this based on your environment
if (isset($_SERVER['SERVER_NAME'])) {
    if (strpos($_SERVER['SERVER_NAME'], 'localhost') === false &&
        strpos($_SERVER['SERVER_NAME'], '127.0.0.1') === false) {
        $logLevel = 'WARNING'; // Production: only warnings and above
    }
}

// Initialize global logger
$GLOBALS['adminLogger'] = new Logger(__DIR__ . '/logs', $logLevel);
$adminLogger = $GLOBALS['adminLogger'];

/**
 * Custom error handler
 */
function adminLogErrorHandler($errno, $errstr, $errfile, $errline) {
    global $adminLogger;

    // Don't log suppressed errors (@)
    if (!(error_reporting() & $errno)) {
        return false;
    }

    $errorTypes = [
        E_ERROR             => 'ERROR',
        E_WARNING           => 'WARNING',
        E_PARSE             => 'ERROR',
        E_NOTICE            => 'NOTICE',
        E_CORE_ERROR        => 'ERROR',
        E_CORE_WARNING      => 'WARNING',
        E_COMPILE_ERROR     => 'ERROR',
        E_COMPILE_WARNING   => 'WARNING',
        E_USER_ERROR        => 'ERROR',
        E_USER_WARNING      => 'WARNING',
        E_USER_NOTICE       => 'NOTICE',
        E_STRICT            => 'NOTICE',
        E_RECOVERABLE_ERROR => 'ERROR',
        E_DEPRECATED        => 'NOTICE',
        E_USER_DEPRECATED   => 'NOTICE',
    ];

    $level = isset($errorTypes[$errno]) ? $errorTypes[$errno] : 'ERROR';

    $message = "PHP {$level}: {$errstr}";
    $context = [
        'file' => $errfile,
        'line' => $errline,
        'type' => $errno
    ];

    // Log based on severity
    switch ($level) {
        case 'ERROR':
            $adminLogger->error($message, $context);
            break;
        case 'WARNING':
            $adminLogger->warning($message, $context);
            break;
        case 'NOTICE':
            $adminLogger->notice($message, $context);
            break;
        default:
            $adminLogger->info($message, $context);
    }

    // Don't execute PHP internal error handler
    return true;
}

/**
 * Custom exception handler
 */
function adminLogExceptionHandler($exception) {
    global $adminLogger;
    $adminLogger->logException($exception);
}

/**
 * Shutdown handler for fatal errors
 */
function adminLogShutdownHandler() {
    global $adminLogger;

    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        $adminLogger->critical(
            "Fatal Error: {$error['message']}",
            [
                'file' => $error['file'],
                'line' => $error['line'],
                'type' => $error['type']
            ]
        );
    }
}

// Register error handlers
set_error_handler('adminLogErrorHandler');
set_exception_handler('adminLogExceptionHandler');
register_shutdown_function('adminLogShutdownHandler');

// Log application start
$adminLogger->info('Admin Application Started', [
    'request_uri' => $_SERVER['REQUEST_URI'] ?? '',
    'request_method' => $_SERVER['REQUEST_METHOD'] ?? '',
    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
    'referer' => $_SERVER['HTTP_REFERER'] ?? ''
]);

// Auto-cleanup old logs (once per day)
$cleanupFlagFile = __DIR__ . '/logs/.last_cleanup';
if (!file_exists($cleanupFlagFile) || (time() - filemtime($cleanupFlagFile)) > 86400) {
    $deleted = $adminLogger->clearOldLogs(30); // Delete logs older than 30 days
    if ($deleted > 0) {
        $adminLogger->info("Auto-cleanup: Deleted {$deleted} old log files");
    }
    touch($cleanupFlagFile);
}

// Helper function for quick access
if (!function_exists('adminLog')) {
    /**
     * Quick logging helper function
     *
     * @param string $level Log level
     * @param string $message Log message
     * @param array $context Additional context
     */
    function adminLog($level, $message, $context = []) {
        global $adminLogger;
        return $adminLogger->log($level, $message, $context);
    }
}
