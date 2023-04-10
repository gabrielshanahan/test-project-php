<?php

/**
 * Config
 * provides interface for user's configuration options
 */
class Config {
	
	private $directory;
	public $database;
    public $captchaSecret;
    public $debug;
    public $version;

	public function __construct() {
		// Save current directory path
		$this->directory = dirname(__FILE__);
		
		// Read user's database config
		require $this->directory .'/../config/database.php';
		$this->database = $database;

        require $this->directory .'/../config/captcha.php';
        $this->captchaSecret = $captchaSecret;

        require $this->directory .'/../config/debug.php';
        $this->debug = $debug ?? false;

        require $this->directory .'/../config/version.php';
        $this->version = $version ?? false;
	}
	
}

return new Config();
