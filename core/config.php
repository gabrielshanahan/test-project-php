<?php

/**
 * Config
 * provides interface for user's configuration options
 */
class Config {
	
	public array $database;
    public string $captchaSecret;
    public bool $debug;
    public string $version;
    public string $cookieDomain;

	public function __construct() {
        foreach (glob(__DIR__ . '/../config/*.php') as $filename) {
            require $filename;
        }

        foreach (array_keys(get_class_vars(Config::class)) as $property) {
            $this->$property = $$property;
        }
	}
}

return new Config();
