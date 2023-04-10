<?php

error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', 'php://stderr');

// Load BaseModel and all models from models directory
require dirname(__FILE__).'/base_model.php';
foreach (glob(dirname(__FILE__).'/../models/*.php') as $filename) {
    require $filename;
}

require_once __DIR__ . "/form/FormHandler.php";
require_once __DIR__ . "/form/Response.php";

/**
 * App
 * provides interface for database manipulation, accessing config and rendering views
 */
class App
{
    private $directory;
    public $db;

    /**
     * @var Config
     */
    public static Config $config;

    public const DB_TEXT_FIELD_LEN = 65535;

    private const SESSION_LIFETIME_SECONDS = 3600;
    private const MAX_CSRF_TOKENS_COUNT = 100;

    public const DEFINED_CSRF_TOKENS_SESSION_KEY = 'csrf_tokens';

    public function __construct()
    {
        // Save current directory path
        $this->directory = dirname(__FILE__);

        // Load database instance and tell it to connect with given config
        $this->db = require $this->directory.'/database.php';
        $this->db->connect(self::$config->database);

        $this->init();
        $this->session();
        $this->headers();
    }

    private function init() {
        set_exception_handler(['App', 'exceptionHandler']);
        $_POST = json_decode(file_get_contents("php://input"), true);
    }

    private function session() {
        session_set_cookie_params([
            'lifetime' => self::SESSION_LIFETIME_SECONDS,
            'path' => '/',
            'domain' => self::$config->cookieDomain,
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);

        session_start();
        if (key_exists(session_name(), $_COOKIE)) {
            if(empty($_SESSION)) { // Expired session
                setcookie(session_name(), '', time()-1, '/');
                http_response_code(400);
                $errorMsg = 'This window has stayed inactive for too long! Please refresh it and try again.';
                if (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json')) {
                    echo json_encode([
                        'other' => $errorMsg .
                            " Be aware that, by refreshing, you will lose the data you just tried to create, and will" .
                            " have to enter it anew. " .
                            "Data that was already saved (i.e. is visible in the table bellow) will not be affected."
                    ]);
                } else {
                    echo $errorMsg;
                }
                exit;
            }
        }

        session_regenerate_id();
        $_SESSION['nonce'] = base64_encode(random_bytes(16));
        $_SESSION[self::DEFINED_CSRF_TOKENS_SESSION_KEY][] = bin2hex(random_bytes(32));
        if($_SESSION[self::DEFINED_CSRF_TOKENS_SESSION_KEY] > self::MAX_CSRF_TOKENS_COUNT) {
            $_SESSION[self::DEFINED_CSRF_TOKENS_SESSION_KEY] = array_slice(
                $_SESSION[self::DEFINED_CSRF_TOKENS_SESSION_KEY],
                count($_SESSION[self::DEFINED_CSRF_TOKENS_SESSION_KEY]) - self::MAX_CSRF_TOKENS_COUNT
            );
        }
    }

    private function headers() {
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

    public function getDefinedCSRFTokens(): array
    {
        return $_SESSION[self::DEFINED_CSRF_TOKENS_SESSION_KEY] ?? [];
    }

    public function getRemoteIp(): ?string {
        return $_SERVER['REMOTE_ADDR'] ?? null;
    }

    public function handleFormAndExit($formHandlerClass, $formData) {
        /** @var FormHandler $handler */
        $handler = new $formHandlerClass($this);

        self::respondAndExit($handler->doHandle($formData));
    }

    private static function respondAndExit(Response $response) {
        header('Content-Type: application/json');
        http_response_code($response->getStatus());
        echo json_encode($response->getBody());
        exit;
    }

    public static function exceptionHandler($exception)
    {
        self::respondAndExit(new UncaughtException($exception, self::$config->debug));
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
}

App::$config = require __DIR__ . '/config.php';

return new App();
