<?php

// Load BaseModel and all models from models directory
require dirname(__FILE__).'/base_model.php';
foreach (glob(dirname(__FILE__).'/../models/*.php') as $filename) {
    require $filename;
}

/**
 * App
 * provides interface for database manipulation, accessing config and rendering views
 */
class App
{
    private $directory;
    public $db;
    public $config;

    public const DB_TEXT_FIELD_LEN = 65535;
    private const MAX_CSRF_TOKENS_COUNT = 100;

    public function __construct()
    {
        // Save current directory path
        $this->directory = dirname(__FILE__);

        // Load configuration options
        $this->config = require $this->directory.'/config.php';

        // Load database instance and tell it to connect with given config
        $this->db = require $this->directory.'/database.php';
        $this->db->connect($this->config->database);
        $this->init();
    }

    private function init() {
        // Basic wiring
        set_exception_handler(['App', 'exceptionHandler']);
        $_POST = json_decode(file_get_contents("php://input"), true);

        // Session
        session_start();
        $_SESSION['nonce'] = base64_encode(random_bytes(16));
        $_SESSION['csrf_tokens'][] = bin2hex(random_bytes(32));
        $_SESSION['csrf_tokens'] = array_slice($_SESSION['csrf_tokens'], self::MAX_CSRF_TOKENS_COUNT);

        // Headers
        header("X-Frame-Options: DENY");
        header('X-Content-Type-Options: nosniff');
        header(
            "Content-Security-Policy: " .
            "default-src 'none'; " .
            "connect-src 'self'; " .
            "script-src 'self' https://cdn.jsdelivr.net https://www.google.com 'nonce-" . $_SESSION['nonce'] . "'; " .
            "frame-src https://www.google.com; " .
            "img-src 'self' data:; " .
            "style-src 'self' https://cdn.jsdelivr.net 'nonce-" . $_SESSION['nonce'] . "'; " .
            "font-src 'self'; " .
            "object-src 'none'; " .
            "base-uri 'none'"
        );
        header_remove("X-Powered-By");
    }

    /**
     * Renders given view with given set of variables
     *
     * param $viewfile: path of the view file relative to the views direcotry, without the ending .php
     * param $vars: array of variables to be accessed insede the views
     */
    public function renderView($viewfile, $vars = array())
    {
        // Render array to usable variables
        foreach ($vars as $key => $value) {
            $$key = $value;
        }

        // Start capturing of output
        ob_start();
        include './views/'.$viewfile.'.php';
        // Assign output to $content which will be rendered in layout
        $content = ob_get_contents();
        // Stop output capturing
        ob_end_clean();
        // Render $content in layout
        include './views/layout.php';
    }

    public static function exceptionHandler($exception)
    {
        http_response_code(500);
        echo "Uncaught exception of type '" . get_class($exception) . "'";
    }
}

return new App();
