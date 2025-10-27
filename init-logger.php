<?php
/**
 * Logger Initialization
 * This file initializes the logger and sets up error handlers
 */

// Include Logger class
require_once __DIR__ . '/core/Logger.php';

// Initialize Logger
$logger = new Logger(__DIR__ . '/logs/');

// Set log level based on environment
if (defined('ENVIRONMENT') && ENVIRONMENT === 'production') {
    $logger->setLogLevel(Logger::WARNING);
} else {
    $logger->setLogLevel(Logger::DEBUG);
}

// Set max file size to 10MB
$logger->setMaxFileSize(10485760);

// Keep last 7 rotated files
$logger->setMaxFiles(7);

/**
 * Custom Error Handler
 */
function logErrorHandler($errno, $errstr, $errfile, $errline)
{
    global $logger;

    $errorTypes = [
        E_ERROR             => 'ERROR',
        E_WARNING           => 'WARNING',
        E_PARSE             => 'CRITICAL',
        E_NOTICE            => 'NOTICE',
        E_CORE_ERROR        => 'CRITICAL',
        E_CORE_WARNING      => 'WARNING',
        E_COMPILE_ERROR     => 'CRITICAL',
        E_COMPILE_WARNING   => 'WARNING',
        E_USER_ERROR        => 'ERROR',
        E_USER_WARNING      => 'WARNING',
        E_USER_NOTICE       => 'NOTICE',
        E_STRICT            => 'NOTICE',
        E_RECOVERABLE_ERROR => 'ERROR',
        E_DEPRECATED        => 'NOTICE',
        E_USER_DEPRECATED   => 'NOTICE'
    ];

    $type = $errorTypes[$errno] ?? 'ERROR';

    $context = [
        'file' => $errfile,
        'line' => $errline,
        'error_number' => $errno
    ];

    $logger->log($type, $errstr, $context);

    // Don't execute PHP internal error handler
    return true;
}

/**
 * Custom Exception Handler
 */
function logExceptionHandler($exception)
{
    global $logger;
    $logger->logException($exception);

    // Display user-friendly error page
    if (defined('ENVIRONMENT') && ENVIRONMENT === 'production') {
        http_response_code(500);
        include __DIR__ . '/errors/500.php';
    } else {
        // Show exception details in development
        echo '<pre>';
        echo '<h1>Uncaught Exception</h1>';
        echo '<strong>Message:</strong> ' . $exception->getMessage() . '<br>';
        echo '<strong>File:</strong> ' . $exception->getFile() . '<br>';
        echo '<strong>Line:</strong> ' . $exception->getLine() . '<br>';
        echo '<strong>Trace:</strong><br>' . $exception->getTraceAsString();
        echo '</pre>';
    }

    exit;
}

/**
 * Shutdown Handler for Fatal Errors
 */
function logShutdownHandler()
{
    global $logger;

    $error = error_get_last();

    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        $context = [
            'file' => $error['file'],
            'line' => $error['line'],
            'type' => $error['type']
        ];

        $logger->critical('FATAL ERROR: ' . $error['message'], $context);
    }
}

// Register handlers
set_error_handler('logErrorHandler');
set_exception_handler('logExceptionHandler');
register_shutdown_function('logShutdownHandler');

// Log application start
$logger->info('Application Started', [
    'url' => $_SERVER['REQUEST_URI'] ?? 'CLI',
    'method' => $_SERVER['REQUEST_METHOD'] ?? 'CLI',
    'ip' => $_SERVER['REMOTE_ADDR'] ?? 'localhost'
]);

// Auto-cleanup old logs (older than 30 days) - runs once per day
$cleanupFlagFile = __DIR__ . '/logs/.last_cleanup';
if (!file_exists($cleanupFlagFile) || (time() - filemtime($cleanupFlagFile)) > 86400) {
    $deleted = $logger->clearOldLogs(30);
    if ($deleted > 0) {
        $logger->info("Log cleanup: Deleted {$deleted} old log files");
    }
    touch($cleanupFlagFile);
}
